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
 	
   	
   	$uidQuery = "SELECT UID FROM salesout";
   	
   	if(mysql_query($uidQuery))
   	{
   		$uidCall = mysql_query($uidQuery);
   		$uidList = array();
   		while($uidList = mysql_fetch_assoc($uidCall))
   		{
   			$salesoutForecastQuery = "SELECT * FROM salesout WHERE UID = ".$uidList['UID'];
 			$salesoutForecastCall = mysql_query($salesoutForecastQuery) or die(mysql_error());
 			//echo $calcForecastQuery."<br>";
 			$salesoutForecastList = mysql_fetch_assoc($salesoutForecastCall);
 			
 			$status = $salesoutForecastList['Status'];
 			$salesoutForecast = array();
 			$salesoutForecast[0] = $salesoutForecastList['Stock_Week_N-6'];
 			$salesoutForecast[1] = $salesoutForecastList['Stock_Week_N-5'];
 			$salesoutForecast[2] = $salesoutForecastList['Stock_Week_N-4'];
 			$salesoutForecast[3] = $salesoutForecastList['Stock_Week_N-3'];
 			$salesoutForecast[4] = $salesoutForecastList['Stock_Week_N-2'];
 			$salesoutForecast[5] = $salesoutForecastList['Stock_Week_N-1'];
 			
 			for($i = 6; $i <= 32; $i++)
 			{
 				if(($status == "") || ($status == NULL))
 				{
 					$salesoutForecast[$i] = 0;
 				}
 				else
 				{
 					$salesoutForecast[$i] = round(($salesoutForecast[$i - 1] + $salesoutForecast[$i - 2]
 												+ $salesoutForecast[$i - 3] + $salesoutForecast[$i - 4] 
 													+ $salesoutForecast[$i - 5] + $salesoutForecast[$i - 6])/6);
 				}
 				//echo $salesoutForecast[$i]."<br>";
 			}
 			
 			$updateSalesout = "UPDATE salesout SET Stock_Week_N1 = ".$salesoutForecast[6]."," .
 								"Stock_Week_N2 = ".$salesoutForecast[7]."," .
 									"Stock_Week_N3 = ".$salesoutForecast[8]."," .
 										"Stock_Week_N4 = ".$salesoutForecast[9]."," .
 											"Stock_Week_N5 = ".$salesoutForecast[10]."," .
 												"Stock_Week_N6 = ".$salesoutForecast[11]."," .
 													"Stock_Week_N7 = ".$salesoutForecast[12]."," .
 														"Stock_Week_N8 = ".$salesoutForecast[13]."," .
 															"Stock_Week_N9 = ".$salesoutForecast[14]."," .
 																"Stock_Week_N10 = ".$salesoutForecast[15]."," .
 																	"Stock_Week_N11 = ".$salesoutForecast[16]."," .
 																		"Stock_Week_N12 = ".$salesoutForecast[17]."," .
 																			"Stock_Week_N13 = ".$salesoutForecast[18]."," .
 																				"Stock_Week_N14 = ".$salesoutForecast[19]."," .
 																			"Stock_Week_N15 = ".$salesoutForecast[20]."," .
 																		"Stock_Week_N16 = ".$salesoutForecast[21]."," .
 																	"Stock_Week_N17 = ".$salesoutForecast[22]."," .
 																"Stock_Week_N18 = ".$salesoutForecast[23]."," .
 															"Stock_Week_N19 = ".$salesoutForecast[24]."," .
 														"Stock_Week_N20 = ".$salesoutForecast[25]."," .
 													"Stock_Week_N21 = ".$salesoutForecast[26]."," .
 												"Stock_Week_N22 = ".$salesoutForecast[27]."," .
 											"Stock_Week_N23 = ".$salesoutForecast[28]."," .
 										"Stock_Week_N24 = ".$salesoutForecast[29]."," .
 									"Stock_Week_N25 = ".$salesoutForecast[30]." " .
 								"WHERE UID = ".$uidList['UID'];
 			
 			mysql_query($updateSalesout) or die(mysql_error());
 			
   		}
   		
   	}	
	
 	//echo "Table updated.";
 	mysql_close($db_handle);
 	header("location: /forecast/newMVCProj/views/adminViews/fillSalesout.php");
 	}
 	else
 	{
 	echo "You are not logged in";
 	}
 
 	
?>
