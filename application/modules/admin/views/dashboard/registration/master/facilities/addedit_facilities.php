<script src="<?php echo base_url();?>assets/js/customJs/registraion/main_package.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Package Facilities</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>package/facilities" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="MainPackageForm"  id="PackageFacilitiesForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="couponId" id="couponId" value="<?php echo $couponId; ?>">

                <div class="formblock-box">   
                         
                    <div class="row">
                        <div class="col-md-1"></div>  
                              <label for="coupon_title" class="col-md-2">Title</label>
                                <div class="col-md-3">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs" id="coupon_title" name="coupon_title" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $couponEditdata->coupon_title;  }  ?>">
                                        </div>
                                    </div>
                                </div> 
                                </div> 
                                <div class="row">
                                <div class="col-md-1"></div> 
                                <label for="rate_type" class="col-md-2">Rate Type</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="rate_type" name="rate_type" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach(json_decode(Rate_TYPE) as $key => $value){ ?>
                                                    <option value='<?php echo $key; ?>' <?php if($mode == 'EDIT' && $couponEditdata->rate_type == $key){ echo "selected"; } ?>>
                                                    <?php echo $value; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>

                                        </div>
                                        </div>
                                    </div>                                                
                                
                    </div>
                             <div class="row">
                                <div class="col-md-1"></div> 
                                <label for="actual_rate" class="col-md-2">Actual Rate</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs numberwithdecimal" id="actual_rate" name="actual_rate" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $couponEditdata->actual_rate;  }  ?>">

                                        </div>
                                        </div>
                                    </div>                                                
                                
                            </div>
                             <div class="row">
                                <div class="col-md-1"></div> 
                                <label for="price_off_rate" class="col-md-2">Off (in %)</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs numberwithdecimal" id="price_off_rate" name="price_off_rate" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $couponEditdata->price_off_rate;  }  ?>">

                                        </div>
                                        </div>
                                    </div>                                                
                                
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div> 
                                <label for="maximum_booking" class="col-md-2">Online Maximun Booking</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs onlynumber" id="maximum_booking" name="maximum_booking" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $couponEditdata->maximum_booking;  }  ?>">

                                        </div>
                                        </div>
                                    </div>                                                
                                
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div> 
                                <label for="sms_title" class="col-md-2">SMS Title</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs" id="sms_title" name="sms_title" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $couponEditdata->sms_title;  }  ?>">

                                        </div>
                                        </div>
                                    </div>                                                
                                
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div> 
                                <label for="package_name" class="col-md-2">IS GST Chargable</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="checkbox" class="call-checkbox" name="isgst_chargable" name="isgst_chargable" <?php if($mode == 'EDIT' && $couponEditdata->is_gstchargble == 'Y'){ echo "checked";  }else if($mode == 'ADD'){ echo "checked"; }  ?>>

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
                                <button type="submit" class="btn btn-sm action-button" id="facilitiesavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>