<?php
/*
 * Created on 17-May-2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 1))
 {
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
   	$sql = "";
   	$uidQuery = "SELECT UID FROM customer_forecast";
   	
   	if(mysql_query($uidQuery))
   	{
   		$uidCall = mysql_query($uidQuery);
   		$uidList = array();
   		while($uidList = mysql_fetch_assoc($uidCall))
   		{
   			set_time_limit(0);
   			//echo $uidList['UID']."<br>";
   			
   			
   			//Customer Forecast List
   			$custForecastQuery = "SELECT * FROM customer_forecast WHERE UID = ".$uidList['UID'];
 			$custForecastCall = mysql_query($custForecastQuery) or die(mysql_error());
 			//echo $custForecastQuery."<br>";
 			$custForecastList = mysql_fetch_assoc($custForecastCall);
   			
   			$custName = $custForecastList['Customer_Name'];
   			
 			$custName = str_replace("'", "''",$custName);
 			$prodName = $custForecastList['Product_Name'];
   			
   			
   			
   			//Decided Forecast List
   			$decidedForecastQuery = "SELECT * FROM forecast_decision_table WHERE Customer_Name LIKE '%".$custName."%' AND" .
   											" Product_Name = '".$prodName."'";
 			$decidedForecastCall = mysql_query($decidedForecastQuery) or die(mysql_error());
 			//echo $decidedForecastQuery."<br>";
 			$decidedForecastList = mysql_fetch_assoc($decidedForecastCall);
 			//echo $decidedForecastList['Customer_Name']."<br>";
 			
 			//Comments and Min Stock
 			$custProdRelnQuery = "SELECT * FROM customer_prod_relation WHERE Customer_Name LIKE '%".$custName."%' AND" .
   											" Product_Name = '".$prodName."'";
   			$custProdRelnCall = mysql_query($custProdRelnQuery) or die(mysql_error());
   			$custProdReln = mysql_fetch_assoc($custProdRelnCall);
   			
 			if(sizeof($decidedForecastList) > 2)
 			{
 				
   				$customerForecastQuery = "UPDATE customer_forecast SET " .
   									"Forecast_Week_N0 = ".$decidedForecastList['Forecast_Week_N0'].", " .
   								"Forecast_Week_N1 = ".$decidedForecastList['Forecast_Week_N1']."," .
   							"Forecast_Week_N2 = ".$decidedForecastList['Forecast_Week_N2']."," .
   						"Forecast_Week_N3 = ".$decidedForecastList['Forecast_Week_N3']."," .
   					"Forecast_Week_N4 = ".$decidedForecastList['Forecast_Week_N4']."," .
   				"Forecast_Week_N5 = ".$decidedForecastList['Forecast_Week_N5']."," .
   			"Forecast_Week_N6 = ".$decidedForecastList['Forecast_Week_N6']."," .
   				"Forecast_Week_N7 = ".$decidedForecastList['Forecast_Week_N7']."," .
   					"Forecast_Week_N8 = ".$decidedForecastList['Forecast_Week_N8']."," .
   						"Forecast_Week_N9 = ".$decidedForecastList['Forecast_Week_N9']."," .
   							"Forecast_Week_N10 = ".$decidedForecastList['Forecast_Week_N10']."," .
   								"Forecast_Week_N11 = ".$decidedForecastList['Forecast_Week_N11']."," .
   									"Forecast_Week_N12 = ".$decidedForecastList['Forecast_Week_N12']."," .
   										"Forecast_Week_N13 = ".$decidedForecastList['Forecast_Week_N13']."," .
   									"Forecast_Week_N14 = ".$decidedForecastList['Forecast_Week_N14']."," .
   								"Forecast_Week_N15 = ".$decidedForecastList['Forecast_Week_N15']."," .
   							"Forecast_Week_N16 = ".$decidedForecastList['Forecast_Week_N16']."," .
   						"Forecast_Week_N17 = ".$decidedForecastList['Forecast_Week_N17']."," .
   					"Forecast_Week_N18 = ".$decidedForecastList['Forecast_Week_N18']."," .
   				"Forecast_Week_N19 = ".$decidedForecastList['Forecast_Week_N19']."," .
   			"Forecast_Week_N20 = ".$decidedForecastList['Forecast_Week_N20']."," .
   				"Forecast_Week_N21 = ".$decidedForecastList['Forecast_Week_N21']."," .
   					"Forecast_Week_N22 = ".$decidedForecastList['Forecast_Week_N22']."," .
   						"Forecast_Week_N23 = ".$decidedForecastList['Forecast_Week_N23']."," .
   							"Forecast_Week_N24 = ".$decidedForecastList['Forecast_Week_N24']."," .
   								"Forecast_Week_N25 = ".$decidedForecastList['Forecast_Week_N25']."," .
   									"Comments = '".mysql_real_escape_string($custProdReln['Comments'])."', " .
   										"Min_Stock = ".$custProdReln['Min_Stock'].", ".
   									"Login = '".$_SESSION['name']."'," .
   								"Updated_From = 'Decided' " .
   							"WHERE Customer_Name LIKE '%".$custName."%' ".
						 "AND Product_Name = '".$prodName."'";
   									//echo $customerForecastQuery."<br>";
 				$customerForecastCall = mysql_query($customerForecastQuery) or die(mysql_error());
 			
 			}
 			
 			
   		}
   		
   		
   	}
   			
	
 	//echo "Table updated.";
 	mysql_close($db_handle);
 	header("location: /forecast/newMVCProj/views/adminViews/customerForecasts.php");
 	
 }
 else
 {
 	echo "You are not logged in";
 }
 	
 
?>
