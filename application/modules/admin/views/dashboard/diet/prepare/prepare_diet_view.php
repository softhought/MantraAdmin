<link href="<?php echo base_url(); ?>assets/css/diet.css?v=1..0" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>assets/js/customJs/diet/diet.js?v=1.0.0"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/timepicker.js"></script>


  <style type="text/css">
  	#bottom-remaining-info {
	  background: #202020;
	  color: #fff;
	  width: 200px;
	  height: auto;
	  position: fixed;
	  z-index: 999999;
	  top: 0;
	  right: 0;
	  border-top: 5px solid #ff2323;
	  border-bottom: 5px solid #ff2323;
	  border-left: 5px solid #ff2323;
	  //box-shadow: 2px 1px 8px 2px #D2D2D2;
	  border-top-left-radius: 10px;
	  border-bottom-left-radius: 10px;
	  text-indent: 9px;
	  font-size: 11px;
	  font-weight: 600;
	  text-shadow: 1px 1px 1px #323232;
	}
  </style>


  <?php

   $this->load->model('dietmodel','_dietmodel',TRUE);
   $mealID=$dietId;
   if ($mode=='EDIT') {
 
    if ($rowMemberMasterData) {

          $membership_no = $rowMemberMasterData->membership_no;
          $validity_string = $rowMemberMasterData->validity_string;
          $gender = $rowMemberMasterData->gender;
          $weight = $rowMemberMasterData->weight;
          $waist = $rowMemberMasterData->waist;
          $activity_level = $rowMemberMasterData->activity_level;
          $bodyfatpercent = $rowMemberMasterData->bodyfatpercent;
          $bodyfatremarks = $rowMemberMasterData->bodyfatremarks;
          $bmr_rate = $rowMemberMasterData->bmr_rate;
          $calorie_required = $rowMemberMasterData->calorie_required;
          $meal_approach_id = $rowMemberMasterData->meal_approach;
          $add_or_sub_type = $rowMemberMasterData->add_or_sub_type;
          $add_or_sub_value = $rowMemberMasterData->add_or_sub_value;
          $final_calorie_req = $rowMemberMasterData->final_calorie_req;
          $zig_zag_calorie = $rowMemberMasterData->zig_zag_calorie;
          $total_cal_with_zig_zag = $rowMemberMasterData->total_cal_with_zig_zag;
          $protein_need_factor_id = $rowMemberMasterData->protein_need_factor_id;
          $protein_percentage = $rowMemberMasterData->protein_percentage;
          $carbs_percentage = $rowMemberMasterData->carbs_percentage;
          $fat_percentage = $rowMemberMasterData->fat_percentage;
          $protein_gm = $rowMemberMasterData->protein_gm;
          $carbs_gm = $rowMemberMasterData->carbs_gm;
          $fat_gm = $rowMemberMasterData->fat_gm;
          $meal_approach_sub_opt = $rowMemberMasterData->meal_approach_sub_opt;
          $meal_approach_sub_detail = $rowMemberMasterData->meal_approach_sub_detail;
          
          $carbs_new_percentage = $rowMemberMasterData->carbs_new_percentage;
          $carbs_new_calorie = $rowMemberMasterData->carbs_new_calorie;
          $carbs_new_gram = $rowMemberMasterData->carbs_new_gram;
          
          $total_calorie_given = $rowMemberMasterData->total_calorie_given;
          $total_protein_given = $rowMemberMasterData->total_protein_given;
          $total_carbs_given = $rowMemberMasterData->total_carbs_given;
          $total_fat_given = $rowMemberMasterData->total_fat_given;
          
          $member_remarks = $rowMemberMasterData->member_remarks;
          $dietitian_id = $rowMemberMasterData->dietitian_id;
          $disease_guideID = $rowMemberMasterData->disease_guidlines;
          $youtubevideo_ID = $rowMemberMasterData->youtube_videos;
          $calculate_by = $rowMemberMasterData->calculate_by;
        
      
    }

    	if($disease_guideID != NULL && $disease_guideID!=''){
        $disease_guideIDs=explode(',',$disease_guideID);
	    	$disease_guidlines = $this->_dietmodel->getAllDiseaseforpreaperdiet($disease_guideIDs);
	    }else{
	    	$disease_guidlines = [];
	    }

      	$finl_cal_requrment = 0;
        $carbs_req = 0;
        if($total_cal_with_zig_zag>0)
        {
          $finl_cal_requrment = $total_cal_with_zig_zag;
          
        }
        else
        {
          $finl_cal_requrment = $final_calorie_req;
          
        }
        
        if($meal_approach_id==3)
        {
          $carbs_req = $carbs_new_gram;
        }
        else
        {
          $carbs_req = $carbs_gm;
        }
        
        // Total Consume for Micro Nutrion Approach\
        $isConsumed = "";
        $total_percentage = $protein_percentage+$carbs_percentage+$fat_percentage;
        if($total_percentage<100)
        {
          $isConsumed = "N";
        }
        elseif($total_percentage==100)
        {
          $isConsumed = "Y";
        }
        else
        {
          $isConsumed = "N";
        }

        $personal_dtl = $this->_dietmodel->getMemberPersonalDetailByMembershipNo($membership_no);
	
      if($personal_dtl)
      {
        $mobile_no = $personal_dtl->CUS_PHONE;
        $gender = $personal_dtl->CUS_SEX;
        $dob = $personal_dtl->CUS_DOB;
        $member_acc_code = $personal_dtl->member_acc_code;
      }
      
      if($gender=="M")
      {
        $gender = "Male";
      }
      if($gender=="F")
      {
        $gender = "Female";
      }


      $rowActivityLvlData = $this->_dietmodel->GetActivityLevelById($activity_level); 
      if($rowActivityLvlData)
      {
        $activity_desc = $rowActivityLvlData->activity_lvl_desc;
      }

            // Sub Meal Options For Zig ZAG
        $MealSubApproach =  $this->_dietmodel->GetMealSubApproach($meal_approach_id);
        
        // Sub Sub Details Option For Zig Zag
        $MealSubApproachDetail =  $this->_dietmodel->GetMealSubDetailApproach($meal_approach_sub_opt);
        
        // sub Sub Detail For Zig Zag Value
        $MealSubApproachDetailByID =  $this->_dietmodel->GetMealApproachSubSubDtlByID($meal_approach_sub_detail);
        
        $add_or_reduce = "";
        if(sizeof($MealSubApproachDetailByID)>0)
        {
         
            $add_or_reduce = $MealSubApproachDetailByID->add_reduce;
         
        }
        
      
      // Meal Detail*****************************************
      
      $rowMemberMealDtl = $this->_dietmodel->GetMemberMealDetail($mealID);
      $rowMemberMealDtlAll = $this->_dietmodel->GetMemberMealDetail($mealID);
      
          
      
        
   }/* end of edit data */
  
  
  
  ?>
<div class="diet-container">
	<form name="prepareDietForm" id="prepareDietForm" action="javascript:;" accept-charset="utf-8">
   <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
   <input type="hidden" name="dietId" id="dietId" value="<?php echo $dietId; ?>">
   <section class="layout-box-content-format1">

        <div class="card card-primary">
                  <!-- <div class="alert alert-danger" role="alert">
  ***This module on working under process.
</div> -->
                      <div class="card-header box-shdw">


                      
                      
                     
                   

                        <h3 class="card-title"><?php if($mode=='ADD'){echo "Prepare Diet";}else{echo "Edit Diet";}?></h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>diet/membersdiet" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="dietId" id="dietId" value="<?php echo $dietId; ?>">
                  <div class="card-body">


                    <div class="formblock-box">
                    <!-- <center><span class="badge <?php echo $kpcls;?> " id="keeploogedin" style="cursor:pointer;"><?php echo $kptext;?></span></center> -->
                        <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Calculate Calorie Requirement 
                        
                        </h3>                          
                          <!-- start top Calculate Calorie div  -->     
                        <div class="row">
                          <!-- start top left div  -->
                          <div class="col-md-4" style="#border:1px solid red;">

                            <div class="row" id="member_info_div" style="margin-bottom:5px;display:none">   
                         
                            <label for="first_name" class="col-md-4 labletext">Member Info </label>
                                <div class="col-md-8">
                                  <span class="badge badge-dark" id="mem_info_name"></span>
                                  <span class="badge badge-primary" id="mem_info_code"></span>
                                  <span class="badge badge-warning" id="mem_info_card"></span>
                                  <span class="badge badge-success" id="mem_info_act"></span>
                                  <span class="badge badge-info" id="mem_info_validity"></span>
                                  

                                  
                              </div>                      

                            </div>
                             <div class="row" id="member_dietinfo_div" style="margin-bottom:5px;display:none"> 
                               <label for="first_name" class="col-md-4 labletext">Member Diet </label>
                                      <div class="col-md-2" id="mem_vegnonveg">
                                 
                                  
                                 

                                  
                              </div>
                             </div>
                            <div class="row">
                               <label for="first_name" class="col-md-4 labletext">Mobile No* </label>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                      <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile No" value="<?php if($mode == 'EDIT'){ echo $mobile_no;} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" <?php if($mode == 'EDIT'){ echo 'readonly';} ?>>
                                      <input type="hidden" id="mealMasterID" name="mealMasterID" value="<?php echo $mealID; ?>" />
                                      <input type="hidden" name="membership_no" id="membership_no" value="<?php if($mode == 'EDIT'){ echo $membership_no; } ?>" class="form_input_text" style="width: 235px;" autocomplete="off"  />
                                     	<input type="hidden" id="hidden_mmno" name="hidden_mmno" value="<?php if($mode == 'EDIT'){ echo $member_acc_code; } ?>" />
                                      </div>
                                    </div>                        
                                    </div>     
                                </div>

                                <div class="row">
                               <label for="first_name" class="col-md-4 labletext">Gender </label>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="gender" id="gender" placeholder="Enter Gender" value="<?php if($mode == 'EDIT'){ echo $gender; } ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                          <input type="hidden" name="dob" id="dob" class="form_input_text" style="width: 235px;" value="<?php if($mode == 'EDIT'){ echo $dob; } ?>"  readonly />
                                      </div>
                                    </div>                        
                                    </div>     
                                </div>

                               <div class="row">                    
                                    <label for="branch_id" class="col-md-4 labletext">Calculate By  </label>
                                <div class="col-md-8">          
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="calculate_by" name="calculate_by" style="width: 100%;">
                                            <option value='R' <?php if($mode == 'EDIT' && $calculate_by=="R"){echo "selected";}else{echo "";}?>>Remote</option>
                                            <option value='H' <?php if($mode == 'EDIT' && $calculate_by=="H"){echo "selected";}else{echo "";}?>>HAV</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                       <div class="row">
                               <label for="first_name" class="col-md-4 labletext">Weight (In Kg.) </label>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="weight" id="weight" placeholder="Enter Weight" value="<?php if($mode == 'EDIT'){ echo $weight; } ?>" autocomplete="off" onkeyup="return numericFilter(this);" >
                                      </div>
                                    </div>                        
                                    </div>     
                                </div>

                            <div class="row">
                               <label for="first_name" class="col-md-4 labletext">Waist (In Inch) </label>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="waist" id="waist" placeholder="Enter Waist" value="<?php if($mode == 'EDIT'){ echo $waist; } ?>" autocomplete="off"  onkeyup="return numericFilter(this);">
                                      </div>
                                    </div>                        
                                    </div>     
                                </div>
                           <div class="row">                    
                                    <label for="branch_id" class="col-md-4 labletext">Activity Level </label>
                                <div class="col-md-8">          
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="activity_lvl" name="activity_lvl" style="width: 100%;">
                                            <option value='' data-acdesc="">Select</option>
                                            <?php 
                                                foreach ($activityLevel as $activitylevel) {
                                                 
                                            ?>
                                            <option value='<?php echo $activitylevel->id;?>' 
                                            data-acdesc='<?php echo $activitylevel->activity_lvl_desc;?>'
                                            <?php if($mode == 'EDIT' && $activity_level==$activitylevel->id){echo "selected";}else{echo "";}?>>
                                            <?php echo $activitylevel->activity_level;?></option>
                                            <?php }?>
                                            
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                 <label for="remarks" class="col-md-4 labletext">Activity Desc  </label>
                                    <div class="col-md-8">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <textarea class="form-control" cols="30" rows="3" name="activity_desc" id="activity_desc" readonly><?php if($mode == 'EDIT'){ echo $activity_desc;  }  ?></textarea>
                                            </div>
                                            </div>
                                        </div>    
                                </div>
                                    <div class="row">                    
                                    <label for="branch_id" class="col-md-4 labletext">Dietitian </label>
                                <div class="col-md-8">          
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="dietitian_id" name="dietitian_id" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php 
                                                foreach ($dietcianList as $dietcianlist) {   
                                            ?>
                                            <option value='<?php echo $dietcianlist->empl_id;?>'
                                            <?php if($mode == 'EDIT' && $dietitian_id==$dietcianlist->empl_id){echo "selected";}else{echo "";}?>><?php echo $dietcianlist->empl_name;?></option>
                                            <?php }?>
                                            
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">                    
                                 <label for="branch_id" class="col-md-4 labletext">Disease Guidelines </label>
                                <div class="col-md-8">          
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="disease_adviceid" name="disease_adviceid[]" style="width: 100%;" multiple="multiple">
                                            <!-- <option value=''>Select</option> -->
                                            <?php 
                                                foreach ($diseaseguidelineList as $diseaseguidelinelist) {   
                                            ?>
                                            <option value='<?php echo $diseaseguidelinelist->id;?>'><?php echo $diseaseguidelinelist->disease;?></option>
                                            <?php }?>
                                            
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="dtl_diseaseValues" id="dtl_diseaseValues" value="<?php if($mode == 'EDIT'){ echo $disease_guideID; }?>">

                                     <div class="row">                    
                                 <label for="branch_id" class="col-md-4 labletext">Youtube Videos </label>
                                <div class="col-md-8">          
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="youtube_videoid" name="youtube_videoid[]" style="width: 100%;" multiple="multiple">
                                            <!-- <option value=''>Select</option> -->
                                            <?php 
                                                foreach ($youtubevideoList as $youtubevideolist) {   
                                            ?>
                                            <option value='<?php echo $youtubevideolist->id;?>'><?php echo $youtubevideolist->videotitle;?></option>
                                            <?php }?>
                                            
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="dtl_youtubeValues" id="dtl_youtubeValues" value="<?php if($mode == 'EDIT'){ echo $youtubevideo_ID; }?>">          
                            <div class="row">
                          <div class="col-md-4"> </div>
                          <div class="col-md-8">
                          <p id="errormsg1" class="errormsgcolor"></p>
                           </div>
                          
                        </div>

                     <div class="row">
                          <div class="col-md-6"> </div>
                           <div class="col-md-5">
                              
                          <button type="button" class="btn btn-sm action-button actinct actibtn" id="calculate_btn" >
                          <i class="fas fa-calculator"></i> Calculate</button>
                            </div>
                        </div>





                          </div>
                          <!-- end top left div  -->
                          <!-- start top right div  -->
                          <div id="ritht_top_row" class="col-md-8" style="background-image: url(<?php echo base_url();?>assets/img/diet2.jpg); background-repeat: no-repeat;opacity:0.3">
                            <div class="row">
                          <div class="col-md-6"> 
                            <div class="row" id="member_reg_info" style="">
                             
                            
                                                </div>
                          </div>
                          <div class="col-md-6"> 

               <div class="jumbotron" id="calresult" style="font-size: 12px; width: 45%; display:none;">
		
							
							<input type="hidden" name="bFatPercentage" id="bFatPercentage" value="<?php if($mode == 'EDIT'){ echo $bodyfatpercent; }?>">
							<input type="hidden" name="bodyFatRemarks" id="bodyFatRemarks" value="<?php if($mode == 'EDIT'){ echo $bodyfatremarks; }?>">
							<input type="hidden" name="bmrValue" id="bmrValue" value="<?php if($mode == 'EDIT'){ echo $bmr_rate; }?>">
							
							 <h2 style="margin-top:5px;">Body Fat is <span id="bdyfatval" style="color:#13a4d5;"><?php if($mode == 'EDIT'){ echo number_format($bodyfatpercent,2)." %"; }?></span></h2>
							 <h2 style="margin-top:5px;">BMR is <span id="BMRval" style="color:#d63f0d;"><?php if($mode == 'EDIT'){ echo number_format($bmr_rate,2)." Cal/Day"; }?></span></h2>
							 <h2 style="margin-top:5px;">Daily Calorie Requirement is </h2> 
							 <h1 style="font-size:48px;margin-left:0px;margin-top:-10px;text-shadow: 2px 2px 2px #A78989;"><span id="calReq"><?php if($mode == 'EDIT'){ echo $calorie_required; }?></span></h1>
             </div>    




                          </div>

                            </div>
                            <div class="row" id="member_hav_div">
                          <div class="col-md-12" id='member_hav_div_data'>
                          <center>
                          <div style="text-align: center;">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>
                          </center>
                          
                          </div>    

                          </div>  

                         <div class="row" id="member_blood_div">
                          <div class="col-md-12" id='member_blood_test_data'>
                          <center>
                          <div style="text-align: center;">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>
                          </center>
                          
                          </div>    

                          </div>                        
                       

                          </div>
                          <!-- end top right div  -->
                        </div>



                    

                        <!-- end top Calculate Calorie div  -->
                            
 <!------------------------------------Youtube video ----------------->   
 <div id="youtube_video_thumb" style="#border:1px solid red;">


 </div>

  <!------------------------------------Youtube video ----------------->             

                           
                   <!------------------------------------Disease Nutrition Advice----------------->
					          <div id="diet_disease" style="#border:1px solid red;">
                                 
<br>
 <?php if($mode == 'EDIT'){ if($disease_guidlines){ ?>

   
  <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Disease Nutrition Guidelines </h3>                          
   <?php } ?>
        <div class="card" style="margin-bottom: .5rem!important;">
              
              <!-- /.card-header -->
              <div class="card-body">
                <div id="accordion" class="accordionCard2">
         	<?php $sl=1;
          
         	 for($i=0;$i<count($disease_guidlines);$i++){  ?>
                  <div class="card card-danger advAccor" id="<?php echo $i; ?>">
                  	<a data-toggle="collapse" data-parent="#accordion" href="#collapseAdv_<?php echo $i; ?>" class="" aria-expanded="true">
                    <div class="card-header" style="cursor: pointer;">
                      <h4 class="card-title">
                        
                         <?php echo $sl++.". ";
                         echo $disease_guidlines[$i]->disease; ?>
                       
                      </h4>
                    </div> </a>

                    <div id="collapseAdv_<?php echo $i; ?>" class="panel-collapse collapse" >
                      <div class="card-body ">
                      	<div class="callout callout-warning" style="margin-top:5px;">
                        <?php echo $disease_guidlines[$i]->disease_guidelines; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                   <?php } ?>
             
                </div>
              </div>
              <!-- /.card-body -->
            </div>
             <input type="hidden" name="advide_count" id="advide_count" value="<?php echo $i;?>"> 
             <?php }?>
                    </div>

                 <!-- End Disease Nutrition Advice --> 


                 <!------------------------------------Calorie Distribution------------------------->
                    
                   <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Calorie Distribution </h3>                          
               
                   <input type="hidden" name="calorieReqOrg" id="calorieReqOrg" value="<?php if($mode == 'EDIT'){echo $calorie_required;}else{echo "0";}?>0"/>
                   <div class="row">
                    <label for="sel_approach" class="col-md-2 labletext">Select Approach</label>
                          <div class="col-md-2">
                          <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                         <select class="form-control clrselct select2" id="meal_approach" name="meal_approach" style="width: 100%;" >
                                            <option value='0'>Select</option>  
                                        <?php foreach($rowMealApproach as $meal_approach){?>
                                          <option value="<?php echo $meal_approach->id;?>" 
                                          <?php if($mode == 'EDIT' && $meal_approach->id==$meal_approach_id){echo "selected";}else{echo "";}?>><?php echo $meal_approach->meal_approach;?></option>
                                        <?php } ?>
                                            
                                            </select> 
                                            <input type="hidden" name="approach_code" id="approach_code" />
                                        </div>
                                        </div> 
                          </div>
                            <!-- FOR ZIG ZAG Approach Need Factor Requirement  ----->              
                              <div class="col-md-3" id="need_factor_row" style="display:none;"> 
                               <div class="row">
                                <label for="protin_cal" class="col-md-4 labletext">Protein Calculator</label>
                                 <div class="col-md-8">
                                    <div class="form-group"> 
                                  
                                    <div class="input-group input-group-sm">
                                    <select class="form-control clrselct select2" id="need_factor" name="need_factor" style="width: 100%;" >
                                	<option value="0">Select</option>
                                  <?php foreach($rowNeedFactor as $need_factor){?>
                                    <option value="<?php echo $need_factor->id;?>"
                                     <?php if($mode == 'EDIT' && $protein_need_factor_id==$need_factor->id){echo "selected";}else{echo "";}?>><?php echo $need_factor->need_factor_description;?></option>
                                  <?php } ?>
                                                      </select> 
                                                  </div>
                                                  </div> 
                              </div>
                               </div>
                              </div>              
                          <div class="col-md-8" id="add_reduce_calorie_row">
                          <div class="row">
                              <label for="add_red_cal" class="col-md-2 labletext">Add or Reduce calorie</label>
                                   <div class="col-md-3">
                          <div class="form-group"> 
                         
                                        <div class="input-group input-group-sm">
                                         <select class="form-control clrselct select2" id="calrecalOpt" name="calrecalOpt" style="width: 100%;" >
                                        <option value='0'>Select</option>  
                                      
                                        <option value="ADD" <?php if($mode == 'EDIT' && $add_or_sub_type=="ADD"){echo "selected";}else{echo "";}?>>Add</option>
                                        <option value="SUB" <?php if($mode == 'EDIT' && $add_or_sub_type=="SUB"){echo "selected";}else{echo "";}?>>Reduce</option>
                                            
                                            </select> 
                                        </div>
                                        </div> 
                              </div>

                             <div class="col-md-2" style="font-weight:bold;">
                              <span id="prv_cal_txt"><?php if($mode == 'EDIT'){echo $calorie_required;}else{echo 'Calorie Requirement';} ?></span>
                              <span id="cal_opr"><?php 
                                                if($mode == 'EDIT' && $add_or_sub_type=="ADD"){echo "+";}
                                                elseif($mode == 'EDIT' && $add_or_sub_type=="SUB"){echo "-";}
                                                else{echo "?";}
                                              ?></span>
                              </div> 

                              <div class="col-md-1">
                              <input type="text" name="geivencal" id="geivencal" class="form-control clrselct" value="<?php if($mode == 'EDIT'){echo $add_or_sub_value;}else{echo "0";} ?>" style="" autocomplete="off" />						           
                              </div>
                              
                              <div class="col-md-2">
                               <span> =  &nbsp;</span><span id="recalCalVal" class="btn btn-danger clrText"><?php if($mode == 'EDIT'){echo $finl_cal_requrment;}else{echo "----";} ?></span>
                              </div>
                          </div>
                          
                          
                           </div>
                        

                            



                         </div>                 

                         
                          <div class="row" > 
                          <div class="col-md-12" style="font-size:18px;font-weight:bold">
                          Final Calorie Requirement is <span id="finalcalReq"><?php if($mode == 'EDIT'){ echo $finl_cal_requrment;} ?></span>
                          <input type="hidden" name="final_cal_req" id="final_cal_req" value="<?php if($mode == 'EDIT'){echo $finl_cal_requrment;}else{echo "0";} ?>" class="clrselct" />
                          <input type="hidden" name="final_cal_req_zig_zag" id="final_cal_req_zig_zag" value="0" />
                          
                          </div>
                          
                          </div>
                            <br>
                           <div class="row" >
                                <label for="prot" class="col-md-1 labletext">Protein</label>
                                <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="protein_per" id="protein_per"  value="<?php if($mode == 'EDIT'){echo $protein_percentage;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext">% &nbsp;&nbsp;Calorie</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="protein_cal" id="protein_cal"  value="<?php if($mode == 'EDIT'){echo $proteinCalorie;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext"> &nbsp;&nbsp;Gram</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="protein_gram" id="protein_gram"  value="<?php if($mode == 'EDIT'){echo $protein_gm;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                    <label for="add_red_cal" class="col-md-1 labletext">gm</label>
                            </div>

                           <div class="row" >
                                <label for="prot" class="col-md-1 labletext">Carbohydrate</label>
                                <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="carbo_per" id="carbo_per"  value="<?php if($mode == 'EDIT'){echo $carbs_percentage;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext">% &nbsp;&nbsp;Calorie</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="carbo_cal" id="carbo_cal"  value="<?php if($mode == 'EDIT'){echo $carbsCalorie;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext"> &nbsp;&nbsp;Gram</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="carbo_gram" id="carbo_gram"  value="<?php if($mode == 'EDIT'){echo $carbs_gm;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                    <label for="add_red_cal" class="col-md-1 labletext">gm</label>
                            </div>

                            <div class="row" >
                                <label for="prot" class="col-md-1 labletext">Fat</label>
                                <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="fat_per" id="fat_per"  value="<?php if($mode == 'EDIT'){echo $fat_percentage;}else{echo "0";} ?>" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext">% &nbsp;&nbsp;Calorie</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="fat_cal" id="fat_cal"  value="<?php if($mode == 'EDIT'){ echo $fatCalorie;}else{echo "0";} ?>0" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext"> &nbsp;&nbsp;Gram</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                    <input type="text" class="form-control clrselct" name="fat_gram" id="fat_gram"  value="<?php if($mode == 'EDIT'){ echo $fat_gm;}else{echo "0";} ?>0" autocomplete="off" maxlength="10" onkeyup="return numericFilter(this);" readonly>
                                    </div>
                                    </div>                        
                                  </div>
                                    <label for="add_red_cal" class="col-md-1 labletext">gm</label>
                            </div>
                             	<!-----------SUB MENU FOR ZIG ZAG Approach ----------->       
                            <div class="row" id="meal_approach_sub_opt_div" style="display:none;" >
                                <label for="add_red_cal" class="col-md-2 labletext">Zig Zag Goal Option</label>
                                <input type="hidden" name="meal_sub_dtl_id" id="meal_sub_dtl_id" value="<?php if($mode == 'EDIT'){echo $meal_approach_sub_opt;} ?>" />
							                	<input type="hidden" name="meal_sub_sub_dtl_id" id="meal_sub_sub_dtl_id" value="<?php if($mode == 'EDIT'){echo $meal_approach_sub_detail;} ?>" />
                                <div class="col-md-2">
                                  <div class="form-group">                      
                                  <div class="input-group input-group-sm" id="sub_meal_approach_div">
                                    <select class="form-control clrselct select2" id="meal-approach-sub-opt" name="meal-approach-sub-opt" >
                                        <option value="0">Select</option>
                                        <?php 
                                        if ($mode == 'EDIT') {
                                          
                                        foreach($MealSubApproach as $meal_sub_approach){?>
                                        <option value="<?php echo $meal_sub_approach->id;?>" 
                                        <?php if($meal_sub_approach->id==$meal_approach_sub_opt){echo "selected";}else{echo "";}?>>
                                          <?php echo $meal_sub_approach->meal_approach_sub;?>
                                        </option>
                                      <?php } }?>    
                                    </select> 
                                  </div>
                                  </div> 
                                </div>
                            </div>

                         <div class="row" id="meal_approach_sub_opt_dtl_div" style="display:none;" >
                                <label for="add_red_cal" class="col-md-2 labletext">Zig Zag Meal Approach</label>
                                <div class="col-md-2">
                                  <div class="form-group">                      
                                  <div class="input-group input-group-sm" id="sub_meal_approach_detail_div">
                                    <select class="form-control clrselct select2" id="meal-approach-sub-detail-opt" name="meal-approach-sub-detail-opt" style="width: 100%;" >
                                        <option value="0">Select</option>
                                        	<?php 
                                          if ($mode == 'EDIT') {
                                          foreach($MealSubApproachDetail as  $meal_sub_sub_detail){?>
                                          <option value="<?php echo $meal_sub_sub_detail->id;?>"
                                          <?php
                                          if($meal_approach_sub_detail == $meal_sub_sub_detail->id){echo "selected";}else{echo "";}?>>
                                            <?php echo $meal_sub_sub_detail->meal_approach_sub_detail; ?>
                                          </option>
                                        <?php } } ?>    
                                    </select> 
                                 
                                  </div>
                                  </div> 
                                </div>
                                <div class="col-md-2">    <span  id="zig_zag_margin_info" ></span></div>
                            </div>

                              <div class="row" id="carbs_zig_zag_row" style="display:none;" >
                                <label for="add_red_cal" class="col-md-1 labletext">Carbohydrate(New)</label>
                                 <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                  <input type="text" name="carbo_per_zigzag" id="carbo_per_zigzag" class="form-control not-allw-cls clrselct" value="<?php if ($mode == 'EDIT') {echo $carbs_new_percentage;}else{echo "0";} ?>" style="" autocomplete="off" readonly />
                                  
                                    </div>
                                    </div>                        
                                  </div>
                               

                                <label for="add_red_cal" class="col-md-1 labletext">% &nbsp;&nbsp;Calorie(New)</label>
                                <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                  <input type="text" name="carbo_cal_zigzag" id="carbo_cal_zigzag" class="form-control not-allw-cls clrselct" value="<?php if ($mode == 'EDIT') {echo $carbs_new_calorie; }else{echo "0";}?>" style="" autocomplete="off" readonly />
                                  
                                    </div>
                                    </div>                        
                                  </div>
                               
                                <label for="add_red_cal" class="col-md-1 labletext">Gram(New)</label>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                  <input type="text" name="carbo_gram_zigzag" id="carbo_gram_zigzag" class="form-control not-allw-cls clrselct" value="<?php if ($mode == 'EDIT') { echo $carbs_new_gram;}else{echo "0";} ?>" style="" autocomplete="off" readonly />
                                  
                                    </div>
                                    </div>                        
                                  </div>
                                  <label for="add_red_cal" class="col-md-1 labletext">gm </label>





                              </div>

                             <div class="row" > 
                          <div class="col-md-12" style="font-size:14px;font-weight:bold;color: #b93939;">
                          <input type="hidden" name="isconsumed" id="isconsumed" value="<?php if ($mode == 'EDIT') { echo $isConsumed;} ?>" readonly />
                         ** Summation of Protein,Carbohydrate & Fat Percentage must be equal to 100.
                         
                          
                          </div>
                          
                          </div>
                         
                         
                          
                   
                
                 <!------------------------------------end of Calorie Distribution------------------>
              <br>
               <!------------------------------------Prepare Meal ------------------------->
                    
                   <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Prepare Meal  </h3>  
                   
                     <div class="card" style="margin-bottom: .5rem!important;">
              
              <!-- /.card-header -->
              <div class="card-body">
                <div id="accordion" class="accordionCard2">
         	<?php $sl=1;
         	 for($i=1;$i<=11;$i++){  
              if($i==11){
                /********************11th Block*****************/
                if ($mode=='EDIT') {

                  	$rowMealDeatilByMealNo = $this->_dietmodel->GetMemberFoodDtlByMealNoAndMealID($mealID,$i);
                      $meal_dtl_id = 0;
                      $total_assistnce_calorie = 0;
                      $total_assistnce_protein = 0;
                      $total_assistnce_carbs = 0;
                      $total_assistnce_fat = 0;
                      
                      
                      if($rowMealDeatilByMealNo)
                      {
                        
                          $meal_dtl_id = $rowMealDeatilByMealNo->id;
                          $total_assistnce_calorie = $rowMealDeatilByMealNo->meal_calorie_given;
                          $total_assistnce_protein = $rowMealDeatilByMealNo->meal_protein_given;
                          $total_assistnce_carbs = $rowMealDeatilByMealNo->meal_carbs_given;
                          $total_assistnce_fat = $rowMealDeatilByMealNo->meal_fat_given;
                        
                      }
                 


                }

                ?>
                <!---- LAST DIV BLOCK ----------->	
                  <div class="card card-danger predMeal dnclk " id="meal<?php echo $i; ?>" >
                  	<a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i; ?>" class="" aria-expanded="true">
                    <div class="card-header" style="cursor: pointer;">
                      <h4 class="card-title">
                        
                         <?php echo 'Daily Recommandation '; ?>
                       
                      </h4>
                    </div> </a>

                    <div id="collapse_<?php echo $i; ?>" class="panel-collapse collapse" >
                      <div class="card-body ">
                      	<div class="callout callout-warning" style="margin-top:5px;">
                        <?php //echo ' Daily Recommandation '; ?>
                        <div id="meal_<?php echo $i; ?>">
                          	<input type="hidden" name="isDailyAssistanceMeal[]" class="isDailyAssistanceMeal" id="isDailyAssistanceMeal" value="Y"/>
                            <input type="hidden" name="meal[]" value="Meal<?php echo $i;?>" />	
                            <input type="hidden" name="srl[]" value="<?php echo $i;?>" />	

                            
                        <fieldset class="scheduler-border"> 

                      <div class="row" >
                         <div class="col-md-1"></div>
                            <!-- <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">Meal Time</label>
                                  <div class="input-group input-group-sm" >
                                   
                                  </div>
                                </div>
                            </div> -->
                             <input type="hidden" class="form-control mealTime clrField" name="mealTime[]" id="mealTime_<?php echo $i;?>" placeholder="" value="" autocomplete="off" >
                         <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">Food Type</label>
                                    <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                    <select class="form-control food_type clrselct select2" name="food_type" id="foodtype_<?php echo $i;?>"  style="width: 100%;">
                                    <option value="0" >Select</option>
                                      <?php
                                      foreach ($rowFoodType as $food_type) {  
                                    ?>
                                    <option value="<?php echo $food_type->id?>"  ><?php echo $food_type->food_type_name;?></option>
                                    <?php }?>
                                  </select>
                                  </div>
                                </div>
                      </div>

                       <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">Food Cat.</label>
                                    <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                   <select class="form-control food_category clrselct select2" name="food_category" id="foodcategory_<?php echo $i;?>"  style="width: 100%;">
                                    <option value="0" >Select</option>
                                      <?php
                                      foreach ($rowFoodCategory as $food_category) {  
                                    ?>
                                    <option value="<?php echo $food_category->id?>"  ><?php echo $food_category->category;?></option>
                                    <?php }?>
                                  </select>
                                  </div>
                                </div>
                      </div>

                        <!-- <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">GI(From)</label>
                                  <div class="input-group input-group-sm" >
                                    <input type="text" class="form-control giIndexfrom clrField" name="giIndex_from" id="giIndexfrom_<?php echo $i;?>"  value="" autocomplete="off" onkeyup="numericFilter(this)"  >
                                  </div>
                                </div>
                            </div>
                          <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">GI(To)</label>
                                  <div class="input-group input-group-sm" >
                                   
                                    <input type="text" class="form-control giIndexto clrField" name="giIndex_to" id="giIndexto_<?php echo $i;?>"  value="" autocomplete="off" onkeyup="numericFilter(this)"  >
                                  </div>
                                </div>
                            </div> -->
                         <div class="col-md-3">
                                <div class="form-group">
                                  <label for="code">Food Name</label>
                                    <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                     <select class="form-control food_select clrselct select2" name="food_select" id="food_select_<?php echo $i;?>"  style="width: 100%;">
                                    <option value="0" >Select</option>
                                      
                                  </select>
                                  </div>
                                </div>
                      </div>   
                      <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">quantity</label>
                                  <div class="input-group input-group-sm" >
                                    <input type="text" class="form-control qty clrField" name="qty" id="qty_<?php echo $i;?>"  value="" autocomplete="off" onkeyup="numericFilter(this)"  >
                                  </div>
                                </div>
                            </div>
                          <div class="col-md-4">
                                <div class="form-group">
                                  <label for="code">Instruction</label>
                                  <div class="input-group input-group-sm" >
                                   <textarea class="form-control instruction clrField" id="instruction_<?php echo $i;?>" name="instruction" style="width: 200px;height: 30px;resize:none;"></textarea>
                                  </div>
                                </div>
                            </div>  
                         <div class="col-md-1">
                          <div class="form-group">
                            <label for="firstname">&nbsp;</label>
                              <div class="input-group input-group-sm">
                           <i id="mealbtn_<?php echo $i;?>" class="far fa-plus-square adRow  addFood"></i>
                            </div>

                          </div>
                     </div>    

                        </div>

                        <!-- ------------------------------------------------------------------------------------ -->
                          <hr>
                         <div class="row">
                           <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                    <div  id="detail_itemamt" style="#border: 1px solid #e49e9e;">
                    <div class="table-responsive">
                 
                 <table class="table table-bordered foodTable clearTable " id="foodTable_<?php echo $i;?>" style="font-size: 14px;#color: #354668;<?php //echo $style_var; ?>">
                  <thead>                  
                    <tr class="tblfood">
                     
                   <th style="text-align:left;">Food</th>
									<th>Qty</th>
									<th>Unit</th>
									<th align="center">Calorie</th>
									<th>Protein in (gm.)</th>
									<th>Carbs in (gm.)</th>
									<th>Fat in (gm.)</th>
									<th style="text-align:left;">Instruction</th>
									<th>Del</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 

              if($mode=='EDIT'){
							$rowFoodDetailForDailyRecom = $this->_dietmodel->GetMemberFoodDtl($meal_dtl_id);
							$mealno = $i;
							if($rowFoodDetailForDailyRecom>0)
							{
								foreach($rowFoodDetailForDailyRecom as $daily_recomaddation)
								{ 
								//$mealno = $daily_recomaddation['member_meal_dtlid'];
								
								$row = $daily_recomaddation->memMealFoodDtlID;
								
								?>
								
			  		<tr id="fdetailrow_<?php echo $i; ?>_<?php echo $row; ?>" style="font-weight:700;">
						<td>
						<input type="hidden" id="foodForMeal_<?php echo $i; ?>" name="foodID_<?php echo $i; ?>[]" value="<?php echo $daily_recomaddation->diet_food_id; ?>" />
						<?php echo $daily_recomaddation->food_name; ?>
						</td>
						<td>
							<input type="hidden" id="qtyForMeal_<?php echo $i; ?>" name="qtyGiven_<?php echo $i; ?>[]" value="<?php echo $daily_recomaddation->food_qty; ?>" />
							<?php echo $daily_recomaddation->food_qty; ?>
						</td>
						<td>
							<input type="hidden" id="UnitForMeal_<?php echo $i; ?>" name="UnitGiven_<?php echo $i; ?>[]" value="<?php echo $daily_recomaddation->food_unit_id; ?>" />
							<?php echo $daily_recomaddation->unit_name; ?>
						</td>
						<td>
							<input type="text" name="calorieGiven_<?php echo $i; ?>[]" id="calorieGiven_<?php echo $i;?>" class="calorieGiven form_input_text" value="<?php echo $daily_recomaddation->calorie; ?>"  style="width:80px;text-align:right;" readonly />
							<?php // echo $calorie_given; ?>
						</td>
						<td>
							<input type="text" name="proteinGiven_<?php echo $i; ?>[]" id="proteinGiven_<?php echo $i;?>" class="proteinGiven form_input_text" value="<?php echo $daily_recomaddation->protein_grams; ?>" style="width:80px;text-align:right;" readonly />
							<?php //echo $protein_given; ?>
						</td>
						<td>
							<input type="text" name="carboGiven_<?php echo $i; ?>[]" id="carboGiven_<?php echo $i;?>" class="carboGiven form_input_text" value="<?php echo $daily_recomaddation->carbs_grams; ?>"  style="width:80px;text-align:right;" readonly />
							<?php // echo $carbo_given; ?>
						</td>
						<td>
							<input type="text" name="fatGiven_<?php echo $i; ?>[]" id="fatGiven_<?php echo $i;?>" class="fatGiven form_input_text" value="<?php echo $daily_recomaddation->fat_grams; ?>" style="width:80px;text-align:right;" readonly />
							<?php //echo $fat_given; ?>
						</td>
						
						<?php if(strlen($daily_recomaddation->instruction)>0){?>
						<td>
							<input type="hidden" name="instructionGiven_<?php echo $i; ?>[]" id="instructionGiven_<?php echo $i;?>" class="instructionGiven form_input_text" value="<?php echo $daily_recomaddation->instruction; ?>" style="width:80px;text-align:right;" readonly />
							<?php echo $daily_recomaddation->instruction; ?>
						</td>
						<?php } else{
						?>
            	<td>
							<input type="hidden" name="instructionGiven_<?php echo $i; ?>[]" id="instructionGiven_<?php echo $i;?>" class="instructionGiven form_input_text" value="<?php echo ""; ?>" style="width:80px;text-align:right;" readonly />
							<?php echo $daily_recomaddation->instruction; ?>             
            </td>
						<?php } ?>
					

          <td style="vertical-align: middle;text-align: center;">
          <a href="javascript:;" class="delicon" id="deldtlid_<?php echo $i; ?>_<?php echo $row; ?>" title="Delete">
              <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i>
              </a>

        </td>

					</tr>

								
								
									
						<?php	
								}
							}
						
            }
							
							?>
                  </tbody>
                </table>
                </div><!-- end of table responsive -->
                </div>
             
                </div>



                      
                    </div>
                        <!-- ------------------------------------------------------------------------------------ -->

                        <div class="row" >
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                              <div class="row mealTotalRow totalTableCal"  id="mealSum_<?php echo $i;?>" >                   
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Daily Assistance Calorie</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib" name="calorieSum[]" id="calorieSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){echo $total_assistnce_calorie; }?>"  readonly >
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Daily Assistance Protein</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib" name="proteinSum[]" id="proteinSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){echo $total_assistnce_protein; }?>"  readonly >
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Daily Assistance Carbs</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib"  name="carbsSum[]" id="carbsSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){echo $total_assistnce_protein; }?>" readonly >
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Daily Assistance Fat</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib" name="fatSum[]" id="fatSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){echo $total_assistnce_fat; }?>"  readonly>
                                        </div>
                                      </div>
                                  </div>

                                  </div>

                             </div>

                              </div>
                              <!-- ------------------------------------------------------------------------------------------- -->
                              
                                <div class="row">
                                        <div class="col-md-9"></div>
                                      <div class="col-md-2 text-right">
                                          <button type="button" class="btn btn-sm action-button saveMeal"  style="width: 60%;"><?php echo $btnText; ?></button>
                                        </div>               
                                </div>                 
                              
                              <!-- ------------------------------------------------------------------------------------------- -->


                        </fieldset>
                          
                        </div>

                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                /*****************END 11th Block***************/
              }else{

                if ($mode=='EDIT') {

                    	$row_meal_dtl_data = $this->_dietmodel->GetMemberFoodDtlByMealNoAndMealID($mealID,$i);
				

                        $meal_Dtl_ID = 0;
                        $total_assistnce_calorie_d = 0;
                        $total_assistnce_protein_d = 0;
                        $total_assistnce_carbs_d = 0;
                        $total_assistnce_fat_d = 0;
                        $mealTime= "";
                        

                          if($row_meal_dtl_data)
                          {
                            $meal_Dtl_ID = $row_meal_dtl_data->id;
                            $total_assistnce_calorie_d = $row_meal_dtl_data->meal_calorie_given;
                            $total_assistnce_protein_d = $row_meal_dtl_data->meal_protein_given;
                            $total_assistnce_carbs_d = $row_meal_dtl_data->meal_carbs_given;
                            $total_assistnce_fat_d = $row_meal_dtl_data->meal_fat_given;
                            $mealTime = date("h:i:s a",strtotime($row_meal_dtl_data->meal_time));
                            
                          }


                }

              ?>
                  <div class="card card-danger predMeal dnclk " id="meal<?php echo $i; ?>">
                  	<a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i; ?>" class="" aria-expanded="true">
                    <div class="card-header" style="cursor: pointer;">
                      <h4 class="card-title">
                        
                         <?php 
                         echo 'Meal '.$i; ?>
                       
                      </h4>
                    </div> </a>

                    <div id="collapse_<?php echo $i; ?>" class="panel-collapse collapse" >
                      <div class="card-body ">
                      	<div class="callout callout-warning" style="margin-top:5px;">
                        <?php //echo 'Meal '.$i; ?>

                        <div id="meal_<?php echo $i; ?>">
                        <input type="hidden" name="isDailyAssistanceMeal[]" class="isDailyAssistanceMeal" id="isDailyAssistanceMeal" value="N"/>
                        <input type="hidden" name="meal[]" value="Meal<?php echo $i;?>" />	
                        <input type="hidden" name="srl[]" value="<?php echo $i;?>" />

                        <fieldset class="scheduler-border"> 

                      <div class="row" >
                         <div class="col-md-1"></div>
                            <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">Meal Time</label>
                                  <div class="input-group input-group-sm" >
                                    <input type="text" class="form-control mealTime clrField" name="mealTime[]" id="mealTime_<?php echo $i;?>" placeholder="" value="<?php if ($mode=='EDIT'){echo $mealTime;} ?>" autocomplete="off" >
                                  </div>
                                </div>
                            </div>
                         <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">Food Type</label>
                                    <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                    <select class="form-control food_type clrselct select2" name="food_type" id="foodtype_<?php echo $i;?>"  style="width: 100%;">
                                    <option value="0" >Select</option>
                                      <?php
                                      foreach ($rowFoodType as $food_type) {  
                                    ?>
                                    <option value="<?php echo $food_type->id?>"  ><?php echo $food_type->food_type_name;?></option>
                                    <?php }?>
                                  </select>
                                  </div>
                                </div>
                      </div>

                       <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">Food Cat.</label>
                                    <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                   <select class="form-control food_category clrselct select2" name="food_category" id="foodcategory_<?php echo $i;?>"  style="width: 100%;">
                                    <option value="0" >Select</option>
                                      <?php
                                      foreach ($rowFoodCategory as $food_category) {  
                                    ?>
                                    <option value="<?php echo $food_category->id?>"  ><?php echo $food_category->category;?></option>
                                    <?php }?>
                                  </select>
                                  </div>
                                </div>
                      </div>

                        <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">GI(From)</label>
                                  <div class="input-group input-group-sm" >
                                    <input type="text" class="form-control giIndexfrom clrField" name="giIndex_from" id="giIndexfrom_<?php echo $i;?>"  value="" autocomplete="off" onkeyup="numericFilter(this)"  >
                                  </div>
                                </div>
                            </div>
                          <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">GI(To)</label>
                                  <div class="input-group input-group-sm" >
                                   
                                    <input type="text" class="form-control giIndexto clrField" name="giIndex_to" id="giIndexto_<?php echo $i;?>"  value="" autocomplete="off" onkeyup="numericFilter(this)"  >
                                  </div>
                                </div>
                            </div>
                         <div class="col-md-3">
                                <div class="form-group">
                                  <label for="code">Food Name</label>
                                    <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                     <select class="form-control food_select clrselct select2" name="food_select" id="food_select_<?php echo $i;?>"  style="width: 100%;">
                                    <option value="0" >Select</option>
                                      
                                  </select>
                                  </div>
                                </div>
                      </div>   
                      <div class="col-md-1">
                                <div class="form-group">
                                  <label for="code">quantity</label>
                                  <div class="input-group input-group-sm" >
                                    <input type="text" class="form-control qty clrField" name="qty" id="qty_<?php echo $i;?>"  value="" autocomplete="off" onkeyup="numericFilter(this)"  >
                                  </div>
                                </div>
                            </div>
                         <div class="col-md-1">
                          <div class="form-group">
                            <label for="firstname">&nbsp;</label>
                              <div class="input-group input-group-sm">
                           <i id="mealbtn_<?php echo $i;?>" class="far fa-plus-square adRow  addItem addFood"></i>
                            </div>

                          </div>
                     </div>    

                        </div>

                        <!-- ------------------------------------------------------------------------------------ -->
                          <hr>
                         <div class="row">
                           <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                    <div  id="detail_itemamt" style="#border: 1px solid #e49e9e;">
                    <div class="table-responsive">
                     
                 <table class="table table-bordered foodTable clearTable " id="foodTable_<?php echo $i;?>" style="font-size: 14px;#color: #354668;<?php //echo $style_var; ?>">
                  <thead>                  
                    <tr class="tblfood">  
                    <th>Food</th>
										<th>Qty</th>
										<th>Unit</th>
										<th align="center">Calorie</th>
										<th>Protein in (gm.)</th>
										<th>Carbs in (gm.)</th>
										<th>Fat in (gm.)</th>									
                    <th style="width: 40px">Del</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
						if($mode=='EDIT'){
						$rowFoodDetailForMeal = $this->_dietmodel->GetMemberFoodDtl($meal_Dtl_ID);
						$mealNO = $i;
						if(sizeof($rowFoodDetailForMeal)>0)
						{
							foreach($rowFoodDetailForMeal as $food_dtl_meal)
							{ 
								
								//$mealNO = $meal_Dtl_ID;
								$rowNO = $food_dtl_meal->memMealFoodDtlID;
							?>
						

							<tr id="fdetailrow_<?php echo $i; ?>_<?php echo $rowNO; ?>" style="font-weight:700;">
								<td>
								<input type="hidden" id="foodForMeal_<?php echo $i; ?>" name="foodID_<?php echo $i; ?>[]" value="<?php echo $food_dtl_meal->diet_food_id; ?>" />
								<?php echo $food_dtl_meal->food_name; ?>
								</td>
								<td>
									<input type="hidden" id="qtyForMeal_<?php echo $i; ?>" name="qtyGiven_<?php echo $i; ?>[]" value="<?php echo $food_dtl_meal->food_qty; ?>" />
									<?php echo $food_dtl_meal->food_qty; ?>
								</td>
								<td>
									<input type="hidden" id="UnitForMeal_<?php echo $i; ?>" name="UnitGiven_<?php echo $i; ?>[]" value="<?php echo $food_dtl_meal->food_unit_id; ?>" />
									<?php echo $food_dtl_meal->unit_name; ?>
								</td>
								<td>
									<input type="text" name="calorieGiven_<?php echo $i; ?>[]" id="calorieGiven_<?php echo $i;?>" class="calorieGiven form_input_text" value="<?php echo $food_dtl_meal->calorie; ?>"  style="width:80px;text-align:right;" readonly />
									<?php // echo $calorie_given; ?>
								</td>
								<td>
									<input type="text" name="proteinGiven_<?php echo $i; ?>[]" id="proteinGiven_<?php echo $i;?>" class="proteinGiven form_input_text" value="<?php echo $food_dtl_meal->protein_grams; ?>" style="width:80px;text-align:right;" readonly />
									<?php //echo $protein_given; ?>
								</td>
								<td>
									<input type="text" name="carboGiven_<?php echo $i; ?>[]" id="carboGiven_<?php echo $i;?>" class="carboGiven form_input_text" value="<?php echo $food_dtl_meal->carbs_grams; ?>"  style="width:80px;text-align:right;" readonly />
									<?php // echo $carbo_given; ?>
								</td>
								<td>
									<input type="text" name="fatGiven_<?php echo $i; ?>[]" id="fatGiven_<?php echo $i;?>" class="fatGiven form_input_text" value="<?php echo $food_dtl_meal->fat_grams; ?>" style="width:80px;text-align:right;" readonly />
									<?php //echo $fat_given; ?>
								</td>
								
								<?php if(strlen($food_dtl_meal->instruction)>0){?>
								<td>
									<input type="hidden" name="instructionGiven_<?php echo $i; ?>[]" id="instructionGiven_<?php echo $i;?>" class="instructionGiven form_input_text" value="<?php echo $food_dtl_meal->instruction; ?>" style="width:80px;text-align:right;" readonly />
									<?php echo $food_dtl_meal->instruction; ?>
								</td>
								<?php } else{
								?>
									<input type="hidden" name="instructionGiven_<?php echo $i; ?>[]" id="instructionGiven_<?php echo $i;?>" class="instructionGiven form_input_text" value="<?php echo ""; ?>" style="width:80px;text-align:right;" readonly />
								<?php echo $food_dtl_meal->instruction; ?>	
								<?php } ?>
							
                <td style="vertical-align: middle;text-align: center;">
               <a href="javascript:;" class="delicon" id="deldtlid_<?php echo $i; ?>_<?php echo $rowNO; ?>" title="Delete">
              <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i>
              </a>

               </td>
							</tr>


						
				<?php		}
						}

          }
						?>
						
                     
                  </tbody>
                </table>
                </div><!-- end of table responsive -->
                </div>
             
                </div>



                      
                    </div>
                        <!-- ------------------------------------------------------------------------------------ -->

                        <div class="row" >
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                              <div class="row mealTotalRow totalTableCal"  id="mealSum_<?php echo $i;?>" >                   
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal <?php echo $i; ?> Calorie</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib" name="calorieSum[]" id="calorieSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){ echo $total_assistnce_calorie_d ;} ?>"  readonly >
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal <?php echo $i; ?> Protein</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib" name="proteinSum[]" id="proteinSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){ echo $total_assistnce_protein_d ;} ?>"  readonly >
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal <?php echo $i; ?> Carbs</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib"  name="carbsSum[]" id="carbsSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){ echo $total_assistnce_carbs_d ;} ?>" readonly >
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal <?php echo $i; ?> Fat</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib" name="fatSum[]" id="fatSum_<?php echo $i; ?>"  value="<?php if($mode=='EDIT'){ echo $total_assistnce_fat_d ;} ?>"  readonly>
                                        </div>
                                      </div>
                                  </div>

                                  </div>

                             </div>

                              </div>
                              <!-- ------------------------------------------------------------------------------------------- -->
                              
                                <div class="row">
                                        <div class="col-md-9"></div>
                                      <div class="col-md-2 text-right">
                                          <button type="button" class="btn btn-sm action-button saveMeal"  style="width: 60%;"><?php echo $btnText; ?></button>
                                        </div>               
                                </div>                 
                              
                              <!-- ------------------------------------------------------------------------------------------- -->


                        </fieldset>

                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   <?php } } ?>


                
             
                </div>
              </div>
              <!-- /.card-body -->
            </div>
                           
                  
               <!------------------------------------end of Prepare Meal ------------------------->   
               
                <br>
               <!------------------------------------Other Assistance  ------------------------->
                    
                   <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Other Assistance  </h3> 
                   
                    <fieldset class="scheduler-border"> 

                      <div class="row" >
                         <div class="col-md-1"></div>
                           
                              <div class="col-md-2">
                                      <div class="form-group">
                                        <label for="code">Category</label>
                                          <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                          <select class="form-control  clrselct select2" name="other_assistnc_catg" id="other_assistnc_catg"  style="width: 100%;">
                                          <option value="0" >Select</option>
                                            <?php
                                            foreach ($rowOtherAssistanceCatg as $othr_assistnc) {  
                                          ?>
                                          <option value="<?php echo $othr_assistnc->id?>"  ><?php echo $othr_assistnc->othr_assistnc_name;?></option>
                                          <?php }?>
                                        </select>
                                        </div>
                                      </div>
                            </div>
                                
                              <div class="col-md-2">
                                      <div class="form-group">
                                        <label for="code"> Supplement</label>
                                          <div class="input-group input-group-sm" id="item_cgst_rateerr">
                                          <select class="form-control  clrselct select2" name="supplement_name" id="supplement_name"  style="width: 100%;">
                                          <option value="0" >Select</option>
                                          
                                        </select>
                                        </div>
                                      </div>
                            </div>
                            <div class="col-md-1">
                                      <div class="form-group">
                                        <label for="code">Serving Size</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control  clrField " name="serving_size" id="serving_size"  value="" >
                                        </div>
                                      </div>
                           </div>
                               <div class="col-md-1">
                                      <div class="form-group">
                                        <label for="code">Unit</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control  clrField " name="other_assistnc_unit" id="other_assistnc_unit"  value="" readonly>
                                        <input type="hidden" name="other_assistnc_unitID" id="other_assistnc_unitID" class="form_input_text clrField" readonly />
                                        </div>
                                      </div>
                           </div>
                                 <div class="col-md-3">
                                <div class="form-group">
                                  <label for="code">Advice</label>
                                  <div class="input-group input-group-sm" >
                                   <textarea class="form-control clrField" id="other_assistnce_advice" name="other_assistnce_advice" style="width: 200px;height: 30px;resize:none;"></textarea>
                                  </div>
                                </div>
                            </div>  
                         <div class="col-md-1">
                          <div class="form-group">
                            <label for="firstname">&nbsp;</label>
                              <div class="input-group input-group-sm">
                           <i id="otherAssistanceBtn" class="far fa-plus-square adRow  addOtherAssistance"></i>
                            </div>

                          </div>
                     </div> 
                      </div>
                        <div class="row">
                           <div class="col-sm-1" ></div>  
                           <div class="col-sm-11" id="supplement_omponents_details"></div>  
                        </div>                         
                    <hr>

                      <div class="row">
                           <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                    <div  id="detail_itemamt" style="#border: 1px solid #e49e9e;">
                    <div class="table-responsive">
                     
                 <table class="table table-bordered foodTable clearTable " id="otherAssistanceDtl" style="font-size: 14px;#color: #354668;<?php //echo $style_var; ?>">
                  <thead>                  
                    <tr class="tblfood">
                    <th>Category</th>
                    <th>Supplement</th>
                    <th>Serving Size</th>
                    <th>Unit</th>
                    <th>Advice</th>
                    <th style="width:40px">Del</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 

                  if($mode=='EDIT'){
							$rowOtherAssistance = $this->_dietmodel->getOtherAssistanceData($mealID);
							if(sizeof($rowOtherAssistance)>0)
							{
								foreach($rowOtherAssistance as $other_assistance_data)
								{ 
									$category = $other_assistance_data->categoryID;
									$suplmntCatg = $other_assistance_data->othr_assistnc_name;
									$supplmntID = $other_assistance_data->otherAssistancemasterID;
									$suplmntName = $other_assistance_data->supplement_name;
									$servingsize = $other_assistance_data->serving_size;
									$unitId = $other_assistance_data->dietUnitID;
									$suplmntUnit = $other_assistance_data->unit_name;
									$advice = $other_assistance_data->advice;
									$rowno=$other_assistance_data->id.$other_assistance_data->categoryID.$other_assistance_data->otherAssistancemasterID;
								?>
								
								
						<tr id="otherAssistanceRow_<?php echo $rowno; ?>">
							<td>
								<input type="hidden" name="otherAssistanceCategory[]" class="otherAssistanceCategory" value="<?php echo $category; ?>" />
								<?php echo $suplmntCatg; ?>
							</td>
							<td>
								<input type="hidden" name="otherAssistanceSupplyName[]" class="otherAssistanceSupplyName" value="<?php echo $supplmntID; ?>" />
								<?php echo $suplmntName; ?>
							</td>
							<td>
								<input type="hidden" name="otherAssistanceServingSize[]" class="otherAssistanceServingSize" value="<?php echo $servingsize; ?>" />
								<?php echo $servingsize; ?>
							</td>
							<td>
								<input type="hidden" name="otherAssistanceUnit[]" class="otherAssistanceUnit" value="<?php echo $unitId; ?>" />
								<?php echo $suplmntUnit; ?>
							</td>
							<td>
								<input type="hidden" name="otherAssistanceAdvice[]" class="otherAssistanceAdvice" value="<?php echo trim($advice); ?>" />
								<?php echo $advice; ?>
							</td>
						
                <td style="vertical-align: middle;text-align: center;">
               <a href="javascript:;" class="otherAssistanceDlt delicon" id="otherAssistanceDlt_<?php echo $rowno; ?>" title="Delete">
              <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i>
              </a>

               </td>
						</tr>
						
						
								
						<?php	}
							}

            }
						
						?>
						
							
                     
                  </tbody>
                </table>
                </div><!-- end of table responsive -->
                </div>
             
                </div>



                      
                    </div>



                  </fieldset>




                      <div class="row" >
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                              <div class="row mealTotalRow totalTableCal"  id="totalmealSum" >                   
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal Calorie</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control  finpcls clrField" name="totalCalorie" id="totalCalorie"  value="<?php if($mode=='EDIT'){ echo $total_calorie_given;}?>"  readonly >                                       
			                                  	<input type="hidden" name="totalRemCalorie" id="totalRemCalorie" value="" class="finpcls clrField" readonly />
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal Protein</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField" name="totalProtein" id="totalProtein"  value="<?php if($mode=='EDIT'){ echo $total_protein_given;}?>"  readonly >
							                        	  <input type="hidden" name="totalRemProtein" id="totalRemProtein" value="" class="finpcls clrField" readonly />
                                       
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal Carbs</label>
                                        <div class="input-group input-group-sm" >
                                         <input type="text" class="form-control finpcls clrField ib"  name="totalCarbs" id="totalCarbs"  value="<?php if($mode=='EDIT'){ echo $total_carbs_given;}?>" readonly >
							                          	<input type="hidden" name="totalRemCarbs" id="totalRemCarbs" value="" class="finpcls clrField" readonly />
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Total Meal Fat</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control finpcls clrField ib"name="totalFat" id="totalFat"  value="<?php if($mode=='EDIT'){ echo $total_fat_given;}?>"  readonly>
                                         
							                          	<input type="hidden" name="totalRemFat" id="totalRemFat" value="" class="finpcls clrField" readonly />
                                        </div>
                                      </div>
                                  </div>

                                  </div>

                             </div>

                              </div> 

                          <div class="row">
                                <label for="prot" class="col-md-1 labletext">Special Note</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                      <textarea class="form-control clrField" id="remarks_members" name="remarks_members" style="width: 200px;height: 60px;resize:none;"><?php if($mode=='EDIT'){echo $member_remarks;} ?></textarea>
                                  </div>
                                    </div>                        
                                  </div>
                        </div>          

                           
                  
               <!------------------------------------end of Other Assistance  ------------------------->      

                      </div>



                    </div>  <!-- /.card-body -->



               <div class="formblock-box" >
                   <div class="row">
                          <div class="col-md-9">                    
                          <p id="errormsg" class="errormsgcolor"></p>
                          
                          </div>
                         <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-sm action-button saveMeal"  style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>
                            
                           </div> 
                           <div class="col-md-1 text-center">                    
                        
                          <?php if($mode=='EDIT'){?>
                           <a id="wplink" href="https://api.whatsapp.com/send?text=https://www.mantrahealthclub.com/adminportal/admin/diet/printdiet/<?php echo $dietId;?>" target="_blank" > &nbsp; <img src="<?php echo base_url(); ?>assets/img/wp.png" width="25" height="25" /></a>
                          <?php }?>
                          </div>              
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>
</form>
</div>
<!-- End of diet-container -->


	<div id="bottom-remaining-info">
				<p>Calorie Req : <span id="calorie-req-bottom">0.00</span></p>
				<p>Protein Req : <span id="protein-req-bottom" class="clrText">0.00 gm</span></p>
				<p>Carbs Req : <span id="carbs-req-bottom" class="clrText">0.00</span></p>
				<p>Fat Req : <span id="fat-req-bottom" class="clrText">0.00 gm</span></p>
				
				<h4 style="border-bottom:1px solid #F00;"></h4>
				
				<p>Calorie Given : <span id="calorie-given-bottom" class="clrText" >0.00</span></p>
				<p>Protein Given : <span id="protein-given-bottom" class="clrText">0.00 gm</span></p>
				<p>Carbs Given : <span id="carbs-given-bottom" class="clrText">0.00 gm</span></p>
				<p>Fat Given : <span id="fat-given-bottom" class="clrText">0.00 gm</span></p>
				
				<!--
				<p class="carbs-given-block" style="display:none;">Carbs Req : <span id="carbs-req-bottom">0.00</span></p>
				<p class="carbs-given-block" style="display:none;">Carbs Given : <span id="carbs-given-bottom">0.00</span></p>-->
				
				
			</div>
