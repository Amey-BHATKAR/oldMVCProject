<?php
/*
 * Created on 18-Jul-2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 function getGlobalForecast()
 {
 	include_once($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
 	set_time_limit(0);
 	$custName = mysql_escape_string($custName);
 	$dispGlobalForecastQuery = "SELECT * FROM forecastdb.global_forecast WHERE 1";
 	/*if($custName == "")
 	{
 		
 	}
 	else
 	{
 		$dispCustForecastQuery = "SELECT * FROM forecastdb.customer_forecast WHERE Customer_Name LIKE '%".$custName."%'";
 	}*/
 	$dispGlobalForecastCall = mysql_query($dispGlobalForecastQuery);
 	while($dispGlobalForecast = mysql_fetch_assoc($dispGlobalForecastCall))
 	{
 	?>
 	<tr>
 		<td><?php echo $dispGlobalForecast['UID'];?></td>
 		<td><?php echo $dispGlobalForecast['Product_Name'];?></td>
 		<td><?php echo $dispGlobalForecast['MM'];?></td>
 		<td><?php echo $dispGlobalForecast['Decided_Volume'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N0'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N1'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N2'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N3'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N4'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N5'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N6'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N7'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N8'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N9'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N10'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N11'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N12'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N13'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N14'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N15'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N16'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N17'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N18'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N19'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N20'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N21'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N22'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N23'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N24'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N25'];?></td>
 		
 	</tr>	
 	<?php
 	}
 }
 
 
  function getSearchedGlobalForecast($searchString)
 {
 	include_once($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
 	set_time_limit(0);
 	$custName = mysql_escape_string($custName);
 	$dispGlobalForecastQuery = "SELECT * FROM forecastdb.global_forecast WHERE Product_Name LIKE '%$searchString%'";
 	/*if($custName == "")
 	{
 		
 	}
 	else
 	{
 		$dispCustForecastQuery = "SELECT * FROM forecastdb.customer_forecast WHERE Customer_Name LIKE '%".$custName."%'";
 	}*/
 	$dispGlobalForecastCall = mysql_query($dispGlobalForecastQuery);
 	while($dispGlobalForecast = mysql_fetch_assoc($dispGlobalForecastCall))
 	{
 		?>
 	<tr>
 		<td><?php echo $dispGlobalForecast['UID'];?></td>
 		<td><?php echo $dispGlobalForecast['Product_Name'];?></td>
 		<td><?php echo $dispGlobalForecast['MM'];?></td>
 		<td><?php echo $dispGlobalForecast['Decided_Volume'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N0'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N1'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N2'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N3'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N4'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N5'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N6'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N7'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N8'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N9'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N10'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N11'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N12'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N13'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N14'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N15'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N16'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N17'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N18'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N19'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N20'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N21'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N22'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N23'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N24'];?></td>
 		<td><?php echo $dispGlobalForecast['G_Forecast_Week_N25'];?></td>
 		
 	</tr>
 	<?php
 	}
 }
?>
