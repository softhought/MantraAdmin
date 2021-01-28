<!-- <script>
 $('#checkAll').on('click', function(){
          // Check/uncheck all checkboxes in the table
          // var rows = table.rows({ 'search': 'applied' }).nodes();
       
         if ($("input[type='checkbox'][name='checkAll']:checked").length){
              $("#sendsms").css('display','block');
           }else{
            $("#sendsms").css('display','none');
           }
         $('.rowCheckAll').not(this).prop('checked', this.checked);
     });
     $('.checkrow').on('click', function(){
      
       if($("input[type='checkbox'][name='mem_id[]']:checked").length == 0){
        $("#sendsms").css('display','none');
       }else{
        $("#sendsms").css('display','block');
       }
        
     });
</script> -->


<table id=""  class="table customTbl table-bordered table-hover dataTable2  tablepad">
          <thead>
          <tr>
              <th style="width:55px;">Sl.No</th>      
              <th style="width:125px;">Action</th>          
              <th style="width:150px;">Membership No.<br>Validity Pd<br>Mobile No.</th>   
               <!-- <th style="width:90px;"></th>
              <th  style="width:70px;"></th>   -->
              <th style="width:120px;">Name <br> Conv. Mem. No <br> Trainer Name</th>
              <th style="width:60px;">Expiry Dt</th>
              <th style="width:100px;">Last Payment </th>
              <th  style="width:80px;">Renewal Dt</th>  
              <!-- <th  style="width:80px;">Package</th>   -->
          
              <th  style="width:150px;">Renewal Rate(W/o Tax)</th>  
               <!-- <th style="width:150px;">Payment History</th>                -->
               <th style="width:150px;">Last Time Paid(with Tax) <br> This Time Paid (with Tax)</th>               
              <th style="width:100px;">Last attd. Dt <br>Remaining Dys</th>  
              <th style="width:80px;">Attd</th>  
              <th style="width:80px;">Wallet Cash</th>  
              <!-- <th style="width:125px;">Action</th>   -->
                       
              <!-- <th style="width:110px;"><span>Select All </span><input name="checkAll" id="checkAll" type="checkbox" /></th> -->
                       
              </tr>
          </thead>
          <tbody>
              <?php  $i=1;$att_rate=0;$days=0; $years="";$months="";$k=0;$tot_new_amt=0;$fresh=0;$last_time_paid=0;$renew=0;$done_renew=0;$conv_count=0;	$tot_conv_amt=0;$renewed_amt=0;
              $renewed_due=0;$renewed_paid=0;$renewed_tax=0;
              foreach($renewalreminderlist as $renewalreminderlist){ $k++;

                $tot_new_amt+=$renewalreminderlist['renewal_rate'];
                $last_time_paid+=$renewalreminderlist['TOTAL_AMOUNT'];

                if($renewalreminderlist['FRESH_RENEWAL']=="R")
                {
                  $fresh=$fresh+1;
                }
                if($renewalreminderlist['FRESH_RENEWAL']=="F")
                {
                  $renew=$renew+1;
                }

                $curr_dt = date("Y-m-d");
                $totalwalletamt = 0;
                $from_dt=$renewalreminderlist['FROM_DT'];
                $to_dt=$renewalreminderlist['VALID_UPTO'];
                $actualExpiryDt=$renewalreminderlist['EXPIRY_DT'];
                  
                $date_diff=strtotime($to_dt) - strtotime($from_dt);

                $days = floor(($date_diff - $years* 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))+1;
                if ($days>0)
                {
                    $att_rate=number_format($renewalreminderlist['totAtt']*100/$days,2);
                } 

                // remaining days
                $cal_remaining_dys=strtotime($actualExpiryDt) - strtotime($curr_dt);
                $remaining_days = floor(($cal_remaining_dys - @$years * 365*60*60*24 - @$months*30*60*60*24)/ (60*60*24));
                  if($remaining_days>0){
                    $rem_dys = $remaining_days;
                  }
                  else{
                    $rem_dys = "Not remaining";
                  }

                  // wallet cash

                  $totalwalletamt = $renewalreminderlist['promo_amt'] + $renewalreminderlist['cash_amt'];

                  // conversion check
                  $convtd_amt = 0;
                  $conv ="";
                 
                  if(!empty($renewalreminderlist['convertion_dtl'])){

                    $convtd_amt=$renewalreminderlist['convertion_dtl']->AMOUNT;
                    $conv_mem_no = $renewalreminderlist['convertion_dtl']->MEMBERSHIP_NO;
                    $CUS_CARD = $renewalreminderlist['convertion_dtl']->CARD_CODE;

                    $conv="CONV. to " . $conv_mem_no . "(" . $CUS_CARD .")/".$convtd_amt;
						        	$tot_conv_amt=$tot_conv_amt+$convtd_amt;
                      $conv_count=$conv_count+1;
                  }

                  // enquiry count 
                  $tot_call =0;$isEnq = "";
                  if($renewalreminderlist['tot_calling']<10)
                  {
                    $tot_call = "0".$renewalreminderlist['tot_calling'];
                  }
                  else
                  {
                      $tot_call = $renewalreminderlist['tot_calling'];
                  }
                  if($tot_call > 0){ $isEnq = "Y"; }else{ $isEnq = "N"; }
                 if(!empty($renewalreminderlist['prepaymentdtl']) && empty($renewalreminderlist['convertion_dtl'])) { 
                   $done_renew+=1; 
                   $renewed_amt+=$renewalreminderlist['TOTAL_AMOUNT'];
                   $renewed_paid+=$renewalreminderlist['AMOUNT'];
                   $renewed_tax+=$renewalreminderlist['TOTAL_AMOUNT']-$renewalreminderlist['AMOUNT'];
                   $renewed_due+=$renewalreminderlist['DUE_AMOUNT'];
                  }
                  ?>

                <tr>
                <td> <?php echo $k; ?>
                     <!-- <input type="hidden" class="" name="mem_id[]"  id = "mem_id_<?php echo $i; ?>" value="<?php echo $renewalreminderlist['CUS_ID']; ?>"> -->
                     <input type="hidden" class="" name="mem_no[]"  id = "mem_no_<?php echo $i; ?>" value="<?php echo $renewalreminderlist['MEMBERSHIP_NO']; ?>">
                     <input type="hidden" class="" name="validity_str[]"  id = "validity_str_<?php echo $i; ?>" value="<?php echo $renewalreminderlist['VALIDITY_STRING']; ?>">
                     <input type="hidden" class="" name="expiry_dt[]"  id = "expiry_dt_<?php echo $i; ?>" value="<?php echo $renewalreminderlist['EXPIRY_DT']; ?>">
                

               
                
                </td>
                <td align="center"> 
                <!-- <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $renewalreminderlist['CUS_ID']; ?>" data-target="#paymenthistorylistmodel" class="btn btn-block action-button btn-sm viewpayment" style="font-size:9px;padding: 2px;display: inline-block;width: calc(50% - 4px);">Profile</a>  -->
                <!-- <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $renewalreminderlist['CUS_ID']; ?>" data-target="#paymenthistorylistmodel" class="btn btn-block action-button btn-sm viewpayment" style="font-size:10px;padding: 2px;display: inline-block;width: calc(51% - 4px);">Deactive</a>  -->
                <?php if(!empty($renewalreminderlist['prepaymentdtl'])) {  ?>
                  <a class="btn btn-block action-button btn-sm" href="<?php echo admin_with_base_url(); ?>motherpackage/receiptpdf/<?php echo $renewalreminderlist['PAYMENT_ID']; ?>/<?php echo $renewalreminderlist['CUS_ID']; ?>" target="_blank"style="font-size:12px;padding: 2px;width: 60%;">Recipt</a>
                <?php }else{ ?>
                <a href="<?php echo admin_with_base_url(); ?>renewalreminder/addeditrenewal/<?php echo $renewalreminderlist['CUS_ID']; ?>/<?php echo $renewalreminderlist['PAYMENT_ID']; ?>"    class="btn btn-block action-button btn-sm" style="font-size:12px;padding: 2px;width: 60%;">Renew</a> 

                <?php } ?>

                <?php if($isEnq=="Y"){?>
                <div data-toggle="modal" data-cusid="<?php echo $renewalreminderlist['CUS_ID']; ?>" data-pid="<?php echo $renewalreminderlist['PAYMENT_ID']; ?>" data-mode="Feedback" data-mode="Feedback" data-target="#addFeedback" class="addFeedback" style="cursor:pointer;margin-top: 8px;text-indent: 0px;font-size: 14px;text-align: center;display: inline-block;width: calc(50% - 4px);float: left;"> 
										<i class="fa fa-comments enq-add-icon" aria-hidden="true"></i>
									</div> 
                  <?php }else{ ?>

                  <div data-toggle="modal" data-cusid="<?php echo $renewalreminderlist['CUS_ID']; ?>" data-pid="<?php echo $renewalreminderlist['PAYMENT_ID']; ?>" data-mode="Enquiry" data-target="#addFeedback" class="addFeedback" style="cursor:pointer;margin-top: 8px;text-indent: 0px;font-size: 14px;display: inline-block;width: calc(50% - 0px);float: left;text-align: center;"> 
										<i class="fa fa-plus enq-add-icon" aria-hidden="true"></i>
									</div> 
                  <?php } ?>

                  <div  data-toggle="modal" data-cusid="<?php echo $renewalreminderlist['CUS_ID']; ?>" data-pid="<?php echo $renewalreminderlist['PAYMENT_ID']; ?>"data-target="#feedbackList" class="feedbackList enq-count-notify-dv" style="display: inline-block;width: calc(50% - 4px);margin-top: 6px">
										<span class="count-enq"><?php echo $tot_call; ?></span>
										<i class="fa fa-bell bell-icon-enq" aria-hidden="true" style="float:right;"></i>
									</div> 




                </td>
                <td>
                <?php echo $renewalreminderlist['MEMBERSHIP_NO']; ?>
                <br>
                <?php echo $renewalreminderlist['FROM_DT'].' - '.$renewalreminderlist['VALID_UPTO']; ?>
                <br>
                <?php echo $renewalreminderlist['CUS_PHONE']; ?>
                </td>
                <!-- <td>  
                </td>
                <td>
                </td> -->
                <td>
                <?php echo $renewalreminderlist['CUS_NAME']; ?>
                <br>
                <?php echo $conv; ?>
                <br>
                TrN : <?php echo $renewalreminderlist['empl_name']; ?>
               
                </td>
                <td>
                <?php echo date('d-m-Y',strtotime($renewalreminderlist['EXPIRY_DT'])); ?>
                </td>
                <td>
                <?php if(!empty($renewalreminderlist['prepaymentdtl'])) { echo date('d-m-Y',strtotime($renewalreminderlist['prepaymentdtl']->PAYMENT_DT)); } ?>
                
                </td>
                <td>
                <?php echo date('d-m-Y',strtotime($renewalreminderlist['PAYMENT_DT'])); ?>
                </td>
                <td align="right">
                <?php echo $renewalreminderlist['renewal_rate']; ?>
                </td>
                <td align="right">
               
                <?php echo $renewalreminderlist['TOTAL_AMOUNT']; ?>
                <br>
                <?php if(!empty($renewalreminderlist['prepaymentdtl']) && empty($renewalreminderlist['convertion_dtl'])) { echo $renewalreminderlist['prepaymentdtl']->TOTAL_AMOUNT; } ?>
                <!-- <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $renewalreminderlist['CUS_ID']; ?>" data-target="#paymenthistorylistmodel" class="btn btn-block action-button btn-sm viewpayment" style="width:40%;font-size:12px;">View</a>  -->
                       
        </td>
                <td><?php if($renewalreminderlist['last_att_date'] != ""){  echo date('d-m-Y',strtotime($renewalreminderlist['last_att_date'])); } ?>
                <br>
                <?php echo $rem_dys; ?>
                
                
                </td>
                <td align="center"><?php echo $renewalreminderlist['totAtt'].'/'.$days;
                        echo "<br>";
                        echo $att_rate.'%'; ?></td>
                <td><?php if($totalwalletamt > 0) { echo $totalwalletamt; } ?></td>
                
             
                <!-- <td><input type="checkbox" class="call-checkbox rowCheckAll checkrow" name="mem_id[]" value="<?php echo $renewalreminderlist['CUS_ID']; ?>"></td> -->
                </tr>

              <?php $i++; } ?>
          </tbody>
          <tfoot>
            <tr style="background-color: #e8a392;">
            <th colspan="2">Total</th>           
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align:right;"><?php echo(number_format($tot_new_amt,2));?></th>
            <th style="text-align:right;"><?php echo(number_format($last_time_paid,2));?></th>
            
            <!-- <th></th> -->
            <th></th>
            <th></th>
            <th></th>
            </tr>
            <tr style="background-color: #e8a392;">
            
                       
            <th colspan="2">Fresh To Renewal</th>
            <th align="right"><?php echo $fresh;?></th>
            <th colspan="2">Renewal To Renewal</th>
            <th><?php echo $renew;?></th>
            <th>Renewal<br>Converted</th>
            <th><?php echo $done_renew; ?> <br><?php echo $conv_count; ?><br>( <?php echo(number_format($tot_conv_amt,2)); ?>  )</th>
            <th><?PHP echo(number_format($renewed_amt,2));?><br>(B : <?PHP echo(number_format($renewed_paid,2));?><br>T : <?PHP echo(number_format($renewed_tax,2));?>)<br>Due : <?PHP echo(number_format($renewed_due,2));?></th>
            <th></th>
            <th></th>           
            <th></th>
            <!-- <th></th> -->
            <!-- <th></th> -->
            </tr>
            <?php
				@$recovry=number_format((($done_renew+$conv_count)*100)/($fresh+$renew),2);
				$total_recovery=number_format(($renewed_paid+$tot_conv_amt),2);
				?>
            <tr style="background-color: #e8a392;">
            
           
            <th colspan="2">Business Recovery</th>
            <th align="right"><?php echo $recovry;?>&nbsp;%</th>
            <th colspan="2">Total Recovery Without Tax</th>
            <th><?php  echo($total_recovery); ?></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <!-- <th></th>   -->
            <!-- <th></th> -->
            <th></th>
            <th></th>
            
            </tr>
          </tfoot>
        </table>
        
       


 <!-- payment history list Modal -->
<section class="layout-box-content-format1">
<div class="modal fade" id="paymenthistorylistmodel"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header card-header box-shdw" style="color: white;">
              <h5 class="modal-title">Payment History List</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">×</span>
              </button>
            </div>          

            <div id="paymentlistModalBody"  class="modal-body">
                

            </div>      
               
               <div class="modal-footer ">
                
                 <button type="button" class="btn btn-sm action-button" data-dismiss="modal">Close</button>
               </div>
             </div>
             <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
         </div>
     </section>

