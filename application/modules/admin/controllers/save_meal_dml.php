<?php 
session_start();
if(empty($_SESSION['YID']))
	{
	   echo '<script>window.location.href="logout.php";</script>';
	   exit();
	}
	include ('system/database.php');
	include ('system/Zebra_Pagination.php');
	include ('diet_plan_managment_cls.php');
	include ('disp.reg.cls.php');
	/*
	$database_obj=new clsConnection();
	$dbCon=$database_obj->getConnection();
	$conn = $dbCon->_connectionID;
	*/
	
	$obj_diet_pln = new diet_plan_manag();
	$obj_reg_inc = new reg_inc();
	
	$mealData = $_POST['formData'];
	parse_str($mealData, $data);
	
	/*
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	*/
	
$comp = $_SESSION['COMPANY'];	
	
	
	
	
	
	
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
	
	
		
		$rowCurenttPackage = $obj_reg_inc->GetCurrentPackage($data['mobile'],$comp);
		foreach($rowCurenttPackage as $memb_info)
		{
			$membership = $memb_info['MEMBERSHIP_NO'];
			$validity = $memb_info['VALIDITY_STRING'];
			$member_id = $memb_info['CUS_ID'];
			$gender = $memb_info['CUS_SEX'];
		}
		
		
		
		// master Data For Table : members_meal_master
	
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
			"disease_guidlines" =>$data['dtl_diseaseValues']
			
		);
	
		$insert1 = $obj_diet_pln->insertIntoMembersMealMaster($members_meal_master);
		//$member_meal_master_id = mysql_insert_id();
		$member_meal_master_id = $insert1;
		//$member_meal_master_id = 0;
		
		
		///Table diet_management
		
/* 	if(isset($data['Meal_1']) && $data['Meal_1']=="on"){$meal1 = "Y";}else{ $meal1 = "N"; }
	if(isset($data['Meal_2']) && $data['Meal_2']=="on"){$meal1 = "Y";}else{ $meal2 = "N"; }
	if(isset($data['Meal_3']) && $data['Meal_3']=="on"){$meal1 = "Y";}else{ $meal3 = "N"; }
	if(isset($data['Meal_4']) && $data['Meal_4']=="on"){$meal1 = "Y";}else{ $meal4 = "N"; }
	if(isset($data['Meal_5']) && $data['Meal_5']=="on"){$meal1 = "Y";}else{ $meal5 = "N"; }
	if(isset($data['Meal_6']) && $data['Meal_6']=="on"){$meal1 = "Y";}else{ $meal6 = "N"; }
	if(isset($data['Meal_7']) && $data['Meal_7']=="on"){$meal1 = "Y";}else{ $meal7 = "N"; }
	if(isset($data['Meal_8']) && $data['Meal_8']=="on"){$meal1 = "Y";}else{ $meal8 = "N"; }
	if(isset($data['Meal_9']) && $data['Meal_9']=="on"){$meal1 = "Y";}else{ $meal9 = "N"; }
	if(isset($data['Meal_10']) && $data['Meal_10']=="on"){$meal1 = "Y";}else{ $meal10 = "N"; }
		
		$dietry_managment_data = array(
			"member_id" => $member_id,
			"membership_no" => $membership,
			"date_of_entry" => date('Y-m-d'),
			"date_of_collection" => date('Y-m-d'),
			"meal1" => $meal1,
			"meal2" => $meal2,
			"meal3" => $meal3,
			"meal4" => $meal4,
			"meal5" => $meal5,
			"meal6" => $meal6,
			"meal7" => $meal7,
			"meal8" => $meal8,
			"meal9" => $meal9,
			"meal10" => $meal10,
			"carbs" => $data['carbs_dietry'],
			"protein" => $data['protein_dietry'],
			"weight" => $data['weight'],
			"new_meal_master_id" => $member_meal_master_id
		);
		
		$insert_dietry = $obj_diet_pln->insertIntoDietryManagment($dietry_managment_data); */
		
		$mealTimeLen = sizeof($data['mealTime']);
		$mealFoodTypeLen = sizeof($data['food_type']);
		$mealFoodCatLen = sizeof($data['food_category']);
		$mealFoodNameLen = sizeof($data['food_select']);
		$mealFoodNameLen = sizeof($data['qty']);
		
		$mealCalorieLen = sizeof($data['calorieSum']);
		$mealProteinLen = sizeof($data['proteinSum']);
		$mealCarbsSum = sizeof($data['carbsSum']);
		$mealfatSum = sizeof($data['fatSum']);
		
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
					
					$insert2 = $obj_diet_pln->insertIntoMembersMealDetail($member_meal_detail);
					//$member_meal_dtl_id = mysql_insert_id();
					$member_meal_dtl_id = $insert2;
					insertMemberFoodDetail($data,$i,$member_meal_dtl_id,$obj_diet_pln);
				}
				else
				{
					// Nothing
				}
			}
		
		
		
		// Other Assistance Insert
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
					
					$insert4 = $obj_diet_pln->insertIntoOtherAssistanceMemberMeal($other_assistance_supllement);
			}
			
		}
		
		
	
		echo "1";
		
	}
	else
	{
		echo "0";
	}
	
	
	
	function insertMemberFoodDetail($data,$i,$detailId,$obj_diet_pln)
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
			
			$insert3 = $obj_diet_pln->insertIntoMembersFoodMealDetail($member_food_detail);
		}
	}
