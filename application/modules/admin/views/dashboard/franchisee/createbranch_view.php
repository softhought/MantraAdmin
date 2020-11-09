<script src="<?php echo base_url();?>assets/js/customJs/branch.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Create Branch</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>createbranch" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="CreateBranchForm"  id="CreateBranchForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="branchId" id="branchId" value="<?php echo $branchId; ?>">

                <div class="formblock-box">   
                         
                           <div class="row">                              
                                <div class="col-md-3">
                                        <label for="companyname">Comapny Name *</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="company_id" name="company_id" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach($companylist as $companylist){ ?>
                                                <option value='<?php echo $companylist->comany_id; ?>' <?php if($mode == 'EDIT' && $branchEditdata->company_id == $companylist->comany_id){ echo "selected"; } ?>><?php echo $companylist->company_name; ?></option>
                                            <?php } ?>
                                            </select>
                                      
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <label for="branch_name">Branch Name*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead inputupper" id="branch_name" name="branch_name" placeholder="Enter Branch Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $branchEditdata->BRANCH_NAME;  }  ?>">

                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                    <label for="branch_code">Branch Code*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead inputupper" id="branch_code" name="branch_code" placeholder="Enter Branch Code" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $branchEditdata->BRANCH_CODE;  }  ?>" maxlength="2">

                                        </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                    <label for="gst_no">GST No.*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead" id="gst_no" name="gst_no" placeholder="Enter GST No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $branchEditdata->gst_no;  }  ?>">

                                        </div>
                                        </div>
                                    </div>
                            
                            </div>
                            <div class="row">                              
                                <div class="col-md-3">
                                        <label for="company_contact">Company Contact No.</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs typeahead onlynumber" id="company_contact" name="company_contact" placeholder="Enter Company Contact No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $branchEditdata->company_contact;  }  ?>" maxlength="10">
                                      
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                        <label for="contact_person">Contact Person</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs typeahead " id="contact_person" name="contact_person" placeholder="Enter Contact Person Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $branchEditdata->contact_person;  }  ?>">
                                      
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                        <label for="branch_address">Branch Address*</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <textarea rows="1" cols="30" id="branch_address" name="branch_address" ><?php if($mode == 'EDIT'){ echo $branchEditdata->branch_address;  }  ?></textarea>
                                      
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
                                <button type="submit" class="btn btn-sm action-button" id="branchsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>