<table class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th>Sl.No</th>
              <th>Membership No</th> 
              <th>Name</th>  
              <th>Mobile</th>  
              <th>Branch</th>  
              <th>Card Code</th>  
              <th>Payment Date</th>  
              <th>Voucher A</th>  
              <th>Voucher B</th>  
              <th>Amount</th>  
              <th>Action</th>
                                  
              </tr>
          </thead>
          <tbody>

          <?php $i=1;
          foreach($OnlinePaymentList as $OnlinePaymentList){ ?>

          <tr>
          <td><?php echo $i;  ?></td>
          <td><?php echo $OnlinePaymentList->MEMBERSHIP_NO; ?></td>
          <td><?php echo $OnlinePaymentList->CUS_NAME; ?></td>
          <td><?php echo $OnlinePaymentList->CUS_PHONE; ?></td>
          <td><?php echo $OnlinePaymentList->BRANCH_NAME; ?></td>
          <td><?php echo $OnlinePaymentList->CUS_CARD; ?></td>
          <td><?php if($OnlinePaymentList->PAYMENT_DT != ""){ echo date('d-m-Y',strtotime($OnlinePaymentList->PAYMENT_DT)); } ?></td>
          <td id="voucher_no_a_<?php echo $i; ?>"><?php echo $OnlinePaymentList->voucher_no_a; ?></td>
          <td id="voucher_no_b_<?php echo $i; ?>"><?php echo $OnlinePaymentList->voucher_no_b; ?></td>
          <td><?php echo $OnlinePaymentList->AMOUNT; ?></td>
          <td>
          <?php //echo $voucher_master_id;

			 					if ($OnlinePaymentList->voucher_master_id == NULL || $OnlinePaymentList->second_voucher_mast_id == NULL) {
			 						$disp1="display:none";

			 				?>
          <button class="btn label-primary postonlinepaymentvoucher" id="postinfo_<?php echo $i;?>"
						               data-toggle="modal" 
						               data-membership="<?php echo $OnlinePaymentList->MEMBERSHIP_NO; ?>"
						               data-paymentid="<?php echo  $OnlinePaymentList->PAYMENT_ID; ?>"
						               data-branchid="<?php echo $OnlinePaymentList->branch_id; ?>"
						               data-valsl=<?php echo $i; ?>
						              >Post Voucher</button>
                 <?php }else{ $disp1="display:block"; }?>
            <button id="afterpostvoucher_<?php echo $i;?>" type="button" class="btn label-success" style="<?php echo $disp1; ?>"> Voucher Posted&nbsp;<i class="fa fa-check"></i> </button>
           
			 				 <div id="process-loader_<?php echo $i;?>" style="display:none; text-align: center;">
							<img src="<?php echo base_url(); ?>assets/img/loading_new.gif" style="height: 25px;width: 25px;">
              <br>Processing...
              </div>
						
               

                          </td>
          </tr>

          <?php $i++; } ?>
               
                  
          </tbody>
        </table>