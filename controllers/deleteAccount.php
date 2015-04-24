<?php
/*
 * Created on Apr 29, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 ?>
 
<html>
<head><link href="/forecast/newMVCProj/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/headerAdmin.php'); 
	?>
</head>
</head>
<body>
<?php
 session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 1))
 {
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
	$userID = mysql_escape_string($_POST['userID']);
?>
 <div id = "title_block4">
 <?php
	if($userID == 0)
	{
		echo "Please select a user."."<br>";
	}
	else
	{
		$sql = "";
 		mysql_connect ("localhost","forecast","21ARFUvP");
   	 	mysql_select_db ("forecastaccess");
    	$sql = "select * from forecastaccess.access_rights where UID = ".$userID;
   
    	$list = mysql_query($sql) or die(mysql_error());
   	 	$row = mysql_fetch_assoc($list);
    	
    	$sql1 = "DELETE FROM forecastaccess.access_rights where User_Name = '".$row['User_Name']."'";
   		mysql_query($sql1) or die(mysql_error());
    	echo "User deleted successfully.";
    	
    	
    
   		
   		//header("location: /forecast/newMVCProj/views/adminViews/createAccounts.php");
	}
 	
   ?>
   		
   	
</div>
<div id = "title_block4">
<form method = "post" action = "/forecast/newMVCProj/views/adminViews/deleteAccounts.php">
  	 		<input type="hidden" name="form3" value="form3" />
 			<input id = "backButton" type="submit" name="Submit" value="Go Back to Delete Accounts Page" />
 		</form>
 		</div>
</body>
</html>
<?php
}
 else
 {
 	echo "You are not logged in";
 }
 
?>