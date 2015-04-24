<?php
/*
 * Created on 18-Jul-2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  session_start();
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 1))
 {
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/displayGlobalForecasts.php');
?>
<html>
<head><link href="/forecast/newMVCProj/css/bootstrapmain.min.css" rel="stylesheet" media="screen">
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/headerAdmin.php'); 
$week = date("W");
?>

</head>
<body>
<div id = "title_block5">

	<!--FRAMESET rows="20%, 80%">
  		<FRAMESET rows="100, 200">
      		<FRAME src="contents_of_frame1.html">
      		<FRAME src="contents_of_frame2.gif">
  		</FRAMESET>
  	</FRAMESET-->
	<table>
	<tr>
		<!--form method = "post" action = "/forecast/newMVCProj/views/salesViews/salesPage.php">
  	
  			<input type="hidden" name="form3" value="form3" />
 			<input id = "backButton" type="submit" name="Submit" value="Go Back to Menu" />
 		</form-->
 	
		<form action="/forecast/newMVCProj/views/salesViews/displayGlobalForecast.php" method="post">
			<input type="hidden" name="form1" value="form1" />
			<td>Enter the search string here:</td>
			<td><input id = "searchString" type="text" class="text" name="searchString" id="searchString" value="" size="auto" maxlength="auto" title = "Enter any search string related to product name."/></td>
			<td><input id = "searchSubmit" type="submit" class="submit button" name="searchSubmit" value="Search" /></td>
		</form>
	</tr>
	<tr>
		<table id = "mainTable" border = 1>
			<tr>
				<th>#</th>
				<th>Product Name</th>
				<th>MM</th>
				<th>Decided Volume</th>
				<th>Forecast Week <?php echo $week; ?></th>
				<th>Forecast Week <?php echo ($week + 1); ?></th>
				<th>Forecast Week <?php echo ($week + 2); ?></th>
				<th>Forecast Week <?php echo ($week + 3); ?></th>
				<th>Forecast Week <?php echo ($week + 4); ?></th>
				<th>Forecast Week <?php echo ($week + 5); ?></th>
				<th>Forecast Week <?php echo ($week + 6); ?></th>
				<th>Forecast Week <?php echo ($week + 7); ?></th>
				<th>Forecast Week <?php echo ($week + 8); ?></th>
				<th>Forecast Week <?php echo ($week + 9); ?></th>
				<th>Forecast Week <?php echo ($week + 10); ?></th>
				<th>Forecast Week <?php echo ($week + 11); ?></th>
				<th>Forecast Week <?php echo ($week + 12); ?></th>
				<th>Forecast Week <?php echo ($week + 13); ?></th>
				<th>Forecast Week <?php echo ($week + 14); ?></th>
				<th>Forecast Week <?php echo ($week + 15); ?></th>
				<th>Forecast Week <?php echo ($week + 16); ?></th>
				<th>Forecast Week <?php echo ($week + 17); ?></th>
				<th>Forecast Week <?php echo ($week + 18); ?></th>
				<th>Forecast Week <?php echo ($week + 19); ?></th>
				<th>Forecast Week <?php echo ($week + 20); ?></th>
				<th>Forecast Week <?php echo ($week + 21); ?></th>
				<th>Forecast Week <?php echo ($week + 22); ?></th>
				<th>Forecast Week <?php echo ($week + 23); ?></th>
				<th>Forecast Week <?php echo ($week + 24); ?></th>
				<th>Forecast Week <?php echo ($week + 25); ?></th>
				
			</tr>
	
				<?php
					if(isset($_POST['searchString']) && ($_POST['searchString'] != ""))
					{
						getSearchedGlobalForecast($_POST['searchString']);
					}
					else
					{
						getGlobalForecast();
					} 
				 ?>
	
		</table>
	</tr>
	
</table>

	

	
	

 	<form method = "post" action = "/forecast/newMVCProj/views/salesViews/salesPage.php">
  	
  			<input type="hidden" name="form2" value="form2" />
 			<input id = "backButton" type="submit" name="Submit" value="Go Back to Menu" />
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