<?php
/*
 * Created on Apr 16, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 session_start();
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
 if(isset($_POST['name']) && isset($_POST['password']))
 {
 	
 	$username = mysql_escape_string($_POST['name']);
 	$password = mysql_escape_string($_POST['password']);
 
 	$_SESSION['role'] = "";

 	$sql = "";
 	if(mysql_connect ("localhost","forecast","21ARFUvP"))
 	{
 		if(mysql_select_db ("forecastaccess"))
 		{
 			$sql = "select * from access_rights where User_Name = '".$username."' and Password = '".$password."'";
   
    		$list = mysql_query($sql);
    		$row = mysql_fetch_assoc($list);
   
    
    
    		$sql2 = "select MAX(UID) from forecastaccess.access_rights";
   
   			$list1 = mysql_query($sql2);
   			$row1 = mysql_fetch_assoc($list1);
    		$var = 0;
   			if($row1['MAX(UID)'] != "" )
   			{ 
   				$var = $row1['MAX(UID)']; 
   			} 
   			else 
   			{
   				$var = 0;
   			}
   			
   			if($var >= 1)
    		{
    			if($row["Role"] == "admin")
    			{
    				$_SESSION['role'] = 1;
    				$_SESSION['name'] = $username;
    				var_dump($_SESSION);
    				header("location: /forecast/newMVCProj/views/adminViews/adminPage.php");
    			}
    			else
    			{	
    				if($row["Role"] == "sales")
    				{
    					$_SESSION['role'] = 2;
	    				$_SESSION['name'] = $username;
	    				var_dump($_SESSION);
    					header("location: /forecast/newMVCProj/views/salesViews/salesPage.php");
    				}
    				else
    				{
    						echo "You are not assigned any role at the moment. Please await to be assigned an role.";	
    					
    				}
    			}
    	
    	
   			}
    		else
    		{
    			echo "You are not registered. Please register.";
    		}
   			
 		}
 		else
 		{
 			echo "No database selected.";
 		}
 		
 	}
 	else
 	{
 		echo "Cannot connect to the database.";
 	}
 }
 else
 {
 	echo "You have entered wrong user name and password.";
 }
 
    
    
    
    
   
    
?>
