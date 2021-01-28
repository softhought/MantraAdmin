<script src="<?php echo base_url();?>assets/js/customJs/payment_received/renewal_remider.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Previous Registration & Present Renewal (GST)</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                   <!-- <a href="<?php echo admin_with_base_url(); ?>statutorymaster" class="btn btn-info btnpos link_tab">

                  <i class="fas fa-clipboard-list"></i> List </a> -->

                </div>

           

            </div><!-- /.card-header -->

            <div class="card-body">

               <form name="RenewalForm"  id="RenewalForm" enctype="multipart/form-data"> 



               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
               <input type="hidden" name="cus_id" id="cus_id" value="<?php echo $cus_id; ?>">
               <input type="hidden" name="payment_id" id="payment_id" value="<?php echo $payment_id; ?>">

                

                <div class="formblock-box">   

                <div class="row"> 
                <label for="name" class="col-md-2">Name  </label>
                  <label for="name" class="col-md-2"><?php echo $cus_name; ?></label>                    
                   </div>
                   <div class="row"> 
                     <label for="mno" class="col-md-2">Membership No  </label>
                      <label for="mno" class="col-md-2"><?php echo $membership_no; ?></label>
                    
                   </div>
                   <div class="row"> 
                     <label for="validity" class="col-md-2">Validation Period  </label>
                      <label for="validity" class="col-md-2"><?php echo $validity_string; ?></label>
                    
                   </div>
                   <div class="row"> 
                     <label for="subamt" class="col-md-2">Subscription  </label>
                      <!-- <label for="mno" class="col-md-2"><?php echo $sub_amt; ?></label> -->
                      <label for="subamt" class="col-md-2"><?php echo number_format($renewal_rate,2); ?></label>
                    
                   </div>

                <div class="row">  
                    <label for="start_dt" class="col-md-2 labletext">Starting Date  </label> 
                    <div class="col-md-3">                                       
                        <div class="form-group">
                            <div class="input-group input-group-sm">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                   </div>
                                <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="start_dt" id="start_dt" im-insert="false" value="<?php echo date('d-m-Y',strtotime($nextstartdt)); ?>" readonly>
                                    </div>
                            </div>
                        </div>  

                        <label for="payment_dt" class="col-md-2 labletext">Payment Date  </label> 
                        <div class="col-md-3">                                       
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="payment_dt" id="payment_dt" im-insert="false" value="" readonly>
                                        </div>
                                </div>
                            </div>         

                </div>
                <div class="row">
                     <label for="complimentry" class="col-md-2 labletext">Complimentary</label>
                     <div class="col-md-3">                    
                          <div class="form-group">                            
                             <input type="checkbox" class="call-checkbox" name="complimentry" id="complimentry" value="">
                         
                       </div> 
                     </div>  
                </div>
                <div class="row">                                 
                   <label for="disc_nego" class="col-md-2 labletext">Discount on Negotiation  </label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs numberwithdecimal" id="disc_nego" name="disc_nego" placeholder="" autocomplete="off" value="">

                                            </div>
                                        </div>
                                    </div>
                       

                </div>
                <div class="row">
                <label for="rem_nego" class="col-md-2 labletext">Remarks for Negotiation  </label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <textarea cols="30" rows="2" name="rem_nego" id="rem_nego"></textarea>
                                            </div>
                                        </div>
                                    </div>
                </div>
                <?php if($cashback_on_sale > 0){ ?>
                <div class="row">
                   <label for="first_name" class="col-md-3 labletext">On Sale Cash Back<br>
                   <span style="color:#871209;font-size:9px;">
						(Will be consider on next transaction)</span>
                   </label>
                   <label for="first_name" class="col-md-1 labletext"><?php echo $cashback_on_sale; ?></label>        
                </div>
                <?php } ?>

                <div class="row">                                 
                   <label for="renewal_amt" class="col-md-2 labletext">Wallet</label>
                        <div class="col-md-3">                                        
                            <div class="form-group"> 
                              <div class="input-group input-group-sm">
                                <select class="form-control select2" id="wallet_cashback" name="wallet_cashback" style="width: 100%;">
                                <option value=''>Select</option>
                                <?php foreach ($walletdtl as $walletdtl) { 
                                   if($walletdtl->is_promo == 'Y'){
                                        ?>
                                    <option data-amount="<?php echo $walletdtl->amount; ?>" data-ispromo="<?php echo $walletdtl->is_promo; ?>" value="<?php echo $walletdtl->is_promo.'_'.$walletdtl->id.'_'.$walletdtl->amount; ?>"><?php echo $walletdtl->title.' - '.$walletdtl->amount; ?></option>

                                   <?php }else{ ?>

                                    <option data-amount="<?php echo $walletdtl->amount; ?>" data-ispromo="<?php echo $walletdtl->is_promo; ?>" value="<?php echo $walletdtl->is_promo.'_'.$walletdtl->id.'_'.$walletdtl->amount; ?>"><?php echo 'Cashback'.' - '.$walletdtl->amount; ?></option>

                                    <?php } } ?>
                                            
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                       

                    </div>

                <div class="row">                                 
                   <label for="renewal_amt" class="col-md-2 labletext">Renewal Amount</label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <input name="subscription_amt" id="subscription_amt" type="hidden" value="<?PHP echo($renewal_rate);?>">
                                             <input type="text" class="form-control forminputs numberwithdecimal" id="premium_amt" name="premium_amt" placeholder="" autocomplete="off" value="<?php echo $renewal_rate; ?>" readonly>

                                            </div>
                                        </div>
                                    </div>
                       

                    </div>
                <div class="row">                                 
                   <label for="payment_now" class="col-md-2 labletext">Payment Now*</label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs numberwithdecimal" id="payment_now" name="payment_now" placeholder="" autocomplete="off" value="<?php echo $renewal_rate; ?>" >

                                            </div>
                                        </div>
                                    </div>
                            <!-- <label for="maintenance_charge" class="col-md-2 labletext">Maintenance Chgs</label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="maintenance_charge" name="maintenance_charge" placeholder="" autocomplete="off" value="" >

                                            </div>
                                        </div>
                                    </div> -->

                </div>
                <div class="row">                                 
                   <label for="due_amt" class="col-md-2 labletext">Due</label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="due_amt" name="due_amt" placeholder="" autocomplete="off" value="" readonly>

                                            </div>
                                        </div>
                                    </div>
                       

                </div>
                <div class="row">                                 
                   <label for="installment_phase" class="col-md-2 labletext">Installment</label>
                            <div class="col-md-3">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="installment_phase" name="installment_phase" style="width: 100%;">
                                                <option value=''>Select</option>
                                                <?php foreach($dueinstallmentlist as $dueinstallmentlist){ ?>
                                                <option value='<?php echo $dueinstallmentlist->installment_period; ?>' data-rate="<?php echo $dueinstallmentlist->rate; ?>"><?php echo $dueinstallmentlist->installment_period.' ( '.$dueinstallmentlist->rate.'% )'; ?></option>
                                                <?php } ?>
                                            
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <label for="extra_charges" class="col-md-2 labletext">Extra Charges</label>
                            <div class="col-md-2">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="extra_charges" name="extra_charges" placeholder="" autocomplete="off" value="" readonly>

                                            </div>
                                        </div>
                                    </div>
                       
                </div>
                <div id="installment_list">
                
                </div>
                
                        <div class="row">
                        <label for="cgstrate" class="col-md-2 labletext">CGST</label>
                           <div class="col-md-3">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="cgstrate" id="cgstrate" class="form-control select2">								
                                        <option value="0">Select </option>
                                        <?php foreach($cgstlist as $row_cgst){?>
                                        <option value="<?php echo $row_cgst->id;?>"><?php echo $row_cgst->rate; ?></option>
								    <?php } ?>
								
								
							</select>
                                    </div>
                                </div>
                            </div>
                            <label for="cgstAmount" class="col-md-2 labletext">CGST Amount</label>
                                <div class="col-md-2">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cgstAmount" id="cgstAmount" type="text" class="form_input_text form-control forminputs "  autocomplete="off" readonly  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                        <div class="row">
                        <label for="sgstrate" class="col-md-2 labletext">SGST</label>
                           <div class="col-md-3">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="sgstrate" id="sgstrate" class="form-control select2">								
                                        <option value="0">Select </option>
                                        <?php foreach($sgstlist as $row_cgst){?>
                                        <option value="<?php echo $row_cgst->id;?>"><?php echo $row_cgst->rate; ?></option>
								    <?php } ?>
								
								
							</select>
                                    </div>
                                </div>
                            </div>
                            <label for="sgstAmount" class="col-md-2 labletext">SGST Amount</label>
                                <div class="col-md-2">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="sgstAmount" id="sgstAmount" type="text" class="form_input_text form-control forminputs "  autocomplete="off" readonly  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                                                   
                <div class="row">
                <label for="payable_amt" class="col-md-2 labletext">Payable</label>
                                <div class="col-md-3">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="payable_amt" id="payable_amt" type="text" class="form_input_text form-control forminputs "  autocomplete="off" readonly  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                        <div class="row">
                        <label for="payment_mode" class="col-md-2 labletext">Payment Mode*</label>
                           <div class="col-md-3">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="payment_mode" id="payment_mode" class="form-control select2">								
                                        <!-- <option value="0">Select </option> -->
                                        <?php foreach(json_decode(PAYMENT_MODE) as $key=>$value){?>
                                        <option value="<?php echo $key;?>"><?php echo $value; ?></option>
								    <?php } ?>
								
								
							</select>
                                    </div>
                                </div>
                            </div>
                            </div>

                <div class="row">
                       <label for="cheque_no" class="col-md-2 labletext">Cheque No</label>
                                <div class="col-md-3">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cheque_no" id="cheque_no" type="text" class="form_input_text form-control forminputs "  autocomplete="off"   >

                                                </div>
                                            </div>
                                    </div>
                            <label for="cheque_date" class="col-md-2 labletext">Cheque Date</label>
                                <div class="col-md-2">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                     <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="cheque_date" id="cheque_date" im-insert="false" value="" readonly>

                                                </div>
                                            </div>
                                    </div>
                        </div> 
                        <div class="row">
                <label for="cheque_bank" class="col-md-2 labletext">Bank</label>
                                <div class="col-md-3">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cheque_bank" id="cheque_bank" type="text" class="form_input_text form-control forminputs "  autocomplete="off"   >

                                                </div>
                                            </div>
                                    </div>
                            <label for="cheque_branch" class="col-md-2 labletext">Branch</label>
                                <div class="col-md-2">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cheque_branch" id="cheque_branch" type="text" class="form_input_text form-control forminputs "  autocomplete="off"  >

                                                </div>
                                            </div>
                                    </div>
                        </div>

                        <div class="row">
                        <label for="collection_branch" class="col-md-2 labletext">Collection Branch*</label>
                           <div class="col-md-3">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="collection_branch" id="collection_branch" class="form-control select2">								
                                        <option value="">Select </option>
                                        <?php foreach($branchlist as $branchlist){?>
                                        <option value="<?php echo $branchlist->BRANCH_ID;?>"><?php echo $branchlist->BRANCH_NAME; ?></option>
								    <?php } ?>
								
								
							</select>
                                    </div>
                                </div>
                            </div>
                            </div>
                    <div class="row">
                        <label for="corporate_company" class="col-md-2 labletext">Corporate Company</label>
                           <div class="col-md-3">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="corporate_company" id="corporate_company" class="form-control select2">								
                                        <option value="0">Select </option>
                                        <?php foreach($corporatecomlist as $corporatecomlist){?>
                                        <option value="<?php echo $corporatecomlist->id;?>"><?php echo $corporatecomlist->company_name; ?></option>
								    <?php } ?>
								
								
							</select>
                                    </div>
                                </div>
                            </div>
                            </div>


                </div>



                    <div class="formblock-box">

                        <div class="row">

                            <div class="col-md-10">

                               <p class="errormsgcolor" id="errormsg"></p>

                            </div>

                                <div class="col-md-2 text-right">

                                <button type="submit" class="btn btn-sm action-button" id="renewalsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>



                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>



                                </div>

                            </div>

                    </div>

                    </form>

                               

         </div>

</div><!-- /.card-body -->



</section>

<div id="renewalvalidationModal" class="modal fade validation" >
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <!-- dialog body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
			<p id="valid_err"  style="font-weight: bold;color: #ca3636;"></p>
      </div>
      <!-- dialog buttons -->
      <!-- <div class="modal-footer"><button type="button" class="btn btn-primary" id="btnhide" >OK</button></div> -->
    </div>
  </div>
</div>