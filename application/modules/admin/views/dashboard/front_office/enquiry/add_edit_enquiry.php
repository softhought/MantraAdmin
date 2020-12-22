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
                <input type="hidden" name="mayhelp_id" id="mayhelp_id" value="<?php echo $mayhelp_id; ?>">
                <input type="hidden" name="frguestpId" id="frguestpId" value="<?php echo $frguestpId; ?>">
                <input name="enq_from" id="enq_from" type="hidden"  value="<?php if($mode == 'ADD' && !empty($mayihelpudata)){ echo $mayihelpudata->enq_from; } ?>">

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
                                                <input type="text" class="form-control forminputs typeahead" id="first_name" name="first_name" placeholder="Enter First Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->FIRST_NAME;  }  if($mode == 'ADD' && !empty($mayihelpudata)){ echo explode(" ",$mayihelpudata->name)[0]; } if($mode == 'ADD' && !empty($freeguestpassdata)){ echo $freeguestpassdata->first_name; } ?>">

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
                                                <option value='<?php echo $branchlist->BRANCH_ID; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->branch_id == $branchlist->BRANCH_ID){ echo "selected"; } if($mode == 'ADD' && !empty($mayihelpudata) && $mayihelpudata->branch_cd == $branchlist->BRANCH_CODE){ echo "selected"; } if($mode == 'ADD' && !empty($freeguestpassdata) && $freeguestpassdata->gym_location == $branchlist->BRANCH_CODE){ echo "selected"; } ?>><?php echo $branchlist->BRANCH_NAME; ?></option>
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
                                                <input type="text" class="form-control forminputs typeahead" id="last_name" name="last_name" placeholder="Enter Last Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->LAST_NAME;  } if($mode == 'ADD' && !empty($mayihelpudata)){ echo explode(" ",$mayihelpudata->name)[1]; } if($mode == 'ADD' && !empty($freeguestpassdata)){ echo $freeguestpassdata->last_name; }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row"> 
                            <label for="gender" class="col-md-2 labletext">Gender*  </label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="gender" name="gender" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach(json_decode(GENDER) as $key => $value){ ?>
                                                <option value='<?php echo $key; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->gender == $key){ echo "selected"; } ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                           
                                    <div class="col-md-1"></div>
                                    <label for="age" class="col-md-2 labletext">DOB / Age  </label>
                                    <div class="col-md-2">
                                       
                                       <div class="form-group">
                                       <div class="input-group input-group-sm">                                           
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                           </div>
                                           <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="dob" id="dob" im-insert="false" value="<?php if($mode == 'EDIT' && $enquiryEditdata->dob != ""){ echo date('d-m-Y',strtotime($enquiryEditdata->dob)); } ?>" readonly>
                                       </div>
                                   </div>
                               </div>
                                    <div class="col-md-1">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            
                                                <input type="text" class="form-control forminputs typeahead onlynumber" id="age" name="age" placeholder="Enter Age" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->age;  }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                </div>
                         <div class="row"> 
                         <label for="wing_category" class="col-md-2 labletext">Wings Category*  </label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="wing_category" name="wing_category" style="width: 100%;">
                                        <option value=''>Select</option>
                                                <?php foreach($wingcatlist as $wingcatlist){ ?>
                                                <option value='<?php echo $wingcatlist->cat_id; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->wing_cat_id == $wingcatlist->cat_id){ echo "selected"; } if($mode == 'ADD' && (!empty($mayihelpudata) ||  !empty($freeguestpassdata)) && $wingdtl->wing_category_id == $wingcatlist->cat_id){ echo "selected"; }  ?> >
                                                <?php echo $wingcatlist->category_name; ?>
                                                </option>
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
                                         <input type="email" class="form-control forminputs typeahead" id="email" name="email" placeholder="Enter Email" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->EMAIL;  } if($mode == 'ADD' && !empty($mayihelpudata)){ echo $mayihelpudata->emailid; } if($mode == 'ADD' && !empty($freeguestpassdata)){ echo $freeguestpassdata->emailid; }  ?>">
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
                                            <option value='<?php echo $pinlist->id; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->PIN == $pinlist->id){ echo "selected"; } if($mode == 'ADD' && !empty($mayihelpudata) && $mayihelpudata->pincode == $pinlist->pin_code){ echo "selected"; } if($mode == 'ADD' && !empty($freeguestpassdata) && $freeguestpassdata->pincode == $pinlist->pin_code){ echo "selected"; } ?>><?php echo $pinlist->pin_code; ?></option>
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
                                                <?php if($mode == 'EDIT' || ($mode == 'ADD' && !empty($mayihelpudata)) || ($mode == 'ADD' && !empty($freeguestpassdata))){                                                    
                                                    foreach($locationlist as $locationlist){ ?>

                                                        <option value='<?php echo $locationlist->location; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->LOCATION == $locationlist->location){ echo "selected"; } ?>><?php echo $locationlist->location; ?></option>

                                                      <?php  }  }   ?>
                                            
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
                                            <input type="text" class="form-control forminputs typeahead onlynumber" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->MOBILE1;  }if($mode == 'ADD' && !empty($mayihelpudata)){ echo $mayihelpudata->mobile_no; } if($mode == 'ADD' && !empty($freeguestpassdata)){ echo $freeguestpassdata->contactno; }  ?>" maxlength="10">

                                            </div>
                                            </div>
                                        </div>
                           
                                    <div class="col-md-1"></div>
                                    <label for="whatsapp_no" class="col-md-2 labletext">Whatsapp No.  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead onlynumber" id="whatsapp_no" name="whatsapp_no" placeholder="Enter Whatsapp No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $enquiryEditdata->MOBILE2;  }  ?>" maxlength="10">
                                            </div>
                                            </div>
                                        </div>
                                    
                                </div>

                                <div class="row"> 
                                    <label for="address" class="col-md-2 labletext">Wings*  <br><br><br>Address*</label>
                                        <div class="col-md-3">

                                        <div class="form-group">
                                            <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="wings" name="wings" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php  if($mode == 'EDIT' || ($mode == 'ADD' && !empty($mayihelpudata)) || ($mode == 'ADD' && !empty($freeguestpassdata))){
                                            foreach($winglist as $winglist){ ?>
                                                <option value='<?php echo $winglist->wing_id; ?>' <?php if($mode == 'EDIT' && $enquiryEditdata->wing_id == $winglist->wing_id){ echo "selected"; } if($mode == 'ADD' && !empty($mayihelpudata) && $wingdtl->wing_id == $winglist->wing_id){ echo "selected"; } if($mode == 'ADD' && !empty($freeguestpassdata) && $wingdtl->wing_id == $winglist->wing_id){ echo "selected"; }?>><?php echo $winglist->wing_name; ?></option>
                                            <?php } } ?>
                                            </select>

                                            </div>
                                            </div>
                                            
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <textarea cols="30" rows="1" name="address" id="address"><?php if($mode == 'EDIT'){ echo $enquiryEditdata->ADDRESS;  }if($mode == 'ADD' && !empty($mayihelpudata)){ echo $mayihelpudata->address.' / '.$mayihelpudata->pincode; } if($mode == 'ADD' && !empty($freeguestpassdata)){ echo $freeguestpassdata->address.' / '.$freeguestpassdata->pincode; }  ?></textarea>

                                            
                                            </div>
                                            </div>
                                            
                                        </div>

                                                                  
                                    <div class="col-md-1"></div>
                                    <label for="remarks" class="col-md-2 labletext">Remarks  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <textarea cols="30" rows="3" name="remarks" id="remarks"><?php if($mode == 'EDIT'){ echo $enquiryEditdata->REMARKS;  }  ?></textarea>
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
                                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="followup_date" id="followup_date" im-insert="false" value="<?php if($mode == 'EDIT' && $enquiryEditdata->FOLLOWUP_DATE != ""){ echo date('d-m-Y',strtotime($enquiryEditdata->FOLLOWUP_DATE));  }  ?>" readonly>
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
                                                <option value='<?php echo $userlist['id']; ?>' <?php if($mode == "EDIT" && $enquiryEditdata->user_id == $userlist['id']){ echo "selected"; } ?>><?php echo $userlist['name']; ?></option>
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