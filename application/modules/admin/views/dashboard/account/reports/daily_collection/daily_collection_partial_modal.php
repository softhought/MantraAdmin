
<h2 class="head_txt"><?php echo $heading; ?></h2>
<table class="table customTbl table-bordered table-hover tablepad">
<?php if($payment_mode == 'Cash Rcvd' || $payment_mode == 'Cash Exp'){ ?>
<thead>

<tr class="heading">
	<td width="4%">#</td>
	<td>Date</td>
	<td>Account</td>
    <?php if($payment_mode == 'Cash Exp'){ ?>	
	<td>Narration</td>
    <?php } ?>
	<td>Total Amt</td>
</tr>
</thead>
<tbody>
<?php  $i=1;$totalAmount=0;$voucherAmt=0;
  foreach($dailycollectionlist as $dailycollectionalldtl){
    $voucherAmt =  $dailycollectionalldtl['amount'];
    $totalAmount = $totalAmount+$voucherAmt;
    ?>
   <tr>
   <td><?php  echo  $i++; ?></td>
   <td><?php if($dailycollectionalldtl['voucher_date'] != ""){ echo date('d-m-Y',strtotime($dailycollectionalldtl['voucher_date'])); } ?></td>
    <td>
    <?php foreach($dailycollectionalldtl['cashdtl'] as $cashdtl)
			{ ?>
			<?php echo $cashdtl->account_description;?>
            
        </td>
    <!-- <?php if($payment_mode != 'Cash Exp'){ ?>
		<td><?php echo $cashdtl->amount;?></td>
     <?php } ?> -->
					
	 
			<?php } ?>
            <?php if($payment_mode == 'Cash Exp'){ ?>
                <td><?php echo $dailycollectionalldtl['narration']; ?>
            <?php } ?>
            <td align="right"><?php echo number_format($voucherAmt,2); ?>
   </tr>
   
  <?php } ?>
  <tr class="total_section">
	<td colspan="5" align="right">Total Amt : <?php echo number_format($totalAmount,2);?></td>
   </tr>
</tbody>

<?php }else{ ?>


<thead>

<tr class="heading">
	<td width="4%">#</td>
	<td>MembershipNo</td>
	<td>Name</td>
	<td>Mobile No</td>
	<td>Branch</td>
	<td>Basic</td>
	<td>Tax</td>
	<td>Total Amt</td>
</tr>
</thead>
<tbody>

  <?php  $i=1;$grandTotalAmt=0;
  foreach($dailycollectionlist as $dailycollectionalldtl){
      
      $grandTotalAmt+= $dailycollectionalldtl['totalAmt']; 
      ?>

  <tr>
  <td><?php  echo  $i++; ?></td>
  <td><?php echo $dailycollectionalldtl['membership_no']; ?></td>
  <td><?php echo $dailycollectionalldtl['membName']; ?></td>
  <td><?php echo $dailycollectionalldtl['mobile']; ?></td>
  <td><?php echo $dailycollectionalldtl['branch']; ?></td>
  <td align="right"><?php echo $dailycollectionalldtl['basicAmt']; ?></td>
  <td align="right"><?php echo $dailycollectionalldtl['taxAmt']; ?></td>
  <td align="right"><?php echo number_format($dailycollectionalldtl['totalAmt'],2); ?></td>
  </tr>

  <?php } ?>

  <tr>
  <td colspan="8" align="right">Total Amt : <?php echo number_format($grandTotalAmt,2);?></td>
  </tr>

</tbody>
  <?php } ?>
</table>