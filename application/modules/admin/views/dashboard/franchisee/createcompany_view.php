<script src="<?php echo base_url();?>assets/js/customJs/company.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Create Company</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>createcompany" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="CreateCompanyForm"  id="CreateCompanyForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="companyId" id="companyId" value="<?php echo $companyId; ?>">

                <div class="formblock-box">   
                         
                    <div class="row">
                        <div class="col-md-1"></div>
                         <div class="col-md-8">
                            <div class="row">
                               <div class="col-md-6">
                                <div class="col-md-12">
                                        <label for="companyname">Comapny Name *</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs typeahead" id="company_name" name="company_name" placeholder="Enter Company Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $comapnyEditdata->company_name;  }  ?>">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <label for="shortname">Short Name*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead inputupper" id="short_name" name="short_name" placeholder="Enter Company Short Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $comapnyEditdata->short_name;  }  ?>" maxlength="2">

                                        </div>
                                        </div>
                                    </div>                                                
                              
                               <div class="col-md-12">
                                    <label for="email">Register Email*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="email" class="form-control forminputs typeahead " id="email" name="email" placeholder="Enter Email" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $comapnyEditdata->company_email;  }  ?>" >

                                        </div>
                                        </div>
                                    </div>                                                
                             
                               <div class="col-md-12">
                                    <label for="mobile_no">Register Mobile*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead onlynumber" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No." autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $comapnyEditdata->company_phone;  }  ?>" maxlength="10">

                                        </div>
                                        </div>
                                    </div>                                                
                               </div> 
                               <div class="col-md-4 uploadProfile">
                                    <label for="profilepic"></label>
                                       <div class="form-group profile-block">
                                            <img src='<?php  if($mode == 'EDIT' && $comapnyEditdata->logo_name != ''){ ?> <?php echo base_url(); ?>assets/img/company-logo/<?php echo $comapnyEditdata->logo_name; } ?>' id="showimage" style="width: 120px;height:125px;border: 1px solid #6d78cb;margin-bottom:13px; ">                                    
                                            <div class="inputWrapper">
                                                <label class="btn  btn-default btn-flat" >Upload logo 
                                                <input class="fileInput "  type='file' custom-file-input name='imagefile' id="imagefile" size='20' onchange="readCommanURL(this);" data-showId="showimage" data-isimage="isImage" style="display: none;" accept="image/*">
                                                </label>                                    
                                                <input type="hidden" name="company_logo" id="company_logo" value="<?php if($mode == 'EDIT' && $comapnyEditdata->logo_name != ''){  echo $comapnyEditdata->logo_name; } ?>"> 
                                                <input type='hidden' name='isImage' id="isImage" value="N">
                                            </div>
                                      </div>
                                 </div> <!-- end of uploadProfile section -->
                            
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
                                <button type="submit" class="btn btn-sm action-button" id="companysavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>