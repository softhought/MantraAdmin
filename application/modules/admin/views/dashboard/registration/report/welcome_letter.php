<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>

	<style type="text/css">

	body {
		background-color: #fff;	
		font-family:  Arial Helvetica, Arial, sans-serif;
		/* color: #4F5155; */
    }
      .heading{		
        font-size: 17px;
        font-weight:bold;
       	}
	.header{
        font-size: 12px;
    }
	
	.payment-details{
		border-collapse: collapse;
		
	}
	.padding10 td{
		padding: 6px;
	}
	.padding15 td{
		padding: 15px;
		text
	}
	.payment-details td,th{
      border:1px solid black;
	
	}
	
	
	.info-1{
		margin-bottom: 0px;
       font-size: 10px;
	}
	
	ul.list2 {
		display: list-item;
		list-style-type: none;
		list-style-position: outside;
		margin: 0px;
		padding: 0px;
	}
	ul.list2 li {
		list-style-type: decimal;
		line-height: normal;
		font-size: 14px;
		font-weight: bold;
		text-align: justify;
		float: left;
		margin-left: 35px;
		padding-left: 3px;
		hyphens: auto;
	}
	ul.list2 li span {
		font-size: 12px;
		font-weight: normal;
	}
		
	</style>
</head>
<body>
<?php 
//  echo "<pre>";
//  print_r($paymentdtl);
//  echo "</pre>";exit;


?>
<!-- <table  cellpadding="0" cellspacing="0" class="custom_tbl2" style="width:100%; font-size:12px;">   
<caption class="heading">Welcome Letter</caption>
       
		 
</table> -->
<div class="header">
 <p>Dear <?php echo ucwords(strtolower($memberdtl->CUS_NAME)); ?>,</p>

 <p>
 Greetings from Mantra Life Style Health Club!<br>
 We would like to thank you for selecting <b>Mantra <?PHP echo($memberdtl->CARD_DESC);?></b> and joining the esteemed <b>Mantra family</b>.<br>
 For the past 13 years MANTRA has enriched and transformed the lives of more than 10,000 people, drastically improving their health and wellness from every perspective.<br>
 We are also happy to inform you that <b>Mantra</b> is the only Life Style Health Club in Eastern Region to tie-up with <b>Netaji Subhash Open University</b> to establish an elite and top grade Fitness Institute to train and enhance the quality of our trainers. This is essentially to render highest quality health & fitness services to you and all our customers.<br>
 Your  <b><?PHP echo($memberdtl->CARD_DESC);?></b> membership number is  <b><?PHP echo($memberdtl->MEMBERSHIP_NO);?></b>. <br>
 Your register mobile number is <b><?PHP echo($memberdtl->CUS_PHONE);?></b>, your initial <b>NET GYMING</b> User Id is your Registered Mobile Number.<br>
 We would like to take this opportunity to highlight the Key Package Facilities & Complimentary Facilities of <b>Mantra <?PHP echo($memberdtl->CARD_DESC);?> </b>. 
 </p>

</div>
<br>
<table  class="payment-details" style="width:100%; font-size:12px;"> 
    <caption class="heading">Mantra <?PHP echo($memberdtl->CARD_DESC);?> Facility Chart</caption>
    <tr class="padding10">
     <td colspan="4"  style="text-align:center;"><b>Key package facilities</b></td>
    </tr>
    <tr class="padding10">
     <td colspan="2" style="text-align:center;width:50%;">&emsp;&emsp;&emsp;&emsp;Work out facilities&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
     <td colspan="2" style="text-align:center;width:50%;">Health &amp; Fitness assessment facilities</td>
    </tr>
		<tr class="padding10">
			<td >Description</td>
			<td style="text-align:center;width:8%;">Qty</td>
			<td >Description</td>
			<td style="text-align:center;width:8%;">Qty</td>			
		</tr>

      <!-- <?php foreach ($carddtlbytype as $carddtlbytype) {
		 
	  ?>

		<tr class="padding10">
		    <td ><?php echo $carddtlbytype->coupon_title; ?></td>
			<td style="text-align:center;"><?php echo number_format($carddtlbytype->qty,0); ?></td>
		</tr>

	  <?php } ?> -->
	  <?PHP
	   for($r=0;$r<$maxIndex;$r++)
	   {
		   if ($arrWorkOutDesc[$r]=="")
		   {
			   $wsl="";
			   $wdesc="";
		   }
		   else
		   {
			   $wsl=($r+1).".";
			   $wdesc=$arrWorkOutDesc[$r].".";
		   }

		   if ($arrFitNesDesc[$r]=="")
		   {
			   $fsl="";
			   $fdesc="";
		   }
		   else
		   {
			   $fsl=($r+1).".";
			   $fdesc=$arrFitNesDesc[$r].".";
		   }

	   ?>
		<tr><td>
		<?PHP echo($wsl)?> <?PHP echo($wdesc);?></td>
		<td align="center"><?PHP echo($arrWorkOutQty[$r]);?></td>

		<td><?PHP echo($fsl)?> <?PHP echo($fdesc);?></td>
		<td align="center"><?PHP echo($arrFitNesQty[$r]);?></td>
		</tr>

		<?PHP
	   }
		?>

</table>
<br>
<table  class="payment-details " style="width:100%; font-size:12px;">
		<tr class="padding10"><td  align="center" colspan="2" style="font-size: 14px; font-weight: bold; background-color: #e2e2e2 !important;">Complimentary facilities</td></tr>
		<tr>
		<th align="center">Facilities</th>
		<th align="center">Qty</th>
		</tr>
		<?PHP
				foreach($CardDetailByCompl as $CardDetailByCompl)
				{
				  
				?>
		<tr>
			<td>&emsp;
		      	<?PHP echo($CardDetailByCompl->coupon_title); ?>
				
			</td>
			<td align="center"><?PHP echo(number_format($CardDetailByCompl->qty,0));?></td>
		</tr>
		<?PHP
				}
				?>
	</table>
	<p style="width:100%; font-size:12px;">
	We request you to read the enclosed <b>Terms & Conditions</b> for a better understanding of our rules and regulations (Signing on the signature panel of the Terms & Conditions sheet implies acceptance of the same)<br>    
	
	For any queries, please feel free to contact our customer care at <?php echo($mobile);?> any time from Monday to Saturday between 7 AM to 9 PM. <br></p>

	Warm Regards<br>
	<?php
	if($branch_code!="LT")
	{
	?>
	<img src="<?php echo base_url(); ?>assets/img/sign_subhabrata.jpg" style="margin: 10px 0px 5px 0px;"><br>
	<p style="width:100%;font-size:12px;margin:0px;">Subhabrata Bhattacharjee,
	&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Registration Date : <?php if($memberdtl->REGISTRATION_DT != "") { echo date('d-m-Y',strtotime($memberdtl->REGISTRATION_DT)); } ?></p>
<p style="width:100%;font-size:12px;margin:0px;">
	Director Nu Mantra Life Style Health Club Pvt. Ltd.
	&ensp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Print Date : <?php echo date('d-m-Y'); ?>
	<br><br>
	
	</p>
	<?php
	}
	else
	{
	?>
	&nbsp;<br>
	Team Swasth Mantra<br><br>
	<?php
	}
	?>


<!-- <div class="info-1">
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
    <p style="margin:0px;text-indent:20px;">Degignation/Status</p>
  </div>
  <div style="text-align:right;width:50%;float:rigth;">
  <p style="margin:0px;">-----------------------------------------</p>   
   <p style="margin:0px;padding-right:40px;">Signature</p>
  </div>
  
	
   
</div> -->

</body>
</html>