<style type="text/css">
  .alright{
    text-align: right;
  }

  input[type="text"] {

    font-weight: bold;
}
tr:nth-child(even){background-color: #f2f2f2;}
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-indent: 5px;
}
</style>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Due Payment Confirmation</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                  <!--  <a href="<?php echo admin_with_base_url(); ?>createcompany" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a> -->
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
              

             

                <div class="formblock-box">  
                  <?php

                      if ($customerData) {
                          $mem_no= $customerData->MEMBERSHIP_NO;
                          $mem_name= $customerData->CUS_NAME;
                          $pass= $customerData->PASS;
                          $customer_id= $customerData->CUS_ID;
                      }else{
                          $mem_no= '';
                          $mem_name= '';
                          $pass= '';
                          $customer_id=0;

                      }
                      
                      if ($duepayable) {
                        $payment_amount=$duepayable->payment_amount;
                        if($duepayable->due_again > 0){

                          $due_again = $duepayable->due_again;
                          $due_again_date = date('d-m-Y',strtotime($duepayable->due_again_date));
                          $note = "Please clear due amount in proper time";

                        }else{
                          $due_again = 0.00;
                          $due_again_date = "";
                          $note = "Due Cleared";
                        }
                        $payment_id = $duepayable->payment_id;
                       
                      }else{
                        $due_again = 0.00;
                          $due_again_date = "";
                          $note = "";

                      }

                    ?>
              <div class="row"> 
                <div class="col-md-3"></div> 
                  <div class="col-md-5">
                    <table class="table">
                         <tr>
                            <td>Membership No</td>
                             <td><?php echo $mem_no;?></td>
                          </tr>
                          <tr>
                            <td>Member Name</td>
                            <td><?php echo $mem_name;?></td>
                         </tr>
                          <tr>
                              <td>Payment Now</td>
                              <td><?php echo $payment_amount;?></td>
                        </tr>
                        <tr>
                              <td>Next Due</td>
                              <td><?php echo $due_again;?></td>
                        </tr>
                        <tr>
                              <td>Next Due Dt.</td>
                              <td><?php echo $due_again_date;?></td>
                        </tr>
                        <tr>
                              <td>Note</td>
                              <td><?php echo $note;?></td>
                        </tr>
                        <tr>
                              <td>SMS</td>
                              <td><?php if($is_sms == 'Y'){ echo "Sent successfully"; }else{ echo "Not Sent"; } ;?></td>
                        </tr>
                    </table>
                  </div> 
            </div>



        <!--   <table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
          <tr><td width="20%">Membership No</td><td style="font-weight: normal;"><?PHP //echo($mem_no);?></td></tr>
          <tr><td width="20%">Name</td><td style="font-weight: normal;"><?PHP //echo($mem_nm);?></td></tr>
          <tr><td>Password</td><td style="font-weight: normal;"><?PHP //echo($pass);?></td></tr>

          <tr><td>Validation Pd</td><td style="font-weight: normal;"><?PHP //echo($valid_str);?></td></tr>

          <tr><td>Basic Amt.</td><td style="font-weight: normal;"><?PHP //echo($basic_amt);?></td></tr>
          <tr><td>CGST Amt.</td><td style="font-weight: normal;"><?PHP //echo($gst_amt);?></td></tr>
          <tr><td>SGST Amt.</td><td style="font-weight: normal;"><?PHP //echo($sgst_amt);?></td></tr>
          <tr><td>Total Payable</td><td style="font-weight: normal;"><?PHP //echo($tot_amt);?></td></tr>

          <tr><td>SMS</td><td style="font-weight: normal;"><?PHP //echo($sent);?></td></tr>

          <tr>
            <td colspan="2" align="right">
            
              <a href="print_receipt_gst.php?cid=<?PHP //echo($cst_id);?>&pid=<?PHP //echo($pmt_id);?>" target="_blank" class="button_c" style="display: block; width: 40px; float: right;">Print</a>&nbsp;&nbsp;

              <a href="print_welcome_letter.php?cid=<?PHP //echo($cst_id);?>" target="_blank" class="button_c" style="display: block; width: 150px; float: left;">Welcome Letter</a>

            </td>
          </tr>
        </table> 
 -->
           
                         
                
                </div>
                <div class="formblock-box">
                        <div class="row">
                            <div class="col-md-10"></div>
                                <div class="col-md-2 text-right">
                                   <a  href="<?php echo admin_with_base_url(); ?>motherpackage/receiptpdf/<?php echo $payment_id; ?>/<?php echo $customer_id; ?>" target="_blank"  >
                                <button type="submit" class="btn btn-sm action-button" id="enquirysavebtn" style="width: 57%;">Recipt</button>
                                  </a>
                                  

                                </div>
                            </div>
                    </div>

                
                    
                               
         </div>
</div><!-- /.card-body -->

</section>