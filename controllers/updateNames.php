<?php
/*
 * Created on Apr 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  session_start();
  //isset($_SESSION['role']) && ($_SESSION['role'] == 2)
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 2))
 {
 	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
	$sql = "";
 	
    
 	$sql = "select MAX(UID) from forecastdb.cust_prod_current";
   
    $list = mysql_query($sql);
    $row1 = mysql_fetch_assoc($list);
    $var = 0;
    if($row1['MAX(UID)'] == 1 )
    { 
    	$var = 1; 
    } 
    else 
    {
    	$var = 0;
    }
    //echo $var;
    
    
    $week = date("W");
	$year = date("o");

	/*
	//$_POST['cust_name']
	$custNameQuery = "select * from forecastdb.customer_spec where UID = " . $_POST['drop_1'];
	
	$custNameList = mysql_query($custNameQuery) or die(mysql_error());
	$custName = mysql_fetch_array($custNameList);
	if($custName == "FNAC SA Centrale d'Achats")
 	{
 		$custName = "FNAC SA Centrale d''Achats";
 	}
	
	//$_POST['prodName']
	$prodNameQuery = "select * from forecastdb.product_list where UID = " . $_POST['tier_two'];
	
	$prodNameList = mysql_query($prodNameQuery) or die(mysql_error());
	$prodName = mysql_fetch_array($prodNameList);
    $prodMaturity = $prodName[5];
    */
    if($_SESSION['page'] == "MassProd")
    {
    	$custName[1] = mysql_escape_string($_POST['drop_1']);
    }
	else
	{
		$custName[1] = mysql_escape_string($_POST['drop_5']);
	}
    
    if(isset($_POST['prodNameOther']))
    {
    	$prodName[1] = mysql_escape_string($_POST['prodNameOther']);
    }
    else
    {
    	$prodName[1] = mysql_escape_string($_POST['tier_two']);
    }
    $prodMatQuery = "select * from forecastdb.product_list where Product_Name = '" . $prodName[1]."'";
	echo $prodMatQuery."<br>";
	$prodMatCall = mysql_query($prodMatQuery) or die(mysql_error());
	$prodMatList = mysql_fetch_assoc($prodMatCall);
	echo $prodMatList['Product_Name']."<br>";
	if($prodMatList['Product_Name'] != NULL)
	{
		
		$prodMaturity = $prodMatList['Life_Cycle'];
		//echo $prodMaturity."<br>";
    	//For Sales
		$salesListQuery = "select * from forecastdb.salesout where Customer_Name LIKE '%" . $custName[1] . 
								"%' AND Product_Name LIKE '" . $prodName[1] . "'";
		echo $salesListQuery."<br>";
		$salesQueryCall = mysql_query($salesListQuery) or die(mysql_error());
		$status = false;
		$warehouseStock = 0;
	
		
		$stockArray[54] = array();
		$salesList = mysql_fetch_assoc($salesQueryCall);
	
		$warehouseStock = $salesList['Warehouse_Stock'];
	
		
		
		
		if($salesList != NULL) 
		{ 
			for($i = -6, $j = 0; $j < 32 ;$i++, $j++)
			{
				$stockArray[$j] = $salesList['Stock_Week_N'.$i];
			}
			
			$warehouseStock = $salesList['Warehouse_Stock'];
		} 
		else
		{
			for($j = 0; $j < 32 ;$j++)
			{
				$stockArray[$j] = 0;
			}
				$warehouseStock = 0;
		}
		
	
		//For Orders
		$ordersListArray[54] = array();
		$ordersListQuery = "select * from orders where Customer_Name LIKE '%" . $custName[1] . 
								"%' AND Product_Name LIKE '" . $prodName[1] . "' " ;
	
		$ordersQueryCall = mysql_query($ordersListQuery) or die(mysql_error());
	
		
		for($k = 1, $ordersList = mysql_fetch_assoc($ordersQueryCall); $k < 55 ; $k++)
		{
			if(($ordersList['Quantities_Cdes'] > 1) && ($ordersList['Week'] == $k))
			{
				$ordersListArray[$k] = $ordersList['Quantities_Cdes'];
			}
			else
			{
				$ordersListArray[$k] = 0;
			}
		}
		
		
		//For History
		$historyListQuery = "select * from history where Customer_Name LIKE '%" . $custName[1] . 
								"%' AND Product_Name LIKE '" . $prodName[1] . "' " ;
		
		$historyQueryCall = mysql_query($historyListQuery) or die(mysql_error());
		$historyList = array();
		$lastOrder = 0;
		$columnL = 0;
		$montantHTV = 0.00;
		while($historyList = mysql_fetch_assoc($historyQueryCall))
		{
			$lastOrder = $lastOrder + $historyList['Quantities_V'];
			$columnL = $columnL + $historyList['Column_L'];
			$montantHTV = $montantHTV  + $historyList['Montant_Net_H_T_V'];
		}
		$fullHistoryListQuery = "select * from history where Product_Name LIKE '" . $prodName[1] . "' " ;
		$fullHistoryQueryCall = mysql_query($fullHistoryListQuery) or die(mysql_error());
		$fullHistoryList = array();
		$articleQuantitySum = 1;
		$fullHistoryList = mysql_fetch_assoc($fullHistoryQueryCall);
		while($fullHistoryList = mysql_fetch_assoc($fullHistoryQueryCall))
		{
			$articleQuantitySum =  $articleQuantitySum + $fullHistoryList['Quantities_V'];
		}
		$articleQuantitySum = $articleQuantitySum - 1;



		//Forecast Values from Database
		$forecastListQuery = "select * from forecast_decision_table where Customer_Name LIKE '%" . $custName[1] . 
								  "%' AND Product_Name LIKE '" . $prodName[1] . "'" ;
		$forecastSearch = mysql_query($forecastListQuery);
		$resultCount = mysql_fetch_assoc($forecastSearch);

		//Forecast Decision values
		$totalForecastValue = 0;
		for($i = 0; $i < 26; $i++)
		{
			$totalForecastValue = $totalForecastValue + $resultCount['Forecast_Week_N'.$i];
		}

		//Couple Article/Client
		$articleClientRatio = $lastOrder/$articleQuantitySum;
		$articleClientRatio = $articleClientRatio * 100;


		//Valuer Prevue
		$valuerPrevue = ($montantHTV/$lastOrder)*$totalForecastValue;
		

		//Monthly sales out
		$monthlySalesOut = 0;
		for($i = 0; $i < 4; $i++)
		{
			$monthlySalesOut = $monthlySalesOut + $stockArray[$i+2];
		}


		//Monthly Orders
		$monthlyOrders = round($lastOrder/4);

		//Stock Theorique
		$stockTheorique = 0;
		$outletsStock = 0;
		if(($outletsStock + $warehouseStock) > 0)
		{
			$stockTheorique = 0;
		}
		else
		{
			$stockTheorique = $lastOrder - ($monthlySalesOut * 4);
		}


		//Batch Moyen
		$batchMoyen = (int)($lastOrder/$columnL);
		
		//Date Status
		$devListQuery = "select * from dev where Product_Name LIKE '" . $prodName[1] . "' " ;
		echo $devListQuery."<br>";
		$devQueryCall = mysql_query($devListQuery);
		$devList = mysql_fetch_assoc($devQueryCall);
		if($devList['Date_Status'] != NULL)
		{
			$dateStatus = $devList['Date_Status'];
			echo "Entered".$dateStatus."<br>";
		}
		else
		{
			$dateStatus = 0;
			echo $dateStatus."<br>";
		}
		//echo $dateStatus."<br>";

		//EDD First Batch
		$minWeekQuery = "select MIN(Week) from dev where Product_Name LIKE '".$prodName[1]."'";
		$minWeekQueryCall = mysql_query($minWeekQuery);
		$minWeekList = mysql_fetch_assoc($minWeekQueryCall);
		if($minWeekList['MIN(Week)'] != NULL)
		{
			$eddFirstBatch = $minWeekList['MIN(Week)'];
		}
		else
		{
			$eddFirstBatch = $devList['Week'];
		}
		
		//First Order Quantity
		$firstOrderQuery = "SELECT SUM(Quantity) FROM dev WHERE Product_Name LIKE '".$prodName[1]."'";
		$firstOrderCall = mysql_query($firstOrderQuery);
		$firstOrderList = mysql_fetch_assoc($firstOrderCall);
			
		if($firstOrderList['SUM(Quantity)'] != NULL)
		{
			$firstOrderQuantity = $firstOrderList['SUM(Quantity)'];
		}
		else
		{
			$firstOrderQuantity = 0;
		}

		//Reserved Quantity
		$reservdQtyListQuery = "select * from forecast_decision_table where Product_Name LIKE '" . $prodName[1] . "' " ;
		$reservdQtyQueryCall = mysql_query($reservdQtyListQuery) or die(mysql_error());
		$reservdQtyForecastValue = 0;
		$weekDiff = $eddFirstBatch - $week;
		while($reservdQtytList = mysql_fetch_assoc($reservdQtyQueryCall))
		{
			for($i = $weekDiff; $i < ($weekDiff+3); $i++)
			{
				$reservdQtyForecastValue += $reservdQtytList['Forecast_Week_N'.$i];
			}
		}
		
		


		//From LT for Lead Time
		$ltListQuery = "select * from lt where Product_Name LIKE '" . $prodName[1] . "' " ;
		$ltQueryCall = mysql_query($ltListQuery) or die(mysql_error());
		$ltList = mysql_fetch_assoc($ltQueryCall);
		$ltLookup = $ltList['Column_C'];
		if($ltLookup > 0)
		{
			$leadTime = (round($ltLookup/5)) + 1;
		}
		else
		{
			$leadTime = 5;
		}

		//Comments and Min Stock
		$relationListQuery = "select * from customer_prod_relation where Customer_Name LIKE '%" . $custName[1] . 
				  				  "%' AND Product_Name LIKE '" . $prodName[1] . "' " ;
		$relationQueryCall = mysql_query($relationListQuery) or die(mysql_error());
		$relationList = mysql_fetch_assoc($relationQueryCall);
		$ifComment = $relationList['Comments'];
		$ifMinStock = $relationList['Min_Stock'];

		//Decided Forecast Values
		$forecastListQuery = "select * from forecast_decision_table where Customer_Name LIKE '%" . $custName[1] . 
		 		   				  "%' AND Product_Name LIKE '" . $prodName[1] . "' " ;
		$forecastQueryCall = mysql_query($forecastListQuery) or die(mysql_error());
		$forecastList = mysql_fetch_assoc($forecastQueryCall);
		$forecastValueArray = array();
		for($i = 0; $i < 26; $i++)
		{
			$forecastValueArray[$i] = $forecastList['Forecast_Week_N'.$i];
		}
		$temp =  array();
		for($i = 0; $i < 26; $i++)
		{
			if(sizeof($forecastList) > 1)
			{
				$temp[$i] = $forecastValueArray[$i];
			}
			else 
			{
				$temp[$i] = 0;
			}
		}
    	$custProdCurntUpdate = "UPDATE customer_prod_relation SET Comments = '".$forecastValuesList['Comments']."'," .
    							"Min_Stock = ".$forecastValuesList['Min_Stock']."  WHERE Customer_Name LIKE %'".$custName."'% AND " .
    								"Product_Name LIKE '".$current['Product_Name']."'";
    	echo $custProdCurntUpdate."<br>";
    	mysql_query($custProdCurntUpdate);
    	
    	
    
    	//Insert in cust_prod_current
    	if($var == 1)
    	{
    		$sql = "delete from forecastdb.cust_prod_current where uid = 1";
    		$list = mysql_query($sql);
    		$sql1 = "INSERT INTO forecastdb.cust_prod_current (UID, Customer_Name, Product_Name) VALUES (1, '".$custName[1]."', '".$prodName[1]."')";
    		$list = mysql_query($sql1);    	
    	}
    	else
    	{
	    	$sql = "INSERT INTO forecastdb.cust_prod_current (UID, Customer_Name, Product_Name) VALUES (1, '".$custName[1]."', '".$prodName[1]."')";
    		$list = mysql_query($sql);
    	}
    
    	//Liste_Display Entry	
    	$custNameTemp = $custName[1];
    	if($custNameTemp == "FNAC SA Centrale d'Achats")
 		{
 			$custNameTemp = "FNAC SA Centrale d''Achats";
 		}
		if($custNameTemp == "ATLANTIC TELECOM CHATEAU D'OLONNE")
 		{
			$custNameTemp = "ATLANTIC TELECOM CHATEAU D''OLONNE";
	 	}
		
	   	$namesListeExistQuery = "SELECT Product_Name, Customer_Name FROM liste_display WHERE" .
   									" Product_Name LIKE '".$prodName[1]."' AND " .
   										" Customer_Name LIKE '%".$custNameTemp."%' ";
   		$namesListeExistCall = mysql_query($namesListeExistQuery);
   		$namesListeExist = mysql_fetch_assoc($namesListeExistCall);
   			
   		if(($namesListeExist['Customer_Name'] == $custNameTemp) 
   					&& ($namesListeExist['Product_Name'] == $prodName[1]))
   		{
   		
   		}
   		else
   		{
   			set_time_limit(0);
   			$insertListeQuery = "INSERT INTO liste_display(Product_Name, Customer_Name) " .
   									"VALUES ('".$prodName[1]."', '".$custNameTemp."')";
   			//echo $i." ".$insertQuery."<br>";
			//$i++;
   			mysql_query($insertListeQuery);
   		}
    
    
    	//Insert in main_table_entries
    	if($var == 1)
    	{
    		$sql = "delete from forecastdb.main_table_entries where uid = 1";
    		$list = mysql_query($sql);
    		$sql1 = "INSERT INTO forecastdb.main_table_entries (UID, Customer_Name, Product_Name, Maturity, Year, Week, Last_Orders, Warehouse_Stock, " .
    					"Outlets_Stock, Stock_Theoritical, Batch_Moyen, Lead_Time, Monthly_Sales_Out, Monthly_Orders, Date_Status, EDD_First_Batch," .
    					"First_Order_Quantity, Reserved_Quantity, Couple_Article_Client, " .
    						"Valuer_Prevue, Sales_Out_Trend_1, Sales_Out_Trend_2, Sales_Out_Trend_3, Sales_Out_Trend_4) VALUES (1, '".$custName[1].
								"', '".$prodName[1]."', '".$prodMaturity."', ".$year.", ".$week.", ".$lastOrder.", ".$warehouseStock.", 0, ".$stockTheorique.
										", ".$batchMoyen.", ".$leadTime.", ".$monthlySalesOut.", ".$monthlyOrders.", '".$dateStatus."', 'Week ".$eddFirstBatch.
											"', ".$firstOrderQuantity.", ".$reservdQtyForecastValue.", ".$articleClientRatio.
												", ".$valuerPrevue.", ".$stockArray[6].", ".$stockArray[5].
													", ".$stockArray[4].", ".$stockArray[3].")";
													echo $sql1;
    		$list = mysql_query($sql1);
    	}
    	else
    	{
    		$sql = "INSERT INTO forecastdb.main_table_entries (UID, Customer_Name, Product_Name, Maturity, Year, Week, Last_Orders, Warehouse_Stock, " .
    					"Outlets_Stock, Stock_Theoritical, Batch_Moyen, Lead_Time, Monthly_Sales_Out, Monthly_Orders, Date_Status, EDD_First_Batch," .
    					"First_Order_Quantity, Reserved_Quantity, Couple_Article_Client, " .
    						"Valuer_Prevue, Sales_Out_Trend_1, Sales_Out_Trend_2, Sales_Out_Trend_3, Sales_Out_Trend_4) VALUES (1, '".$custName[1].
								"', '".$prodName[1]."', '".$prodMaturity."', ".$year.", ".$week.", ".$lastOrder.", ".$warehouseStock.", 0, ".$stockTheorique.
										", ".$batchMoyen.", ".$leadTime.", ".$monthlySalesOut.", ".$monthlyOrders.", '".$dateStatus."', 'Week ".$eddFirstBatch.
											"', ".$firstOrderQuantity.", ".$reservdQtyForecastValue.", ".$articleClientRatio.
												", ".$valuerPrevue.", ".$stockArray[6].", ".$stockArray[5].
													", ".$stockArray[4].", ".$stockArray[3].")";
													echo $sql;
    		$list = mysql_query($sql);
    	}
    	
    	

		mysql_close($db_handle);
		
    	if($_SESSION['page'] == "MassProd")
    	{
    		if($prodMaturity == "DEV")
    		{
    			header("location: /forecast/newMVCProj/views/salesViews/mainTTLPage.php");
    		}
    		else
    		{
    			header("location: /forecast/newMVCProj/views/salesViews/mainPage.php");
    		}
    	}
		else
		{
			header("location: /forecast/newMVCProj/views/salesViews/mainTTLPage.php");
		}
		
	}
	else
	{
		header("location: /forecast/newMVCProj/views/salesViews/mainPage.php");
	}
	
}
 else
 {
 	echo "You are not logged in";
 }
?>
