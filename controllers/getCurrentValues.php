
<?php include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/class/pData.class.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/class/pDraw.class.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/class/pImage.class.php'); ?>


<?php
/*
 * Created on Apr 18, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 	
 	
 	
session_start();
if(isset($_SESSION['role']) && ($_SESSION['role'] == 2))
{
 	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
 	$week = date("W");
 	
 	$user_name = "forecast";
	$password = "21ARFUvP";
	$database = "forecastdb";
	//$server = "127.0.0.1";
	
	mysql_connect ("localhost","forecast","21ARFUvP");
   	mysql_select_db ("forecastdb");
   
   
    
    
	$sql = "select * from forecastdb.main_table_entries where uid = 1";
    $list = mysql_query($sql);
    $current = mysql_fetch_assoc($list);
    //echo "Hi";
    //echo $current['Customer_Name'];
    $custName = $current['Customer_Name'];
    if($custName == "FNAC SA Centrale d'Achats")
 	{
 		$custName = "FNAC SA Centrale d''Achats";
 	}
   
    
    
//For forecast values
    $forecastListQuery = "select * from forecastdb.forecast_decision_table where Customer_Name LIKE '%" . $custName . 
								  "%' AND Product_Name LIKE '" . $current['Product_Name'] . "' " ;
	$forecastSearch = mysql_query($forecastListQuery);
    $forecastValuesList = mysql_fetch_assoc($forecastSearch);
    $forecastValues[26] = array();
    if($forecastValuesList == NULL)
    {
    	for($i = 0; $i < 26; $i++)
    	{
    		$forecastValues[$i] = 0;
    	}
    }
    else
    {	for($i = 0; $i < 26; $i++)
    	{
    		$forecastValues[$i] = $forecastValuesList['Forecast_Week_N'.$i];
    		//echo $forecastValuesList['Forecast_Week_N'.$i]."--";
    		//echo $forecastValues[$i]."<br>";
    	}
    	
    	$custProdCurntUpdate = "UPDATE customer_prod_relation SET Comments = '".$forecastValuesList['Comments']."'," .
    							"Min_Stock = ".$forecastValuesList['Min_Stock']."  WHERE Customer_Name LIKE %'".$custName."'% AND " .
    								"Product_Name LIKE '".$current['Product_Name']."'";
    	//echo $custProdCurntUpdate."<br>";
    	mysql_query($custProdCurntUpdate);
    }
    
    
  	$sql1 = "select * from forecastdb.customer_prod_relation where Customer_Name LIKE '%".$custName."%' and Product_Name LIKE '".$current['Product_Name']."'";
    //echo $sql1;
    $list1 = mysql_query($sql1);
    $stckncomm = mysql_fetch_assoc($list1);
    $minStock = $stckncomm['Min_Stock'];
    $comments = $stckncomm['Comments'];
    
    
//For Sales Stocks
    $salesListQuery = "select * from forecastdb.salesout where Customer_Name LIKE '%" . $custName . 
								"%' AND Product_Name LIKE '" . $current['Product_Name'] . "'";
	$status = false;
	$salesQueryCall = mysql_query($salesListQuery) or die(mysql_error());
	$salesList = mysql_fetch_assoc($salesQueryCall);
	$stockArray[33] = array();
	if($salesList == NULL)
    {
    	for($i = 0; $i < 32; $i++)
    	{
    		$stockArray[$i] = 0;
    	}
    }
    else
    {	
    	for($i = -6, $j = 0; $j < 32; $i++, $j++)
    	{
    		$stockArray[$j] = $salesList['Stock_Week_N'.$i];
    	}
    }
		
	
//For Orders
	$ordersListArray[54] = array();
	$ordersListQuery = "select * from forecastdb.orders where Customer_Name LIKE '%" . $custName . 
							"%' AND Product_Name LIKE '" . $current['Product_Name'] . "' " ;
	$ordersQueryCall = mysql_query($ordersListQuery) or die(mysql_error());
	while($ordersList = mysql_fetch_assoc($ordersQueryCall))
	{
		for($k = 1; $k < 55 ; $k++)
		{
			if($k == $ordersList['Week'])
			{
				$ordersListArray[$k] += $ordersList['Quantities_Cdes'];
			}
			else
			{
				$ordersListArray[$k] = 0;
			}
		}
	}
		
////////////////////////                GRAPH                     /////////////////				 
	
	$week = date("W");
	
	$xTicksValues[26] = array();
	$minStockValues[26] = array();
	$maxStockValues[26] = array();
	$YxActualValues[26] = array();
	
	$initialValue = $current['Warehouse_Stock'] + $current['Outlets_Stock'] + $current['Stock_Theoritical'] 
						- $stockArray[6] + $forecastValues[0];
	$YxActualValues[0] = $initialValue;
	$tempVal = $initialValue; 
	for($i = 0; $i < 26; $i++)
	{	
		//For X Tick Values(Weeks)
		$xTicksValues[$i] = $week + $i;
		
		//For Minimum Stock Line
		$minStockValues[$i] = $minStock;
		
		//For Maximum Stock Line
		$maxStockValues[$i] = $minStock * 2;
		
	}
	
	for($i = 1; $i < 26; $i++)
	{
		//For YxActualValues Line
		$tempVal = $tempVal - $stockArray[(6+$i)] + $forecastValues[$i];
		$YxActualValues[$i] = $tempVal;
	}
	
	
	
 	/* Create and populate the pData object */
 		$MyData = new pData();  
 		$MyData->addPoints(array($minStockValues[0],$minStockValues[1],$minStockValues[2],$minStockValues[3],$minStockValues[4],$minStockValues[5],
 			$minStockValues[6],$minStockValues[7],$minStockValues[8],$minStockValues[9],$minStockValues[10],$minStockValues[11],$minStockValues[12],
 				$minStockValues[13],$minStockValues[14],$minStockValues[15],$minStockValues[17],$minStockValues[18],$minStockValues[19],$minStockValues[20],
 					$minStockValues[21],$minStockValues[22],$minStockValues[23],$minStockValues[24],$minStockValues[25]),"Min. Stock");
 		$MyData->addPoints(array($maxStockValues[0],$maxStockValues[1],$maxStockValues[2],$maxStockValues[3],$maxStockValues[4],$maxStockValues[5],
 			$maxStockValues[6],$maxStockValues[7],$maxStockValues[8],$maxStockValues[9],$maxStockValues[10],$maxStockValues[11],$maxStockValues[12],
 				$maxStockValues[13],$maxStockValues[14],$maxStockValues[15],$maxStockValues[17],$maxStockValues[18],$maxStockValues[19],$maxStockValues[20],
 					$maxStockValues[21],$maxStockValues[22],$maxStockValues[23],$maxStockValues[24],$maxStockValues[25]),"Max. Stock");
 		$MyData->addPoints(array($YxActualValues[0],$YxActualValues[1],$YxActualValues[2],$YxActualValues[3],$YxActualValues[4],$YxActualValues[5],
 			$YxActualValues[6],$YxActualValues[7],$YxActualValues[8],$YxActualValues[9],$YxActualValues[10],$YxActualValues[11],$YxActualValues[12],
 				$YxActualValues[13],$YxActualValues[14],$YxActualValues[15],$YxActualValues[17],$YxActualValues[18],$YxActualValues[19],$YxActualValues[20],
 					$YxActualValues[21],$YxActualValues[22],$YxActualValues[23],$YxActualValues[24],$YxActualValues[25]),"Growth Line");
 		$MyData->setSerieTicks("Max. Stock",4);
 		$MyData->setSerieWeight("Growth Line",2);
 		$MyData->setAxisName(0,"Stock");
 		$MyData->addPoints(array($xTicksValues[0],$xTicksValues[1],$xTicksValues[2],$xTicksValues[3],$xTicksValues[4],$xTicksValues[5],
 			$xTicksValues[6],$xTicksValues[7],$xTicksValues[8],$xTicksValues[9],$xTicksValues[10],$xTicksValues[11],$xTicksValues[12],
 				$xTicksValues[13],$xTicksValues[14],$xTicksValues[15],$xTicksValues[17],$xTicksValues[18],$xTicksValues[19],$xTicksValues[20],
 					$xTicksValues[21],$xTicksValues[22],$xTicksValues[23],$xTicksValues[24],$xTicksValues[25]),"Labels");
 		$MyData->setSerieDescription("Labels","Weeks");
 		$MyData->setAbscissa("Labels");
		

 	/* Create the pChart object */
 		$myPicture = new pImage(800,490,$MyData);

 	/* Turn of Antialiasing */
 		$myPicture->Antialias = FALSE;

 	/* Add a border to the picture */
 		$myPicture->drawRectangle(0,0,799,489,array("R"=>0,"G"=>0,"B"=>0));
 
 	/* Write the chart title */ 
 	$myPicture->setFontProperties(array("FontName"=>$_SERVER['DOCUMENT_ROOT']."/forecast/newMVCProj/controllers/fonts/Forgotte.ttf","FontSize"=>11));
 	$myPicture->drawText(150,35,"Customer Stock Evolution",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

 	/* Set the default font */
 		$myPicture->setFontProperties(array("FontName"=>$_SERVER['DOCUMENT_ROOT']."/forecast/newMVCProj/controllers/fonts/pf_arma_five.ttf","FontSize"=>6));

 	/* Define the chart area */
 		$myPicture->setGraphArea(40,40,780,470);

 	/* Draw the scale */
 		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 		$myPicture->drawScale($scaleSettings);

 	/* Turn on Antialiasing */
 		$myPicture->Antialias = TRUE;

 	/* Draw the line chart */
 		$myPicture->drawLineChart();

 	/* Write the chart legend */
 		$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 	/* Render the picture (choose the best way) */
 		if($current['Customer_Name'] == "ASCENDEO UK IRELAND/CENTROSUS MOBIL")
 		{
 			$custTemp = "ASCENDEO UK IRELAND CENTROSUS MOBIL";
 		}
 		else
 		{
 			$custTemp = $current['Customer_Name'];
 		}
 		$custTemp = str_replace(' ', '_', $custTemp);
		 //$myPicture->autoOutput($_SERVER['DOCUMENT_ROOT']."/forecast/newMVCProj/controllers/pictures/".$current['Customer_Name']."_".$current['Product_Name'].".jpeg");
 		$myPicture->render($_SERVER['DOCUMENT_ROOT']."/forecast/newMVCProj/controllers/pictures/".$custTemp."_".$current['Product_Name'].".jpeg");
		 

 }
 else
 {
 	echo "You are not logged in";
 }
?>	
