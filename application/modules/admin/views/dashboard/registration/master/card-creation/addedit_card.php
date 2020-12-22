<script src="<?php echo base_url();?>assets/js/customJs/registraion/card_creation.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Card</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>Packagecardcreation" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body" >
               <form name="CardCreationForm"  id="CardCreationForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="cardId" id="cardId" value="<?php echo $cardId; ?>">

                <div class="formblock-box">   
                         
                    <div class="row">
                        <!-- <div class="col-md-1"></div>   -->
                              <label for="package_cat" class="col-md-2">Package Category*</label>
                                <div class="col-md-3">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="package_cat_err">
                                        <select class="form-control select2" id="package_cat" name="package_cat" style="width: 100%;" >
                                            <option value='' <?php if($mode == 'EDIT'){ echo "disabled"; } ?>>Select</option>
                                                <?php
                                                    foreach($packagecatlist as $packagecatlist){ ?>
                                                    <option value='<?php echo $packagecatlist->id; ?>' data-prefix="<?php echo $packagecatlist->start_letter; ?>" <?php if($mode == 'EDIT'){ if($cardEditdata->PROD_CATEGORY_ID == $packagecatlist->id){ echo "selected";}else{ echo "disabled"; } }?> >
                                                    <?php echo $packagecatlist->category_name; ?>
                                                    </option>
                                                 <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div> 
                                <label for="package_type" class="col-md-2">Package Type</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm" id="package_type_err">
                                            <select class="form-control select2" id="package_type" name="package_type" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach(json_decode(PACKAGE_TYPE) as $key => $value){ ?>
                                                    <option value='<?php echo $key; ?>' <?php if($mode == 'EDIT' && $cardEditdata->package_card_type == $key){ echo "selected"; } ?>>
                                                    <?php echo $value; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>

                                        </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                <!-- <div class="col-md-1"></div>   -->
                                    <label for="card_prefix" class="col-md-2">Prefix & Code</label>
                                        <div class="col-md-1">                                       
                                                <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs inputupper" id="card_prefix" name="card_prefix" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->CARD_PREFIX; } ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">                                       
                                                <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs inputupper" id="card_code" name="card_code" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->CARD_CODE; } ?>" <?php if($mode == 'EDIT'){ echo "readonly"; } ?> maxlength="2">
                                                </div>
                                            </div>
                                        </div> 
                                        <label for="package_desc" class="col-md-2">Package Description</label>
                                    <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs inputupper" id="package_desc" name="package_desc" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->CARD_DESC; } ?>">

                                        </div>
                                        </div>
                                    </div>
                                   </div> 
                                
                            <div class="row">
                                <!-- <div class="col-md-1"></div>  -->
                                <label for="achivement_type" class="col-md-2">Achievemen Type</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm" id="achivement_type_err">
                                            <select class="form-control select2" id="achivement_type" name="achivement_type" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach($achivmentslist as $achivmentslist){ ?>
                                                    <option value='<?php echo $achivmentslist->id; ?>' <?php if($mode == 'EDIT' && $cardEditdata->achievement_id == $achivmentslist->id){ echo "selected"; } ?>>
                                                    <?php echo $achivmentslist->achievement_name; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>

                                        </div>
                                        </div>
                                    </div>
                                    <label for="active_days" class="col-md-2">Active Days</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs onlynumber" id="active_days" name="active_days" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->CARD_ACTIVE_DAYS; } ?>">

                                        </div>
                                        </div>
                                    </div>                                                  
                                
                    </div>
                            
                            <div class="row">
                                <!-- <div class="col-md-1"></div>  -->
                                <label for="appearance_serial" class="col-md-2">Appearance Serial</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs onlynumber" id="appearance_serial" name="appearance_serial" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->appearance_serial; } ?>">
                                            <span id="status_appearance_serial"></span>
                                        </div>
                                        </div>
                                    </div>                                                
                                
                            </div>
                            </div>
                            <div class="formblock-box">
                            <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Branch Wise Rate</h3>
                            <div class="row">
                                <div class="col-md-1"></div> 
                              
                                <div class="col-md-2">
                                   <label for="branch">Branch</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="branch" name="branch" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php $branchlist1 = $branchlist;
                                                    foreach($branchlist1 as $branchlist1){ ?>
                                                    <option value='<?php echo $branchlist1->BRANCH_ID; ?>' >
                                                    <?php echo $branchlist1->BRANCH_NAME; ?>
                                                    </option>
                                                    <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div> 
                                    
                                <div class="col-md-2">
                                    <label for="package_rate">Package Rate</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs numberwithdecimal" id="package_rate" name="package_rate" placeholder="" autocomplete="off" value="">

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="renewal_rate">Renewal Rate</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs numberwithdecimal" id="renewal_rate" name="renewal_rate" placeholder="" autocomplete="off" value="">

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="disount_rate">Discount Rate(%)</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs numberwithdecimal" id="disount_rate" name="disount_rate" placeholder="" autocomplete="off" value="">

                                        </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-2">
                                         <label for="package_name">&nbsp;</label>
                                           <div class="form-group">
                                             <button type="button" class="btn btn-sm action-button" id="addcardrate" style="width: 57%;">Add</button>
                                         </div>
                                        </div>
                                                                                   
                                        
                            </div>
                            <div class="row">
                              <div class="col-sm-1"></div>
                              <p class="errormsgcolor" id="rateerrormsg"></p>
                            </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                            <div class="col-sm-9">
                                <div  id="detail_cardrate" style="#border: 1px solid #e49e9e;">
                                    <div class="table-responsive">
                                        <?php
                                                $rowno=0;
                                                $detailCount = 0;
                                                if($mode=="EDIT")
                                                {
                                               // $detailCount = sizeof();
                                                //$detailCount = 0;
                                                }
                                                // For Table style Purpose
                                                if($mode=="EDIT" && $detailCount>0)
                                                {
                                                    $style_var = "display:block;width:100%;";
                                                }
                                                else
                                                {
                                                    $style_var = "display:none;width:100%;";
                                                }
                                                ?>
                                                <table class="table table-bordered" style="font-size: 13px;color: #354668;">
                                                    <thead>   
                                                        <tr>  
                                                            <th>#</th>
                                                            <th>Branch</th>
                                                            <th>Package Rate</th>
                                                            <th>Renewal Rate</th>
                                                            <th>Discount Rate(%)</th>                                         
                                                            <th >Action</th> 
                                                        
                                                        </tr>
                                                    </thead>
                                                        <tbody>

                                                      <?php
                                                      if($mode=="EDIT")
                                                      {
                                                      foreach($ratedetaildata as $ratedetaildata){ 
                                                          $rowno++;
                                                          ?>

                                                        <tr id="rowcarddetails_<?php echo $rowno; ?>">
                                                                <td><?php echo $rowno; ?></td>
                                                                <td>
                                                                    <input type="hidden" name="rate_branch_code[]" id="rate_branch_code_<?php echo $rowno; ?>" value="<?php echo $ratedetaildata->branch_code; ?>">

                                                                    <input type="hidden" name="rate_branch_id[]" id="rate_branch_id_<?php echo $rowno; ?>" value="<?php echo $ratedetaildata->branch_id; ?>">

                                                                    <?php echo $ratedetaildata->BRANCH_NAME; ?>
                                                                </td>
                                                                <td>
                                                                <input type="hidden" name="package_rate_dtl[]" id="ppackage_rate_dtl_<?php echo $rowno; ?>" value="<?php echo $ratedetaildata->package_rate; ?>">
                                                                    <?php echo $ratedetaildata->package_rate; ?>
                                                                </td>
                                                                <td>
                                                                <input type="hidden" name="renewal_rate_dtl[]" id="renewal_rate_dtl_<?php echo $rowno; ?>" value="<?php echo $ratedetaildata->renewal_rate; ?>">
                                                                    <?php echo $ratedetaildata->renewal_rate; ?>
                                                                </td>
                                                                <td>
                                                                <input type="hidden" name="discount_rate_dtl[]" id="discount_rate_dtl_<?php echo $rowno; ?>" value="<?php echo $ratedetaildata->discount_rate; ?>">
                                                                    <?php echo $ratedetaildata->discount_rate; ?>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:;" class="delcardDetails" id="delDocRow_<?php echo $rowno; ?>" title="Delete">
                                                                    <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a>
                                                                </td>
                                                                </tr>
                                                      <?php  } } ?>
                                                        
                                                        </tbody>
                                                        <input type="hidden" name="rowno" id="rowno" value="<?php echo $rowno;?>">
                                                        <input type="hidden" name="is_card_rate_change" id="is_card_rate_change" value="N">  
                                                </table>
                                        </div><!-- end of table responsive -->
                                    </div>                                                   

                        </div>           

                    </div>
                    
                </div>
              
                     <div class="formblock-box">
                            <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Other Info</h3>
                            <div class="row">
                            <label for="session_alloted" class="col-md-2">Sessions Alloted</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs onlynumber" id="session_alloted" name="session_alloted" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->NO_OF_SESSION;  }  ?>">

                                        </div>
                                        </div>
                                    </div>
                                    <label for="extension_days" class="col-md-2">Grace Pd.(In Days)</label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs onlynumber" id="extension_days" name="extension_days" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->EXTENSION_DAYS;  }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                    
                            </div>
                            <div class="row">
                            <label for="from_time" class="col-md-2">From Time</label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs " id="from_time" name="from_time" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->FROM_TIME;  }  ?>">

                                        </div>
                                        </div>
                                    </div>
                                    <label for="to_time" class="col-md-2">To Time</label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs" id="to_time" name="to_time" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->TO_TIME;  }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                    
                            </div>
                            <div class="row">
                            <label for="point" class="col-md-2">Conversion Points </label>
                                <div class="col-md-3">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs" id="point" name="point" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->point;  }  ?>">

                                        </div>
                                        </div>
                                    </div>
                                    <label for="application_limit_days" class="col-md-2">Days limit for Application(Extension)</label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs onlynumber" id="application_limit_days" name="application_limit_days" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->application_limit_days;  }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                    
                            </div>
                            <div class="row">
                                <label for="covid_extension_days" class="col-md-2">Extension Days For Covid-19</label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputsonlynumber " id="covid_extension_days" name="covid_extension_days" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $cardEditdata->covid_extension_days;  }  ?>">

                                            </div>
                                            </div>
                                        </div>
                                
                                        </div>
                              <div class="row"> 
                              <label for="is_active" class="col-md-2">Is Active</label>
                                    <div class="col-md-1">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input type="checkbox" class="call-checkbox" name="is_active" name="is_active" <?php if($mode == 'EDIT' && $cardEditdata->IS_ACTIVE == 'Y'){ echo "checked";  }  ?>>


                                            </div>
                                            </div>
                                        </div>
                                        <label for="web_active" class="col-md-2">Active For Website</label>
                                    <div class="col-md-2">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input type="checkbox" class="call-checkbox" name="web_active" name="web_active" <?php if($mode == 'EDIT' && $cardEditdata->WEB_ACTIVE == 'Y'){ echo "checked";  }  ?>>


                                            </div>
                                            </div>
                                        </div> 
                                        <label for="attendance_consider" class="col-md-4">Attendance Consideration(For Cash Back)</label>
                                    <div class="col-md-1">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <input type="checkbox" class="call-checkbox" name="attendance_consider" name="attendance_consider" <?php if($mode == 'EDIT' && $cardEditdata->attendance_consider == 'Y'){ echo "checked";  }  ?>>


                                            </div>
                                            </div>
                                        </div> 
                            </div>
                </div>

                <div class="formblock-box">
                            <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Package Details</h3>
                            <div class="row">
                               
                              
                                <div class="col-md-2">
                                   <label for="packdtl_branch">Branch</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="packdtl_branch" name="packdtl_branch" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach($branchlist as $branchlist2){ ?>
                                                    <option value='<?php echo $branchlist2->BRANCH_ID; ?>' >
                                                    <?php echo $branchlist2->BRANCH_NAME; ?>
                                                    </option>
                                                    <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div> 
                                    
                                <div class="col-md-2">
                                    <label for="facility">Facility</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="facility" name="facility" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach($couponlist as $couponlist){ ?>
                                                    <option value='<?php echo $couponlist->coupon_id; ?>' >
                                                    <?php echo $couponlist->coupon_title; ?>
                                                    </option>
                                                    <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                    <label for="qty">Qty</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control forminputs numberwithdecimal" id="qty" name="qty" placeholder="" autocomplete="off" value="">

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="type">Type</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="type" name="type" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach(json_decode(PACK_TYPE) as $key => $value){ ?>
                                                    <option value='<?php echo $key; ?>'>
                                                    <?php echo $value; ?>
                                                    </option>
                                                    <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="work_out">Work Out (H & F)</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="work_out" name="work_out" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach(json_decode(PACK_SUB_TYPE) as $key => $value){ ?>
                                                    <option value='<?php echo $key; ?>' >
                                                    <?php echo $value; ?>
                                                    </option>
                                                    <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="sub_group">Sub Group</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="sub_group" name="sub_group" style="width: 100%;">
                                            <option value=''>Select</option>
                                                    <?php
                                                    foreach(json_decode(HF_GROUP_TYPE) as $key => $value){ ?>
                                                    <option value='<?php echo $key; ?>' >
                                                    <?php echo $value; ?>
                                                    </option>
                                                    <?php } ?>
                                        </select>

                                        </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-1">
                                         <label for="package_name">&nbsp;</label>
                                           <div class="form-group">
                                             <button type="button" class="btn btn-sm action-button" id="addpackagedtl" >Add</button>
                                         </div>
                                        </div>
                                                                                   
                                
                            </div>
                            <div class="row">
                              <!-- <div class="col-sm-1"></div> -->
                              <p class="errormsgcolor" id="packageerrormsg"></p>
                            </div>
                           
                            <div class="row" id="package_dtl">
                              <input type="hidden" name="edit_srl" id="edit_srl" value="1">
                               <!-- <div class="table-responsive"> -->
                             <?php  $dtl_rowno=0; 
                                 
                               // pre($facilitydata);exit;
                               $totalrow = count($facilitydata);
                               $branch = "";           
                               $i=1;
                               $flag=0; $rowStart=1;
                               //count(array_keys($facilitydata, "BP"));
                                  foreach($facilitydata as $facilitydata){      

                                    if($branch != $facilitydata->branch_id){ 
                                         
                                       
                                        if($flag!=0){
                                      ?>    
                                           
                                        </tbody>
                                        <input type="hidden" name="srl_no_<?php echo $branch; ?>" id="srl_no_<?php echo $branch; ?>" value="<?php echo $i-1; ?>">
                                    </table>
                                        <?php } $branch =   $facilitydata->branch_id; $i=1; $flag++; ?>
                                                                
                                <table class="table table-bordered" style="font-size: 13px;color: #354668;" id="table_<?php echo $branch; ?>">
                                
                                <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i><?php echo $facilitydata->BRANCH_NAME; ?></h3>
                                
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Branch</th>
                                            <th>Facility</th>
                                            <th>Qty</th>
                                            <th>Type</th>
                                            <th>Work Out</th>
                                            <th>Sub Group</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                     <?php
                                  
                                     } 
                                     ?>

                                     <tr id="rowfacilitydetails_<?php echo $dtl_rowno; ?>">
                                        <td><?php echo $i++; ?></td>
                                        <td>

                                         <input type="hidden" name="card_branch_code[]" id="card_branch_code_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->branch_cd; ?>">

                                        <input type="hidden" name="card_branch_id[]" id="card_branch_code_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->branch_id; ?>">

                                        <input type="hidden" name="card_coupon_id[]" id="card_coupon_id_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->coupon_id; ?>">
                                            <?php echo $facilitydata->branch_cd.'-'.$facilitydata->coupon_id; ?>
                                        </td>
                                        <td>
                                            
                                            <?php echo $facilitydata->coupon_title; ?>
                                        </td>
                                        <td>
                                             <input type="hidden" name="carddtl_qty[]" id="carddtl_qty_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->qty; ?>">
                                            <?php echo $facilitydata->qty; ?>
                                        </td>
                                        <td>
                                           <input type="hidden" name="detail_description[]" id="detail_description_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->detail_description; ?>">
                                            <?php echo $facilitydata->detail_description; ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="sub_description[]" id="sub_description_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->detail_description; ?>">
                                            <?php echo $facilitydata->sub_description; ?>
                                        </td>
                                        <td>
                                             <input type="hidden" name="grp_for_hf[]" id="grp_for_hf_<?php echo $dtl_rowno; ?>" value="<?php echo $facilitydata->grp_for_hf; ?>">
                                            <?php echo $facilitydata->grp_for_hf; ?>
                                        </td>
                                        <td> <a href="javascript:;" class="delfacilityDetails" id="delDocRow_<?php echo $dtl_rowno; ?>" title="Delete">
                                            <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a></td>
                                    </tr>

                                     <?php 
                                              if($rowStart==$totalrow){ ?>
                                                </tbody>
                                        <input type="hidden" name="srl_no_<?php echo $branch; ?>" id="srl_no_<?php echo $branch; ?>" value="<?php echo $i-1; ?>">
                                    </table>
                                       <?php     } $rowStart++;
                                     $dtl_rowno++;  
                                    ?>
                                 <?php } ?>
                                 
                                
                                 <input type="hidden" name="dtl_rowno" id="dtl_rowno" value="<?php echo $dtl_rowno;?>"> 
                                 <input type="hidden" name="is_card_detail_change" id="is_card_detail_change" value="N">  
                              <!-- <script> 
                            var branch_id =  <?php echo json_encode($facilitydata->branch_id); ?>;
                            var coupon_id =  <?php echo json_encode($facilitydata->coupon_id); ?>;
                            var coupon_title =  <?php echo json_encode($facilitydata->coupon_title); ?>;
                            var qty =  <?php echo json_encode($facilitydata->qty); ?>;
                            var detail_description =  <?php echo json_encode($facilitydata->detail_description); ?>;
                             var sub_description =  <?php echo json_encode($facilitydata->sub_description); ?>;
                             var grp_for_hf =  <?php echo json_encode($facilitydata->grp_for_hf); ?>;
                             var dtl_rowno =  <?php echo json_encode($dtl_rowno); ?>;
                             var method =  <?php echo json_encode($_SERVER['HTTP_REFERER']); ?>+'/getpackagedtl';
                            
                             addeditpackagelist2(branch_id,coupon_id,coupon_title,qty,detail_description,sub_description,grp_for_hf,dtl_rowno,method); 
                               
                                 </script> -->

                                    

                               
                             
                                <!-- </div> --> 
                                
                            </div>
                            
                </div>
                    <div class="formblock-box">
                        <div class="row">
                            <div class="col-md-10">
                               <p class="errormsgcolor" id="errormsg"></p>
                            </div>
                                <div class="col-md-2 text-right">
                                <button type="submit" class="btn btn-sm action-button" id="cardsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>