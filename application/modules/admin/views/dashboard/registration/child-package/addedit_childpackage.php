<script src="<?php echo base_url();?>assets/js/customJs/registration/exchange_pack.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Child Package - Registration (GST)</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                   <!-- <a href="<?php echo admin_with_base_url(); ?>statutorymaster" class="btn btn-info btnpos link_tab">

                  <i class="fas fa-clipboard-list"></i> List </a> -->

                </div>

           

            </div><!-- /.card-header -->

            <div class="card-body">

               <form name="ExchangepackForm"  id="ExchangepackForm" enctype="multipart/form-data"> 



               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">

               <input type="hidden" name="cus_id" id="cus_id" value="">
               <input type="hidden" name="currdate" id="currdate" value="<?php echo date('Y-m-d'); ?>">
               <input type="hidden" name="pre_branch_id" id="pre_branch_id" value="">
               

                

                <div class="formblock-box">   
                  

                <div class="row"> 

                        <label for="payment_dt" class="col-md-1 labletext">Mobile No</label> 
                        <div class="col-md-2">                                       
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    
                                    <input type="text" class="form-control onlynumber" name="mobile_no" id="mobile_no" im-insert="false" value="" maxlength="10">
                                        </div>
                                </div>
                            </div> 

                            <label for="sel_package" class="col-md-1 labletext">Package</label>
                           <div class="col-md-4">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="sel_package" id="sel_package" class="form-control select2">								
                                        <option value="">Select </option>
                                       
								    
								
							</select>
                                    </div>
                                </div>
                            </div>        

                </div>
                 
                </div>
                <div class="formblock-box">   
                   <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Information(s) - Mother Package</h3> 

                        <div class="row"> 

                            <label for="reg_dt" class="col-md-2 labletext">Registration Date </label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        <input type="text" class="form-control" name="reg_dt" id="reg_dt" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <label for="membership_no" class="col-md-2 labletext">Membership No.</label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        
                                        <input type="text" class="form-control " name="membership_no" id="membership_no" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row"> 
                        <label for="mother_pack" class="col-md-2 labletext">Mother Package</label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        
                                        <input type="text" class="form-control" name="mother_pack" id="mother_pack" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>

                            <label for="validity_pd" class="col-md-2 labletext">Validity Pd </label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        
                                        <input type="text" class="form-control " name="validity_pd" id="validity_pd" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                        <div class="row"> 
                        <label for="mem_name" class="col-md-2 labletext">Name </label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        
                                        <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>

                            <label for="phone_no" class="col-md-2 labletext">Phone / Mobile </label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        
                                        <input type="text" class="form-control onlynumber" name="phone_no" id="phone_no" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                        <div class="row"> 
                        <label for="grantdays" class="col-md-2 labletext">App Ext.(Grant Days)</label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        
                                        <input type="text" class="form-control" name="grantdays" id="grantdays" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>

                            <label for="actual_exp_date" class="col-md-2 labletext">Actual Exp Date </label> 
                            <div class="col-md-3">                                       
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        <input type="text" class="form-control" name="actual_exp_date" id="actual_exp_date" im-insert="false" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                </div>
                 </div>
                 <div class="formblock-box">   
                   <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Admission & Payment Information(s) - Child Package</h3> 
                            <div class="row">
                               <label for="payment_dt" class="col-md-2 labletext">Transfer  </label> 
                              <div class="col-md-2">
                               
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfer_branch" id="transfer_branch_a" value="TSB" checked>
                                                <label class="form-check-label font12">Within Branch</label>
                                            </div>                                               

                                         </div>
                                </div>
                                <div class="col-md-2">
                               
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfer_branch" id="transfer_branch_b" value="TOB">
                                                <label class="form-check-label font12">Across Branch</label>
                                            </div>                                               

                                         </div>
                                </div>
                                <div class="col-md-3">
                               
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfer_branch" id="transfer_branch_c" value="TRN">
                                                <label class="form-check-label font12">Across Branch (No payment)  </label>
                                            </div>                                               

                                         </div>
                                </div>
                            </div>
                            <div class="row">
                               <label for="package_starting" class="col-md-2 font12">Package Starting Date</label> 
                               <label for="package_starting" class="col-md-4 font12" id="pack_starting_dt"></label> 
                               <input type="hidden" name="packg_start_dt" id="packg_start_dt" />
                               </div>
                            <div class="row">
                               <label for="paid_amt" class="col-md-2 font12">Paid Amount </label> 
                               <label for="paid_amt" class="col-md-2 font12" id="paidamt"></label> 
                               <input type="hidden" name="prv_pckg_paid_amt" id="prv_pckg_paid_amt" value="">
                            </div>

                            <div class="row">
                               <label for="pre_due" class="col-md-2 font12">Previous Due </label> 
                               <span for="pre_due" class="col-md-10 fontetext" id="previousdue"></span> 
                               <input type="hidden" name="prv_due_amt" id="prv_due_amt" />
                            </div>

                            <div class="row">                      

                                <label for="payment_dt" class="col-md-2 labletext withinbrn accrossbrn">Payment Date  </label> 
                                <div class="col-md-3 withinbrn accrossbrn">                                       
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
                        <label for="package_name" class="col-md-2 labletext dispnone accbrnnopay">Package</label>
                           <div class="col-md-3 dispnone accbrnnopay">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <input name="package_name" id="package_name" type="text" class="form_input_text form-control forminputs "  autocomplete="off"   readonly>
                                    </div>
                                </div>
                            </div>
                            </div>
                             <div class="row"> 
                             
                                    <label for="from_branch" class="col-md-2 labletext dispnone accrossbrn">From Branch*</label>
                                    <div class="col-md-3 dispnone accrossbrn">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <select name="from_branch" id="from_branch" class="form-control select2">								
                                                    <option value="">Select </option>
                                                    <?php 
                                                    $frombranchlist = $branchlist;
                                                    foreach($frombranchlist as $frombranchlist){?>
                                                    <option value="<?php echo $frombranchlist->BRANCH_ID;?>"><?php echo $frombranchlist->BRANCH_NAME; ?></option>
                                                <?php } ?>
                                            
                                            
                                        </select>
                                                </div>
                                            </div>
                                        </div> 
                                        </div>
                    <div class="row">
                            <label for="branch" class="col-md-2 labletext dispnone accrossbrn accbrnnopay">To Branch*</label>
                             <label for="branch" class="col-md-2 labletext withinbrn">Branch*</label>
                                    <div class="col-md-3 withinbrn accrossbrn accbrnnopay">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <select name="branch" id="branch" class="form-control select2">								
                                                    <option value="">Select </option>
                                                    <?php 
                                                    $branchlist1 = $branchlist;
                                                    foreach($branchlist1 as $branchlist1){?>
                                                    <option value="<?php echo $branchlist1->BRANCH_ID;?>" data-code="<?php echo $branchlist1->BRANCH_CODE;?>"><?php echo $branchlist1->BRANCH_NAME; ?></option>
                                                <?php } ?>
                                            
                                            
                                        </select>
                                                </div>
                                            </div>
                                        </div> 
                            </div>
                             <!-- <div class="row">
                                        <label for="to_branch" class="col-md-2 labletext dispnone accrossbrn accbrnnopay">To Branch*</label>
                                    <div class="col-md-3 dispnone accrossbrn accbrnnopay">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <select name="to_branch" id="to_branch" class="form-control select2">								
                                                    <option value="">Select </option>
                                                    <?php 
                                                    $tobranchlist = $branchlist;
                                                    foreach($tobranchlist as $tobranchlist){?>
                                                    <option value="<?php echo $tobranchlist->BRANCH_ID;?>"><?php echo $tobranchlist->BRANCH_NAME; ?></option>
                                                <?php } ?>
                                            
                                            
                                        </select>
                                                </div>
                                            </div>
                                        </div>        
                        </div>  -->
                             <div class="row"> 
                             <label for="sel_card" class="col-md-2 labletext withinbrn accrossbrn">Package*</label>
                                    <div class="col-md-3 accrossbrn withinbrn">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <select name="sel_card" id="sel_card" class="form-control select2">								
                                                    <option value="">Select </option>
                                                    <?php foreach($cardlist as $cardlist){?>
                                                    <option value="<?php echo $cardlist->CARD_ID;?>" data-card="<?php echo $cardlist->CARD_CODE;?>"><?php echo $cardlist->CARD_DESC.' ('.$cardlist->CARD_CODE.')'; ?></option>
                                                <?php } ?>
                                            
                                            
                                        </select>
                                      
                                                </div>
                                                
                                            </div>
                                           
                                        </div>
                                       
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10 dispnone withinbrn accrossbrn" id="carderr">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                          <span class="fontetext" id="packg_validity"></span>
                                          </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <label for="collection_branch" class="col-md-2 labletext withinbrn accrossbrn">Collection Branch*</label>
                                    <div class="col-md-3 withinbrn accrossbrn">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <select name="collection_branch" id="collection_branch" class="form-control select2">								
                                                    <option value="">Select </option>
                                                    <?php 
                                                    $collectionbrn  = $branchlist;
                                                    foreach($collectionbrn as $collectionbrn){?>
                                                    <option value="<?php echo $collectionbrn->BRANCH_ID;?>"><?php echo $collectionbrn->BRANCH_NAME; ?></option>
                                                <?php } ?>
                                            
                                            
                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        </div>  
                                      
                             
                    <div class="row ">
                       <label for="complimentry" class="col-md-2 labletext withinbrn accrossbrn">Complimentary</label>
                        <div class="col-md-3 withinbrn accrossbrn">                    
                            <div class="form-group">                            
                                <input type="checkbox" class="call-checkbox" name="complimentry" id="complimentry" value="">
                            
                        </div> 
                      </div>  
                  </div> 
                         <div class="row "> 
                             <label for="package_rate" class="col-md-2 labletext withinbrn accrossbrn">Package Rate*</label>
                                    <div class="col-md-3 withinbrn accrossbrn">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control"  name="package_rate_txt" id="package_rate_txt" im-insert="false" value="" readonly>
                                                <input type="text" class="form-control"  name="package_rate" id="package_rate" im-insert="false" value="" readonly>
                                                </div>
                                            </div>
                                 </div>
                                 </div> 
                         <div class="row "> 
                                 <label for="paid_amt" class="col-md-2 labletext withinbrn accrossbrn">Amount to be paid*</label>
                                    <div class="col-md-3 withinbrn accrossbrn">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control"  name="paid_amt_txt" id="paid_amt_txt" im-insert="false" value="" readonly>
                                                <input type="text" class="form-control"  name="paid_amt" id="paid_amt" im-insert="false" value="" readonly>
                                                </div>
                                            </div>
                                 </div>
                                
                                    <span class="col-md-4 fontetext withinbrn accrossbrn" id="amttobepaidinfo"></span>
                                
                            </div>

                            
                    <div class="row">
                    <label for="cashback_on_sale" class="col-md-3 labletext withinbrn accrossbrn dispnone" id="cashback_on_sale_txt">On Sale Cash Back<br>
                    <span style="color:#871209;font-size:9px;">
                            (Will be consider on next transaction)</span>
                    </label>
                    <label for="cashback_on_sale" class="col-md-1 labletext withinbrn accrossbrn dispnone" id="cashback_on_sale"></label>  
                    <input type="hidden" name="sale_cashback" id="sale_cashback">      
                    </div>
                <div class="row dispnone" id="wallet">                                 
                   <label for="wallet_cashback" class="col-md-2 labletext withinbrn accrossbrn">Wallet</label>
                        <div class="col-md-3 withinbrn accrossbrn">                                        
                            <div class="form-group"> 
                              <div class="input-group input-group-sm">
                                <select class="form-control select2" id="wallet_cashback" name="wallet_cashback" style="width: 100%;">
                                <option value=''>Select</option>                              
                                            
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                       
                      </div>
               
                           
                            <div class="row ">                                 
                                <label for="disc_conv" class="col-md-2 labletext withinbrn accrossbrn">Discount on Conversion  </label>
                                            <div class="col-md-3 withinbrn accrossbrn">                                        
                                                    <div class="form-group"> 
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs numberwithdecimal" id="disc_conv" name="disc_conv" placeholder="" autocomplete="off" value="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label for="disc_offer" class="col-md-2 labletext withinbrn accrossbrn">Discount on Offer  </label>
                                            <div class="col-md-3 withinbrn accrossbrn">                                        
                                                    <div class="form-group"> 
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs numberwithdecimal" id="disc_offer" name="disc_offer" placeholder="" autocomplete="off" value="">

                                                            </div>
                                                        </div>
                                                    </div>

                                </div>
                               
                            <div class="row ">                                 
                                <label for="disc_nego" class="col-md-2 labletext withinbrn accrossbrn">Discount on Negotiation  </label>
                                            <div class="col-md-3 withinbrn accrossbrn">                                        
                                                    <div class="form-group"> 
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs numberwithdecimal" id="disc_nego" name="disc_nego" placeholder="" autocomplete="off" value="">

                                                            </div>
                                                        </div>
                                                    </div>
                                    

                                </div>  
                                <div class="row " >
                                  <label for="rem_nego" class="col-md-2 labletext withinbrn accrossbrn">Remarks for Negotiation  </label>
                                    <div class="col-md-3 withinbrn accrossbrn">                                        
                                            <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <textarea cols="30" rows="2" name="rem_nego" id="rem_nego"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                            <div class="row ">                                 
                   <label for="premium_amt" class="col-md-2 labletext withinbrn accrossbrn">Premium*</label>
                            <div class="col-md-3 withinbrn accrossbrn">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                       
                                             <input type="text" class="form-control forminputs numberwithdecimal" id="premium_amt" name="premium_amt" placeholder="" autocomplete="off" value="" readonly>

                                            </div>
                                        </div>
                                    </div>
                       

                    </div>
                   <div class="row">                                 
                      <label for="payment_now" class="col-md-2 labletext  withinbrn accrossbrn">Payment Now*</label>
                            <div class="col-md-3  withinbrn accrossbrn">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs numberwithdecimal" id="payment_now" name="payment_now" placeholder="" autocomplete="off" value="" >

                                            </div>
                                        </div>
                                    </div>
                            

                   </div>
                   <div class="row ">                                 
                   <label for="due_amt" class="col-md-2 labletext withinbrn accrossbrn">Due</label>
                            <div class="col-md-3 withinbrn accrossbrn">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="due_amt" name="due_amt" placeholder="" autocomplete="off" value="" readonly>

                                            </div>
                                        </div>
                                    </div>
                       

                </div>
                <div class="row ">                                 
                   <label for="installment_phase" class="col-md-2 labletext withinbrn accrossbrn">Installment</label>
                            <div class="col-md-3 withinbrn accrossbrn">                                        
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
                                    <label for="extra_charges" class="col-md-2 labletext withinbrn accrossbrn">Extra Charges</label>
                            <div class="col-md-2 withinbrn accrossbrn">                                        
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="extra_charges" name="extra_charges" placeholder="" autocomplete="off" value="" readonly>

                                            </div>
                                        </div>
                                    </div>
                       
                </div>
                <div id="installment_list">
                
                </div>
                <div class="row ">
                        <label for="cgstrate" class="col-md-2 labletext withinbrn accrossbrn">CGST</label>
                           <div class="col-md-3 withinbrn accrossbrn">                                        
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
                            <label for="cgstAmount" class="col-md-2 labletext withinbrn accrossbrn">CGST Amount</label>
                                <div class="col-md-2 withinbrn accrossbrn">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cgstAmount" id="cgstAmount" type="text" class="form_input_text form-control forminputs "  autocomplete="off" readonly  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                        <div class="row ">
                        <label for="sgstrate" class="col-md-2 labletext withinbrn accrossbrn">SGST</label>
                           <div class="col-md-3 withinbrn accrossbrn">                                        
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
                            <label for="sgstAmount" class="col-md-2 labletext withinbrn accrossbrn">SGST Amount</label>
                                <div class="col-md-2 withinbrn accrossbrn">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="sgstAmount" id="sgstAmount" type="text" class="form_input_text form-control forminputs "  autocomplete="off" readonly  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                                                   
                <div class="row ">
                <label for="payable_amt" class="col-md-2 labletext withinbrn accrossbrn">Payable</label>
                                <div class="col-md-3 withinbrn accrossbrn">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="payable_amt" id="payable_amt" type="text" class="form_input_text form-control forminputs "  autocomplete="off" readonly  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                        <div class="row ">
                        <label for="payment_mode" class="col-md-2 labletext accrossbrn withinbrn">Payment Mode*</label>
                           <div class="col-md-3 accrossbrn withinbrn">                                        
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

                <div class="row ">
                       <label for="cheque_no" class="col-md-2 labletext withinbrn accrossbrn">Cheque No</label>
                                <div class="col-md-3 withinbrn accrossbrn">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cheque_no" id="cheque_no" type="text" class="form_input_text form-control forminputs "  autocomplete="off"   >

                                                </div>
                                            </div>
                                    </div>
                            <label for="cheque_date" class="col-md-2 labletext withinbrn accrossbrn">Cheque Date</label>
                                <div class="col-md-2 withinbrn accrossbrn">                                        
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
                        <div class="row ">
                <label for="cheque_bank" class="col-md-2 labletext withinbrn accrossbrn">Bank</label>
                                <div class="col-md-3 withinbrn accrossbrn">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cheque_bank" id="cheque_bank" type="text" class="form_input_text form-control forminputs "  autocomplete="off"   >

                                                </div>
                                            </div>
                                    </div>
                            <label for="cheque_branch" class="col-md-2 labletext withinbrn accrossbrn">Branch</label>
                                <div class="col-md-2 withinbrn accrossbrn">                                        
                                        <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input name="cheque_branch" id="cheque_branch" type="text" class="form_input_text form-control forminputs "  autocomplete="off"  >

                                                </div>
                                            </div>
                                    </div>
                        </div>
                        <div class="row ">
                       <label for="hold_mno" class="col-md-2 labletext withinbrn accrossbrn">Hold Membership</label>
                        <div class="col-md-3 withinbrn accrossbrn">                    
                            <div class="form-group">                            
                                <input type="checkbox" class="call-checkbox" name="hold_mno" id="hold_mno" value="">
                            
                        </div> 
                      </div>  
                  </div>
                
                  <div class="row ">
                        <label for="dony_by" class="col-md-2 labletext withinbrn accrossbrn">Done by*</label>
                           <div class="col-md-3 withinbrn accrossbrn">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="dony_by" id="dony_by" class="form-control select2">								
                                        <option value="0">Select </option>
                                        <?php foreach($userlist as $userlist){?>
                                        <option value="<?php echo $userlist->id;?>"><?php echo $userlist->name; ?></option>
								    <?php } ?>
								
								
							</select>
                                    </div>
                                </div>
                            </div>
                            </div>
                  <div class="row ">
                            <label for="trainer" class="col-md-2 labletext withinbrn accrossbrn accbrnnopay ">Trainer</label>
                           <div class="col-md-3  withinbrn accrossbrn accbrnnopay">                                        
                                <div class="form-group"> 
                                    <div class="input-group input-group-sm">
                                    <select name="trainer" id="trainer" class="form-control select2">								
                                        <option value="0">Select </option>
                                        <?php foreach($trainerlist as $trainerlist){?>
                                        <option value="<?php echo $trainerlist->empl_id;?>"><?php echo $trainerlist->empl_name; ?></option>
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

                                <button type="submit" class="btn btn-sm action-button" id="exchangesavebtn" style="width: 57%;"><?php echo $btnText; ?></button>



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