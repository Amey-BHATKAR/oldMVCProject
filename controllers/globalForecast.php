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
 	
   	$uidQuery = "SELECT UID FROM global_forecast";
   	
   	if(mysql_query($uidQuery))
   	{
   		$uidCall = mysql_query($uidQuery);
   		$uidList = array();
   		//$i = 0;
   		while($uidList = mysql_fetch_assoc($uidCall))
   		{
   			set_time_limit(0);
   			//echo $uidList['UID']."<br>";
   			
   			
   			//Global Forecast Product List
   			$globalForecastQuery = "SELECT * FROM global_forecast WHERE UID = ".$uidList['UID'];
 			$globalForecastCall = mysql_query($globalForecastQuery) or die(mysql_error());
 			//echo $custForecastQuery."<br>";
 			$globalForecastList = mysql_fetch_assoc($globalForecastCall);
 			$prodNameGlobal = $globalForecastList['Product_Name'];
 			//echo "Product # ".$i."is : ".$prodNameGlobal."<br>";
 			//$i++;
 			
 			//Customer Forecast List
   			$custForecastQuery = "SELECT * FROM customer_forecast WHERE Product_Name = '".$prodNameGlobal."'";
 			$custForecastCall = mysql_query($custForecastQuery) or die(mysql_error());
 			$globalForecastArray = array();
 			//echo $custForecastQuery."<br>";
 			
 			while($custForecastList = mysql_fetch_assoc($custForecastCall))
 			{
 				//Global Forecast Values
 				for($i = 0; $i < 26; $i++)
 				{
 					$globalForecastArray[$i] = 0;
 					if($custForecastList['Forecast_Week_N'.$i])
 					{
 						$globalForecastArray[$i] += $custForecastList['Forecast_Week_N'.$i];
 					}
 				}
 				
 				
 				
 				
 				
 				//Decided Volume Numerator
 				$decidedVolume = "";
 				$decidedVolumeNum = 0;
 				$decidedVolumeDenom = 0;
 				if($custForecastList['Updated_From'] == "Decided")
 				{
 					$decidedVolumeNum += $custForecastList['Forecast_Week_N0'];
 				}
 				else
 				{
 					$decidedVolumeNum += 0;
 				}
 				
 				
 			}
 			//MM Value
 			$mmGlobal = 0;
 			for($j = 0; $j < 16; $j++)
 			{
 				$mmGlobal += $globalForecastArray[$j];
 			}
 			$mmGlobal = $mmGlobal / 15;
 			$mmGlobal = round($mmGlobal * 4);
 				
 			//Decided Volume
 			for($j = 0; $j < 14; $j++)
 			{
 				$decidedVolumeDenom += $globalForecastArray[$j];
 			}
 			$decidedVolume = number_format(($decidedVolumeNum / $decidedVolumeDenom) , 1)." %";
   		
   			//Insert in Global Forecast database
   			$insertGlobalQuery = "UPDATE global_forecast SET MM = $mmGlobal, " .
   									"G_Forecast_Week_N0 = $globalForecastArray[0], " .
   										"G_Forecast_Week_N1 = $globalForecastArray[1], " .
   											"G_Forecast_Week_N2 = $globalForecastArray[2], " .
   												"G_Forecast_Week_N3 = $globalForecastArray[3], " .
   													"G_Forecast_Week_N4 = $globalForecastArray[4], " .
   														"G_Forecast_Week_N5 = $globalForecastArray[5], " .
   															"G_Forecast_Week_N6 = $globalForecastArray[6], " .
   																"G_Forecast_Week_N7 = $globalForecastArray[7], " .
   																	"G_Forecast_Week_N8 = $globalForecastArray[8], " .
   																		"G_Forecast_Week_N9 = $globalForecastArray[9], " .
   																			"G_Forecast_Week_N10 = $globalForecastArray[10], " .
   																				"G_Forecast_Week_N11 = $globalForecastArray[11], " .
   																			"G_Forecast_Week_N12 = $globalForecastArray[12], " .
   																		"G_Forecast_Week_N13 = $globalForecastArray[13], " .
   																	"G_Forecast_Week_N14 = $globalForecastArray[14], " .
   																"G_Forecast_Week_N15 = $globalForecastArray[15], " .
   															"G_Forecast_Week_N16 = $globalForecastArray[16], " .
   														"G_Forecast_Week_N17 = $globalForecastArray[17], " .
   													"G_Forecast_Week_N18 = $globalForecastArray[18], " .
   												"G_Forecast_Week_N19 = $globalForecastArray[19], " .
   											"G_Forecast_Week_N20 = $globalForecastArray[20], " .
   										"G_Forecast_Week_N21 = $globalForecastArray[21], " .
   									"G_Forecast_Week_N22 = $globalForecastArray[22], " .
   										"G_Forecast_Week_N23 = $globalForecastArray[23], " .
   									"G_Forecast_Week_N24 = $globalForecastArray[24], " .
   										"G_Forecast_Week_N25 = $globalForecastArray[25], " .
   									"Decided_Volume = '$decidedVolume' " .
   									"WHERE UID = ".$uidList['UID'];
   			//echo $insertGlobalQuery."<br>";
   			mysql_query($insertGlobalQuery);
   		}
   	}
 	mysql_close($db_handle);
 	header("location: /forecast/newMVCProj/views/adminViews/globalForecasts.php");
 	}
 	else
 	{
 		echo "You are not logged in";
 	}
 
 	
?>
