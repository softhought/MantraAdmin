<script src="<?php echo base_url();?>assets/js/customJs/payment_received/renewal_remider.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Renewal Reminder list</h3>
       <!-- <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add Enquiry</a>
    </div> -->
     
      
    </div><!-- /.card-header -->
   
    <div class="card-body">   

    <div class="list-search-block">
               <div class="row box">  
                             
                  <div class="col-sm-2">
                    <label for="from_dt">From Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="from_dt" id="from_dt" im-insert="false" value="" readonly>
                          </div>
                        </div>
                       
                    </div>
                   
                    <div class="col-sm-2">
                    <label for="to_date">To Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="to_date" id="to_date" im-insert="false" value="" readonly>
                          </div>
                        </div>
                         
                    </div> 
                    <div class="col-sm-2">
                    <label for="branch">Branch</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="branch" id="branch">
                              <option value="">Select</option>
                              <?php foreach($branchlist as $branchlist){ ?>
                                      <option value='<?php echo $branchlist->BRANCH_ID; ?>'><?php echo $branchlist->BRANCH_NAME; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-3">
                    <label for="category">Category</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="category" id="category">
                              <option value="">Select</option>
                              <?php foreach($packagecatlist as $packagecatlist){ ?>
                                      <option value='<?php echo $packagecatlist->id; ?>'><?php echo $packagecatlist->category_name; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-3">
                    <label for="card">Package</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="card" id="card">
                              <option value="">Select</option>
                            
                              
                            </select>
                          </div>
                        </div>
                       
                    </div>
                   
                    <div class="col-sm-3">
                    <label for="trainer">Trainer</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="trainer" id="trainer">
                              <option value="">Select</option>
                              <?php foreach($trainerlist as $trainerlist){ ?>
                                      <option value='<?php echo $trainerlist->empl_id; ?>'><?php echo $trainerlist->empl_name; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-2">
                    <label for="mobile_no">Mobile No.</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">                            
                           <input type="text" class="form-control onlynumber" name="mobile_no" id="mobile_no" value="" maxlength="10">
                          </div>
                        </div>
                      
                    </div> 
                    <div class="col-sm-2">
                    <label for="mem_no">Membership No.</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">                            
                           <input type="text" class="form-control" name="mem_no" id="mem_no" value="" >
                          </div>
                        </div>
                      
                    </div> 

                <div class="col-md-1">
                <label for="payment">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="renewaltviewbtn" >Show</button>

                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
             
              </div>

              </div> <!-- End of search block -->

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

      <div id="renewal_reminder_list">
        
     </div>
    </div>

    </div><!-- /.card-body -->
</div><!-- /.card -->
</section>


<!-- Feedback Modal -->
<section class="layout-box-content-format1">
<div class="modal fade" id="feedbackmodel"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header card-header box-shdw" style="color: white;">
              <h5 class="modal-title">Add Feedback</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">×</span>
              </button>
            </div>          

            <div id="ModalBody"  class="modal-body">
            
              <!--- In Case of Renewal OR Due---------->
				<input type="hidden" name="customer_id" id="customer_id" value="0" />
                <input type="hidden" name="feedbackEnqMode" id="feedbackEnqMode" value=""/>
		         <input type="hidden" name="enquiry_id" id="enquiry_id" value=""/>

                      <div class="row">     
                           <label class="col-md-2 labletext" for="fname">First Name</label>                         
                                <div class="col-md-3">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead" id="fname" name="fname" autocomplete="off" value="" readonly>

                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                               
                                    <label for="lname" class="col-md-2 labletext">Last Name  </label>
                                    <div class="col-md-3">                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead" id="lname" name="lname"  autocomplete="off" value="" readonly>

                                            </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">     
                           <label class="col-md-2 labletext" for="pincode">Pin</label>                         
                                <div class="col-md-3">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead" id="pincode" name="pincode" autocomplete="off" value="" readonly>

                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                               
                                    <label for="location" class="col-md-2 labletext">Location  </label>
                                    <div class="col-md-3">                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead" id="location" name="location"  autocomplete="off" value="" readonly>

                                            </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">     
                           <label class="col-md-2 labletext" for="address">Address</label>                         
                                <div class="col-md-3">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                             <textarea class="disable_field" cols="20" rows="1" name="address" id="address" ></textarea>
                                               
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div><label for="email" class="col-md-2 labletext">Email  </label>
                                    <div class="col-md-3">                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="email" class="form-control forminputs typeahead" id="email" name="email"  autocomplete="off" value="" readonly>

                                            </div>
                                            </div>
                                        </div>
                               
                                  
                                </div>
                                <div class="row">     
                                    <label class="col-md-2 labletext" for="mobile1">Mobile 1</label>                         
                                            <div class="col-md-3">                                       
                                                    <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs typeahead" id="mobile1" name="mobile1" autocomplete="off" value="" readonly>

                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <label for="mobile2" class="col-md-2 labletext">Mobile 2  </label>
                                                <div class="col-md-3">                                        
                                                        <div class="form-group"> 
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs typeahead" id="mobile2" name="mobile2"  autocomplete="off" value="" readonly>

                                                        </div>
                                                        </div>
                                                    </div>                                    
                                         </div>
                                         <div class="row">     
                                    <label class="col-md-2 labletext" for="wing">Wing</label>                         
                                            <div class="col-md-3">                                       
                                                    <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs typeahead" id="txtwing" name="txtwing" autocomplete="off" value="" readonly>

                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <label for="feedbck_branch" class="col-md-2 labletext">Branch</label>
                                                <div class="col-md-3">                                        
                                                        <div class="form-group"> 
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control forminputs typeahead" id="feedbck_branch" name="feedbck_branch"  autocomplete="off" value="" readonly>

                                                        </div>
                                                        </div>
                                                    </div>                                    
                                         </div>
                                         <div class="row">     
                                                <label class="col-md-2 labletext" for="sel_remarks">Remarks</label>                         
                                                        <div class="col-md-3">                                       
                                                                <div class="form-group">
                                                                <div class="input-group input-group-sm">
                                                                <select class="form-control select2" id="sel_remarks" name="sel_remarks" style="width: 100%;">
                                                                <option value=''>Select</option>
                                                                
                                                                </select>

                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <label for="txtremark" class="col-md-2 labletext">Addtional Remarks  </label>
                                                            <div class="col-md-3">                                        
                                                                    <div class="form-group"> 
                                                                    <div class="input-group input-group-sm">
                                                                    <textarea cols="20" rows="1" name="txtremark" id="txtremark"></textarea>

                                                                    </div>
                                                                    </div>
                                                                </div>                                    
                                                  </div>
                                                  <div class="row">     
                                                <label class="col-md-2 labletext" for="followup_date">Follow Up Date</label>                         
                                                        <div class="col-md-3">                                       
                                                                <div class="form-group">
                                                                <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="followup_date" id="followup_date" im-insert="false" value="" readonly>
                                                                </div>

                                                                    </div>
                                                            </div>
                                                        
                                                        <div class="col-md-1"></div>
                                                        <label for="first_name" class="col-md-2 labletext">Done By</label>
                                                            <div class="col-md-3">                                        
                                                                    <div class="form-group"> 
                                                                    <div class="input-group input-group-sm" id="donebyerr">
                                                                    <select class="form-control select2" id="done_by" name="done_by" style="width: 100%;">
                                                                        <option value=''>Select</option>
                                                                    
                                                                    
                                                                        </select>

                                                                    </div>
                                                                    </div>
                                                                </div>                                    
                                                  </div>
                                                  <div class="row"> 
                                                  <div class="col-md-5"></div>
                                                  <div class="col-md-2">
			
                                                     <button type="button" class="btn btn-sm action-button" style="width: 100%;" onclick="addFeedBack();" >Add</button>
                                                     </div>
                                                  </div>
                            </div>      
               
            <div class="modal-footer ">
              <p class="successmodel" id="errormodal" style="display:none;">
                  <img src="<?php echo base_url(); ?>assets/img/successfully_icon.png" width="30" height="30" style="vertical-align:middle;">
                  Feedback added successfully
                </p>
              <button type="button" class="btn btn-sm action-button" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  </section>

  <!-- Feedback list Modal -->
<section class="layout-box-content-format1">
<div class="modal fade" id="feedbacklistmodel"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header card-header box-shdw" style="color: white;">
              <h5 class="modal-title">Feedback List</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">×</span>
              </button>
            </div>          

            <div id="feedbackModalBody"  class="modal-body">
                

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