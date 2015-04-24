
<?php
/*
 * Created on Apr 26, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 2))
 {
 	
 ?>
 
 
<html>
<head><link href="/forecast/newMVCProj/css/bootstrap.min.css" rel="stylesheet" media="screen">

<?php 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/headerSales.php'); 
?>
</head>
<body>
 <div id = "title_block2">
 <form method = "post" action = "/forecast/newMVCProj/views/salesViews/mainPage.php">
  	
  		<input type="hidden" name="form1" value="form1" />
 <input type="submit" name="Submit" value="Go to Mass Prod App" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/salesViews/mainTTLPage.php">
  	
  		<input type="hidden" name="form2" value="form2" />
 <input type="submit" name="Submit" value="Go to TTL App" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/salesViews/displayGlobalForecast.php">
  	
  		<input type="hidden" name="form3" value="form3" />
 <input type="submit" name="Submit" value="View Global Forecasts" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/salesViews/displayCustomerForecast.php">
  	
  		<input type="hidden" name="form4" value="form4" />
 <input type="submit" name="Submit" value="View Customer Forecast" />
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


