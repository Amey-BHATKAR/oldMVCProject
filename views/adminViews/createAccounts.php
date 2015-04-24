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
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
?>


<!DOCTYPE html>
<html>
<head><link href="/forecast/newMVCProj/css/bootstrapmain.min.css" rel="stylesheet" media="screen">
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/headerAdmin.php'); 
?>
</head>
<body>
<br>
 <div id = "title_block4">
          <table border = 1 >
				<tr>
					<td>Existing Users </td>
					<td> :</td>
					<td>
						<table border = 1>
							
								<?php 
								$list = mysql_query("select * from forecastaccess.access_rights");
								while($row_list = mysql_fetch_assoc($list))
								{
								?>
								<tr><td background-color = ><?php echo $row_list['User_Name'];?></td></tr>
								<?php
								}
								?>
								
							
						</table>
					</td>
				</tr>
			</table>
			</div>
			
 <div id = "title_block4">           
<form method = "post" action = "/forecast/newMVCProj/controllers/createAccount.php">
 	
  		<input type="hidden" name="form1" value="form1" />
  		 
<table id = "table">
	<tr>
		<td>User Name</td>
		<td>: </td>
		<td><input id = "bigBoxes" type = "text" name = "name"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td>: </td>
		<td><input id = "bigBoxes" type = "text" name = "password"></td>
	</tr>
	<tr>
		<td>Role</td>
		<td>: </td>
		<td>
			<select name="role" id="role">
      			<option value="" selected="selected" disabled="disabled">Select a Category</option>
      			<option value="admin">admin</option>
				<option value="sales">sales</option>
      		</select>
		</td>
	</tr>
</table>

<input type="submit" name="Submit" value="Create" style="font-weight: normal; vertical-align: middle; font-size: 50%; height: 30px; width: 100px"/>
 </form>
 <form method = "post" action = "/forecast/newMVCProj/views/adminViews/adminPage.php">
  	
  		<input type="hidden" name="form3" value="form3" />
 <input id = "backButton" type="submit" name="Submit" value="Go Back to Admin Page" style="font-weight: normal; vertical-align: middle; font-size: 50%; height: 30px; width: auto"/>
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