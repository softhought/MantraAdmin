<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dietmodel extends CI_Model{

    public function getLastHavDataByMobile($mobile_no)
	{
		$data = array();
        $where = array('mobile_no' => $mobile_no);
		$this->db->select("*")
				->from('hav_records_app')
				->where($where)
                ->order_by('entry_date')
				->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
            return $data;

        }

	}


    public function getBodyFatMultiplier($gen,$bodyfateperc)
	{
		$data = array();
      
		$sql="SELECT * FROM `body_fat_multiplier` WHERE
				 body_fat_multiplier.`gender`='".$gen."' AND ".$bodyfateperc." >= `body_fat_multiplier`.`greater_nd_eql_perc` 
				 AND ".$bodyfateperc." < body_fat_multiplier.`less_than_perc`";
         $query = $this->db->query($sql);

		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
            return $data;

        }

	}

	public function GetActivityLevelById($activityID)
	{
		$data = array();
        $where = array('activity_level_multiplier.id' => $activityID);
		$this->db->select("*")
				->from('activity_level_multiplier')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
            return $data;

        }

	}


	public function getAllDiseaseforpreaperdiet($diseaseIds)
	{
		$data = array();
		$this->db->select("*")
				->from('diet_disease_guide_master')
				->where_in('id',$diseaseIds);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;         
        }
		else
		{
             return $data;
         }

	}

	public function getAllYoutubeVideo($videoIds)
	{
		$data = array();
		$this->db->select("*")
				->from('videogallery')
				->where_in('id',$videoIds);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;         
        }
		else
		{
             return $data;
         }

	}

	public function GetMealApproach()
	{
		$data = array();
		$this->db->select("*")
				->from('meal_approach')
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetFoodMaster()
	{
		$data = array();
		$sql="SELECT 
					diet_food_master.`id` AS foodID,
					CONCAT(diet_food_master.`food_name`,'-',diet_food_master.`food_qty`,' ',diet_unit_master.`unit_name`,' -',diet_food_master.`calorie`,' Cal') AS foodName,
					diet_food_master.`carbohydrate`,
					diet_food_master.`protein`,
					diet_food_master.`fat`
				FROM diet_food_master 
				INNER JOIN 
				`diet_unit_master`
				ON `diet_unit_master`.`id` = diet_food_master.`diet_unit_id`";
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetFoodType()
	{
		$data = array();
		$this->db->select("*")
				->from('food_type')
				->order_by('food_type.food_type_name')
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetFoodCategory()
	{
		$data = array();
		$this->db->select("*")
				->from('diet_food_category')
				->order_by('diet_food_category.category')
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetOtherAssistanceCategory()
	{
		$data = array();
		$this->db->select("*")
				->from('other_assistance_category')
				->order_by('other_assistance_category.othr_assistnc_name')
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetNeedFactor()
	{
		$data = array();
		$this->db->select("*")
				->from('need_factor')
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetMealSubApproach($meal_approach_id)
	{
		$data = array();
		$where = array('meal_approach_sub.`meal_approach_master_id`' => $meal_approach_id );
		$this->db->select("*")
				->from('meal_approach_sub')
				->where($where)
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }
	}

	public function GetMealSubDetailApproach($meal_approach_detail_id)
	{
		$data = array();
		$where = array('meal_approach_sub_detail.meal_approach_sub_id' => $meal_approach_detail_id );
		$this->db->select("*")
				->from('meal_approach_sub_detail')
				->where($where)
				;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	
	public function GetMealSubDetailApproachByID($meal_approach_detail_id)
	{
		$data = array();
		$where = array('meal_approach_sub_detail.`id`' => $meal_approach_detail_id );
		$this->db->select("*")
				->from('meal_approach_sub_detail')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row; 
        }
		else
		{
            return $data;
        }

	}


	public function getNeddFactorById($id)
	{
		$data = array();
		$where = array('need_factor.`id`' => $id );
		$this->db->select("*")
				->from('need_factor')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row; 
        }
		else
		{
            return $data;
        }

	}

	public function GetFoodByTypeAndCategory($ftype,$fcategory,$gifrom,$gito)
	{
		$data = array();
		$whereGIindex = "";
		if($gifrom!="" AND $gito!="")
		{
			$whereGIindex = " AND diet_food_master.glucose_index BETWEEN ".$gifrom." AND ".$gito;
		}
		else
		{
			$whereGIindex = "";
		}
		
		$sql="SELECT 
				diet_food_master.`id` AS foodID,
				CONCAT(diet_food_master.`food_name`,'-',diet_food_master.`food_qty`,' ',diet_unit_master.`unit_name`,' -',diet_food_master.`calorie`,' Cal') AS foodName,
				diet_food_master.`carbohydrate`,
				diet_food_master.`protein`,
				diet_food_master.`fat`
				FROM diet_food_master 
				INNER JOIN 
				`diet_unit_master`
				ON `diet_unit_master`.`id` = diet_food_master.`diet_unit_id`
				 WHERE diet_food_master.`food_type_id`=".$ftype." AND diet_food_master.`food_category_id`=".$fcategory.$whereGIindex." ORDER BY diet_food_master.food_name";
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}


		public function GetFoodMasterById($fid)
	{
		$data = array();

		
		$sql="SELECT 
					diet_food_master.`id` AS foodID,
					CONCAT(diet_food_master.`food_name`,'-',diet_food_master.`food_qty`,' ',diet_unit_master.`unit_name`,' -',diet_food_master.`calorie`,' Cal') AS foodName,
					diet_food_master.`diet_unit_id`,
					diet_food_master.`carbohydrate`,
					diet_food_master.`protein`,
					diet_food_master.`fat`,
					diet_food_master.`food_qty`,
					diet_food_master.`calorie`,
					diet_unit_master.unit_name
				FROM diet_food_master 
				INNER JOIN 
				`diet_unit_master`
				ON `diet_unit_master`.`id` = diet_food_master.`diet_unit_id`
				WHERE diet_food_master.id=".$fid;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row; 
        }
		else
		{
            return $data;
        }

	}

	public function getOtherAssistncSupllement($categoryID)
	{
		$data = [];

		$sql="SELECT * FROM other_assistance_master 
			 WHERE other_assistance_master.othr_assis_catgID=".$categoryID;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function getOtherAssistanceUnitBySupllmentId($suplmntID)
	{
		$data = array();

		
		$sql="SELECT 
				 diet_unit_master.id AS unitID,
				 diet_unit_master.unit_name
				 FROM other_assistance_master
				 INNER JOIN diet_unit_master
                 ON other_assistance_master.`unit_id` = diet_unit_master.`id`
                 WHERE other_assistance_master.`id`=".$suplmntID;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row; 
        }
		else
		{
            return $data;
        }

	}


	public function getOtherAssistncSupllementDetail($supplementID)
	{
		$data = array();

		
		$sql="SELECT 
				other_assistance_master.`supplement_name`,
				other_assistance_category.`othr_assistnc_name`,
				diet_unit_master.`unit_name`
				FROM other_assistance_master 
				INNER JOIN `other_assistance_category`
				ON other_assistance_category.id=other_assistance_master.`othr_assis_catgID`
				INNER JOIN diet_unit_master
				ON diet_unit_master.`id` = other_assistance_master.`unit_id`
				WHERE other_assistance_master.`id`=".$supplementID;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row; 
        }
		else
		{
            return $data;
        }

	}

	public function GetOtherAssistanceDetail($splmntId)
	{
		$data = array();
		$where = array('other_assistance_detail.other_assis_mastrID'=>$splmntId);
		$this->db->select("other_assistance_detail.*")
				->from('other_assistance_detail')
				
				->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;


        }
		else
		{
             return $data;
         }
	}

	public function memberMedicalInformation($mobile,$company_id)
	{
		$data = array();
		$where = array('CUS_PHONE' => $mobile,
		'customer_master.pack_type'=>'M',
		'company_id' => $company_id);
		$this->db->select("
							customer_master.is_high_bp,
							customer_master.high_bp_medicines,
							customer_master.diabetes_type,
							customer_master.diabetics_medicines,
							customer_master.is_heart_disease,
							customer_master.heart_disease_medicines,
							customer_master.is_pcod,
							customer_master.pcod_medicines,
							customer_master.is_chronic_kidney_disease,
							customer_master.chronic_kidney_disease_medicines,
							customer_master.CUS_PSYCHE,
							customer_master.regular_med_history,
							customer_master.doctor_prescription,
							
							")
				->from('customer_master')
				->where($where)
				->order_by('CUS_ID','desc')
				->limit(1);
		$query = $this->db->get();
        #echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
         return $data;

        }

	}

	public function getBloodReportData($member_ac_code)
	{
		$data = array();
		$where = array('blood_test.member_acc_code'=>$member_ac_code);
		$this->db->select("blood_test.tran_id,
							blood_test.date_of_collection,
							blood_test.test_id,
							blood_test.reading,
							blood_test.note,
							blood_test_master.test_desc")
				 ->from('blood_test')
				 ->join('blood_test_master','blood_test_master.blood_id = blood_test.test_id','INNER')
				 ->where($where)
				 ->order_by('blood_test.date_of_collection','desc');
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;


        }
		else
		{
             return $data;
         }
	}


	public function getBloodTestList()
	{
		$data = array();
		
		$this->db->select("blood_test_master.*,unit_desc")
				 ->from('blood_test_master')
				->join('unit_master','unit_master.unit_id = blood_test_master.unit_id','INNER')
				 ;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;


        }
		else
		{
             return $data;
         }
	}

	public function GetAllMemberMealListByMbl($mbl)
	{
		$data = [];

		$sql="SELECT 
				  members_meal_master.`id` AS memberMealMasterID,
				  members_meal_master.`membership_no`,
				  members_meal_master.`validity_string`,
				  members_meal_master.`meal_date`,
				  members_meal_master.`weight`,
				  members_meal_master.`waist`,
				  members_meal_master.`bodyfatpercent`,
				  members_meal_master.`bmr_rate`,
				  members_meal_master.`final_calorie_req`,
				  members_meal_master.`protein_gm`,
				  members_meal_master.`carbs_gm`,
				  members_meal_master.`fat_gm`,
				  members_meal_master.`total_calorie_given`,
				  members_meal_master.`total_protein_given`,
				  members_meal_master.`total_carbs_given`,
				  members_meal_master.`total_fat_given`,
				  members_meal_master.`is_copied`,
				  members_meal_master.`is_modified`,
				  customer_master.`CUS_NAME`,
				  customer_master.`CUS_PHONE`,
				  branch_master.`BRANCH_NAME`,
				  activity_level_multiplier.`activity_level`,
				  meal_approach.`meal_approach`
				FROM
				  members_meal_master 
				  INNER JOIN customer_master 
					ON customer_master.`MEMBERSHIP_NO` = members_meal_master.`membership_no`
					INNER JOIN activity_level_multiplier
					ON activity_level_multiplier.`id` = members_meal_master.`activity_level`
					INNER JOIN meal_approach
					ON meal_approach.`id` = members_meal_master.`meal_approach`
					INNER JOIN branch_master
                    ON branch_master.BRANCH_CODE=customer_master.CUS_BRANCH
						WHERE  
				members_meal_master.`membership_no` IN 
				(SELECT customer_master.`MEMBERSHIP_NO` FROM customer_master WHERE customer_master.`CUS_PHONE`='".$mbl."')
				ORDER BY members_meal_master.meal_date DESC
				";
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetMemberMealDetail($memMealmastID)
	{
		$data = array();
		$where = array('members_meal_detail.membr_meal_masterid'=>$memMealmastID);
		$this->db->select("members_meal_detail.*")
				 ->from('members_meal_detail')
				->where($where)
				 ;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;


        }
		else
		{
             return $data;
         }
	}

	public function GetMemberFoodDtl($mealDtlId)
	{
		$data = [];

		$sql="SELECT 
				mem_meal_food_detail.id AS memMealFoodDtlID,
				mem_meal_food_detail.`member_meal_dtlid`,
				mem_meal_food_detail.`diet_food_id`,
				mem_meal_food_detail.`food_unit_id`,
				mem_meal_food_detail.`food_qty`,
				mem_meal_food_detail.`calorie`,
				mem_meal_food_detail.`protein_grams`,
				mem_meal_food_detail.`carbs_grams`,
				mem_meal_food_detail.`fat_grams`,
				mem_meal_food_detail.`instruction_daily_assistance` AS instruction,
				diet_food_master.`food_name`,
				diet_unit_master.`unit_name`
				FROM mem_meal_food_detail
				INNER JOIN `diet_food_master`
				ON `diet_food_master`.`id` = mem_meal_food_detail.`diet_food_id`
				INNER JOIN `diet_unit_master`
				ON diet_unit_master.`id` = mem_meal_food_detail.`food_unit_id` 
				WHERE mem_meal_food_detail.member_meal_dtlid=".$mealDtlId;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}


	public function GetMembersDietList($fdate,$tdate,$branch,$comp)
	{
		$data = [];

		if ($branch=="AB" || $branch=="All") {
			$branch_code="";
		}else{
			$branch_code="AND branch_master.BRANCH_CODE='".$branch."'";
		}

		$sql="SELECT 
				  members_meal_master.`id` AS memberMealMasterID,
				  members_meal_master.`membership_no`,
				  members_meal_master.`validity_string`,
				  members_meal_master.`meal_date`,
				  members_meal_master.`weight`,
				  members_meal_master.`waist`,
				  members_meal_master.`bodyfatpercent`,
				  members_meal_master.`bmr_rate`,
				  members_meal_master.`final_calorie_req`,
				  members_meal_master.`protein_gm`,
				  members_meal_master.`carbs_gm`,
				  members_meal_master.`fat_gm`,
				  members_meal_master.`total_calorie_given`,
				  members_meal_master.`total_protein_given`,
				  members_meal_master.`total_carbs_given`,
				  members_meal_master.`total_fat_given`,
				  members_meal_master.`is_copied`,
				  members_meal_master.`is_modified`,
				  customer_master.`CUS_NAME`,
				  customer_master.`CUS_PHONE`,
				  branch_master.`BRANCH_NAME`,
				  activity_level_multiplier.`activity_level`,
				  meal_approach.`meal_approach`
				FROM
				  members_meal_master 
				  INNER JOIN customer_master 
					ON customer_master.`MEMBERSHIP_NO` = members_meal_master.`membership_no`
					INNER JOIN activity_level_multiplier
					ON activity_level_multiplier.`id` = members_meal_master.`activity_level`
					INNER JOIN meal_approach
					ON meal_approach.`id` = members_meal_master.`meal_approach`
					INNER JOIN branch_master
                    ON branch_master.BRANCH_CODE=customer_master.CUS_BRANCH
					WHERE members_meal_master.`meal_date` BETWEEN '".$fdate."' AND '".$tdate."' AND customer_master.company_id='".$comp."' 
					".$branch_code." ORDER BY members_meal_master.`meal_date` DESC";
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}


	public function getMemberMasterDietDesignData($meal_id)
	{
		$data = array();
		$where = array('members_meal_master.id' => $meal_id);
		$this->db->select("")
				->from('members_meal_master')
				->where($where)
				->limit(1);
		$query = $this->db->get();
        #echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
         return $data;

        }

	}


	public function GetMemberFoodDtlForCopy($mealDtlID)
	{
		$data = array();
		$where = array('mem_meal_food_detail.member_meal_dtlid'=>$mealDtlID);
		$this->db->select("*")
				 ->from('mem_meal_food_detail')
				->where($where)
				 ;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;


        }
		else
		{
             return $data;
         }
	}

	public function GetOtherassistanceDataByMealmastId($mealMasterID)
	{
		$data = array();
		$where = array('other_assistance_member_meal.memberMealMasterID'=>$mealMasterID);
		$this->db->select("*")
				 ->from('other_assistance_member_meal')
				->where($where)
				 ;
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;


        }
		else
		{
             return $data;
         }
	}

	public function getMemberPersonalDetailByMembershipNo($mno)
	{
		$data = array();
		$where = array('customer_master.MEMBERSHIP_NO' => $mno);
		$this->db->select("")
				->from('customer_master')
				->where($where)
				->limit(1);
		$query = $this->db->get();
        #echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
         return $data;

        }

	}

	public function GetMealApproachSubSubDtlByID($id)
	{
		$data = array();
		$where = array('meal_approach_sub_detail.id' => $id);
		$this->db->select("")
				->from('meal_approach_sub_detail')
				->where($where)
				->limit(1);
		$query = $this->db->get();
        #echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
        }
		else
		{
         return $data;

        }

	}

	public function GetMemberFoodDtlByMealNoAndMealID($mealId,$mealno)
	{
		$data = array();
		$where = array(
						'members_meal_detail.membr_meal_masterid' => $mealId,
						'members_meal_detail.meal_no' => $mealno,
	                  );
		$this->db->select("*")
				->from('members_meal_detail')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row; 
        }
		else
		{
            return $data;
        }

	}

	public function getOtherAssistanceData($mealID)
	{
		$data = [];

		$sql="SELECT
				other_assistance_member_meal.`id`,
				other_assistance_member_meal.`otherAssistncSuplmntID`,
				other_assistance_member_meal.`serving_size`,
				other_assistance_member_meal.`advice`,
				other_assistance_master.`id` AS otherAssistancemasterID,
				other_assistance_master.`supplement_name`,
				other_assistance_category.id AS categoryID,
				other_assistance_category.`othr_assistnc_name`,
				other_assistance_master.quantity AS otherAssmastrQty,
				`diet_unit_master`.`id` AS dietUnitID,
				diet_unit_master.`unit_name`
				FROM other_assistance_member_meal
				INNER JOIN other_assistance_master
				ON other_assistance_master.`id` = other_assistance_member_meal.`otherAssistncSuplmntID`
				INNER JOIN `other_assistance_category`
				ON `other_assistance_category`.`id` = other_assistance_master.`othr_assis_catgID`
				 INNER JOIN `diet_unit_master`
				ON `diet_unit_master`.`id` = other_assistance_member_meal.`unitID`
				WHERE other_assistance_member_meal.`memberMealMasterID`=".$mealID;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

		public function getMemberFoodDtlInfo($mealID)
	{
		$data = [];

		$sql="SELECT 
				mem_meal_food_detail.`id` AS memFoodDtlID
				FROM `mem_meal_food_detail`
				INNER JOIN `members_meal_detail`
				ON members_meal_detail.`id` = mem_meal_food_detail.`member_meal_dtlid`
				WHERE members_meal_detail.`membr_meal_masterid`=".$mealID;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetAllOtherAssistanceData()
	{
		$data = [];

		$sql="SELECT 
				other_assistance_master.id AS othrAssistncMastID,
				other_assistance_master.supplement_name,
				other_assistance_master.quantity,
				other_assistance_category.`othr_assistnc_name`,
				diet_unit_master.`unit_name`
				FROM other_assistance_master 
				INNER JOIN other_assistance_category
				ON other_assistance_category.id = other_assistance_master.othr_assis_catgID
				INNER JOIN diet_unit_master
				ON diet_unit_master.id = other_assistance_master.unit_id";
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	
	public function GetMembersDietByMealID($mealID)
	{
		$data = [];

		$sql="SELECT 
				  members_meal_master.`id` AS memberMealMasterID,
				  members_meal_master.`membership_no`,
				  members_meal_master.`validity_string`,
				  members_meal_master.`meal_date`,
				  members_meal_master.`weight`,
				  members_meal_master.`waist`,
				  members_meal_master.`bodyfatpercent`,
				  members_meal_master.`bodyfatremarks`,
				  members_meal_master.`bmr_rate`,
				  members_meal_master.`calorie_required`,
				  members_meal_master.`final_calorie_req`,
				  members_meal_master.`zig_zag_calorie`,
				  members_meal_master.`total_cal_with_zig_zag`,
				  members_meal_master.`protein_gm`,
				  members_meal_master.`carbs_gm`,
				  members_meal_master.`fat_gm`,
				  members_meal_master.`total_calorie_given`,
				  members_meal_master.`total_protein_given`,
				  members_meal_master.`total_carbs_given`,
				  members_meal_master.`total_fat_given`,
				  members_meal_master.`member_remarks`,
				  members_meal_master.`is_copied`,
				  members_meal_master.`is_modified`,
				  customer_master.`CUS_ID`,
				  customer_master.`CUS_NAME`,
				  customer_master.`CUS_PHONE`,
				  customer_master.`CUS_EMAIL`,
				  customer_master.`CUS_SEX`,
				  customer_master.`CUS_MS`,
				  activity_level_multiplier.`activity_level`,
				  meal_approach.`meal_approach`,
				  meal_approach.`meal_approach_code`,
				  employee_master.empl_name AS dietitian
				FROM
				  members_meal_master 
				  INNER JOIN customer_master 
					ON customer_master.`MEMBERSHIP_NO` = members_meal_master.`membership_no`
					INNER JOIN activity_level_multiplier
					ON activity_level_multiplier.`id` = members_meal_master.`activity_level`
					INNER JOIN meal_approach
					ON meal_approach.`id` = members_meal_master.`meal_approach`
					LEFT JOIN employee_master
					ON employee_master.empl_id=members_meal_master.dietitian_id
					WHERE members_meal_master.id=".$mealID ;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

	public function GetFoodSourceGiven($mealID,$sourceTag)
	{
		$data = [];

		$sql="SELECT 
				mem_meal_food_detail.`carbs_grams`,
				mem_meal_food_detail.`protein_grams`,
				mem_meal_food_detail.`fat_grams`
				FROM `mem_meal_food_detail` 
				INNER JOIN `members_meal_detail` 
				ON members_meal_detail.`id`=mem_meal_food_detail.`member_meal_dtlid`
				INNER JOIN `members_meal_master`
				ON `members_meal_master`.`id` = members_meal_detail.`membr_meal_masterid`
				INNER JOIN `diet_food_master`
				ON `diet_food_master`.`id`=mem_meal_food_detail.`diet_food_id`
				INNER JOIN `food_type`
				ON `food_type`.`id` = diet_food_master.`food_type_id`
				WHERE food_type.`food_type_name`='".$sourceTag."' AND `members_meal_master`.`id` = ".$mealID;
         $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

public function converGramToCalorie($gmValue,$catg)
	{
		$calorieVal = 0;
		if($catg=="Carbohydrate" OR $catg=="Protein")
		{
			$calorieVal = $gmValue*4;
		}
		if($catg=="Fat")
		{
			$calorieVal = $gmValue*9;
		}
		return $calorieVal;
		
	}	

	public function getOtherAssistanceCateg($mealID)
	{
		$data = [];

		$sql="SELECT
				DISTINCT(other_assistance_category.`othr_assistnc_name`) AS otherAssistanceCategory
				FROM other_assistance_member_meal
				INNER JOIN `other_assistance_category`
				ON `other_assistance_category`.id = other_assistance_member_meal.`categoryID`
				 WHERE other_assistance_member_meal.`memberMealMasterID`=".$mealID."
				 ORDER BY otherAssistanceCategory";
			 $query = $this->db->query($sql);	 
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}	

	
	public function getSupplementBycategory($mealID,$otherAssistncecatg)
	{
		$data = [];

		$sql="SELECT
				other_assistance_member_meal.`otherAssistncSuplmntID`,
				other_assistance_member_meal.`advice`,
				other_assistance_member_meal.`serving_size`,
				other_assistance_master.`supplement_name`,
				other_assistance_category.`othr_assistnc_name`,
				other_assistance_master.quantity AS otherAssmastrQty,
				diet_unit_master.`unit_name`
				FROM other_assistance_member_meal
				INNER JOIN other_assistance_master
				ON other_assistance_master.`id` = other_assistance_member_meal.`otherAssistncSuplmntID`
				INNER JOIN `other_assistance_category`
				ON `other_assistance_category`.`id` = other_assistance_master.`othr_assis_catgID`
				 INNER JOIN `diet_unit_master`
				ON `diet_unit_master`.`id` = other_assistance_member_meal.`unitID`
				WHERE other_assistance_member_meal.`memberMealMasterID`=".$mealID." 
				AND other_assistance_category.`othr_assistnc_name`='".$otherAssistncecatg."'";
				 $query = $this->db->query($sql);
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

		public function GetOtherAssistanceDetailData($id)
	{
		$data = [];

		$sql="SELECT 
				other_assistance_detail.other_assis_mastrID,
				other_assistance_detail.component,
				other_assistance_detail.qty,
				other_assistance_detail.unit_id,
				diet_unit_master.unit_name
				FROM other_assistance_detail 
				INNER JOIN diet_unit_master 
				ON diet_unit_master.id = other_assistance_detail.unit_id
				WHERE other_assistance_detail.other_assis_mastrID=".$id;
				 $query = $this->db->query($sql);
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;           
        }
		else
		{
             return $data;
         }

	}

}/* end of class  */