<?php
/*
 * Created on Apr 26, 2013
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
 $username = mysql_escape_string($_POST['name']);
 $password = mysql_escape_string($_POST['password']);
 $role = mysql_escape_string($_POST['role']);
 ?>
 <div id = "title_block4">
 <?php
if(($username == "") || ($password == "") || ($role == ""))
{
	if($username == "")
	{
		echo "User Name can not be empty."."<br>";
	}
	if($password == "")
	{
		echo "Password can not be empty."."<br>";
	}
	if($role == "")
	{
		echo "Role can not be empty."."<br>";
	}
}
else
{
	$sql = "";
 	
    $sql = "select * from forecastaccess.access_rights where User_Name = '".$username."'";
   
    $list = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($list);
    $userNotPresent = false;
   	if($row['User_Name'] == NULL)
   	{
   		$userNotPresent = true;
   		//echo $userNotPresent;
   	}
   	
    $sql = "select MAX(UID) from forecastaccess.access_rights";
   
   	$list = mysql_query($sql);
   	$row1 = mysql_fetch_assoc($list);
    $var = 0;
    
   	if($userNotPresent == true)
   	{
   		$var = $row1['MAX(UID)'];
   		$sql1 = "INSERT INTO forecastaccess.access_rights (UID, User_Name, Password, Role) VALUES (".($var+1).", '".$username
   						."', '".$password."', '".$role."')";
   		mysql_query($sql1) or die(mysql_error());
   		//header("location: /newMVCProj/views/adminViews/createAccounts.php");
   		echo "User created successfully.";
   	}
   	else
   	{
   		echo "Username already used. Try another user name.";
 	}
 
}
 	
    
?>
</div>
<div id = "title_block4">
<form method = "post" action = "/forecast/newMVCProj/views/adminViews/createAccounts.php">
  	 		<input type="hidden" name="form3" value="form3" />
 			<input id = "backButton" type="submit" name="Submit" value="Go Back to Create Accounts Page" />
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