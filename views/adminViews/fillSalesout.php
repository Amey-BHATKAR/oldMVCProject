<?php
/*
 * Created on 15-May-2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 1))
 {
 
?>
<!DOCTYPE html>
<html>
<head><link href="/forecast/newMVCProj/css/bootstrap.min.css" rel="stylesheet" media="screen">
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/headerAdmin.php'); 
?>
</head>
<body>
<br>

  	<div id = "title_block4">
<form method = "post" action = "/forecast/newMVCProj/controllers/salesout.php">
  	
  		<input type="hidden" name="form1" value="form1" />
 <input type="submit" name="Submit" title = "Confirmation needed since it takes long time to generate the fill salesout stocks forecast." value="Confirmation to Update Salesout Forecast Stocks" />
 </form>

 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/adminPage.php">
  	
  		<input type="hidden" name="form3" value="form3" />
 <input id = "backButton" type="submit" name="Submit" value="Go Back to Admin Page" />
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