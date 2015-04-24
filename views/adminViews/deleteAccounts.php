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
  	<form method = "post" action = "/forecast/newMVCProj/controllers/deleteAccount.php">
  	
  		
  		<input type="hidden" name="form1" value="form1" />
            User Name :
            <select User Name = 'userID'>
            <option value = "">--- Select ---</option>
            <?php
               
			
                $select = "access_rights";
                if (isset($select) && $select != ""){
                $select = $_POST ['NEW'];
            }
            ?>
            <?php
                $list = mysql_query("select * from forecastaccess.access_rights");
            while($row_list = mysql_fetch_assoc($list)){
                ?>
                    <option value = "<?php echo $row_list['UID']; ?>"<?php if($row_list['UID'] == $select)
												{ echo "selected"; } ?>>
                                         <?php echo $row_list['User_Name'];?>
                    </option>
                <?php
                }
                ?>
            </select>

            <input type="submit" name="Submit" value="Delete" style="font-weight: normal; vertical-align: middle; font-size: 50%; height: 30px; width: 100px"/>
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