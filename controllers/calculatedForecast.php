<?php
/*
 * Created on 15-May-2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 1))
 {
 	
 	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
	$sql = "";
 	
   	
   	//Dropping calculated forecast table for updations and insertions
   	mysql_query("TRUNCATE TABLE calculated_forecast");
   	//mysql_query("ALTER TABLE calculated_forecast AUTO_INCREMENT = 0");
   	
   	//Date formation for nw and last 4 months
   	$year = date("o");
 	$month = date("m");
 	$previousMonths = array();
 	$previousMonths[0] = $year."/".$month;
 	//echo $previousMonths[0]."<br>";
 	for($i = 1; $i < 5; $i++)
 	{
 		if(($month - $i) <= 0)
 		{
 			if(($month - $i + 12) > 9)
 			{
 				$previousMonths[$i] = ($year-1)."/".($month - $i + 12);
 			}
 			else
 			{
 				$previousMonths[$i] = ($year-1)."/0".($month - $i + 12);
 			}
 		}
 		else
 		{
 			if(($month - $i) < 10)
 			{
 				$previousMonths[$i] = ($year)."/0".($month - $i);
 			}
 			else
 			{
 				$previousMonths[$i] = ($year)."/".($month - $i);
 			}
 		}
 		//echo $previousMonths[$i]."<br>";
 	}
   	
   	
   	//From history for getting customer + product list for calculated forecast table
   	$namesQuery = "SELECT DISTINCT Product_Name, Customer_Name " .
   				  "FROM history " .
   				  "WHERE An_Mois_Besoin =  '".$previousMonths[4]."'" .
   				  	" OR An_Mois_Besoin =  '".$previousMonths[3]."'" .
   				   	" OR An_Mois_Besoin =  '".$previousMonths[2]."'" .
   				 	" OR An_Mois_Besoin =  '".$previousMonths[1]."'";
   	//echo $namesQuery."<br>";
   	
   	if(mysql_query($namesQuery))
   	{
   		$namesCall = mysql_query($namesQuery);
   		$namesList = array();
   		//$i = 1;
   		//$namesList = mysql_fetch_assoc($namesCall);
   		while($namesList = mysql_fetch_assoc($namesCall))
   		{
   			set_time_limit(0);
   			
   			$insertCalcQuery = "INSERT INTO calculated_forecast(Product_Name, Customer_Name) " .
   								"VALUES ('".$namesList['Product_Name']."', '".$namesList['Customer_Name']."')";
   			//echo $i." ".$insertQuery."<br>";
   			//$i++;
   			mysql_query($insertCalcQuery);
   			
   			
   			
   			
 			$namesList['Customer_Name'] = str_replace("'", "''",$namesList['Customer_Name']);
	 		//For History
				$historyListQuery = "select Quantities_V from history where Customer_Name LIKE '%" . $namesList['Customer_Name'] . 
										"%' AND Product_Name = '" . $namesList['Product_Name'] . "' " ;
		
				$historyQueryCall = mysql_query($historyListQuery) or die(mysql_error());
				$historyList = array();
				$lastOrder = 0;
				
				while($historyList = mysql_fetch_assoc($historyQueryCall))
				{
					$lastOrder = $lastOrder + $historyList['Quantities_V'];
					
				}
				
			//Monthly Orders
				$monthlyOrders = round($lastOrder/4);
				
		   	$namesListeExistQuery = "SELECT Product_Name, Customer_Name FROM liste_display WHERE" .
   										" Product_Name = '".$namesList['Product_Name']."' AND " .
   											" Customer_Name LIKE '%".$namesList['Customer_Name']."%' ";
   			$namesListeExistCall = mysql_query($namesListeExistQuery);
   			$namesListeExist = mysql_fetch_assoc($namesListeExistCall);
   			
   			if(($namesListeExist['Customer_Name'] == $namesList['Customer_Name']) 
   						&& ($namesListeExist['Product_Name'] == $namesList['Product_Name']))
   			{
   				echo "Entry exists";
   			}
   			else
   			{
   				
   				$insertListeQuery = "INSERT INTO liste_display(Product_Name, Customer_Name, Monthly_Orders, From_Table) " .
   										"VALUES ('".$namesList['Product_Name']."', '".$namesList['Customer_Name']."' , ".
   											$monthlyOrders.", 'History')";
   				//echo $insertListeQuery."<br>";
		   		//$i++;
		   		
   				mysql_query($insertListeQuery);
   			}
   		}
   	}
   	
   	
   	//From Calculated Forecast itself for further calculations
   	$uidQuery = "SELECT UID FROM calculated_forecast";
   	
   	if(mysql_query($uidQuery))
   	{
   		$uidCall = mysql_query($uidQuery);
   		$uidList = array();
   		while($uidList = mysql_fetch_assoc($uidCall))
   		{
   			set_time_limit(0);
   			//echo $uidList['UID']."<br>";
   			
   			$calcForecastQuery = "SELECT * FROM calculated_forecast WHERE UID = ".$uidList['UID'];
 			$calcForecastCall = mysql_query($calcForecastQuery) or die(mysql_error());
 			//echo $calcForecastQuery."<br>";
 			$calcForecastList = mysql_fetch_assoc($calcForecastCall);
 	
 
 	
 			$custName = $calcForecastList['Customer_Name'];
 			if($custName == "FNAC SA Centrale d'Achats")
 			{
 				$custName = "FNAC SA Centrale d''Achats";
 			}
 			if($custName == "ATLANTIC TELECOM CHATEAU D'OLONNE")
 			{
 					$custName = "ATLANTIC TELECOM CHATEAU D''OLONNE";
 			}
 			$prodName = $calcForecastList['Product_Name'];
 			
 			
 
 
 			mysql_connect ("localhost","forecast","21ARFUvP");
 			mysql_select_db ("forecastdb");
   			
   			for($i = 1; $i < 5; $i++)
 			{
 				$historyListQuery = "select SUM(Quantities_V) from history where An_Mois_Besoin = '".$previousMonths[$i]."' AND " .
 								       "Customer_Name LIKE '%".$custName."%' AND Product_Name = '".$prodName."'" ;
 				//echo $historyListQuery;
 				$historyQueryCall = mysql_query($historyListQuery) or die(mysql_error());
 				$historyList = mysql_fetch_assoc($historyQueryCall);
 				if($historyList['SUM(Quantities_V)'] != NULL)
 				{
 					$sumSales[$i] = $historyList['SUM(Quantities_V)'];
 				}
 				else
 				{
 					$sumSales[$i] = 0;
 				}
 				
 			}
 
 
 			$salesHist4thLastMnth = $sumSales[4];
 			$salesHist3thLastMnth = $sumSales[3];
 			$salesHist2thLastMnth = $sumSales[2];
 			$salesHist1thLastMnth = $sumSales[1];
 		
 	
 			
		 	
		 	$prodListQuery = "SELECT * FROM product_list WHERE Product_Name = '".$prodName."'";
		 	$prodListCall = mysql_query($prodListQuery);
		 	$prodList = mysql_fetch_assoc($prodListCall);
		 	$prodLifeCycle = $prodList['Life_Cycle'];
		 		
		 	$salesForecastCurrMnth = 0;
		 	if(($salesHist4thLastMnth+$salesHist3thLastMnth)*3 < ($salesHist2thLastMnth+$salesHist1thLastMnth))
		 	{
				$salesForecastCurrMnth = (($salesHist2thLastMnth+$salesHist1thLastMnth)/2)/1.5;
				//echo "A".$salesForecastCurrMnth."<br>";
		 	}
		 	else
		 	{
		 		$salesForecastCurrMnth = (($salesHist2thLastMnth+$salesHist1thLastMnth)/2);
		 		//echo $salesForecastCurrMnth."<br>";
		 	}
		 	
		 	if($prodLifeCycle == "FADE OUT")
		 	{
		 		$salesForecastCurrMnth *= 0.6;
		 		//echo "A".$salesForecastCurrMnth."<br>";
		 				
		 	}
		 	else
		 	{
		 		$salesForecastCurrMnth *= 1;
		 		//echo $salesForecastCurrMnth."<br>";
		 	}
		 		
		 	
		 	//echo (int)$salesForecastCurrMnth."<br>";
		 	
		 	$calcForecastValues = array();
		 	
		 	if((int)$salesForecastCurrMnth <= 0)
		 	{
		 		$calcForecastValues[0] = 0;
		 	}
		 	else
		 	{
		 		$calcForecastValues[0] = round($salesForecastCurrMnth/4);
		 	}
		 	//echo $calcForecastValues[0]."<br>";
		 	for($i = 1; $i <= 26; $i++)
		 	{
		 		$calcForecastValues[$i] = $calcForecastValues[0];
		 		//echo $calcForecastValues[$i]."<br>";
		 	}
		 	
		 	$updateCalcForecastQuery = "UPDATE calculated_forecast SET " .
		 				"History_Month_M4 = ".$sumSales[4]."," .
		 					"History_Month_M3 = ".$sumSales[3]."," .
		 						"History_Month_M2 = ".$sumSales[2]."," .
		 							"History_Month_M1 = ".$sumSales[1]."," .
		 								"Forecast_Month_M0 = ".(int)$salesForecastCurrMnth."," .
						"Calculated_Forecast_Week_N0 = ".$calcForecastValues[0].",".
							"Calculated_Forecast_Week_N1 = ".$calcForecastValues[1]."," .
								"Calculated_Forecast_Week_N2 = ".$calcForecastValues[2]."," .
									"Calculated_Forecast_Week_N3 = ".$calcForecastValues[3]."," .
										"Calculated_Forecast_Week_N4 = ".$calcForecastValues[4]."," .
											"Calculated_Forecast_Week_N5 = ".$calcForecastValues[5]."," .
												"Calculated_Forecast_Week_N6 = ".$calcForecastValues[6]."," .
													"Calculated_Forecast_Week_N7 = ".$calcForecastValues[7]."," .
														"Calculated_Forecast_Week_N8 = ".$calcForecastValues[8]."," .
															"Calculated_Forecast_Week_N9 = ".$calcForecastValues[9]."," .
																"Calculated_Forecast_Week_N10 = ".$calcForecastValues[10]."," .
																	"Calculated_Forecast_Week_N11 =".$calcForecastValues[11]."," .
																		"Calculated_Forecast_Week_N12 = ".$calcForecastValues[12]."," .
																	"Calculated_Forecast_Week_N13 = ".$calcForecastValues[13]."," .
																"Calculated_Forecast_Week_N14 = ".$calcForecastValues[14]."," .
															"Calculated_Forecast_Week_N15 = ".$calcForecastValues[15]."," .
														"Calculated_Forecast_Week_N16 = ".$calcForecastValues[16]."," .
													"Calculated_Forecast_Week_N17 = ".$calcForecastValues[17]."," .
												"Calculated_Forecast_Week_N18 = ".$calcForecastValues[18]."," .
											"Calculated_Forecast_Week_N19 = ".$calcForecastValues[19]."," .
										"Calculated_Forecast_Week_N20 = ".$calcForecastValues[20]."," .
									"Calculated_Forecast_Week_N21 = ".$calcForecastValues[21]."," .
								"Calculated_Forecast_Week_N22 = ".$calcForecastValues[22]."," .
							"Calculated_Forecast_Week_N23 = ".$calcForecastValues[23]."," .
						"Calculated_Forecast_Week_N24 = ".$calcForecastValues[24]."," .
					"Calculated_Forecast_Week_N25 = ".$calcForecastValues[25]." WHERE UID = ".$uidList['UID'];
			
			//echo $updateCalcForecastQuery."<br>";
			mysql_query($updateCalcForecastQuery) or die(mysql_error());
		}
		
		
		   		
   	}
   
	
 	//echo "Table updated.";
 	mysql_close($db_handle);
 	header("location: /forecast/newMVCProj/views/adminViews/calculatedForecasts.php");
 }
 else
 {
 	echo "You are not logged in";
 }
 
	
?>
