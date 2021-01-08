<script src="<?php echo base_url();?>assets/js/customJs/account/voucher.js"></script>
<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th> 
              <th width="15%">Date </th>
              <th  width="10%">Transaction Type</th>    
              <th  width="10%">Voucher No.</th>
              <th  width="25%">Account Desc</th> 
              <th width="7%">Narration</th>                         
              <th width="7%">Amount</th>                       
                                       
              <th width="10%">Action</th>
                                  
              </tr>
          </thead>
          <tbody>

            <?php  $i = 1;
                  foreach ($voucherlist as $voucherlist) {                      
                    $str_acc="";
                    foreach($voucherlist['voucherdtl'] as $voucherdtl)
				  {
					$str_acc.=$voucherdtl->tran_tag." - " .$voucherdtl->account_description." - ".$voucherdtl->amount;
					$str_acc.="<br>";
				  }
            
            ?>
            <tr>
            <td><?php echo $i++; ?></td>
            <td><?php if($voucherlist['voucher_date'] != ""){ echo date('d-m-Y',strtotime($voucherlist['voucher_date'])); } ?></td>
            <td><?php 	if($voucherlist['tran_type']=="CASH" OR $voucherlist['tran_type']=="BANK"){
								echo $voucherlist['tran_sub_type']; 
							}
							else{
								echo $voucherlist['tran_type']; 
							}
							
						?>
                        </td>
            <td><?php echo $voucherlist['voucher_no']; ?></td>
            <td><?php echo $str_acc; ?></td>
            <td><?php echo $voucherlist['narration']; ?></td>
            <td style="text-align: right;"><?php 
							if($voucherlist['tran_type']=="REG" OR $voucherlist['tran_type']=="WST" OR $voucherlist['tran_type']=="WOST" OR $voucherlist['tran_type']=="HYG"){
								 echo " ";  
							}
							else{ echo  number_format($voucherlist['total_dr_amt'],2); }
						?></td>
           <td>	<?php 
                      $auto_voucher_type_length= strlen($voucherlist['auto_voucher_type']);
					  if($voucherlist['tran_type']=="REG" OR $voucherlist['tran_type']=="WST" OR $voucherlist['tran_type']=="WOST" OR $voucherlist['tran_type']=="HYG" OR $auto_voucher_type_length>0){echo "";}
						else{  ?>
                    <a href="<?php echo admin_with_base_url(); ?>voucher/addeditvoucher/<?php echo $voucherlist['id'];?>" class="btn tbl-action-btn padbtn" id="" title="Edit">
                    <i class="far fa-edit" ></i></a>

                    <a href="javascript:;" class="btn tbl-action-btn padbtnn voucherdelete" id="" data-voucherid="<?php echo $voucherlist['id'];?>" title="Delete">
                    <i class="far fa-trash-alt" ></i></a>
                       <?php  }
						?>

             </td>

            </tr>

                <?php } ?>


          
          </tbody>
        </table>