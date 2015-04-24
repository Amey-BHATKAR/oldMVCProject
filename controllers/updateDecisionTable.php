
<?php
/*
 * Created on Apr 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 2))
 {
 	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
	$custName = mysql_escape_string($_POST['custName']);
 	$prodName = mysql_escape_string($_POST['prodName']);
 	$forecastValue = mysql_escape_string($_POST['forecastValue']);
 	
 	
 	
 	$week = date("W");
 	$year = date("o");
 	if($custName == "FNAC SA Centrale d'Achats")
 	{
 		$custName = "FNAC SA Centrale d''Achats";
 	}
 	
 	
  
//Forecast Insert in Database
	$forecastListQuery = "select * from forecastdb.forecast_decision_table where Customer_Name LIKE '%" . $custName . 
		 					  "%' AND Product_Name LIKE '" . $prodName . "' " ;
	$forecastSearch = mysql_query($forecastListQuery);
	$resultCount = mysql_fetch_assoc($forecastSearch);
	$forecastMaxUIDQuery = "select MAX(UID) from forecastdb.customer_prod_relation" ;
	$forecastSearchMaxUIDsearch = mysql_query($forecastMaxUIDQuery);
	$forecastSearchMaxUIDList = mysql_fetch_assoc($forecastSearchMaxUIDsearch);
	$forecastSearchMaxUID = 0;
	if(sizeof($forecastSearchMaxUIDList) > 0)
	{
		$forecastSearchMaxUID = $forecastSearchMaxUIDList['MAX(UID)'];
	}
	else
	{
		$forecastSearchMaxUID = 0;
	}
	$forecastSearchMaxUID = $forecastSearchMaxUID + 1;
	
	$temp3 = $week;
	for($i = 0; $i < 26 ;$i++)
	{
		$temp2[$i] = $forecastValue[$i];
		echo $temp2[$i]."<br>";
	}
	
	for($i = 0; $i < 26 ;$i++)
	{	
		
		
		
		$temp1 .= "Forecast_Week_N".$i." = ".$temp2[$i]."";
		$temp4 .= "Forecast_Week_N".$i;
		$temp5 .= "".$temp2[$i];
		if(!($i == 25))
		{
			$temp1 .= ", ";
			$temp4 .= ", ";
			$temp5 .= ", ";
		}
		else
		{
			$temp1 = $temp1;
			$temp4 = $temp4;
			$temp5 = $temp5;
		}
	}
	

	if (($resultCount['Customer_Name'] == $custName) && ($resultCount['Product_Name'] == $prodName))
	{	
		
			
		mysql_query("UPDATE forecastdb.forecast_decision_table
					SET ".$temp1.
					" WHERE Customer_Name LIKE '%" . $custName . 
						"%' AND Product_Name LIKE '" . $prodName . "'")
						or die(mysql_error());		
    } 
    else 
    {
    	
	    mysql_query("INSERT forecastdb.forecast_decision_table (UID, Product_Name, Customer_Name, ".$temp4.",Login)
				VALUES (".$forecastSearchMaxUID.", '".$prodName."', '".$custName."', ".$temp5.", '".$_SESSION['name']."')") 
    				 or die(mysql_error()); 
    				 
    	$custNameTemp = $custName;			 
    	if($custNameTemp == "FNAC SA Centrale d'Achats")
 			{
 				$custNameTemp = "FNAC SA Centrale d''Achats";
 			}
 			if($custNameTemp == "ATLANTIC TELECOM CHATEAU D'OLONNE")
 			{
	 			$custNameTemp = "ATLANTIC TELECOM CHATEAU D''OLONNE";
		 	}
	 	
		   	$namesListeExistQuery = "SELECT Product_Name, Customer_Name FROM liste_display WHERE" .
   										" Product_Name LIKE '".$prodName."' AND " .
   											" Customer_Name LIKE '%".$custNameTemp."%' ";
   			$namesListeExistCall = mysql_query($namesListeExistQuery);
   			$namesListeExist = mysql_fetch_assoc($namesListeExistCall);
   			
   			if(($namesListeExist['Customer_Name'] == $custNameTemp) 
   						&& ($namesListeExist['Product_Name'] == $prodName))
   			{
   		
   			}
   			else
   			{
   				set_time_limit(0);
   				$insertListeQuery = "INSERT INTO liste_display(Product_Name, Customer_Name, From_Table) " .
   										"VALUES ('".$prodName."', '".$custNameTemp."', 'Decided')";
   				//echo $i." ".$insertQuery."<br>";
		   		//$i++;
   				mysql_query($insertListeQuery);
   			}
	}
	





//Comments
	$comments = mysql_escape_string($_POST['comments']);

//Minimum Stock
	$minStock = mysql_escape_string($_POST['minStock']);

//Comments and Min Stock
	$relationListQuery = "select * from forecastdb.customer_prod_relation where Customer_Name LIKE '%" . $custName . 
							"%' AND Product_Name LIKE '" . $prodName . "' " ;
	
	$relationSearch = mysql_query($relationListQuery);
	$resultCount = mysql_numrows($relationSearch);
	$relationMaxUIDQuery = "select MAX(UID) from forecastdb.customer_prod_relation" ;
	$relationMaxUIDsearch = mysql_query($relationMaxUIDQuery);
	$relationMaxUIDList = mysql_fetch_assoc($relationMaxUIDsearch);
	$relationMaxUID = 0;
	if(sizeof($relationMaxUIDList) > 0)
	{
		$relationMaxUID = $relationMaxUIDList['MAX(UID)'];
	}
	else
	{
		$relationMaxUID = 0;
	}
	$relationMaxUID = $relationMaxUID + 1;



	if ($resultCount > 0) 
	{
 
    	mysql_query("UPDATE forecastdb.customer_prod_relation
				SET Comments = '" . $comments . 
				"', Min_Stock = " . $minStock .
				" WHERE Customer_Name LIKE '%" . $custName . 
						"%' AND Product_Name LIKE '" . $prodName . "' ") 
     					or die(mysql_error());
    } 
    else
    {
	   mysql_query("INSERT INTO forecastdb.customer_prod_relation (UID, Customer_Name, Product_Name, Comments, Min_Stock, Max_Stock, Login)
				VALUES('".$relationMaxUID."', '".$custName."', '".$prodName."', '".$comments."', '".$minStock."', 0, '".$_SESSION['name']."')") 
    				 or die(mysql_error()); 
	}
 
//For History
	$historyListQuery = "select * from forecastdb.history where Customer_Name LIKE '%" . $custName . 
								"%' AND Product_Name LIKE '" . $prodName . "' " ;
	$historyQueryCall = mysql_query($historyListQuery) or die(mysql_error());
	$historyList = array();
	$lastOrder = 0;
	$columnL = 0;
	$montantHTV = 0.00;
	while($historyList = mysql_fetch_assoc($historyQueryCall))
	{
		$lastOrder = $lastOrder + $historyList['Quantities_V'];
		$columnL = $columnL + $historyList['Column_L'];
		$montantHTV += $historyList['Montant_Net_H_T_V'];
	}
	$fullHistoryListQuery = "select * from forecastdb.history where Product_Name LIKE '" . $prodName . "' " ;
	$fullHistoryQueryCall = mysql_query($fullHistoryListQuery) or die(mysql_error());
	$fullHistoryList = array();
	$articleQuantitySum = 0;
	$valuerPrevue = 0;
	while($fullHistoryList = mysql_fetch_assoc($fullHistoryQueryCall))
	{
		$articleQuantitySum =  $articleQuantitySum + $fullHistoryList['Quantities_V'];
	}

//EDD First Batch
		$minWeekQuery = "select MIN(Week) from dev where Product_Name LIKE '".$prodName."'";
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
		
		
//Reserved Quantity
		$reservdQtyListQuery = "select * from forecast_decision_table where Product_Name LIKE '" . $prodName . "' " ;
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
		mysql_query("UPDATE forecastdb.main_table_entries
			SET Reserved_Quantity = " . $reservdQtyForecastValue ." WHERE UID = 1 ") 
   					or die(mysql_error());

//Forecast Decision values
	$totalForecastValue = 0;
	for($i = 0; $i < 26; $i++)
	{
		$totalForecastValue = $totalForecastValue + $forecastValue[$i];
	}
	$valuerPrevue = ($montantHTV/$lastOrder)*$totalForecastValue;
	mysql_query("UPDATE forecastdb.main_table_entries
			SET Valuer_Prevue = " . $valuerPrevue ." WHERE UID = 1 ") 
   					or die(mysql_error());
   	mysql_close($db_handle);
	if($_SESSION['page'] == "MassProd")
    	{
    		header("location: /forecast/newMVCProj/views/salesViews/mainPage.php");
    	}
		else
		{
			header("location: /forecast/newMVCProj/views/salesViews/mainTTLPage.php");
		}

 	
	
	
}
 else
 {
 	echo "You are not logged in";
 }
?>