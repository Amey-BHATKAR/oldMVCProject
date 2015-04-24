

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
<form method = "post" action = "/forecast/newMVCProj/controllers/exportHandler/CustProdRelnExport.php">
  	
  		<input type="hidden" name="form1" value="form1" />
 <input type="submit" name="Submit" value="Customer Product Relation" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/controllers/exportHandler/ForecastDecisionTableExport.php">
  	
  		<input type="hidden" name="form2" value="form2" />
 <input type="submit" name="Submit" value="Forecast Decision Table" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/controllers/exportHandler/GlobalForecastExport.php">
  	
  		<input type="hidden" name="form3" value="form3" />
 <input type="submit" name="Submit" value="Global Forecast" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/adminPage.php">
  	
  		<input type="hidden" name="form4" value="form4" />
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