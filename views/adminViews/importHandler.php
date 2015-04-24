

<?php
/*
 * Created on Apr 25, 2013
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
 <div id = "title_block4">
Nothing to import at the moment. Please come back later.
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