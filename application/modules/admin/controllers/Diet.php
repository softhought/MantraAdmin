<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Diet extends MY_Controller{

function __construct(){
    parent::__construct();
	$this->load->model('commondatamodel','commondatamodel',TRUE);	
	$this->load->model('dietmodel','_dietmodel',TRUE);	
	 $this->load->model('registrationmodel','reg_model',TRUE);
    $this->load->module('template');		
}

public function index(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        echo "Mantra Diet List will show";    
    }else{
        redirect('admin','refresh');  
  }
}


public function preparediet(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

		 if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['dietId'] = 0;
        $data['rowMemberMasterData'] = [];
		$data['proteinCalorie'] = '';
		$data['carbsCalorie'] = '';
		$data['fatCalorie'] = '';
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['dietId'] = $this->uri->segment(4);
          $where = array('members_meal_master.id'=>$data['dietId']);
          $data['rowMemberMasterData'] = $this->commondatamodel->getSingleRowByWhereCls('members_meal_master',$where);
		  $final_calorie_req = $data['rowMemberMasterData']->final_calorie_req;
		  $protein_percentage = $data['rowMemberMasterData']->protein_percentage;
		  $carbs_percentage = $data['rowMemberMasterData']->carbs_percentage;
		  $fat_percentage = $data['rowMemberMasterData']->fat_percentage; 

		  $data['proteinCalorie'] = $this->getCalorieByPercentage($final_calorie_req,$protein_percentage);
		  $data['carbsCalorie'] = $this->getCalorieByPercentage($final_calorie_req,$carbs_percentage);
		  $data['fatCalorie'] = $this->getCalorieByPercentage($final_calorie_req,$fat_percentage);



       }


	   if(isset($_COOKIE['umetainfo'])) {        
		 $data['kpcls']="badge-success";   
		 $data['kptext']="Active login for today";   
		  
        }else{
         $data['kpcls']="badge-danger";  
		 $data['kptext']="Keep me logged in";  
        }

		//echo $data['kpcls'];exit;

       
        $orderby='id';
        $data['activityLevel'] = $this->commondatamodel->getAllRecordWhereOrderBy('activity_level_multiplier',[],$orderby);
        $orderby='id';
        $where = array('employee_master.desig_id' => 4);
        $data['dietcianList'] = $this->commondatamodel->getAllRecordWhereOrderBy('employee_master',array('employee_master.desig_id' => 4),'empl_name');
       
        $data['diseaseguidelineList'] = $this->commondatamodel->getAllRecordWhereOrderBy('diet_disease_guide_master',array('is_active' => 'Y'),[]);
		$data['youtubevideoList'] = $this->commondatamodel->getAllRecordWhereOrderBy('videogallery',array('is_active' => 'Y','showtag' => 'N'),[]);
        $data['rowMealApproach'] = $this->_dietmodel->GetMealApproach();
	    $data['rowFoodMaster'] = $this->_dietmodel->GetFoodMaster();
		$data['rowFoodType'] = $this->_dietmodel->GetFoodType();
		$data['rowFoodCategory'] = $this->_dietmodel->GetFoodCategory();
	    $data['rowGIindex'] = $this->_dietmodel->GetFoodCategory();
		$data['rowOtherAssistanceCatg'] = $this->_dietmodel->GetOtherAssistanceCategory();
		$data['rowNeedFactor'] =  $this->_dietmodel->GetNeedFactor();


		//pre($data['rowMemberMasterData']);
		//exit;
        $data['view_file'] = 'dashboard/diet/prepare/prepare_diet_view.php';
       $this->template->admin_template($data);  	

    }else{ 
        redirect('admin','refresh');  
    } 
}


	public function getMemberInformation(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
			$mobile_no = trim($this->input->post('mobile'));
            $company_id=$session['companyid'];


            
			
		 $memberDataList = $this->commondatamodel->GetCurrentPackage($mobile_no,$company_id);

         
          
			if($memberDataList)
			{   $memberData=$memberDataList[0];
                $name = $memberData->CUS_NAME;
                $diet = $memberData->CUS_DIET;
                $mem = $memberData->MEMBERSHIP_NO;
                $gender_code = $memberData->CUS_SEX;
                if($gender_code=='M'){$gender='Male';}else if($gender_code=='F'){$gender='Female';}else{$gender='Other';}
                $dob = $memberData->CUS_DOB;
                $validity = $memberData->VALIDITY_STRING;
                $status ="Active";
				$json_response = array(
                    "msg_status" => 1,
					"cusname" => $name,
                    "membership" => $mem,
                    "gender" => $gender,
                    "dob" => $dob,
                    "card" => $memberData->CUS_CARD,
                    "validity" => $validity,
                    "member_acc_code" => $memberData->member_acc_code,
                    "status" => $status,
                    "diet" => $diet,
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "No Data"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }




    	public function calculateMemberBmr(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
			$mobile = trim($this->input->post('mobile'));
			$calculate_by = trim($this->input->post('calculate_by'));
			$gender = trim($this->input->post('gender'));
			$membership_no = trim($this->input->post('membership_no'));
			$dob = date('Y-m-d',strtotime($this->input->post('dob')));
			$weight = trim($this->input->post('weight'));
			$waist = trim($this->input->post('waist'));
		
	
			$activity = trim($this->input->post('activity'));

            $company_id=$session['companyid'];
                
                $gen = "";
                $step_one_cal = 0;
                $bdyfatmultiplier = 0;
                $activityMultiplier = 0;
                $BMR = 0;
                $calculated_data = array();
                
                
                if($gender=="Male")
                {
                    $gen = "M";
                    $step_one_cal = 1*$weight*24;
                }
                if($gender=="Female")
                {
                    $gen = "F";
                    $step_one_cal = 0.9*$weight*24;
                }

                $cur_date = date("Y-m-d");
                $date_diff=strtotime($cur_date)-strtotime($dob) ;
                $age=floor(($date_diff)/(60*60*24*365));

                $BodyFatPercentage = $this->calculateBodyFatPercentage($gen,$weight,$waist);
                $bodyFatRemarks =  $this->getBodyFatRemarks($age,$gen,$BodyFatPercentage);
                $rowBodyFatMultiplier = $this->_dietmodel->getBodyFatMultiplier($gen,$BodyFatPercentage);
	            $activityLevelMultiplier = $this->_dietmodel->GetActivityLevelById($activity);

				if($rowBodyFatMultiplier)
				{
					$bdyfatmultiplier = $rowBodyFatMultiplier->multiplier;
				}			
				$BMR = $step_one_cal*$bdyfatmultiplier; // BMR Calculated Value
				
				if($activityLevelMultiplier)
				{
					$activityMultiplier = $activityLevelMultiplier->multiplier;
				}


				/*---------------------------------------------------------------------- */

				if($calculate_by=='H'){
					
		            $data['hav'] = $this->_dietmodel->getLastHavDataByMobile($mobile);
					if ($data['hav']) {
						$BMR=$data['hav']->rm;
						$BodyFatPercentage=$data['hav']->bodyfat;
					}
				}
				/*---------------------------------------------------------------------- */

				$calRequired = $BMR*$activityMultiplier; // Total Calorie Required

         
				$json_response = array(
                    "msg_status" => 1,
                    "bodyfatpercentage" => $BodyFatPercentage,
					"bodyFatRemarks" => $bodyFatRemarks,
					"BMR" => number_format($BMR,3,'.', ''),
					"calReq" => number_format($calRequired,3,'.', ''),
				);
			

				//pre($json_response);exit;
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }




    function calculateBodyFatPercentage($gen,$weight,$waist)
	{
		$BF;
        $BFPercent;
		$BM;
		$Weight = $weight*2.20462;
        if($gen=="M")
			{
            $BF = -98.42 + 4.15*$waist - .082*$Weight;
            }
			// Make the female calculations
        else{
               $BF = -76.76 + (4.15*$waist) - (.082*$Weight);
            }
                
            $BFPercent = $BF / $Weight;
            $BFPercent = $BFPercent * 100;
            $BFPercent = round($BFPercent);
			return $BFPercent;
	}

    function getBodyFatRemarks($age,$gender,$body_fat_per)
	{
		if($age >= 18 && $age < 40)
		{
			if($gender=="M")
			{
				$body_remarks=$this->getFatM1("R",$body_fat_per);
				//$body_score=getFatM1("P",$body_fat_per);
			}
			else
			{
				$body_remarks=$this->getFatF1("R",$body_fat_per);
				//$body_score=getFatF1("P",$body_fat_per);
			}
		}
		
		if($age >= 40 && $age < 50)
		{
			if($gender=="M")
			{
				$body_remarks=$this->getFatM2("R",$body_fat_per);
				//$body_score=getFatM2("P",$body_fat_per);
			}
			else
			{
				$body_remarks=$this->getFatF2("R",$body_fat_per);
				//$body_score=getFatF2("P",$body_fat_per);
			}
		}
		
		if($age >= 50 && $age < 80)
		{
			if($gender=="M")
			{
				$body_remarks=$this->getFatM3("R",$body_fat_per);
				//$body_score=getFatM3("P",$body_fat_per);
			}
			else
			{
				$body_remarks=$this->getFatF3("R",$body_fat_per);
				//$body_score=getFatF3("P",$body_fat_per);
			}
		}
		
		return $body_remarks;
	}

    // remarks and point for body composition
function getFatM1($tag,$fat)
{
	if($fat >= 0 && $fat < 5)
	{
		if($tag=="R")
		{
			return "Extremely  under fat";
		}
	}
	if($fat >= 5 && $fat < 8)
	{
		if($tag=="R")
		{
			return "Under fat ";
		}
		
	}
	if($fat >= 8 && $fat < 20)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	
	if($fat >= 20 && $fat < 24)
	{
		if($tag=="R")
		{
			return "Obese Stage 1";
		}
	}	
	
	if($fat >= 24 && $fat < 28)
	{
		if($tag=="R")
		{
			return "Obese Stage 2";
		}
	}
					
	if($fat >= 28)
	{
		if($tag=="R")
		{
			return "Extremely Obese";
		}
	}
					
}



function getFatF1($tag,$fat)
{
	if($fat >= 0 && $fat < 14)
	{
		if($tag=="R")
		{
			return "Extremely  under fat";
		}
	}
	if($fat >= 14 && $fat < 21)
	{
		if($tag=="R")
		{
			return "Under fat ";
		}
	}
	
	if($fat >= 21 && $fat < 33)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	if($fat >= 33 && $fat < 37)
	{
		if($tag=="R")
		{
			return "Obese Stage 1";
		}
		
	}
	if($fat >= 37 && $fat < 40)
	{
		if($tag=="R")
		{
			return "Obese";
		}
		
	}	
	if($fat >= 41)
	{
		if($tag=="R")
		{
			return "Extremely Obese";
		}
		
	}
}


function getFatM2($tag,$fat)
{
	if($fat >= 0 && $fat < 5)
	{
		if($tag=="R")
		{
			return "Extremely  under fat";
		}
	}
	
	if($fat >= 5 && $fat < 11)
	{
		if($tag=="R")
		{
			return "Under fat ";
		}
		
	}
	if($fat >= 11 && $fat < 22)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
	}
	if($fat >= 22 && $fat < 26)
	{
		if($tag=="R")
		{
			return "Obese Stage 1";
		}
	}
	if($fat >= 26 && $fat < 32)
	{
		if($tag=="R")
		{
			return "Obese Stage 2";
		}
	}
	if($fat >= 32)
	{
		if($tag=="R")
		{
			return "Extremely obese";
		}
	}
}





function getFatF2($tag,$fat)
{
	if($fat >= 0 && $fat < 14)
	{
		if($tag=="R")
		{
			return "Extremely  under fat";
		}
		
	}
	if($fat >= 14 && $fat < 23)
	{
		if($tag=="R")
		{
			return "Under fat ";
		}
		
	}
	if($fat >= 23 && $fat < 34)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	if($fat >= 34 && $fat < 39)
	{
		if($tag=="R")
		{
			return "Obese Stage 1";
		}
		
	}
	if($fat >= 39 && $fat < 41)
	{
		if($tag=="R")
		{
			return "Obese Stage 2";
		}
		
	}
	if($fat >= 41)
	{
		if($tag=="R")
		{
			return "Extremely obese";
		}
		
	}
}



function getFatM3($tag,$fat)
{
	if($fat >= 0 && $fat < 5)
	{
		if($tag=="R")
		{
			return "Extremely  under fat";
		}
		
	}
	
	if($fat >= 5 && $fat < 13)
	{
		if($tag=="R")
		{
			return "Under fat ";
		}
		
	}
	
	if($fat >= 13 && $fat < 25)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	
	if($fat >= 25 && $fat < 29)
	{
		if($tag=="R")
		{
			return "Obese";
		}
		
	}
	if($fat >= 25 && $fat < 29)
	{
		if($tag=="R")
		{
			return "Obese";
		}
		
	}
	if($fat >= 29)
	{
		if($tag=="R")
		{
			return "Extremely obese";
		}
		
	}						
					
}



function getFatF3($tag,$fat)
{
	if($fat >= 100 && $fat < 14)
	{
		if($tag=="R")
		{
			return "Eessential fat";
		}
	}
	
	if($fat >= 14 && $fat < 24)
	{
		if($tag=="R")
		{
			return "Under fat ";
		}
		
	}
	if($fat >= 24 && $fat < 36)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	if($fat >= 24 && $fat < 36)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	if($fat >= 24 && $fat < 36)
	{
		if($tag=="R")
		{
			return "Healthy";
		}
		
	}
	if($fat >= 36)
	{
		if($tag=="R")
		{
			return "Obese";
		}
		
	}
}


	public function getHavWeight(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
			$mobile_no = trim($this->input->post('mobile'));
            $company_id=$session['companyid'];
 			$where_mem = array('mobile_no' => $mobile_no );
		    $dataHav = $this->_dietmodel->getLastHavDataByMobile($mobile_no);
          
			if($dataHav)
			{   

				if($dataHav->weight=='' || $dataHav->waist_circumrance==''){
						$json_response = array(
							"msg_status" => 0,
							"msg_data" => "Last HAV information not available go for remote option "
						);
				}else{
						$json_response = array(
							"msg_status" => 1,
							"weight" => $dataHav->weight,
							"waist" => $dataHav->waist_circumrance,
					);
				}
				
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "No HAV information available against mobile no."
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


	public function getDietDiseaseAdvice(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$diseaseIDs = $this->input->post('diseaseIDs');
			// pre($diseaseIDs);exit;
			// if($this->input->post('diseaseIDs')){
			// $diseaseIds = implode(',',$diseaseIDs);
			// }
			// else{
			// $diseaseIds = 0;	
			// }
			$data['dataAdvise']= $this->_dietmodel->getAllDiseaseforpreaperdiet($diseaseIDs);

		//	pre($data['dataAdvise']);exit;
			$page = 'dashboard/diet/prepare/get_diet_disease_advice.php';
			echo $this->load->view($page,$data);
		}
		else
		{
			redirect('admin','refresh');
		}

	}

		public function getYoutubeVideo(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$videoIDs = $this->input->post('videoIDs');
			// pre($diseaseIDs);exit;
			// if($this->input->post('diseaseIDs')){
			// $diseaseIds = implode(',',$diseaseIDs);
			// }
			// else{
			// $diseaseIds = 0;	
			// }
			$data['dataVideo']= $this->_dietmodel->getAllYoutubeVideo($videoIDs);

			//pre($data['dataVideo']);exit;
			$page = 'dashboard/diet/prepare/get_youtube_video.php';
			echo $this->load->view($page,$data);
		}
		else
		{
			redirect('admin','refresh');
		}

	}
	

		public function mealapproachSubOptions(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$meal_approach_id = $this->input->post('meal_approach_id');
			$mealApproachSubOpt= $this->_dietmodel->GetMealSubApproach($meal_approach_id);

			?>
			<select id="meal-approach-sub-opt" name="meal-approach-sub-opt" class="form-control select2" >
				<option value="0">Select</option>
				<?php 
				
					foreach($mealApproachSubOpt as $meal_sub_opt)
					{ ?>
						<option value="<?php echo $meal_sub_opt->id; ?>"><?php echo $meal_sub_opt->meal_approach_sub; ?></option>
			<?php	}
	
				?>
			</select>
			<?php
		}
		else
		{
			redirect('admin','refresh');
		}

	}

	public function mealapproachSubDetailOptions(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$meal_approach_sub_id = $this->input->post('meal_approach_sub_id');
			$mealApproachSubDetailOpt= $this->_dietmodel->GetMealSubDetailApproach($meal_approach_sub_id);

			?>
			<select id="meal-approach-sub-detail-opt" name="meal-approach-sub-detail-opt" class="form-control select2" >
				<option value="0">Select</option>
				<?php 
				
					foreach($mealApproachSubDetailOpt as $meal_sub_detail_opt)
					{ ?>
						<option value="<?php echo $meal_sub_detail_opt->id; ?>">
						<?php echo $meal_sub_detail_opt->meal_approach_sub_detail; ?></option>
			<?php	}
	
				?>
			</select>
			<?php
		}
		else
		{
			redirect('admin','refresh');
		}

	}


		public function zigzagapproachcalculation(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{

            $company_id=$session['companyid'];
			$meal_approach_dtl_id = trim($this->input->post('aproach_dtl_id'));
			$weight = trim($this->input->post('weight')); 
			$final_calorie_req = trim($this->input->post('final_calorie_req')); 

			$meal_approach_sub_dtl = $this->_dietmodel->GetMealSubDetailApproachByID($meal_approach_dtl_id);
			
		    $operation = $meal_approach_sub_dtl->add_reduce;
			$calorie_for_cal = $meal_approach_sub_dtl->calorie_val;
				
			
			
			$weight_in_pound = $weight*2.20462;
			$calorie_margin = $weight_in_pound*$calorie_for_cal;
			$finlcal_req_zigzag = 0;
			$add_reduce_text = "";
			if($operation=="ADD")
			{
				$finlcal_req_zigzag = $final_calorie_req+$calorie_margin;
				$add_reduce_text = " Added ".number_format($calorie_margin,3)." Calories";
			}
			if($operation=="REDUCE")
			{
				$finlcal_req_zigzag = $final_calorie_req-$calorie_margin;
				$add_reduce_text = " Reduced ".number_format($calorie_margin,3)." Calories";
			}
			
			
			$json_response = array(
				"calorie_margin" =>number_format($calorie_margin,5,'.', ''), 
				"calorie_req_finlly_zig_zag" =>number_format($finlcal_req_zigzag,5,'.', ''),
				"operation" => $operation,
				"result_info" => $add_reduce_text
			);



		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }

		public function proteinCalculator(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
			$mobile_no = trim($this->input->post('mobile'));
            $company_id=$session['companyid'];

				$need_factor_id = trim($this->input->post('nfid'));
				$weight = trim($this->input->post('weight'));
				$bfpercentg = trim($this->input->post('bfpercentg')); 
				
				$rowGetNeedFactor = $this->_dietmodel->getNeddFactorById($need_factor_id);
				$nedd_factor_val = $rowGetNeedFactor->need_factor;
	
				$json_response = array(
					"protein_req" => $this->getProteinReqinGrm($weight,$bfpercentg,$nedd_factor_val)
				);
				
				
 		


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


		public function getFoodList(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
		
            $company_id=$session['companyid'];

			$gifrom = "";
			$gito = "";
			
			$foodType = $_POST['fdtype']; 
			$foodCategory = $_POST['fdcat']; 
			
			if(isset($_POST['gifrm']))
			{
				$gifrom = $_POST['gifrm']; 
			}
			if(isset($_POST['gito']))
			{
				$gito = $_POST['gito']; 
			}

				$rowGetFoodByCategory = $this->_dietmodel->GetFoodByTypeAndCategory($foodType,$foodCategory,$gifrom,$gito);
	
				$value = array();
				$name = array();
				
				foreach($rowGetFoodByCategory as $food)
				{
					$value[] = $food->foodID; 
					$name[] = $food->foodName;
				}
				
				
				
				
				
				$json_response = array(
					"foodid" => $value,
					"foodname" => $name
				);
 		
         

		header('Content-Type: application/json');
		echo json_encode($json_response);
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }

	function getProteinReqinGrm($weight,$bfpercentg,$nedd_factor_val)
	{
		$weight_in_pound = 0;
		$fat_percen_val = 0;
		$pound_of_fat = 0;
		$pound_of_muscle = 0;
		$total_protein_req = 0;
		
		$weight_in_pound = $weight*2.20462;
		$fat_percen_val = $bfpercentg/100;
		$pound_of_fat = $weight_in_pound*$fat_percen_val;
		$pound_of_muscle = $weight_in_pound-$pound_of_fat;
		$total_protein_req = $pound_of_muscle * $nedd_factor_val;
		
		return number_format($total_protein_req,3);
	}


	public function addFoodDetailRow(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
				$data['mealno'] = $_POST['meal_no'];
				$data['food_id'] = $_POST['food_id'];
				$qty_req = $_POST['qty'];
				$data['qty_req'] = $_POST['qty'];
				
				$data['instruction'] = $_POST['instruction'];
				$data['row'] = $_POST['row'];
				
				$food_master = $this->_dietmodel->GetFoodMasterById($data['food_id']);
				
					$data['food_name'] = $food_master->foodName; 
					$data['calorie'] = $food_master->calorie; 
					$data['qty'] = $food_master->food_qty; 
					$data['protein'] = $food_master->protein; 
					$data['carbo'] = $food_master->carbohydrate; 
					$data['fat'] = $food_master->fat; 
					$data['unit'] = $food_master->unit_name;
					$data['unitID'] = $food_master->diet_unit_id;
				
				
				$data['calorie_given'] = $this->calCalorieReq($data['calorie'],$data['qty'],$data['qty_req']);
				$data['protein_given'] = $this->calProteinReq($data['protein'],$data['qty'],$data['qty_req']);
				$data['carbo_given'] = $this->calCarboReq($data['carbo'],$data['qty'],$data['qty_req']);
				$data['fat_given'] = $this->calFatReq($data['fat'],$data['qty'],$data['qty_req']);


				  
       $page = 'dashboard/diet/prepare/add_food_details_partial_view.php';  
      $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}


	public function getOtherAssistncSupplement(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
		
            $company_id=$session['companyid'];

			$category = $_POST['catgId'];

			$rowGetOtherAssistncSupllement = $this->_dietmodel->getOtherAssistncSupllement($category);

			$otherSupllmntID = array();
			$otherSupllFoodName = array();
			foreach($rowGetOtherAssistncSupllement as $other_assistnc)
			{
				$otherSupllmntID[] = $other_assistnc->id;
				$otherSupllFoodName[] = $other_assistnc->supplement_name;
			}

			$json_response = array(
				"otherSupllementID" => $otherSupllmntID,
				"otherSupllementName" => $otherSupllFoodName
			);

         

		header('Content-Type: application/json');
		echo json_encode($json_response);
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


		public function getOtherAssistanceUnit(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
		
            $company_id=$session['companyid'];

				$supllementId = $_POST['splmntId'];
				$unit_dtl = $this->_dietmodel->getOtherAssistanceUnitBySupllmentId($supllementId);
				
				$unitname = "";
				$unitID="";
				if($unit_dtl)
				{
					$unitID = $unit_dtl->unitID;
					$unitname = $unit_dtl->unit_name;
				}
				
				$json_response = array(
					"unitID" => $unitID,
					"unitname" => $unitname
				);
				
		header('Content-Type: application/json');
		echo json_encode($json_response);
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


		public function addOtherAssistanceItem(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{

			$data['category'] = $_POST['category'];
			$data['supplmntID'] = $_POST['supplmntID'];
			$data['servingsize'] = $_POST['servingSize'];
			$data['unitId'] = $_POST['unitId'];
			$data['advice'] = $_POST['advice'];
			$data['row'] = $_POST['row'];


			$suplmt_dtl= $this->_dietmodel->getOtherAssistncSupllementDetail($data['supplmntID']);
			
				$data['suplmntCatg'] = $suplmt_dtl->othr_assistnc_name;
				$data['suplmntName'] = $suplmt_dtl->supplement_name;
				$data['suplmntUnit']= $suplmt_dtl->unit_name;
			
			
       $page = 'dashboard/diet/prepare/other_assistance_item_partial_view.php';  
      $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}

	public function supplementComponents(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{

			$data['splmntId'] = $_POST['splmntId'];

		$where = array('other_assistance_master.id'=>$data['splmntId']);
       $assistanceData = $this->commondatamodel->getSingleRowByWhereCls('other_assistance_master',$where);
		
		$data['splmntName'] =$assistanceData->supplement_name;
		$data['supplement_remarks'] =$assistanceData->supplement_remarks;
		
		$data['componentList'] = $this->_dietmodel->GetOtherAssistanceDetail($data['splmntId']);
		//pre($data);exit;
       $page = 'dashboard/diet/prepare/supplement_components_partial_view.php';  
      $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}

	public function memberMedicalInfo(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
		    $company_id=$session['companyid'];

			$mobile = $_POST['mobile'];
			$data['medicalData'] = $this->_dietmodel->memberMedicalInformation($mobile,$company_id);
       $page = 'dashboard/diet/prepare/member_medical_info_partial_view.php'; 
       
      $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}

	public function memberBloodTestList(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
		    $company_id=$session['companyid'];

			$member_ac_code = $_POST['member_ac_code'];
		    $data['rowBloodReport'] = $this->_dietmodel->getBloodReportData($member_ac_code);
		    $data['rowBloodTest'] = $this->_dietmodel->getBloodTestList();

		  // pre($data['rowBloodTest']);exit;
		  

       
	       $page = 'dashboard/diet/prepare/member_blood_test_partial_view.php';  
      $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}


		public function memberHavInformation(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
		    $company_id=$session['companyid'];

			$mobile_no = $_POST['mobile'];
		    $where_mem = array('mobile_no' => $mobile_no );
		    $data['hav'] = $this->_dietmodel->getLastHavDataByMobile($mobile_no);
			//pre($data['hav']);exit;
	        $page = 'dashboard/diet/prepare/member_hav_partial_view.php';  
            $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}

		/*----------Calculate ----------*/
	
	function calCalorieReq($calorie,$qty,$qty_req)
	{
		$cal_req = 0;
		$cal_req = ($calorie*$qty_req)/$qty;
		return number_format($cal_req,3,'.','');
	}
	function calProteinReq($protein,$qty,$qty_req)
	{
		$protein_req = 0;
		$protein_req = ($protein*$qty_req)/$qty;
		return number_format($protein_req,3,'.','');
	}
	function calCarboReq($carbo,$qty,$qty_req)
	{
		$carbo_req = 0;
		$carbo_req = ($carbo*$qty_req)/$qty;
		return number_format($carbo_req,3,'.','');
	}
	function calFatReq($fat,$qty,$qty_req)
	{
		$fat_req = 0;
		$fat_req = ($fat*$qty_req)/$qty;
		return number_format($fat_req,3,'.','');
		
	}


	
  public function diet_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
        
       // $dietId = $this->input->post('dietId');
	$mealData = $_POST['formData'];
	parse_str($mealData, $data);
	//pre($data);exit;
	$mode = $data['mode'];
	$dietId = $data['dietId'];
	
        $comp=$session['companyid'];

        if ($mode == "ADD" && $dietId == "0") {

			if(sizeof($data)>0 AND $data['final_cal_req']>0)
			{
				
			$meal1 = "";
			$meal2 = "";
			$meal3 = "";
			$meal4 = "";
			$meal5 = "";
			$meal6 = "";
			$meal7 = "";
			$meal8 = "";
			$meal9 = "";
			$meal10 = "";

			 $memberDataList = $this->commondatamodel->GetCurrentPackage($data['mobile'],$comp);

         
          
			if($memberDataList)
			{   $memb_info=$memberDataList[0];

				$membership = $memb_info->MEMBERSHIP_NO;
				$validity = $memb_info->VALIDITY_STRING;
				$member_id = $memb_info->CUS_ID;
				$gender = $memb_info->CUS_SEX;

			}

			$members_meal_master = array();
			$member_meal_detail = array();
			$dietry_managment_data = array();
		
			$members_meal_master = array(
				"meal_date" => date('Y-m-d'),
				"membership_no" => $membership,
				"validity_string" => $validity,
				"gender" => $gender,
				"weight" => $data['weight'],
				"waist" => $data['waist'],
				"activity_level" => $data['activity_lvl'],
				"bodyfatpercent" => $data['bFatPercentage'],
				"bodyfatremarks" => $data['bodyFatRemarks'],
				"bmr_rate" => $data['bmrValue'],
				"calorie_required" => $data['calorieReqOrg'],
				"meal_approach" => $data['meal_approach'],
				"add_or_sub_type" => $data['calrecalOpt'],
				"add_or_sub_value" => $data['geivencal'],
				"final_calorie_req" => $data['final_cal_req'],
				"zig_zag_calorie" => $data['final_cal_req_zig_zag']-$data['final_cal_req'],
				"total_cal_with_zig_zag" => $data['final_cal_req_zig_zag'],
				"protein_need_factor_id" => $data['need_factor'],
				
				"protein_percentage" => $data['protein_per'],
				"carbs_percentage" => $data['carbo_per'],
				"fat_percentage" => $data['fat_per'],
				"protein_gm" => $data['protein_gram'],
				"carbs_gm" => $data['carbo_gram'],
				"fat_gm" => $data['fat_gram'],
				
				"meal_approach_sub_opt" => $data['meal-approach-sub-opt'],
				"meal_approach_sub_detail" => $data['meal-approach-sub-detail-opt'],
				"carbs_new_percentage" => $data['carbo_per_zigzag'],
				"carbs_new_calorie" => $data['carbo_cal_zigzag'],
				"carbs_new_gram" => $data['carbo_gram_zigzag'],
				
				"total_calorie_given" => $data['totalCalorie'],
				"total_protein_given" => $data['totalProtein'],
				"total_carbs_given" => $data['totalCarbs'],
				"total_fat_given" => $data['totalFat'],
				
				"member_remarks" => $data['remarks_members'],
				"dietitian_id" => $data['dietitian_id'],
				"disease_guidlines" =>$data['dtl_diseaseValues'],
				"youtube_videos" =>$data['dtl_youtubeValues'],
				"calculate_by" =>$data['calculate_by'],
				"is_new_soft" => 'Y',
				
			);
            $member_meal_master_id = $this->commondatamodel->insertSingleTableData('members_meal_master',$members_meal_master);
				
	/*	$mealTimeLen = sizeof($data['mealTime']);
		$mealFoodTypeLen = sizeof($data['food_type']);
		$mealFoodCatLen = sizeof($data['food_category']);
		$mealFoodNameLen = sizeof($data['food_select']);
		$mealFoodNameLen = sizeof($data['qty']);
		
		$mealCalorieLen = sizeof($data['calorieSum']);
		$mealProteinLen = sizeof($data['proteinSum']);
		$mealCarbsSum = sizeof($data['carbsSum']);
		$mealfatSum = sizeof($data['fatSum']);*/
		
		$count_loop = sizeof($data['meal']);
		
			for($i=0;$i<$count_loop;$i++)
			{
				if(
					$data['calorieSum'][$i]>0 OR
					$data['proteinSum'][$i]>0 OR 
					$data['carbsSum'][$i]>0 OR 
					$data['fatSum'][$i]>0
				  )
				{
					$member_meal_detail = array(
						"membr_meal_masterid" => $member_meal_master_id,
						"meal_name" => $data['meal'][$i],
						"meal_no" => $data['srl'][$i],
						"meal_time" => ($data['mealTime'][$i] == "" ? NULL : date("Y-m-d H:i:s", strtotime($data['mealTime'][$i]))),
						"meal_calorie_given" => $data['calorieSum'][$i],
						"meal_protein_given" => $data['proteinSum'][$i],
						"meal_carbs_given" => $data['carbsSum'][$i],
						"meal_fat_given" => $data['fatSum'][$i],
						"is_daily_assistance" => $data['isDailyAssistanceMeal'][$i]
					);
					
					//$insert2 = $obj_diet_pln->insertIntoMembersMealDetail($member_meal_detail);
			      $member_meal_dtl_id = $this->commondatamodel->insertSingleTableData('members_meal_detail',$member_meal_detail);
					
					$this->insertMemberFoodDetail($data,$i,$member_meal_dtl_id);
				}
				else
				{
					// Nothing
				}
			}

					/* Other Assistance Insert */
		$other_assistance_supllement = array();
			if(isset($data['otherAssistanceSupplyName']))
			{
				$otherAssistnceSupllymnt = sizeof($data['otherAssistanceSupplyName']);
			}
			else
			{
				$otherAssistnceSupllymnt = 0;
			}
		
		
		
		if($otherAssistnceSupllymnt>0)
		{
			for($j=0;$j<$otherAssistnceSupllymnt;$j++)
			{
				
					$other_assistance_supllement = array(
						"categoryID" => $data['otherAssistanceCategory'][$j],
						"otherAssistncSuplmntID" => $data['otherAssistanceSupplyName'][$j],
						"serving_size" => $data['otherAssistanceServingSize'][$j],
						"unitID" => $data['otherAssistanceUnit'][$j],
						"advice" => $data['otherAssistanceAdvice'][$j],
						"memberMealMasterID" => $member_meal_master_id
						
					);
					
		 $insert4 =$this->commondatamodel->insertSingleTableData('other_assistance_member_meal',$other_assistance_supllement);
			
			}
			
		}




		

			 if(1)
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "Saved successfully",
                            "mode" => "ADD",
                            "mealID" => $member_meal_master_id,
                        );

                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "There is some problem.Try again"
                        );

                    }

			}else{

				 $json_response = array(
                            "msg_status" => 0,
                           
                        );

			}

         
              



        }else{


			/* ------------------------------start of edit ----------------------------- */
			
			$MealEditID = $data['mealMasterID'];
			if(sizeof($data)>0 AND $data['final_cal_req']>0)
			{
				 $memberDataList = $this->commondatamodel->GetCurrentPackage($data['mobile'],$comp);

				if($memberDataList)
				{   $memb_info=$memberDataList[0];

					$membership = $memb_info->MEMBERSHIP_NO;
					$validity = $memb_info->VALIDITY_STRING;
					$member_id = $memb_info->CUS_ID;
					$gender = $memb_info->CUS_SEX;

				}

					/*master Data For Table : members_meal_master*/
	
					$members_meal_master = array();
					$member_meal_detail = array();
					
					$members_meal_master = array(
						"membership_no" => $membership,
						"validity_string" => $validity,
						"gender" => $gender,
						"weight" => $data['weight'],
						"waist" => $data['waist'],
						"activity_level" => $data['activity_lvl'],
						"bodyfatpercent" => $data['bFatPercentage'],
						"bodyfatremarks" => $data['bodyFatRemarks'],
						"bmr_rate" => $data['bmrValue'],
						"calorie_required" => $data['calorieReqOrg'],
						"meal_approach" => $data['meal_approach'],
						"add_or_sub_type" => $data['calrecalOpt'],
						"add_or_sub_value" => $data['geivencal'],
						"final_calorie_req" => $data['final_cal_req'],
						"zig_zag_calorie" => $data['final_cal_req_zig_zag']-$data['final_cal_req'],
						"total_cal_with_zig_zag" => $data['final_cal_req_zig_zag'],
						"protein_need_factor_id" => $data['need_factor'],
						
						"protein_percentage" => $data['protein_per'],
						"carbs_percentage" => $data['carbo_per'],
						"fat_percentage" => $data['fat_per'],
						"protein_gm" => $data['protein_gram'],
						"carbs_gm" => $data['carbo_gram'],
						"fat_gm" => $data['fat_gram'],
						
						"meal_approach_sub_opt" => $data['meal-approach-sub-opt'],
						"meal_approach_sub_detail" => $data['meal-approach-sub-detail-opt'],
						"carbs_new_percentage" => $data['carbo_per_zigzag'],
						"carbs_new_calorie" => $data['carbo_cal_zigzag'],
						"carbs_new_gram" => $data['carbo_gram_zigzag'],
						
						"total_calorie_given" => $data['totalCalorie'],
						"total_protein_given" => $data['totalProtein'],
						"total_carbs_given" => $data['totalCarbs'],
						"total_fat_given" => $data['totalFat'],
						
						"member_remarks" => $data['remarks_members'],
						"is_modified"=>'Y',
						"modify_date"=>date("Y-m-d"),
						"dietitian_id" => $data['dietitian_id'],
						"disease_guidlines" =>$data['dtl_diseaseValues'],
						"youtube_videos" =>$data['dtl_youtubeValues'],
						
						
					);

						
				  $where_upd_mst = array('members_meal_master.id'=>$MealEditID);
				  $update = $this->commondatamodel->updateSingleTableData('members_meal_master',$members_meal_master,$where_upd_mst);
				  $member_meal_master_id = $MealEditID;

				  /* delete data if edit mode */
					if($MealEditID>0)
					{
						
						
						/*delete food detail data Table : mem_meal_food_detail*/
						$rowFoodDetailData = $this->_dietmodel->getMemberFoodDtlInfo($MealEditID);
						foreach($rowFoodDetailData as $foodDtl_data)
						{
							$delete =  $this->deleteFoodDetailRecord($foodDtl_data->memFoodDtlID);
						}
						
						/* delete member meal detail data Table : members_meal_detail */
						
						$delete2 =  $this->deleteMemberMealDetailRecord($MealEditID);
						
						
					}

					$count_loop = count($data['meal']);
					for($i=0;$i<$count_loop;$i++)
					{
						if(
							$data['calorieSum'][$i]>0 OR
							$data['proteinSum'][$i]>0 OR 
							$data['carbsSum'][$i]>0 OR 
							$data['fatSum'][$i]>0
						)
						{
							$member_meal_detail = array(
								"membr_meal_masterid" => $member_meal_master_id,
								"meal_name" => $data['meal'][$i],
								"meal_no" => $data['srl'][$i],
								"meal_time" => ($data['mealTime'][$i] == "" ? NULL : date("Y-m-d H:i:s", strtotime($data['mealTime'][$i]))),
								"meal_calorie_given" => $data['calorieSum'][$i],
								"meal_protein_given" => $data['proteinSum'][$i],
								"meal_carbs_given" => $data['carbsSum'][$i],
								"meal_fat_given" => $data['fatSum'][$i],
								"is_daily_assistance" => $data['isDailyAssistanceMeal'][$i]
							);
						
							$member_meal_dtl_id = $this->commondatamodel->insertSingleTableData('members_meal_detail',$member_meal_detail);
							
							$this->insertMemberFoodDetail($data,$i,$member_meal_dtl_id);
							      
						}
						
					}

						/* Other Assistance Insert*/
						$other_assistance_supllement = array();
							if(isset($data['otherAssistanceSupplyName']))
							{
								$otherAssistnceSupllymnt = sizeof($data['otherAssistanceSupplyName']);
							}
							else
							{
								$otherAssistnceSupllymnt = 0;
							}
						
						/* delete data if edit mode */
							if($MealEditID>0)
							{
								// delete member meal detail data Table : other_assistance_member_meal
								$delete =  $this->deleteMemberMealotherAssistanceRecord($MealEditID);
							}

									if($otherAssistnceSupllymnt>0)
									{
							
										for($j=0;$j<$otherAssistnceSupllymnt;$j++)
										{
												$other_assistance_supllement = array(
													"categoryID" => $data['otherAssistanceCategory'][$j],
													"otherAssistncSuplmntID" => $data['otherAssistanceSupplyName'][$j],
													"serving_size" => $data['otherAssistanceServingSize'][$j],
													"unitID" => $data['otherAssistanceUnit'][$j],
													"advice" => $data['otherAssistanceAdvice'][$j],
													"memberMealMasterID" => $member_meal_master_id
													
												);
											 $insert4 =$this->commondatamodel->insertSingleTableData('other_assistance_member_meal',$other_assistance_supllement);	
											
										}
										
									}



			}
	

			/* ------------------------------end of edit ----------------------------- */

           
               if(1)
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "Updated successfully",
                            "mode" => "EDIT",
                            "mealMasterID" => $MealEditID,
                        );

                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "There is some problem.Try again"
                        );

                    }



            

        }


            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;

   }else
		{
			redirect('login','refresh');
        }
        
  }



  	function insertMemberFoodDetail($data,$i,$detailId)
	{
		$member_food_detail = array();
		
		// Creating Index for Food detail
		
		$FoodStartIndex = ($i+1); // Because First Food Index is Like FoodID_1 ( Where 1 is meal no .Meal no can not be zero ) instead of FoodID_0. 
		
		$foodIndex = "foodID_".$FoodStartIndex;
		$qtyIndex = "qtyGiven_".$FoodStartIndex;
		$unitIndex = "UnitGiven_".$FoodStartIndex;
		$caloriIndex = "calorieGiven_".$FoodStartIndex;
		$proteinIndex = "proteinGiven_".$FoodStartIndex;
		$carbsIndex = "carboGiven_".$FoodStartIndex;
		$fatIndex = "fatGiven_".$FoodStartIndex;
		$instructionIndex = "instructionGiven_".$FoodStartIndex;
		
		$FoodCount = count($data[$foodIndex]);
		
			
		
		for($k=0;$k<$FoodCount;$k++)
		{
			$member_food_detail = array(
				"member_meal_dtlid" => $detailId,
				"diet_food_id" => $data[$foodIndex][$k],
				"food_qty" => $data[$qtyIndex][$k],
				"food_unit_id" => $data[$unitIndex][$k],
				"calorie" => $data[$caloriIndex][$k],
				"protein_grams" => $data[$proteinIndex][$k],
				"carbs_grams" => $data[$carbsIndex][$k],
				"fat_grams" => $data[$fatIndex][$k],
				"instruction_daily_assistance" =>($data[$instructionIndex][$k] == "" ? NULL : $data[$instructionIndex][$k])
			);
			
			//$insert3 = $obj_diet_pln->insertIntoMembersFoodMealDetail($member_food_detail);
			$insert3=$this->commondatamodel->insertSingleTableData('mem_meal_food_detail',$member_food_detail);
		}
	}

	function insertMemberFoodDetailForCopy($data,$detailId)
	{
		$member_food_detail = array();
			$member_meal_dtlid = 0;
			$diet_food_id = 0;
			$food_qty = 0;
			$food_unit_id = 0;
			$calorie = 0;
			$protein_grams = 0;
			$carbs_grams = 0;
			$fat_grams = 0;
			$instruction_daily_assistance = "";		
		foreach($data as $food_meal_copy)
		{
			$diet_food_id = $food_meal_copy->diet_food_id;
			$food_qty = $food_meal_copy->food_qty;
			$food_unit_id = $food_meal_copy->food_unit_id;
			$calorie = $food_meal_copy->calorie;
			$protein_grams = $food_meal_copy->protein_grams;
			$carbs_grams = $food_meal_copy->carbs_grams;
			$fat_grams = $food_meal_copy->fat_grams;
			$instruction_daily_assistance = $food_meal_copy->instruction_daily_assistance;
			
				$member_food_detail = array(
				"member_meal_dtlid" => $detailId,
				"diet_food_id" => $diet_food_id,
				"food_qty" => $food_qty,
				"food_unit_id" => $food_unit_id,
				"calorie" => $calorie,
				"protein_grams" => $protein_grams,
				"carbs_grams" => $carbs_grams,
				"fat_grams" => $fat_grams,
				"instruction_daily_assistance" => $instruction_daily_assistance
			);
			$insert3=$this->commondatamodel->insertSingleTableData('mem_meal_food_detail',$member_food_detail);
			
		}




		
		
			
			
	}



		public function bloodtest_action(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			
			$collectiont_dt = trim($this->input->post('collectiont_dt'));
			$sel_blood_test = trim($this->input->post('sel_blood_test'));
			$txtQty = trim($this->input->post('txtQty'));
			$member_acc_code = trim($this->input->post('member_acc_code'));
			$mobile_no = trim($this->input->post('mobile'));
			$test_notes = trim($this->input->post('test_notes'));

			   if($collectiont_dt!=""){
                $collectiont_dt = str_replace('/', '-', $collectiont_dt);
                $collectiont_dt = date("Y-m-d",strtotime($collectiont_dt));
 
             }
             else{
                 $collectiont_dt = NULL;
                
                
             }
			
			
            $company_id=$session['companyid'];
			$year_id=$session['yearid'];
			$user_id=$session['userid'];
			$memberDataList = $this->commondatamodel->GetCurrentPackage($mobile_no,$company_id);

    
          
			if($memberDataList)
			{   $memb_info=$memberDataList[0];

				$membership = $memb_info->MEMBERSHIP_NO;
				$validity = $memb_info->VALIDITY_STRING;
				$member_id = $memb_info->CUS_ID;
				$gender = $memb_info->CUS_SEX;
				$card_cd = $memb_info->CUS_CARD;
				$branch_cd = $memb_info->CUS_BRANCH;

			}

						$insert_fields_arr['date_of_entry']=date("Y-m-d");
						$insert_fields_arr['date_of_collection']=$collectiont_dt;
						$insert_fields_arr['member_id']=$member_id;
						$insert_fields_arr['membership_no']=$membership;
						$insert_fields_arr['test_id']=$sel_blood_test;
						$insert_fields_arr['reading']=$txtQty;
						$insert_fields_arr['validity_string']=$validity;
						$insert_fields_arr['branch_code']=$branch_cd;
						$insert_fields_arr['card_code']=$card_cd;

						$insert_fields_arr['user_id']=$user_id;
						$insert_fields_arr['fin_id']=$year_id;
						$insert_fields_arr['complimentary_id']=0;
						$insert_fields_arr['note']=$test_notes;
						$insert_fields_arr['member_acc_code']=$member_acc_code;
			

		
      $master_id = $this->commondatamodel->insertSingleTableData('blood_test',$insert_fields_arr);
				

         
          
			if($master_id)
			{  
               
				$json_response = array(
                    "msg_status" => 1,
					"msg_data" => "Data saved successfully."
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "No Data"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


public function preview()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $data['companyID']=$session['companyid'];
      
      
       
        $data['view_file'] = 'dashboard/diet/prepare/member_diet_preview.php';         
        $this->template->admin_template($data);
     
    }else{
        redirect('admin','refresh');
    }


 }	

 public function getMemberDietPreviewList(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  

      $mobile_no =  $this->input->post('mobile_no');
      $company_id=$session['companyid'];
      $page = 'dashboard/diet/prepare/member_diet_preview_partial_view.php';  
      $data['rowMembrshpList']  = $this->_dietmodel->GetAllMemberMealListByMbl($mobile_no);
    
        
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}

public function membersdiet()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $data['companyID']=$session['companyid'];
      
      
        $data['rowBranch'] = $this->reg_model->getAllBranch($data['companyID']); 
        $data['view_file'] = 'dashboard/diet/prepare/members_diet_view';         
        $this->template->admin_template($data);
     
    }else{
        redirect('admin','refresh');
    }


 }


 
public function getMembersDietList()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   $result=[];
        $company_id=$session['companyid'];
        $mobileno = $_POST['mobileno'];
		$result['mobileno']=$mobileno;
        $fromDt = date('Y-m-d',strtotime($_POST['frmDt']));
		$result['fromDt']=$fromDt;
        $toDate = date('Y-m-d',strtotime($_POST['toDt']));
		$result['toDate']=$toDate;
        $branch_code = $_POST['branch'];
        
        if($mobileno!="")
        {
            $result['rowMemberDietResult'] = $this->_dietmodel->GetAllMemberMealListByMbl($mobileno);;
        }
        else
        {
            $result['rowMemberDietResult'] = $this->_dietmodel->GetMembersDietList($fromDt,$toDate,$branch_code,$company_id);

        }

     // pre($result['rowMemberDietResult']);exit;

        $page = 'dashboard/diet/prepare/members_diet_list_partial_view';     
           
        $display = $this->load->view($page,$result,TRUE);
        echo $display;

    }else{
        redirect('admin','refresh');
    }


 }


 public function makeDuplicateDiet()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   $result=[];
        $company_id=$session['companyid'];
        $mealmastID = $_POST['mealmastID'];
		$mealMasterID =  $mealmastID;

        $mealDt = $_POST['mealDt'];
		$mealDt = date('Y-m-d',strtotime($_POST['mealDt']));
		/* Step:1 */
		$copied_from_meal_master_data = $this->_dietmodel->getMemberMasterDietDesignData($mealmastID);

	
		//$meal_date = $copied_from_meal_master_data['meal_date'];
		$membership_no = $copied_from_meal_master_data->membership_no;
		$validity_string = $copied_from_meal_master_data->validity_string;
		$gender = $copied_from_meal_master_data->gender;
		$weight = $copied_from_meal_master_data->weight;
		$waist = $copied_from_meal_master_data->waist;
		$activity_level = $copied_from_meal_master_data->activity_level;
		$bodyfatpercent = $copied_from_meal_master_data->bodyfatpercent;
		$bodyfatremarks = $copied_from_meal_master_data->bodyfatremarks;
		$bmr_rate = $copied_from_meal_master_data->bmr_rate;
		$calorie_required = $copied_from_meal_master_data->calorie_required;
		$meal_approach = $copied_from_meal_master_data->meal_approach;
		$add_or_sub_type = $copied_from_meal_master_data->add_or_sub_type;
		$add_or_sub_value = $copied_from_meal_master_data->add_or_sub_value;
		$final_calorie_req = $copied_from_meal_master_data->final_calorie_req;
		$zig_zag_calorie = $copied_from_meal_master_data->zig_zag_calorie;
		$total_cal_with_zig_zag = $copied_from_meal_master_data->total_cal_with_zig_zag;
		$protein_need_factor_id = $copied_from_meal_master_data->protein_need_factor_id;
		$protein_percentage = $copied_from_meal_master_data->protein_percentage;
		$carbs_percentage = $copied_from_meal_master_data->carbs_percentage;
		$fat_percentage = $copied_from_meal_master_data->fat_percentage;
		$protein_gm = $copied_from_meal_master_data->protein_gm;
		$carbs_gm = $copied_from_meal_master_data->carbs_gm;
		$fat_gm = $copied_from_meal_master_data->fat_gm;
		$meal_approach_sub_opt = $copied_from_meal_master_data->meal_approach_sub_opt;
		$meal_approach_sub_detail = $copied_from_meal_master_data->meal_approach_sub_detail;
		$carbs_new_percentage = $copied_from_meal_master_data->carbs_new_percentage;
		$carbs_new_calorie = $copied_from_meal_master_data->carbs_new_calorie;
		$carbs_new_gram = $copied_from_meal_master_data->carbs_new_gram;
		$total_calorie_given = $copied_from_meal_master_data->total_calorie_given;
		$total_protein_given = $copied_from_meal_master_data->total_protein_given;
		$total_carbs_given = $copied_from_meal_master_data->total_carbs_given;
		$total_fat_given = $copied_from_meal_master_data->total_fat_given;
		$member_remarks = $copied_from_meal_master_data->member_remarks;
		$disease_guidline = $copied_from_meal_master_data->disease_guidlines;
		$youtube_videos = $copied_from_meal_master_data->youtube_videos;
		$dietitian_id = $copied_from_meal_master_data->dietitian_id;
		$is_new_soft = $copied_from_meal_master_data->is_new_soft;
		$calculate_by = $copied_from_meal_master_data->calculate_by;

		
	$members_meal_master = array(
			"meal_date" => $mealDt,
			"membership_no" => $membership_no,
			"validity_string" => $validity_string,
			"gender" => $gender,
			"weight" => $weight,
			"waist" => $waist,
			"activity_level" => $activity_level,
			"bodyfatpercent" => $bodyfatpercent,
			"bodyfatremarks" => $bodyfatremarks,
			"bmr_rate" => $bmr_rate,
			"calorie_required" => $calorie_required,
			"meal_approach" => $meal_approach,
			"add_or_sub_type" => $add_or_sub_type,
			"add_or_sub_value" => $add_or_sub_value,
			"final_calorie_req" => $final_calorie_req,
			"zig_zag_calorie" => $zig_zag_calorie,
			"total_cal_with_zig_zag" => $total_cal_with_zig_zag,
			"protein_need_factor_id" => $protein_need_factor_id,
			
			"protein_percentage" => $protein_percentage,
			"carbs_percentage" => $carbs_percentage,
			"fat_percentage" => $fat_percentage,
			"protein_gm" => $protein_gm,
			"carbs_gm" => $carbs_gm,
			"fat_gm" => $fat_gm,
			
			"meal_approach_sub_opt" => $meal_approach_sub_opt,
			"meal_approach_sub_detail" => $meal_approach_sub_detail,
			"carbs_new_percentage" => $carbs_new_percentage,
			"carbs_new_calorie" => $carbs_new_calorie,
			"carbs_new_gram" => $carbs_new_gram,
			
			"total_calorie_given" => $total_calorie_given,
			"total_protein_given" => $total_protein_given,
			"total_carbs_given" => $total_carbs_given,
			"total_fat_given" => $total_fat_given,
			"member_remarks" => $member_remarks,
			
			"copy_date"=>date("Y-m-d"),
			"copy_from_mealID"=>$mealMasterID,
			"is_copied"=>'Y',
			"is_modified"=>'N',
			"modify_date"=>NULL,
			"dietitian_id"=>$dietitian_id,			
			"disease_guidlines"=>$disease_guidline,			
			"youtube_videos"=>$$youtube_videos,			
			"is_new_soft"=>$is_new_soft,			
			"calculate_by"=>$calculate_by,			
		);

		   $member_meal_master_id = $this->commondatamodel->insertSingleTableData('members_meal_master',$members_meal_master);
	
		
		//Step 2: ---- member_meal_detail table
		$rowCopiedFromDetailMealData = $this->_dietmodel->GetMemberMealDetail($mealMasterID);
		$member_meal_detail = array();
			$membr_meal_masterid = 0;
			$meal_name = "";
			$meal_no = 0;
			$meal_time = "";
			$meal_calorie_given = 0;
			$meal_protein_given = 0;
			$meal_carbs_given = 0;
			$meal_fat_given = 0;
			$is_daily_assistance = "N";
		
		foreach($rowCopiedFromDetailMealData as $row_meal_detail_copy)
		{
			$previous_meal_detail_id = $row_meal_detail_copy->id;
			$meal_name = $row_meal_detail_copy->meal_name;
			$meal_no = $row_meal_detail_copy->meal_no;
			$meal_time = $row_meal_detail_copy->meal_time;
			$meal_calorie_given = $row_meal_detail_copy->meal_calorie_given;
			$meal_protein_given = $row_meal_detail_copy->meal_protein_given;
			$meal_carbs_given = $row_meal_detail_copy->meal_carbs_given;
			$meal_fat_given = $row_meal_detail_copy->meal_fat_given;
			$is_daily_assistance = $row_meal_detail_copy->is_daily_assistance;
			
				$member_meal_detail = array(
					"membr_meal_masterid" => $member_meal_master_id,
					"meal_name" => $meal_name,
					"meal_no" => $meal_no,
					"meal_time" => $meal_time,
					"meal_calorie_given" => $meal_calorie_given,
					"meal_protein_given" => $meal_protein_given,
					"meal_carbs_given" => $meal_carbs_given,
					"meal_fat_given" => $meal_fat_given,
					"is_daily_assistance" => $is_daily_assistance
				);
				
				

			$member_meal_dtl_id = $this->commondatamodel->insertSingleTableData('members_meal_detail',$member_meal_detail);
					
				//	$this->insertMemberFoodDetail($data,$i,$member_meal_dtl_id);

				
				
				/* Step : 3 -- mem_meal_food_detail Table */
				$rowMemFoodDetailFromCopydata = $this->_dietmodel->GetMemberFoodDtlForCopy($previous_meal_detail_id);
				$insert3 = $this->insertMemberFoodDetailForCopy($rowMemFoodDetailFromCopydata,$member_meal_dtl_id);
		}
		
		
		/* Step 4 : ---
		 Other Assistance Insert
		 $other_assistance_supllement = array();*/
		 
		 $rowCopiedFromOtherAssistanceMealDtl = $this->_dietmodel->GetOtherassistanceDataByMealmastId($mealMasterID);
		 
			$categoryID = 0;
			$otherAssistncSuplmntID = 0;
			$serving_size = 0;
			$unitID = 0;
			$advice = "";
			
		foreach($rowCopiedFromOtherAssistanceMealDtl as $other_assistance_meal_copy)
		{
			$categoryID = $other_assistance_meal_copy->categoryID;
			$otherAssistncSuplmntID = $other_assistance_meal_copy->otherAssistncSuplmntID;
			$serving_size = $other_assistance_meal_copy->serving_size;
			$unitID = $other_assistance_meal_copy->unitID;
			$advice = $other_assistance_meal_copy->advice;
			
				
				$other_assistance_supllement = array(
					"categoryID" => $categoryID,
					"otherAssistncSuplmntID" => $otherAssistncSuplmntID,
					"serving_size" => $serving_size,
					"unitID" => $unitID,
					"advice" => $advice,
					"memberMealMasterID" => $member_meal_master_id
					
				);
					
		  $insert4 =$this->commondatamodel->insertSingleTableData('other_assistance_member_meal',$other_assistance_supllement);
		
	 }
		
		error_reporting(E_ALL);
		echo "1";
	
       

    }else{
        redirect('admin','refresh');
    }


 }

 function getCalorieByPercentage($total_cal,$percentage)
	{
		$calorie = 0;
		$calorie = $total_cal*$percentage/100;
		$calorie = number_format($calorie,3);
		return $calorie;
		
	}


	

function deleteMemberMealDetailRecord($delId){
 
      $where = array('members_meal_detail.membr_meal_masterid' => $delId);
      $this->commondatamodel->deleteTableData('members_meal_detail',$where);
}

function deleteMemberMealotherAssistanceRecord($delId){
 
      $where = array('other_assistance_member_meal.memberMealMasterID' => $delId);
      $this->commondatamodel->deleteTableData('other_assistance_member_meal',$where);
}

function deleteMemberMealMasterRecord($delId){
 
      $where = array('members_meal_master.id' => $delId);
      $this->commondatamodel->deleteTableData('members_meal_master',$where);
}

function deleteFoodDetailRecord($delId){
 
      $where = array('mem_meal_food_detail.id' => $delId);
      $this->commondatamodel->deleteTableData('mem_meal_food_detail',$where);
}


	public function setSessionToCookie(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{

          if(!isset($_COOKIE['umetainfo'])) {
			  setcookie("umetainfo", "", time() - 3600);
			  //setcookie('umetainfo', json_encode($session), time()+86400);
			  $cookie_name = "umetainfo";
				$cookie_value =  json_encode($session);
				setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/");
			  $json_response = array(
                    "msg_status" => 1,
					
				);

            }else{
				$json_response = array(
                    "msg_status" => 0,
					
				);

			}
		  
			
			


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


		public function deleteDiet(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{

			$mealMasterID = trim($this->input->post('mealMasterID'));
			/* delete from table--------
			*1.mem_meal_food_detail
			*2.members_meal_detail
			*3.other_assistance_member_meal
			*4.members_meal_master
			*/
				
			// delete food detail data Table : mem_meal_food_detail
			$rowFoodDetailData = $this->_dietmodel->getMemberFoodDtlInfo($mealMasterID);
			foreach($rowFoodDetailData as $foodDtl_data)
			{
				$delete1 =  $this->deleteFoodDetailRecord($foodDtl_data->memFoodDtlID);
			}
			
			// delete member meal detail data Table : members_meal_detail
			
			$delete2 =  $this->deleteMemberMealDetailRecord($mealMasterID);
			$delete3 =  $this->deleteMemberMealotherAssistanceRecord($mealMasterID);
			$delete4 =  $this->deleteMemberMealMasterRecord($mealMasterID);
							
	    	$json_response = array(
							"msg_status" => 1,
							
						);

		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


public function printdiet(){
 
  $data['mealID'] = $this->uri->segment(4);     


  $page = 'dashboard/diet/prepare/print_diet.php';
  echo $this->load->view($page,$data);
		


  }




}/* end of class */