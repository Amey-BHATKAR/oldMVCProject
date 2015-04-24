
<?php

 //**************************************
//     Page load dropdown results     //
//**************************************
function getTierOne()
{
	include_once($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
	$result = mysql_query("SELECT DISTINCT Customer_Name FROM forecastdb.customer_spec") 
	or die(mysql_error());
	/*$selected = "";
		$currCustQuery = mysql_query("SELECT Customer_Name, Product_Name FROM forecastdb.cust_prod_current WHERE UID = 1") or die(mysql_error());
		$currCust = mysql_fetch_assoc($currCustQuery);*/
	  while($tier = mysql_fetch_array($result)) 
  
		{
			/*if($tier['Customer_Name'] == $currCust['Customer_Name'])
			{
				$showProd = true;
				//$selected = 'selected = "selected"';
				
			}
			else
			{
				echo '<option value="'.$tier['Customer_Name'].'">'.$tier['Customer_Name'].'</option>';
				
			}
			*/
		   echo '<option value="'.$tier['Customer_Name'].'">'.$tier['Customer_Name'].'</option>';
		}

}

//**************************************
//     First selection results     //
//**************************************
if(($_GET['func'] == "drop_1" && isset($_GET['func']))) { 
   drop_1($_GET['drop_var']); 
}


function drop_1($drop_var)
{  
	
 			
    include_once($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
    $drop_var = str_replace("'", "''",$drop_var);
	$result1 = mysql_query("SELECT * FROM forecastdb.liste_display WHERE Customer_Name = '%".$drop_var."%' AND From_Table = 'Decided' ORDER BY Timestamp DESC") 
	or die(mysql_error());
	
	$result2 = mysql_query("SELECT * FROM forecastdb.liste_display WHERE Customer_Name LIKE '%".$drop_var."%' AND From_Table = 'History' ORDER BY Monthly_Orders DESC") 
	or die(mysql_error());
	echo "Product Name : ";
	
	echo '<select name="tier_two" id="tier_two">
	      <option value=" " disabled = "disabled" selected = "selected">Choose one</option>';

		   	while($drop_2 = mysql_fetch_assoc($result1)) 
			{
				if($drop_2['Comments'] != "EOL")
				{
					echo '<option value="'.$drop_2['Product_Name'].'">'.$drop_2['Product_Name'].'</option>';
				}
				
				
			}
	  		while($drop_3 = mysql_fetch_array($result2)) 
			{
				//echo $drop_3;
			  	echo '<option value="'.$drop_3['Product_Name'].'">'.$drop_3['Product_Name'].'</option>';
			}
			
			while($drop_4 = mysql_fetch_assoc($result1)) 
			{
				if($drop_4['Comments'] == "EOL")
				{
					//echo $drop_2;
			  		echo '<option value="'.$drop_4['Product_Name'].'">'.$drop_2['Product_Name'].'</option>';
				}
				
				
			}
	echo '<option value = "newProd" title = "Products already in mass production but never ordered by this customer so far.">Other Products</option>';
	echo '</select> ';
    echo '<input type="submit" name="submit" value="Submit"  style="font-weight: normal; vertical-align: middle; font-size: 20; height: 30px; width: 100px"/>';
    echo "<script type=\"text/javascript\">
	
	  $('#result_2').hide();
      
</script>";
    echo "<script type=\"text/javascript\">
	$('#wait_2').hide();
	$('#tier_two').change(function(){
	  $('#wait_2').show();
	  $('#result_2').hide();
      $.get(\"/forecast/newMVCProj/controllers/func.php\", {
		func: \"tier_two\",
		drop_var: $('#tier_two').val()
      }, function(response){
        $('#result_2').fadeOut();
        setTimeout(\"finishAjaxOther('result_2', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}

if($_GET['drop_var'] == "newProd" && isset($_GET['drop_var'])) { 
   otherProds(); 
}

function otherProds()
{
	echo 'Product Name: ';
	echo '<input id = "prodOther" type="text" name="prodNameOther" height = 3 width = 8 title = "Enter the exact name of the product you want to assign to the customer." value = ""/><br>';
	echo '<input type="submit" name="submit" value="Submit"  style="font-weight: normal; vertical-align: middle; font-size: 20; height: 30px; width: 100px"/>';
	echo "<script type=\"text/javascript\">
	
	  $('#result_1').hide();
      
</script>";
}


if($_GET['func'] == "drop_5" && isset($_GET['func'])) { 
   drop_5($_GET['drop_var']); 
}

function drop_5($drop_var)
{  
    include_once($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
	$result = mysql_query("SELECT * FROM dev") 
	or die(mysql_error());
	
	echo "Product Name : ";
	
	echo '<select name="tier_two" id="tier_two">
	      <option value=" " disabled="disabled" selected="selected">Choose one</option>';

		   
	  		while($drop_6 = mysql_fetch_array($result)) 
			{
				//echo $drop_6;
			  	echo '<option value="'.$drop_6['Product_Name'].'">'.$drop_6['Product_Name'].'</option>';
			}
			
	echo '</select> ';
    echo '<input type="submit" name="submit" value="Submit"  style="font-weight: normal; vertical-align: middle; font-size: 20; height: 30px; width: 100px"/>';
}	
?>
