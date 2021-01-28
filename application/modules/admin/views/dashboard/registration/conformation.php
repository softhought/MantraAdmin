<style type="text/css">
  .alright{
    text-align: right;
  }

  input[type="text"] {

    font-weight: bold;
}
</style>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Registration / Renewal Confirmation</h3>
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

                    ?>
                    <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">Membership No </label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $mem_no;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                    <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">Member Name </label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $mem_name;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>
                    <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">Password</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $pass;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                      <?php

                      if ($paymentData) {
                        $basic_amt=$paymentData->AMOUNT;
                        $cgst_amt=$paymentData->CGST_AMT;
                        $sgst_amt=$paymentData->SGST_AMT;
                        $tot_amt=$paymentData->TOTAL_AMOUNT;
                        $payment_id=$paymentData->PAYMENT_ID;
                        $valid_str=date("d-m-Y",strtotime($paymentData->FROM_DT)) . " - " . date("d-m-Y",strtotime($paymentData->VALID_UPTO));
                      }else{
                        $basic_amt='';
                        $cgst_amt='';
                        $sgst_amt='';
                        $tot_amt='';
                        $valid_str='';

                      }



                      ?>

                     <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">Validation Period</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $valid_str;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                     <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">Basic Amount</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead alright" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $basic_amt;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                    <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">CGST Amount</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead alright alright" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $cgst_amt;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                    <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">SGST Amount</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead alright" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $tot_amt;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                    <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">Total Payable</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead alright" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $cgst_amt;?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                      </div>

                     <div class="row"> 
                    <div class="col-md-3"></div>    
                           <label class="col-md-2 labletext" for="enquiry_dt">SMS</label>                         
                                <div class="col-md-3">   
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                                             
                                            <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name"  autocomplete="off" value="<?php echo $sms; ?>" readonly>
                                        </div>
                                    </div>
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
                            <div class="col-md-4">
                               <a  href="<?php echo admin_with_base_url(); ?>motherpackage/printwelletter/<?php echo $customer_id; ?>"  target="_blank" >
                               <button type="submit" class="btn btn-sm action-button" id="enquirysavebtn" style="width: 57%;">Welcome Letter</button></a>
                            </div><div class="col-md-6"></div>
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