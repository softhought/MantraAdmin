<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>

	<style type="text/css">

	body {
		background-color: #fff;	
		font-family:  Verdana Helvetica, Arial, sans-serif;
		color: #4F5155;
    }
    .print_logo{
        width:5%;
    }
    .logo{
          width:16%;
    }
   .borderleft{
	border-right: 1px solid black;
   }
   .paddingleft{
	   padding-left:10px;
   }

   .heading{
		text-align: center;
    font-size: 22px;
    border-bottom: 1px solid black;
    padding-bottom: 6px;
    text-transform: uppercase;
	margin-bottom: 0;
	}
	.textstyle{
		padding:5px 0px 5px 5px;
		width:50%;
	}
	
	.borderbottom{
		border-bottom:1px solid black;
	}
	.payment-details{
		border-collapse: collapse;
		
	}
	.padding10 td{
		padding: 10px;
	}
	.padding15 td{
		padding: 15px;
		text
	}
	.payment-details td{
      border:1px solid black;
	
	}
	.info-1{
		margin-bottom: 0px;
       font-size: 10px;
	}
		
	</style>
</head>
<body>
<?php 
//  echo "<pre>";
//  print_r($paymentdtl);
//  echo "</pre>";exit;


?>
<table  cellpadding="0" cellspacing="0" class="custom_tbl2" style="width:100%; font-size:12px;">   
<caption class="heading">Receipt</caption>
        <tr>
          		  
			<td class="borderleft" >
		    	<img src="https://mantrahealthclub.com/memberpanel/application/images/print_logo.jpg" class="print_logo"/>
				<img src="https://www.mantrahealthclub.com/mantra/application/assets/images/main-logo.svg" class="logo"/>
			</td>
			<td class="paddingleft textstyle">
			       Receipt No : <?php echo $receipt_no; ?>
				   
			</td>
			
		
		  </tr>
		  <tr>
				<td class="borderleft textstyle">
				<?php 				
				echo $branchdtl->BRANCH_NAME." ".$branchdtl->branch_address;
				?>
					
				</td>
				<td class="paddingleft textstyle" style="text-transform: capitalize;">
			       Name :  <?php if(!empty($corporatecompdtl)){ echo $corporatecompdtl->company_name; }else{ echo $paymentdtl->cus_name; } ?>
				   
				   
			    </td>
				
			</tr>
			<?php if(!empty($corporatecompdtl)){  ?>
			<tr>
			<td class="borderleft textstyle">&nbsp;</td>
			<td class="paddingleft textstyle">GISTN : <?php echo $corporatecompdtl->gistn_no;  ?></td>
			</tr>
			<?php } ?>
			<tr>
			<td class="borderleft textstyle">
			         Phone No : <?php 				
				echo $branchdtl->company_contact;
				if($branchdtl->contact_person != "" && $branchdtl->company_contact != ""){ echo "/".$branchdtl->contact_person; }else{ echo $branchdtl->contact_person; }
				?>
			</td>
			   <td class="paddingleft textstyle">
						Address  :  <?php echo $paymentdtl->CUS_ADRESS; ?>
				</td>
				
				
			</tr>
			<tr>
			<td class="borderleft textstyle">
			Visit us : www.mantrahealthclub.com
			</td>
			   <td class="paddingleft textstyle">
						Membership No  :  <?php echo $paymentdtl->MEMBERSHIP_NO; ?>
				</td>
				
				
			</tr>
		  <tr>
				<td class="borderleft textstyle">
				GSTIN : <?php echo $branchdtl->gst_no; ?>
				</td>
			
				<td class="paddingleft textstyle">
				Payment Date :  <?php echo date('d-m-Y',strtotime($paymentdtl->PAYMENT_DT)); ?>&emsp;&emsp;&emsp;&emsp;
				<?php if($paymentdtl->PAYMENT_MODE == 'Cheque'){ ?>
				Payment Mode : <?php echo $paymentdtl->PAYMENT_MODE; ?>
				<?php } ?>
				</td>
				
			</tr>	
			<?php if($paymentdtl->PAYMENT_MODE != 'Cheque'){ ?>
				<tr>
				<td class="borderleft textstyle">
				
				</td>
			
				<td class="paddingleft textstyle">			
				    Payment Mode : <?php echo $paymentdtl->PAYMENT_MODE; ?>
			
				</td>
				
			</tr>
				<?php } ?>
		  	
		<?php if($paymentdtl->PAYMENT_MODE == 'Cheque'){ ?>
			<tr >   
				<td class="borderleft textstyle <?php if($paymentdtl->payment_from == "DUE" ){ echo "borderbottom";  }?> ">
				
				</td>
				<td class="paddingleft textstyle <?php if($paymentdtl->payment_from == "DUE" ){ echo "borderbottom";  }?>">
				Cheque Date : <?php echo date('d-m-Y',strtotime($paymentdtl->CHQ_DT)); ?>&emsp;&emsp;&emsp;&emsp;&ensp;
				Cheque No. : <?php echo $paymentdtl->CHQ_NO; ?> 
				
				 
				</td>
				
        </tr>
		

		<?php } ?>
		<?php if($paymentdtl->payment_from != "DUE" ){ ?>
		<tr >   
				<td class="borderleft textstyle borderbottom">
				
				</td>
				<td class=" textstyle borderbottom">
				Validity : <?php echo '('.date('d-m-Y',strtotime($paymentdtl->FROM_DT)).' - '.date('d-m-Y',strtotime($paymentdtl->VALID_UPTO)).')'; ?>
				</td>
        </tr>
		<?php } ?>
		
</table>
<br>
<table  class="payment-details" style="width:100%; font-size:13px;"> 

		<tr class="padding10">
			<td style="width:300px;text-align:center;">Particulars</td>
			<td>Qty</td>
			<td>Rate</td>
			<td>Disc.</td>
			<!-- <td>Amount</td> -->
			
			<td>Due</td>
			<td>Taxable</td>
			<td>CGST</td>
			<td>SGST</td>
			<td>Total Amount</td>
		</tr>

		<tr class="padding15">
			<td ><?php if($paymentdtl->payment_from == 'PRODSALE'){ echo $product_name; }else{ echo $paymentdtl->CARD_DESC; } ?> </td>
			<td>1</td>
			<td><?php echo $paymentdtl->AMOUNT+$paymentdtl->DISCOUNT_CONV+$paymentdtl->DISCOUNT_OFFER+$paymentdtl->DISCOUNT_NEGO+$paymentdtl->WALLET_AMT+$paymentdtl->DUE_AMOUNT;  ?></td>
			<!-- <td><?php echo $paymentdtl->AMOUNT+$paymentdtl->DISCOUNT_CONV+$paymentdtl->DISCOUNT_OFFER+$paymentdtl->DISCOUNT_NEGO+$paymentdtl->WALLET_AMT;  ?></td> -->
			
			<td><?php echo $paymentdtl->DISCOUNT_CONV+$paymentdtl->DISCOUNT_OFFER+$paymentdtl->DISCOUNT_NEGO+$paymentdtl->WALLET_AMT; ?></td>
			<td><?php echo $paymentdtl->DUE_AMOUNT;  ?></td>
			<td><?php echo $paymentdtl->AMOUNT; ?></td>
			<td><?php echo $paymentdtl->CGST_AMT; ?></td>
			<td><?php echo $paymentdtl->SGST_AMT; ?></td>
			<td><?php echo $paymentdtl->TOTAL_AMOUNT; ?></td>
		</tr>
		
</table>
<div class="info-1">
	<p style="margin-bottom: -10px;"><b>Total Invoice Value (In figure) : Rs. <?php echo $paymentdtl->TOTAL_AMOUNT; ?></b></p>
	<p><b>Total Invoice Value (In Words) : <?php echo $fig_in_words; ?></b></p>
	<p>Note: 1. Amount is non refundable and non transferable.<br>
	<span style="margin-left: 24px;">&emsp;&emsp;&emsp;2. Invoice is valid subject to realization of cheque.</span></p>
	<p><b>Disclaimer :</b> We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</p>
</div>
<br>
<br>
<div class="info-1" style="width:100%;">
  <div style="text-align:left;width:50%;float:left;">
     <p style="margin:0px;">-----------------------------------------</p>
    <p style="margin:0px;text-indent:20px;">Designation/Status</p>
  </div>
  <div style="text-align:right;width:50%;float:rigth;">
  <p style="margin:0px;">-----------------------------------------</p>   
   <p style="margin:0px;padding-right:40px;">Signature</p>
  </div>
  
	
   
</div>

</body>
</html>