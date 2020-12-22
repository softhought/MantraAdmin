<script src="<?php echo base_url();?>assets/js/customJs/registraion/main_package.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Main Package</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>package" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="MainPackageForm"  id="MainPackageForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="productId" id="productId" value="<?php echo $productId; ?>">

                <div class="formblock-box">   
                         
                    <div class="row">
                        <div class="col-md-1"></div>
                         <div class="col-md-8">
                            <div class="row">
                               <div class="col-md-6">
                                <div class="col-md-12">
                                        <label for="txtcode">Starting Letter*</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs typeahead inputupper" id="txtcode" name="txtcode" placeholder="" autocomplete="off" maxlength="1" value="<?php if($mode == 'EDIT'){ echo $productEditdata->start_letter;  }  ?>">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <label for="package_name">Main Package Name*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead inputupper" id="package_name" name="package_name" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $productEditdata->category_name;  }  ?>">

                                        </div>
                                        </div>
                                    </div>                                                
                                                                              
                               </div> 
                               <div class="col-md-4 uploadProfile">
                                    <label for="profilepic"></label>
                                       <div class="form-group profile-block">
                                            <img src='<?php  if($mode == 'EDIT' && $productEditdata->banner_img != ''){ ?> <?php echo siteURL(); ?>/images/products/<?php echo $productEditdata->banner_img; } ?>' id="showimage" style="width: 200px;height:70px;border: 1px solid #6d78cb;margin-bottom:13px; ">                                    
                                            <div class="inputWrapper">
                                                <label class="btn  btn-default btn-flat" >Banner Upload
                                                <input class="fileInput "  type='file' custom-file-input name='imagefile' id="imagefile" size='20' onchange="readCommanURL2(this);" data-showId="showimage" data-isimage="isImage" style="display: none;" accept="image/*">
                                                </label>                                    
                                                <input type="hidden" name="banner_img" id="banner_img" value="<?php if($mode == 'EDIT' && $productEditdata->banner_img != ''){  echo $productEditdata->banner_img; } ?>"> 
                                                <input type='hidden' name='isImage' id="isImage" value="N">
                                            </div>
                                      </div>
                                 </div> <!-- end of uploadProfile section -->
                            
                            </div>
                        </div>                  
                    
                    </div>
                    <div class="row">
                    <div class="col-md-1"></div>
                       <div class="col-md-8">
                                <label for="shortname">Design text</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <textarea name="design_text" id="design_text" cols="100" rows="8"><?php if($mode == 'EDIT'){ echo $productEditdata->page_design;  }  ?></textarea>

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
                                <button type="submit" class="btn btn-sm action-button" id="packagesavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>