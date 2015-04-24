

<?php
/*
 * Created on Apr 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 	
 	
 session_start();
 $_SESSION['page'] = "TTL";
 //isset($_SESSION['role']) && ($_SESSION['role'] == 2)
 if(isset($_SESSION['role']) && ($_SESSION['role'] == 2))
 {
 	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/db.php');
 	include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/func.php');
 	include($_SERVER['DOCUMENT_ROOT']."/forecast/newMVCProj/controllers/getCurrentValues.php");
 ?>

<html>

<head>

<?php 
include($_SERVER['DOCUMENT_ROOT'].'/forecast/newMVCProj/controllers/headerAll.php'); 
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_5').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
      $.get("/forecast/newMVCProj/controllers/func.php", {
		func: "drop_5",
		drop_var: $('#drop_5').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}


function error(ValIn,ValOrig)
{
    
    var x1 = ValIn;
    var x2 = ValOrig;
    if (x1 <= x2)
    {
    	
    }
    else
    {
    	alert('Entered value should not exceed the first order quantity value.');
    	//window.location = "/forecast/newMVCProj/views/salesViews/mainTTLPage.php";
    }
    
}


</script>
<link href="/forecast/newMVCProj/css/bootstrapmain.min.css" rel="stylesheet" media="screen">
	
	
	
	</head>

	<body>
	<script src="/forecast/newMVCProj/js/bootstrap.min.js"></script>
	<div id = "title_block2">
	<form method = "post" action = "/forecast/newMVCProj/views/salesViews/mainPage.php">
  	
  			<input type="hidden" name="form3" value="form3" />
 		<input type="submit" name="Submit" value="Select from Products Already in Production" style="font-weight: normal; vertical-align: middle; font-size: 20; height: 30px; width: 500px"/>
 	</form>
	<?php
	
		//echo $_SERVER['DOCUMENT_ROOT'];
		$sql = "";
 	
    	
  	?>
  	
  	<form method = "post" action = "/forecast/newMVCProj/controllers/updateNames.php">
  		Customer Name :
  		<select name="drop_5" id="drop_5">
    
      		<option value="" selected="selected" disabled="disabled">Select a Category</option>
      
      			<?php getTierOne(); ?>
    
    	</select> 
    
    	<span id="wait_1" style="display: none;">
    	<img alt="Please Wait" src="/forecast/newMVCProj/controllers/ajax-loader.gif"/>
    	</span>
    	<span id="result_1" style="display: none;"></span> 
            
    </form>
  	</div>
  	<?php
    	$sql = "select MAX(UID) from forecastdb.cust_prod_current";
    	
    	$list = mysql_query($sql);
    	$row1 = mysql_fetch_assoc($list);
    
    	$showTable = false;
    	if($row1['MAX(UID)'] == 1 )
    	{ 
   
    		
    		$showTable = true;
    	} 
    	else 
    	{
    		
    		$showTable = false;
    	}
    	
    	$sql = "select * from forecastdb.cust_prod_current where UID = 1";

    	$list = mysql_query($sql);
    	$row = mysql_fetch_assoc($list);
   
   		//echo "Hi";
   		//echo $row['Customer_Name'];
    //Table Entries
    	$custName = $row['Customer_Name'];
		$prodName = $row['Product_Name'];
    	
    	
		if($showTable == true)
		{
	
			
			?>
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
			
		<div id = "title_block3">
			<table id = "mainTable">
				<tr>
					<td>
					
						<table id = "cellFirst" border = 1>
							<tr>
								<th align = center>Customer Name</th>
							</tr>
							<tr>
								<td align = center><b><?php echo $custName;?></b></td>
							</tr>
							<tr>
								<th align = center>Product Name</th>
							</tr>
							<tr>
								<td align = center><b><?php echo $prodName;?></b></td>
							</tr>
						</table>
					
					</td>
					
					<td>
					
						<table>
							<tr>
								<td>
								
									<table border = 1>
										<tr>
											<th colspan = 4>Sales Out Trend</th>
										</tr>
										<tr>
											<td align = center><?php echo $current['Sales_Out_Trend_4']; ?></td>
											<td align = center><?php echo $current['Sales_Out_Trend_3']; ?></td>
											<td align = center><?php echo $current['Sales_Out_Trend_2']; ?></td>
											<td align = center><?php echo $current['Sales_Out_Trend_1']; ?></td>
										</tr>
									</table>
								
								</td>
							</tr>
							<tr>
								<td>
								
									<table  id = "columnSecond" border = 1>
										<tr>
											<th>Last Orders(4 months)</th>
											<th>Warehouse Stock</th>
											<th>Outlets Stock</th>
											<th>Stock Theorique</th>
											<?php 
											if($current['Maturity'] == "DEV")
											{
												?>
												<th>Date Status</th>
												<th>EDD First Batch</th>
												<th>First Order Quantity</th>
												<th>Reserved Quantity</th>
												<?php
											}
											else
											{
												?>
												<th>BATCH Moyen</th>
												<th>Lead Time</th>
												<th>Monthly Sales Out</th>
												<th>Monthly Orders</th>
												<?php
											}
											?>
											
										</tr>
										<tr>
											<td align = center><?php echo $current['Last_Orders']; ?></td>
											<td align = center><?php echo $current['Warehouse_Stock']; ?></td>
											<td align = center title = "Currently fixed to 0, can be modified as needed later."><?php echo $current['Outlets_Stock'];?></td>
											<td align = center><?php echo $current['Stock_Theoritical']; ?></td>
											<?php 
											if($current['Maturity'] == "DEV")
											{
												?><td align = center><?php echo $current['Date_Status'];?></td>
											<td align = center><?php echo $current['EDD_First_Batch'];?></td>
											<td align = center><?php echo $current['First_Order_Quantity']; ?></td>
											<td align = center><?php echo $current['Reserved_Quantity']; ?></td><?php
											}
											else
											{
												?><td align = center><?php echo $current['Batch_Moyen'];?></td>
											<td align = center><?php echo $current['Lead_Time'];?></td>
											<td align = center><?php echo $current['Monthly_Sales_Out']; ?></td>
											<td align = center><?php echo $current['Monthly_Orders']; ?></td><?php
											}
											?>
											
										</tr>
									</table>
								
								</td>
							</tr>
						</table>
						
					
					</td>
				</tr>
		
				<tr>
						<form method = "post" action = "/forecast/newMVCProj/controllers/updateDecisionTable.php">
						<input type="hidden" name="form2" value="form2" />
					<td>
					
						<table id = "columnFirst" border = 1>
							<tr>
								<th align = center>Comments</th>
							</tr>
							<tr>
								<td align = center><textarea style{'height: 100px; width = 250px'} name="comments" rows="2" cols="150"  wrap="off"><?php echo $comments; ?></textarea></td>
							</tr>
						</table>
					
					</td>
					<td rowspan = 3>
					
						<table border = 1>
							<tr>
								<th>Year</th>
									<?php for($i = 0; $i < 26; $i++)
										{
									?><td id = "cellSix" align = center><?php if(($current['Week'] + $i) > 53) {echo ($current['Year'] + 1);} else {echo ($current['Year']);} ?></td><?php
									}
									?>
							</tr>
							<tr>
								<th>Week</th>
								<?php for($i = 0; $i < 26; $i++)
										{
										?><td id = "cellSix" align = center><?php if(($current['Week'] + $i) > 53) {echo ($current['Week'] + $i - 53);} else {echo ($current['Week']+$i);} ?></td><?php
										}
										?>
							</tr>

							<tr>
								<th>Forecast Through Sales out</th>
									<?php for($i = 0; $i < 26; $i++)
										{
									?><td id = "cellSix" align = center><?php echo $stockArray[(6 + $i)]; ?></td><?php
										}
										?>
							</tr>
							<tr>
								<th>Current Sage Orders</th>
									<?php for($i = 0; $i < 26; $i++)
										{
									?><td id = "cellSix" align = center><?php if($ordersListArray[($current['Week']+$i)]) { echo ($ordersListArray[($current['Week'] + $i)]."\n"); } 
															else { echo 0;} ?></td><?php
										}
										?>
							</tr>
							<tr>
								<th>Forecast Decision</th>
								<?php 
											if($current['Maturity'] == "DEV")
											{	
												$frozenHorizon = $eddFirstBatch;
												if($eddFirstBatch > $week)
												{
													$frozenHorizon = $eddFirstBatch - $week;
													for($i = $frozenHorizon, $j = 0; $i > 0; $i--, $j++)
													{
														?>
														<td id = "cellSix" align = center><?php echo ($forecastValues[$j]);?></td>
														<input type="hidden" name="forecastValue[<?php echo $j;?>]" value = "<?php echo ($forecastValues[$j]);?>"/>
														<?php
													}
													for($i = $frozenHorizon, $j = $j - 1; $i < $frozenHorizon + 3; $i++, $j++)
													{
														?>
														<td id = "cellSix" align = center><input id = "input" type="text" onchange = "error(this.value,<?php echo $current['First_Order_Quantity'];?>);" name="forecastValue[<?php echo $j; ?>]" value = "<?php echo ($forecastValues[$j]); ?>"/></td>
														<?php
													}
													for($i = $frozenHorizon + 3, $j = $j - 1; $i < 26; $i++, $j++)
													{
														?>
														<td id = "cellSix"><input id = "input" size = 2 type="text"  name="forecastValue[<?php echo $j;?>]" value = "<?php echo ($forecastValues[($j)]);?>"/></td>
														<?php
													}
												}
												else
												{
													if($week - $eddFirstBatch > 6)
													{
														$frozenHorizon = 0;
														for($i = $frozenHorizon, $j = 0; $i < 26; $i++, $j++)
														{
															?>
															<td id = "cellSix"><input id = "input" size = 2 type="text" name="forecastValue[<?php echo $j;?>]"  name="forecastValue[<?php echo $j;?>]" value = "<?php echo ($forecastValues[($j)]);?>"/></td>
															<?php
														}
													}
													else
													{
														$frozenHorizon = $week - $eddFirstBatch;
														for($i = $frozenHorizon, $j = 0; $i > 0; $i--, $j++)
														{
															?>
															<td id = "cellSix" align = center><?php echo ($forecastValues[$j]);?></td>
															<input type="hidden" name="forecastValue[<?php echo $j;?>]" value = "<?php echo ($forecastValues[$j]);?>"/>
															<?php
														}
														for($i = $frozenHorizon, $j = $j - 1; $i < $frozenHorizon + 3; $i++, $j++)
														{
															?>
															<td id = "cellSix" align = center><input id = "input" type="text" onchange = "error(this.value,<?php echo $current['First_Order_Quantity'];?>);" name="forecastValue[<?php echo $j;?>]" value = "<?php echo ($forecastValues[$j]);?>"/></td>
															<?php
														}
														for($i = $frozenHorizon, $j = $j - 1; $i < 26; $i++, $j++)
														{
															?>
															<td id = "cellSix"><input id = "input" size = 2 type="text"  name="forecastValue[<?php echo $j;?>]" value = "<?php echo ($forecastValues[($j)]);?>"/></td>
															<?php
														}
													}
													
												}
												
												
											}
											else
											{
												?><td id = "cellSix" align = center><?php echo ($forecastValues[0]);?></td>
												<td id = "cellSix" align = center><?php echo ($forecastValues[1]);?></td>
												<input type="hidden" name="forecastValue[]" value = "<?php echo ($forecastValues[0]);?>"/>
												<input type="hidden" name="forecastValue[]" value = "<?php echo ($forecastValues[1]);?>"/>
												<?php for($i = 2; $i < 26; $i++)
												{
												?><td id = "cellSix"><input id = "input" size = 2 type="text" name="forecastValue[]" value = "<?php echo ($forecastValues[($i)]);?>" /></td>
												<?php 
												}
												
											}
								?>
								
							</tr>
						</table>
					
					</td>
				</tr>
				
				<tr>
					<td>
					
						<table id = "columnFirst" border = 1>
							<tr>
								<th align = center>Scheduled Customer<br>Safety Stock</th>
							</tr>
							<tr>
								<td align = center><input id = "input" type = "text" size = 4 name = "minStock" value = "<?php echo $minStock; ?>" ></td>
							</tr>
						</table>
					
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td>
					
						<table id = "columnFirst" border = 1>
							<tr>
								<th>Maturity of the product</th>
							</tr>
							<tr>
								<td align = center><b><?php echo $current['Maturity']; ?></b></td></tr>
							</tr>
						</table>
					
					</td>
					<td></td>
				</tr>
				
				<tr valign = top>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;POIDS FINANCIER</b>
						<table id = "columnFirst" border = 1>
							<tr>
								<th align = center>Couple Article/Client</th>
							</tr>
							<tr>
								<td align = center><?php echo (number_format(($current['Couple_Article_Client']),2,'.','')." %");?></td>
							</tr>
							<tr>
								<th align = center>Valuer Prevue</th>
							</tr>
							<tr>
								<td align = center><?php echo number_format($current['Valuer_Prevue'])." €";?></td>
							</tr>
						</table>
					
					</td>
					<td>
					
						<table>
							<tr>
								<?php
								if($current['Customer_Name'] == "ASCENDEO UK IRELAND/CENTROSUS MOBIL")
 								{
 									$custTemp = "ASCENDEO UK IRELAND CENTROSUS MOBIL";
 								}
 								else
 								{
 									$custTemp = $current['Customer_Name'];
 								}
 								$custTemp = str_replace(' ', '_', $custTemp);
 								?>
								<td><img src = "<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/forecast/newMVCProj/controllers/pictures/<?php echo $custTemp."_".$current['Product_Name'];?>.jpeg"></img></td>
								<td><input type="submit" name="Submit" value="Validate" style="font-size: 20; height: 100px; width: 100px"/></td>
							</tr>
						</table>
					
					</td>
				</tr>
			</table>


			
			<input type="hidden" name="custName" value="<?php echo $current['Customer_Name'];?>" />
			<input type="hidden" name="prodName" value="<?php echo $current['Product_Name'];?>" />
			
			</form>
			<form method = "post" action = "/forecast/newMVCProj/views/salesViews/salesPage.php">
  	
  				<input type="hidden" name="form6" value="form6" />
 				<input id = "backButton" type="submit" name="Submit" value="Go Back to Menu" />
 			</form>
		</div>
			<?php
			}
			else
			{
				echo "Nothing to show at the moment.";
			}
			?>
	
	</body>
</html>
 
 <?php
 }
 else
 {
 	echo "You are not logged in";
 }
?>