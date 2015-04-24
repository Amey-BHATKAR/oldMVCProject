<?php
/*
 * Created on Apr 30, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 #Ftp upload

$ftp_server = "ascendeo@84.207.23.11"; #Or IP#
$ftp_user_name = "forecast";
$ftp_user_pass = "PvX5ivUC";

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// check connection
if ((!$conn_id) || (!$login_result)) {
echo "FTP connection has failed!";
echo "Attempted to connect to".$ftp_server."for user".$ftp_user_name;
die;
} else {
echo "Connected to".$ftp_server."for user".$ftp_user_name."<br>";
}

//Add dest. directory to filename

$destination_file = $_SERVER['DOCUMENT_ROOT']."/forecast/newMVCProj/excelSheets/" ;

// upload the file

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);

// check upload status
if (!$upload) {
echo "FTP upload has failed!";
} else {
echo "Uploaded to $ftp_server file<b> $destination_file</b>","<br>";
}


// close the FTP stream
ftp_close($conn_id); 
?>
