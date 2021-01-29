<input type="hidden" name="applytype" id="applytype" value="<?php echo $applyType;?>" >
               <div class="row box">  

                    <div class="col-sm-2">
                    <label for="wing">SMS/Email</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm" id="send_typeerr">
                            
                        <select class="form-control select2" name="send_type" id="send_type" >
                              <option value="sms">SMS</option>
                              <option value="email">Email</option>
                            
                            </select>
                          </div>
                        </div>
                        
                    </div> 
                      <div class="col-sm-4" id="sms_drp_div" >
                    <label for="wing">Sms Title</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm" id="sel_smserr">
                            
                        <select class="form-control select2" name="sel_sms" id="sel_sms" >
                              <option value="" data-smsmatter="">Select</option>
                              <?php foreach($smsList as $smsList){ ?>
                                      <option value='<?php echo $smsList->tran_id; ?>'
                                      data-smsmatter="<?php echo $smsList->sms_matter;?>">
                                      <?php echo $smsList->sms_title; ?></option>
                                <?php } ?>
                            
                            </select>
                          </div>
                        </div>
                        
                    </div> 
                       <div class="col-sm-4" id="email_drp_div" style="display:none;">
                    <label for="wing">Email Title</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm" id="sel_emailerr">
                            
                        <select class="form-control select2" name="sel_email" id="sel_email" >
                                <option value="" data-emailmatter="">Select</option>
                              <?php foreach($emailList as $emailList){ ?>
                                      <option value='<?php echo $emailList->tran_id; ?>'
                                       data-emailmatter="<?php echo $smsList->sms_matter;?>"><?php echo $emailList->email_title; ?></option>
                                <?php } ?>
                            
                            </select>
                          </div>
                        </div>
                        
                    </div>
                      <div class="col-md-1">
                          <div class="form-group">
                            <label for="firstname">Selected </label>
                            <div class="input-group input-group-sm">
                            <input type="text" class="form-control forminputs " id="heads" name="heads" placeholder="" autocomplete="off" value="" style="text-transform:uppercase"  readonly >
                            </div>



                          </div>

               </div> 
                    <div class="col-sm-1"  >
                      <label for="wing">&nbsp;</label>
                          <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <button type="button" class="btn btn-block action-button btn-sm actinct " style="display:none;" id="specialenquiryapplybtn">Apply <i class="fas fa-paper-plane"></i></button>
                          </div>
                        </div>
                    </div>
                    
                    
                    </div>
                    <div class="card-body">
                
                 
                  <input type="hidden" id="matter_data" name="matter_data" />
                <div class="callout callout-warning" style="display:none;" id="matter_box">
                  <h5 id="matter_title"></h5>

                  <p id="matter_text"></p>
                </div>
             
          
<table  class="table customTbl table-bordered table-hover  tablepad" id="specialEnqTable">
          <thead>
        <tr>
              <th style="width:100px;">
               <!-- <input type="checkbox" class="rowCheckAll" name="rowCheckAll" id="rowCheckAll" value="Y" > Select All</th></th>  -->
              <input type="checkbox" class="call-checkbox rowCheckAll" id = "example-select-all" > &nbsp;Select All</th>
              <th style="width:45px;">Sl.No</th> 
              <th style="width:90px;">Sms/Email</th>             
							<th>Mem. No|Name</th>
							<th>Category </th>
							<th>Card</th>
							<th>Branch</th>
							<th>Gender</th>
							<th>Mobile</th>
							<th>Email</th>
							<th style="width:190px;">Validity</th>
              
              </tr>
          </thead>
          <tbody>

          <?php
		$i=1;$row = 1;
		foreach($specialenquirylist as $specialenquirylist){			
		?>
	<tr>                     
                     <td align="center">

                
                  <input type="checkbox" class="call-checkbox rowCheck" name="id[]" id="row_check_<?php echo $row; ?>" value="<?php echo $specialenquirylist->CUS_ID; ?>">
                  </td>
                            <td><?php echo $i++ ?></td>
                          
                         
                            <td>  <br><a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $specialenquirylist->CUS_ID; ?>" data-target="#smslistmodel" class="smsListOldmem hidebtn_<?php echo $specialenquirylist->CUS_ID; ?>">
                            <img src="<?php echo base_url(); ?>assets/img/sms.png" width="30" height="30" /></a>
                            <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $specialenquirylist->CUS_ID; ?>" data-target="#emaillistmodel" class="emailListOldmem hidebtn_<?php echo $specialenquirylist->CUS_ID; ?>">
                            <img src="<?php echo base_url(); ?>assets/img/email.png" width="30" height="30" /></a> </td>
                           	<td><span class="badge badge-success" style="font-size:11px;">
                             <?PHP echo($specialenquirylist->membership_no);?></span>
                             <br>&nbsp;<?PHP echo($specialenquirylist->CUS_NAME);?></td>
                           	<td><?PHP echo($specialenquirylist->category_name);?></td>
                            <td><span class="badge badge-info" style="font-size:11px;">
                            <?PHP echo($specialenquirylist->CARD_CODE);?></span></td>
                            <td><?PHP echo($specialenquirylist->BRANCH_CODE);?></td>
                            <td><?PHP echo($specialenquirylist->CUS_SEX);?></td>
                            <td><span class="badge badge-secondary" style="font-size:11px;">
                            <?PHP echo($specialenquirylist->CUS_PHONE);?></span></td>
                            <td><?PHP echo($specialenquirylist->CUS_EMAIL);?></td>
                            <td><span class="badge badge-danger" style="font-size:11px;">
                            <?PHP echo($specialenquirylist->validFrom." to ".$specialenquirylist->expiryDate);?></span></td>
                           
                      </tr>
        <?php $row++; } ?>
          
          </tbody>
        </table>

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

     <!-- sms list Modal -->
<section class="layout-box-content-format1">
<div class="modal fade" id="smslistmodel"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header card-header box-shdw" style="color: white;">
              <h5 class="modal-title">Sms List</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">×</span>
              </button>
            </div>          

            <div id="smsModalBody"  class="modal-body" style="height: 80vh;
    overflow-y: auto;">
                   <div style="text-align: center;margin-top:250px;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

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


          <!-- sms list Modal -->
<section class="layout-box-content-format1">
<div class="modal fade" id="emaillistmodel"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header card-header box-shdw" style="color: white;">
              <h5 class="modal-title">Email List</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">×</span>
              </button>
            </div>          

            <div id="emailModalBody"  class="modal-body" style="height: 80vh;
    overflow-y: auto;">
                <div style="text-align: center;margin-top:250px;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

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