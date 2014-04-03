<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Create Invoice'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['id'])){
	if(!empty($_REQUEST['id'])){
		if(isset($_REQUEST['action']) && isset($_REQUEST['status'])){
			if($_REQUEST['action'] == "paymentstatus"){
				$result = $order->update($_REQUEST['id'], "payment", $_REQUEST['status']);
			}
		if($_REQUEST['action'] == "orderstatus"){
				$result = $order->update($_REQUEST['id'], "status", $_REQUEST['status']);
			}
		if(isset($_REQUEST['ajax'])){
	if($result == true){
		echo 'true';
		exit;
	}
	else{
		echo $user->error;
		exit;
	}
	}
	
		}
			
		$details = $order->details($_REQUEST['id']);
	}else{
		header("location:orders.php");
	}
	}
require_once('./header.php');

?><ul class="nav nav-pills"><li>
<a href="orders.php" >All Orders</a></li><li><a href="orders-new.php">New Orders</a></li><li><a href="orders-monthly.php" >Monthly Orders</a></li></ul><hr>
<div class="col-md-12">
<form action="create-invoice.php" method="post" class="form-inline">
<h4>Create Invoice</h4><span class="col-md-4 no-gutter"><input class="form-control"type="text" name="id" placeholder="Order ID" required>&nbsp;
</span><span class="col-md-4 no-gutter"><button class="btn btn-default">Create Invoice</button></span></form></div>
<?php 
if(isset($_REQUEST['id'])) {
	$results = $order->details($_REQUEST['id']);
	?>

<button class="btn btn-default" id="print-Button"><i class="glyphicon glyphicon-print"></i> Print</button>
<br><br>
<div id="printable-area">
<table cellspacing="0" cellpadding="0" style="width:720px;margin:0px;padding:0px;"><tbody><tr>
             <td width="100%" style="text-align:left;border-left:1px solid silver;border-top:1px solid silver;border-right:2px solid silver;border-bottom:2px solid silver;padding-left:40px;padding-right:40px; padding-top:40px; padding-bottom:40px;" colspan="100">
  <!-- TB 3 -->
        <table cellspacing="0" cellpadding="0" border="0" style="width:720px; padding:0px; padding-left:0px;margin:0px;text-align:left;vertical-align:top;">
         <tbody><tr>
         <td style="vertical-align:top;">
         <!-- TB 5 -->
         <table cellspacing="0" cellpadding="0" border="0" style="margin:0px; padding:0px;vertical-align:top;">
          <tbody><tr>
           <td style="border:0px solid blue;width:380px;padding-top:0px;padding-left:0px; vertical-align:top;font-family:verdana; font-size:13px; color:#3c3c3c;line-height:13px;">
   		 	    </td>
    	        	</tr>
	    	    	<tr>
		            <td style="border:0px solid green;width:280px;padding-top:0px;padding-left:0px; vertical-align:top;font-family:verdana; font-size:13px; color:#3c3c3c;line-height:13px;">
				   
						</td>
            </tr>

           <!-- TB 5 -->
           </tbody></table></td>

            <td style="vertical-align:top;padding-top:0px; margin-top:0px;line-height:13px;">
            
            <!-- TB 5 -->
             <table cellspacing="0" cellpadding="0" border="0" style="margin:0px; padding:0px;vertical-align:top;">
              <tbody><tr>
               <td style="border:0px solid red; text-align:right;" colspan="2">
               
           <br><p style="vertical-align:top;margin-top:0px;margin-bottom:0px;text-align:right;letter-spacing:5px;font-size:28px;color:#808080;font-weight:bold;font-family:arial;">INVOICE</p>
<br>
        	</td></tr>
           <tr><td style="border:0px solid black; width:155px;">&nbsp;</td>
		<td style="margin:0px; padding:0px;">
            <table cellspacing="0" cellpadding="0" border="0" style="border:0px solid red;text-align:right;margin:0px; padding:0px;">
 			<tbody><tr>
           <td style="padding-left:0px;padding:0px; margin:0px; text-align:right;font-weight:bold;font-family:verdana;font-size:13px;color:#3c3c3c;">
Order&nbsp;# 
            </td>            
 <td style="width:115px; padding-left:5px; padding-right:5px;text-align:right;font-weight:normal; font-family:verdana;font-size:13px;color:#3c3c3c;">

           <?php echo $results['id'];?>
           </td></tr>
			<tr><td style="height:20px;">
			</td></tr>
<tr><td style="height:20px;"><?php $iaddress = $address->details($results['address']);
echo $iaddress['name'] ."<br />";
echo nl2br($iaddress['address'])."<br />";
echo $iaddress['zip']."<br />";
echo $iaddress['country']."<br />";

 ?>
			</td></tr>
<tr><td style="height:20px;">
			</td></tr>
 <tr>
           <td style="padding-left:0px;text-align:right;font-weight:bold;font-family:verdana;font-size:13px;color:#3c3c3c;">
           Invoice&nbsp;Date 
            </td>            
           <td style="padding-left:5px;  padding-right:5px;text-align:right;font-weight:normal; font-family:verdana;font-size:13px;color:#3c3c3c;">
            <?php echo $results['date'];?>
          </tbody></table>
         

           </td></tr>

              <!-- TB 5 -->

              </tbody></table>

<br>

            </td>

           </tr>

         <tr><td></td></tr>



           

           <!-- TB 3 -->

           </tbody></table>



            






           

           <!-- TB 4 -->

           <table cellspacing="0" cellpadding="0" border="0" style="width:720px; vertical-align:top;padding-left:0px;" id="dataTable">

           <tbody>

           <tr style="background-color:#54A0E7;" class="invoiceDataHeadlineTR" id="topRow">

           <th style="border-color:#ccc;color:white;" class="invoiceDataHeadlineItem">Item </th>

           <th style="border-color:#ccc;color:white;" class="invoiceDataHeadlineDescription">Option </th>

           <th style="border-color:#ccc" class="invoiceDataHeadlineEmpty">&nbsp;</th>
           <th style="border-color:#ccc;color:white;" class="invoiceDataHeadlineUnitPrice">Unit&nbsp;Price </th>

           <th style="border-color:#ccc;color:white;" class="invoiceDataHeadlineQuantity">Quantity </th>

           <th style="border-color:#ccc;color:white;" class="invoiceDataHeadlineAmount">Amount </th>

           </tr>

           

           <?php 
      $products = json_decode($results['items'],true);
$i = 0;
foreach($products as $pro){
	$i = $i + 1;
?>
			   			   
			   	
               <tr style="height:30px;line-height:17px;">

               

               <td style="width:65px; padding:5px; padding-top:5px; padding-left:8px; border-left:1px solid #ccc; font-family:verdana;font-size:12px;color:#3c3c3c;vertical-align:top;">

               <?php echo $i; ?>
               </td>

           

               <td style="width:372px; padding:5px; padding-top:5px; font-family:verdana;font-size:12px;color:#3c3c3c;vertical-align:top;" colspan="2">

              <?php echo $pro['name'] . " - " . $pro['opt_name']; ?>
               </td>  



               <td style="width:83px; padding:5px; padding-top:5px;vertical-align:top;text-align:right;font-weight:normal; font-family:verdana;font-size:12px;color:#3c3c3c;">

            <?php echo $setting['currency_symbol'] . " ". $pro['price'] ; ?>
               </td>



               <td style="width:83px; padding:5px; padding-top:5px;vertical-align:top;text-align:right;font-weight:normal; font-family:verdana;font-size:12px;color:#3c3c3c;">

               <?php echo $pro['count']; ?>
               </td>



               <td style="width:83px; padding:5px; padding-top:5px; padding-right:8px; vertical-align:top;text-align:right;border-right:1px solid #ccc;font-weight:normal; font-family:verdana;font-size:12px;color:#3c3c3c;">

                 <?php echo $setting['currency_symbol'] . " ". ($pro['price'])*$pro['count'];?>             

               </td>

               </tr>

               <?php } ?>

           
			   			   
			   	
             
            <tr>

            
            <td style="width:400px;border-bottom:1px solid #ccc; border-left:1px solid #ccc;border-right:1px solid #ccc;vertical-align:top; padding:5px; padding-top:100px; padding-bottom:15px; padding-left:8px; font-family:verdana; font-size:13px; color:#3c3c3c;" colspan="6">

           &nbsp;
            </td>



            </tr>


                       

            <tr>

             <td style="width:65px; border-bottom:1px solid #ccc;border-left:1px solid #ccc;" rowspan="7">

              &nbsp;

             </td>

             <td style="width:372px; border-bottom:1px solid #ccc;border-right:1px solid #ccc;" rowspan="7">

              &nbsp;

             </td>

            

			
            

            <td style="font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;padding-top:7px;padding-bottom:5px;padding-left:35px;" colspan="3">

             Subtotal 
            </td>

            <td style="width:83px; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;padding-top:7px;padding-bottom:5px;padding-right:8px;" colspan="1">

             <?php echo $setting['currency_symbol'] . " " . $results['amount']; ?>
            </td>

           </tr>
           <tr>

            <td style="width:145px; border-top:1px solid #ccc;font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;padding-top:7px;padding-bottom:4px;padding-left:35px;" colspan="3">

             Discount 
            </td>

            <td style="width:83px; border-top:1px solid #ccc; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;padding-top:7px;padding-bottom:4px;padding-right:8px;" colspan="1">

               <?php echo $setting['currency_symbol'] . " " . $results['discount']; ?>
            </td>

           </tr>
		     <tr>

            <td style="width:145px; border-top:1px solid #ccc;font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;padding-top:7px;padding-bottom:4px;padding-left:35px;" colspan="3">

             Tax 
            </td>

            <td style="width:83px; border-top:1px solid #ccc; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;padding-top:7px;padding-bottom:4px;padding-right:8px;" colspan="1">

               <?php echo $setting['currency_symbol'] . " " . $results['tax'] ; ?>
            </td>

           </tr> 
		   <tr>

            <td style="width:145px; border-top:1px solid #ccc;font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;padding-top:7px;padding-bottom:4px;padding-left:35px;" colspan="3">

             Shipping 
            </td>

            <td style="width:83px; border-top:1px solid #ccc; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;padding-top:7px;padding-bottom:4px;padding-right:8px;" colspan="1">

               <?php echo $setting['currency_symbol'] . " " . $results['shipping'] ; ?>
            </td>

           </tr>
		  
   <tr>

            <td style="width:145px; border-top:1px solid #ccc;font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;padding-top:7px;padding-bottom:4px;padding-left:35px;" colspan="3">

             Total 
            </td>

            <td style="width:83px; border-top:1px solid #ccc; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;padding-top:7px;padding-bottom:4px;padding-right:8px;" colspan="1">

               <?php echo $setting['currency_symbol'] . " " . ($results['net']); ?>
            </td>

           </tr>

            

           <tr>

            <td style="width:145px; font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;padding-top:4px;padding-bottom:7px;padding-left:35px;" colspan="3">

             Amount&nbsp;Paid 
            </td>

            <td style="width:83px; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;padding-top:4px;padding-bottom:7px;padding-right:8px;" colspan="1">

               <?php if($results['payment'] == 1){
               	echo $setting['currency_symbol'] . " " . ($results['net']); 
               }
               else{
               	echo $setting['currency_symbol'] . " 0";
               }
               ?>
            </td>

           </tr>

        

           <tr><td style="background-color:#eaedee; font-family:verdana; font-size:13px; color:#3c3c3c; font-weight:bold;border-bottom:1px solid #ccc;border-top:1px solid #ccc;padding-top:7px;padding-bottom:7px;padding-left:35px;padding-right:0px;margin-right:0px;" colspan="3">Balance&nbsp;Due&nbsp;<span style="font-family:verdana;&nbsp;font-size:12px;&nbsp;color:#3c3c3c;&nbsp;font-weight:normal;"></span style="font-family:verdana;&nbsp;font-size:12px;&nbsp;color:#3c3c3c;&nbsp;font-weight:normal;"></td>
            <td style="width:83px; background-color:#eaedee; font-family:verdana;font-size:13px;color:#3c3c3c; text-align:right;border-right:1px solid #ccc;border-bottom:1px solid #ccc;border-top:1px solid #ccc;padding-top:7px;padding-bottom:7px;padding-right:8px;"> <?php if($results['payment'] != 1){
               	echo $setting['currency_symbol'] . " " . ($results['net']); 
               }
               else{
               	echo $setting['currency_symbol'] . " 0";
               }
               ?></td>
           </tr>


           </tbody>

           </table>
                </td></tr>

             
                    <tr style="height:77px;"><td>&nbsp;</td></tr>            

            

                </tbody></table>


</div>
<?php  }?>
<?php
require_once('./footer.php');

?>