
<?php
/*
 * Created on Apr 26, 2013
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
 <div id = "title_block2">
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/importHandler.php">
  	
  		<input type="hidden" name="form1" value="form1" />
 <input type="submit" name="Submit" value="Import to database" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/exportHandler.php">
  	
  		<input type="hidden" name="form2" value="form2" />
 <input type="submit" name="Submit" value="Export Tables to Excel Sheets" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/createAccounts.php">
  	
  		<input type="hidden" name="form3" value="form3" />
 <input type="submit" name="Submit" value="Create Accounts for Tool Access" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/deleteAccounts.php">
  	
  		<input type="hidden" name="form4" value="form4" />
 <input type="submit" name="Submit" value="Delete Accounts from Database for Tool Access" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/displayCustomerForecast.php">
  	
  		<input type="hidden" name="form9" value="form9" />
 <input type="submit" name="Submit" value="View Customer Forecasts" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/displayGlobalForecast.php">
  	
  		<input type="hidden" name="form10" value="form10" />
 <input type="submit" name="Submit" value="View Global Forecasts" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/calculatedForecasts.php">
  	
  		<input type="hidden" name="form5" value="form5" />
 <input type="submit" name="Submit" value="Generate Calculated Forecasts" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/fillSalesout.php">
  	
  		<input type="hidden" name="form6" value="form6" />
 <input type="submit" name="Submit" value="Update Salesout Forecasts" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/customerForecasts.php">
  	
  		<input type="hidden" name="form7" value="form7" />
 <input type="submit" name="Submit" value="Generate Customer Forecasts" />
 </form>
 
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/globalForecasts.php">
  	
  		<input type="hidden" name="form8" value="form8" />
 <input type="submit" name="Submit" value="Generate Global Forecasts" />
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


