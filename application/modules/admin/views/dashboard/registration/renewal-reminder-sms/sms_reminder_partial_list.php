<script>
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
</script>


<form name="SmsForm" id="SmsForm" enctype="multipart/form-data">
<input type="hidden" class="" name="card"  id = "branch_id" value="<?php echo $card; ?>">
<input type="hidden" class="" name="branch_id"  id = "branch_id" value="<?php echo $branch_id; ?>">
<table id="renewal_remindersms"  class="table customTbl table-bordered table-hover dataTable2  tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:100px;">Membership No.</th>
              <th style="width:150px;">Validity Pd</th>
              <th  style="width:70px;">Mobile No.</th>  
              <th style="width:120px;">Name</th>
              <th style="width:60px;">Expiry Dt</th>
              <th style="width:100px;">Last Payment </th>
              <th  style="width:80px;">Renewal Dt</th>  
              <!-- <th  style="width:60px;">Package</th>   -->
              <th  style="width:150px;">Renewal Rate(W/o Tax)</th>  
              <th style="width:150px;">Payment History</th>  
              <!-- <th style="width:150px;">This Time Paid(with Tax)</th>   -->
              <th style="width:80px;">Attd</th>  
              <th style="width:80px;">SMS Count</th>  
                       
              <th style="width:110px;"><span>Select All </span><input name="checkAll"  id="checkAll" type="checkbox" /></th>
                                  
              </tr>
          </thead>
          <tbody>
              <?php  $i=1;$att_rate=0;$days=0; $years="";$months="";
              foreach($renewalsmslist as $renewalsmslist){
                  
                $from_dt=$renewalsmslist['FROM_DT'];
				$to_dt=$renewalsmslist['VALID_UPTO'];
                  
                $date_diff=strtotime($to_dt) - strtotime($from_dt);

                $days = floor(($date_diff - $years* 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))+1;
                if ($days>0)
                {
                    $att_rate=number_format($renewalsmslist['totAtt']*100/$days,2);
                } 
                  
                  ?>

                <tr>
                <td><?php echo $i; ?></td>
                <td>
                <?php echo $renewalsmslist['MEMBERSHIP_NO']; ?>
                <!-- <input type="hidden" class="" name="mem_id[]"  id = "mem_id_<?php echo $i; ?>" value="<?php echo $renewalsmslist['CUS_ID']; ?>"> -->
                <input type="hidden" class="" name="mem_no[]"  id = "mem_no_<?php echo $i; ?>" value="<?php echo $renewalsmslist['MEMBERSHIP_NO']; ?>">
                </td>
                <td><?php echo $renewalsmslist['FROM_DT'].' - '.$renewalsmslist['VALID_UPTO']; ?>
                <input type="hidden" class="" name="validity_str[]"  id = "validity_str_<?php echo $i; ?>" value="<?php echo $renewalsmslist['VALIDITY_STRING']; ?>">
                <input type="hidden" class="" name="expiry_dt[]"  id = "expiry_dt_<?php echo $i; ?>" value="<?php echo $renewalsmslist['EXPIRY_DT']; ?>">
                </td>
                <td><?php echo $renewalsmslist['CUS_PHONE']; ?>
                <input type="hidden" class="" name="mobile_no[]"  id = "mobile_no_<?php echo $i; ?>" value="<?php echo $renewalsmslist['CUS_PHONE']; ?>">
                </td>
                <td><?php echo $renewalsmslist['CUS_NAME']; ?></td>
                <td><?php echo date('d-m-Y',strtotime($renewalsmslist['EXPIRY_DT'])); ?></td>
                <td><?php if($renewalsmslist['prepaymentdtl'] != "") { echo date('d-m-Y',strtotime($renewalsmslist['prepaymentdtl'])); }else{ echo date('d-m-Y',strtotime($renewalsmslist['PAYMENT_DT'])); } ?></td>
                <td><?php echo date('d-m-Y',strtotime($renewalsmslist['PAYMENT_DT'])); ?></td>
                <td><?php echo $renewalsmslist['renewal_rate']; ?></td>
                <td>
                <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $renewalsmslist['CUS_ID']; ?>" data-target="#paymenthistorylistmodel" class="btn btn-block action-button btn-sm viewpayment" style="width:40%;font-size:12px;">View</a> 
               
        
        </td>
                <td><?php echo $renewalsmslist['totAtt'].'/'.$days.'/'.$att_rate; ?></td>
                <td><?php echo $renewalsmslist['totalsms']; ?></td>
                <td><input type="checkbox" class="call-checkbox rowCheckAll checkrow" name="mem_id[]" value="<?php echo $renewalsmslist['CUS_ID']; ?>"></td>
                </tr>

              <?php $i++; } ?>
          </tbody>
        </table>
        
        </form>


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

