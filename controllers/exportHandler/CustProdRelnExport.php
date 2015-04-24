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

			// show column names as names of MySQL fields
			echo "UID;Customer_Name;Product_Name;Comments;Min_Stock;Max_Stock;TimeStamp;Login\t";
			print("\n");

			while($row = mysql_fetch_array($result))
			{
				//set_time_limit(60); // you can enable this if you have lot of data
				$output = '';
				if(!isset($row[0]))
						$output .= "NULL\t";
					else
						$output .= $row[0].";".$row[1].";".$row[2].";".$row[3].";".
									$row[4].";".$row[5].";".$row[6].";".$row[7]."\t";
				
				$output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
				print(trim($output))."\t\n";
			}
			sleep(1);
			if (!copy('C:/Users/Amey/Downloads/'.$filepath, $_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/excelSheets/'.$filepath)) 
			{
    			echo "failed to copy $filepath...\n";
			}
			//rename('C:/Users/Amey/Downloads/'.$filepath, 'C:/xampp/htdocs/exportDB/excelSheets/'.$filepath);
			/*
			sleep(1);
			
			$ftp_server = "sftp://ascendeo@84.207.23.11"; #Or IP#
			$ftp_user_name = "forecast";
			$ftp_user_pass = "PvX5ivUC";

			$connection = ssh2_connect($ftp_server, 22);
			ssh2_auth_password($connection, $ftp_user_name, $ftp_user_pass);

			ssh2_scp_send('C:/Users/Amey/Downloads/'.$filepath, $_SERVER['DOCUMENT_ROOT'].'/newMVCProj/excelSheets/'.$filepath, 0644);
			*/
		}
 	
 	export ('customer_prod_relation');
?>

