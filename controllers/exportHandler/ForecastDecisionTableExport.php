<?php
/*
 * Created on Apr 25, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 			$dbHost	= 'localhost';			//	database host
			$dbUser	= 'forecast';		//	database user
			$dbPass	= '21ARFUvP';		//	database password
			$dbName	= 'forecastdb'; 		//	database name
			

			$connection = @mysql_connect($dbHost, $dbUser, $dbPass) or die("Couldn't connect.");
			$db = mysql_select_db($dbName) or die("Couldn't select database.");
 
 	function export($tableName)
		{
			
			$dbTable = $tableName;
			$sql = "Select * from forecastdb.".$dbTable;
				//echo $sql;
			$result = @mysql_query($sql)	or die("Couldn't execute query:
				".mysql_error().'
					'.mysql_errno());
	
			$filepath=$dbTable."-".date('Ymd').".csv";
			header('Content-Type: application/vnd.ms-excel');	//define header info for browser
			header("Content-Disposition: attachment; filename=\"".basename($filepath)."\"" ); 
			//header('Content-Disposition: attachment; filename= ".$dbTable."-".date('Ymd').".xls");
			header('Pragma: no-cache');
			header('Expires: 0');

			echo "UID;Product_Name;Customer_Name;Forecast_Week_N0;Forecast_Week_N1;Forecast_Week_N2;" .
					"Forecast_Week_N3;Forecast_Week_N4;Forecast_Week_N5;Forecast_Week_N6;Forecast_Week_N7;" .
						"Forecast_Week_N8;Forecast_Week_N9;Forecast_Week_N10;Forecast_Week_N11;Forecast_Week_N12;" .
						"Forecast_Week_N13;Forecast_Week_N14;Forecast_Week_N15;Forecast_Week_N16;Forecast_Week_N17;" .
					"Forecast_Week_N18;Forecast_Week_N19;Forecast_Week_N20;Forecast_Week_N21;Forecast_Week_N22;" .
				"Forecast_Week_N23;Forecast_Week_N24;Forecast_Week_N25;Comments;Min_Stock;Login;Timestamp\t";
			print("\n");

			while($row = mysql_fetch_array($result))
			{
				//set_time_limit(60); // you can enable this if you have lot of data
				$output = '';
				if(!isset($row[0]))
					$output .= "NULL\t";
				else
					$output .= $row[0].";".$row[1].";".$row[2].";".$row[3].";".
									$row[4].";".$row[5].";".$row[6].";".$row[7].";".
								$row[8].";".$row[9].";".$row[10].";".$row[11].";".
									$row[12].";".$row[13].";".$row[14].";".$row[15].";".
								$row[16].";".$row[17].";".$row[18].";".$row[19].";".
									$row[20].";".$row[21].";".$row[22].";".$row[23].";".
								$row[24].";".$row[25].";".$row[26].";".$row[27].";".
									$row[28].";".$row[29].";".$row[30].";".$row[31].";".
								$row[32]."\t";
				
				$output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
				print(trim($output))."\t\n";
			}
			sleep(1);
			
			if (!copy('C:/Users/Amey/Downloads/'.$filepath, $_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/excelSheets/'.$filepath)) 
			{
    			echo "failed to copy $file...\n";
			}
			//rename('C:/Users/Amey/Downloads/'.$filepath, 'C:/xampp/htdocs/exportDB/excelSheets/'.$filepath);
		}
 	
 	export ('forecast_decision_table');
 	
?>

