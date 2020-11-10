<script src="<?php echo base_url();?>assets/js/customJs/front_office/enquiry.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Enquiry</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <!-- <a href="<?php echo admin_with_base_url(); ?>enquirywing" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a> -->
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="EnquiryForm"  id="EnquiryForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="enquiryId" id="enquiryId" value="<?php echo $enquiryId; ?>">
                <input name="enq_from" id="enq_from" type="hidden"  value="" >

                <div class="formblock-box">   
                         
                           <div class="row">     
                           <label class="col-md-2 labletext" for="enquiry_dt">Enquiry Date* </label>                         
                                <div class="col-md-3">
                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="enquiry_dt" id="enquiry_dt" im-insert="false" value="<?php if($mode == 'EDIT' && $enquiryEditdata->DATE_OF_ENQ != ""){ echo date('d-m-Y',strtotime($enquiryEditdata->DATE_OF_ENQ)); } ?>" readonly>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-1"></div>
                               
                                    <label for="first_name" class="col-md-2 labletext">First Name*  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name" placeholder="Enter First Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->FIRST_NAME;  }  ?>">

                                            </div>
                                            </div>
                                        </div>

                            </div>
                            <div class="row"> 
                            <label for="wings" class="col-md-2 labletext">Wings*  </label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="wings" name="wings" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach($winglist as $winglist){ ?>
                                                <option value='<?php echo $winglist->wing_name; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->for_the_wing == $winglist->wing_name){ echo "selected"; } ?>><?php echo $winglist->wing_name; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <label for="last_name" class="col-md-2 labletext">Last Name*  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead" id="last_name" name="last_name" placeholder="Enter Last Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->LAST_NAME;  }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                </div>
                         <div class="row"> 
                            <label for="branch_id" class="col-md-2 labletext">Branch*  </label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="branch_id" name="branch_id" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach($branchlist as $branchlist){ ?>
                                                <option value='<?php echo $branchlist->BRANCH_ID; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->branch_id == $branchlist->BRANCH_ID){ echo "selected"; } ?>><?php echo $branchlist->BRANCH_NAME; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <label for="email" class="col-md-2 labletext">Email </label>
                                    <div class="col-md-3">                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                         <input type="email" class="form-control forminputs typeahead" id="email" name="email" placeholder="Enter Email" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->short_description;  }  ?>">
                                        </div>
                                        </div>
                                </div>
                                   
                                </div>
                                <div class="row"> 
                                <label for="pin" class="col-md-2 labletext">Pin*  </label>
                                    <div class="col-md-3">
                                        
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="pin" name="pin" style="width: 100%;">
                                        <option value=''>Select</option>
                                        <?php foreach($pinlist as $pinlist){ ?>
                                            <option value='<?php echo $pinlist->id; ?>'><?php echo $pinlist->pin_code; ?></option>
                                        <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div>
                           
                                    <div class="col-md-1"></div>
                                    <label for="location" class="col-md-2 labletext">Location*  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="location" name="location" style="width: 100%;">
                                                <option value=''>Select</option>
                                            
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                    
                                </div>

                                <div class="row"> 
                                    <label for="mobile_no" class="col-md-2 labletext">Mobile No.*  </label>
                                        <div class="col-md-3">
                                            
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead onlynumber" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->short_description;  }  ?>" maxlength="10">

                                            </div>
                                            </div>
                                        </div>
                           
                                    <div class="col-md-1"></div>
                                    <label for="whatsapp_no" class="col-md-2 labletext">Whatsapp No.  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead onlynumber" id="whatsapp_no" name="whatsapp_no" placeholder="Enter Whatsapp No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->short_description;  }  ?>" maxlength="10">
                                            </div>
                                            </div>
                                        </div>
                                    
                                </div>

                                <div class="row"> 
                                    <label for="address" class="col-md-2 labletext">Address*  </label>
                                        <div class="col-md-3">
                                            
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <textarea cols="30" rows="2" name="address" id="address"></textarea>

                                            </div>
                                            </div>
                                        </div>
                           
                                    <div class="col-md-1"></div>
                                    <label for="remarks" class="col-md-2 labletext">Remarks  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <textarea cols="30" rows="2" name="remarks" id="remarks"></textarea>
                                            </div>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div class="row">     
                           <label class="col-md-2 labletext" for="followup_date">Follow-Up Date* </label>                         
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
                               
                                 <label for="done_by" class="col-md-2 labletext">Done by*  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="done_by" name="done_by" style="width: 100%;">
                                                <option value=''>Select</option>
                                                <?php foreach($userlist as $userlist){ ?>
                                                <option value='<?php echo $userlist->user_id; ?>'><?php echo $userlist->name_in_full; ?></option>
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
                                <button type="submit" class="btn btn-sm action-button" id="enquirysavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>