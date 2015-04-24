<html>
	<head>
		<link href="/forecast/newMVCProj/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<?php include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/header.php'); ?>
	</head>
	<body>
		<script src="/forecast/newMVCProj/js/bootstrap.min.js">
		</script>
<?php
/*
 * Created on Apr 16, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 //echo "This is to be the index page";
 
 
 session_start();
 
?>
<div id="title_block2">
Enter your credentials:
<form name = "form1" action= "/forecast/newMVCProj/controllers/validationPage.php" method="post">
	<table id = "table">
	<tr><td>User Name</td><td>: </td>
	<td><input type = "text" name = "name"></td></tr>
	<tr><td>Password</td><td>: </td>
	<td><input type = "password" name = "password"></td></tr>
	</table>
	<input type="submit" value="Submit" />
</form>
</div>
	</body>
</html>