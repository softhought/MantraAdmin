<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrationmodel extends CI_Model{

    public function getAllBranch($company_id)
	{
        $data = array();
        $where = array('company_id' => $company_id );
		$this->db->select("*")
				->from('branch_master')
				->where($where)
				->order_by('BRANCH_NAME', 'asc');
		$query = $this->db->get();
		#q();
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
    
    public function getCardList($company_id)
	{
        $data = array();
        $where = array('IS_ACTIVE' => 'Y','package_card_type' => 'M','company_id' => $company_id );
		$this->db->select("CARD_ID,CARD_CODE,CARD_DESC")
				->from('card_master')
				->where($where)
				->order_by('CARD_DESC', 'asc');
		$query = $this->db->get();
		#q();
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
    
    public function getCardChildList($company_id)
	{
        $data = array();
        $where = array('IS_ACTIVE' => 'Y','package_card_type' => 'C','company_id' => $company_id );
		$this->db->select("CARD_ID,CARD_CODE,CARD_DESC")
				->from('card_master')
				->where($where)
				->order_by('CARD_DESC', 'asc');
		$query = $this->db->get();
		#q();
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
    
    public function getInterestedServiceList()
	{
        $data = array();
		$this->db->select("*")
				->from('interested_service')
				->order_by('service_description', 'asc');
		$query = $this->db->get();
		#q();
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
    

    public function getUsers($company_id)
	{
        $data = array();
        $where = array('visible_stat' => 'Y','company_id' => $company_id );
		$this->db->select("*")
				->from('user_master')
				->where($where)
				->order_by('name_in_full', 'asc');
		$query = $this->db->get();
		#q();
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

    public function GetTrainerListAll($company_id)
	{
        $data = array();
        $where = array('employee_master.is_active' => 'Y','company_id' => $company_id );
		$this->db->select("*")
                ->from('employee_master')
                ->join('team_mantra','team_mantra.empl_id = employee_master.empl_id','INNER')
				->where($where)
				->order_by('employee_master.empl_name', 'asc');
		$query = $this->db->get();
		#q();
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

    public function getAllCorporateCompanyList($company_id)
	{
        $data = array();
        $where = array('is_active' => 'Y','company_id' => $company_id );
		$this->db->select("*")
				->from('corporate_company')
				->where($where)
				->order_by('corporate_company.company_name', 'asc');
		$query = $this->db->get();
		#q();
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

     public function getCategoryList($company_id)
	{
        $data = array();
        $where = array('company_id' => $company_id );
		$this->db->select("*")
				->from('product_category')
				->where($where)
				->order_by('product_category.category_name', 'asc');
		$query = $this->db->get();
		#q();
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

    public function GetGSTRate($gstType,$company_id)
	{
        $data = array();
        $where = array('gstType' => $gstType,'companyid' => $company_id );
		$this->db->select("*")
				->from('gst_master')
				->where($where);
		$query = $this->db->get();
		#q();
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
	

	public function getRateDetailByCompany($branch,$card,$company_id)
	{
        $data = array();
        $where = array('rate_detail.card_code' => $card,'rate_detail.branch_code' => $branch,'card_master.company_id' => $company_id );
		$this->db->select("rate_detail.`rate_id`,
							rate_detail.`card_id`,
							rate_detail.`card_code`,
							rate_detail.`package_rate`,
							rate_detail.`renewal_rate`,
							rate_detail.`discount_rate`,
							rate_detail.`branch_code`")
				->from('rate_detail')
				->join('card_master','card_master.CARD_ID = rate_detail.card_id','INNER')
				->where($where);
		$query = $this->db->get();
		#q();
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
	

	public function getTrainerByBrn($branch,$company_id)
	{
		$data = array();
		if($branch!="ALL"){
			$where = array('employee_master.branch_cd' => $branch,'employee_master.IS_ACTIVE' => 'Y','company_id' => $company_id );
		}else{
			$where = array('employee_master.IS_ACTIVE' => 'Y','company_id' => $company_id );
		}
        
		$this->db->select("employee_master.empl_id,employee_master.empl_name,employee_master.branch_cd")
				->from('employee_master')
				->join('team_mantra','team_mantra.empl_id = employee_master.empl_id','INNER')
				->where($where)
				->order_by('employee_master.empl_name', 'asc');
		$query = $this->db->get();
		#q();
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
	
		
	public function GetCardByCategoryByCompny($cat,$comp)
	{
        $data = array();
		$where1 = array('card_master.IS_ACTIVE' => 'Y',
						'card_master.company_id' => $comp
					 );
	    $where2="substr(CARD_CODE,1,1)='".$cat."'";
		$this->db->select("*")
				->from('card_master')
				->where($where1)
				->where($where2)
				->order_by('CARD_DESC', 'asc');
				;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
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
	
	public function getReceiptNoPaymentMaster($branch,$fin,$company)
	{
		 $data = 1;
		 $where = array(
                        'BRANCH_CODE'=>$branch,
                        'FIN_ID'=>$fin,
                        'company_id'=>$company
                  );  
		$this->db->select("RCPT_NO")
				->from('payment_master')
				->where($where)
				->order_by('RCPT_NO', 'desc')
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->RCPT_NO+1;
             
        }
		else
		{
            return $data;
        }
	}

	public function getCardDtlByCode($card_code,$company)
	{
		 $data = [];
		 $where = array(
                        'CARD_CODE'=>$card_code,
                        'company_id'=>$company,
                        'IS_ACTIVE'=>'Y'
                  );  
		$this->db->select("CARD_ID,CARD_PREFIX,CARD_CODE,CARD_DESC,account_id")
				->from('card_master')
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


	public function getValidityForConversion($membership)
	{
		$data = [];
		$where = array('MEMBERSHIP_NO'=>$membership); 
		$ignore = array('D','P','C','H','OC');
		$this->db->select("*")
				->from('payment_master')
				->where($where)
				->where_not_in('FRESH_RENEWAL', $ignore)
				->order_by('payment_id', 'desc')
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

	public function getMemberExtension($membership,$validity_period)
	{
		$data = [];
		$where = array('membership_no'=>$membership,'validity_period'=>$validity_period); 
	
		$this->db->select("
		         application_extension.membership_no,
		         application_extension.grant_days,
			     application_extension.validity_period")
				->from('application_extension')
				->where($where)
				->order_by('tran_id', 'desc')
				->order_by('validity_period', 'desc')
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


	public function Notextendcoviddays($card,$company)
	{
		 $notextendforcovid = 0;
		 $sql="SELECT *  FROM  `card_master` 
	       WHERE card_master.`IS_ACTIVE` = 'Y' AND card_master.`CARD_CODE`  = '".$card."' AND card_master.`company_id`  = '".$company."' AND
		    (`card_master`.`PROD_CATEGORY_ID` = 26 OR card_master.`CARD_ACTIVE_DAYS`  <= 31)";
		 $query = $this->db->query($sql);
		
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
			$notextendforcovid=1;
            return $notextendforcovid; 
        }
		else
		{
             return $notextendforcovid;
        }
	}

	public function getexistingcovidDetail($mobile)
	{
        $data = 0;
		$where = array('mobile_no' => $mobile
					 );
		$this->db->select("*")
				->from('covid_extension_details')
				->where($where);
				;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
		if($query->num_rows()> 0)
		{           
			$data = 1;           
            return $data; 
        }
		else
		{
             return $data;
         }
	}

	public function getlossDaysInCovid($pre_from_date,$pre_expiry_date)
	{
		 $days = 0;
		 $sql="SELECT 
				CASE
				WHEN '$pre_expiry_date' < covid_extension.`end_offday` AND '$pre_from_date' < covid_extension.`start_offday`
				THEN DATEDIFF(
					'$pre_expiry_date',
					covid_extension.`start_offday`
				)
				WHEN  '$pre_from_date' <= covid_extension.`start_offday` AND '$pre_expiry_date' >= covid_extension.`end_offday`  
				THEN DATEDIFF(
					covid_extension.`end_offday`,
					covid_extension.`start_offday`
				)
				WHEN  '$pre_from_date' < covid_extension.`end_offday` AND  '$pre_expiry_date' >= covid_extension.`end_offday` 
				THEN DATEDIFF(     
					covid_extension.`end_offday`,
					'$pre_from_date'      
				)
				WHEN '$pre_from_date' >= covid_extension.`start_offday` 
				AND '$pre_expiry_date' <= covid_extension.`end_offday` 
				THEN DATEDIFF(
				'$pre_expiry_date',
				'$pre_from_date'
				)      
				END * covid_extension.`rate` DIV 100 AS covid_days  
			FROM
				covid_extension LIMIT 1";
		 $query = $this->db->query($sql);
		
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
			 $row = $query->row();
             return $days = $row->covid_days;
            
        }
		else
		{
             return $days;
        }
	}

	public function get_duration($card_code,$company)
	{
		 $data = 0;
		 $where = array(
                        'CARD_CODE'=>$card_code,
                        'company_id'=>$company                      
                  );  
		$this->db->select("CARD_ACTIVE_DAYS")
				->from('card_master')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->CARD_ACTIVE_DAYS;
             
        }
		else
		{
            return $data;
        }
	}



	public function getLastSerialNoForMemCode($company_id)
	{
		$data = array();
		$where = array('serial_table.company_id' => $company_id);
		$this->db->select("*")
				 ->from('serial_table')
				 ->join('company_master','company_master.comany_id = serial_table.company_id','INNER')
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


	public function getRegistrationData($sustomer_id)
	{
		$data = array();
		$where = array('customer_master.CUS_ID' => $sustomer_id);
		$this->db->select("*")
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

	public function getCorporateCompanyData($corporate_comp_id)
	{
		$data = array();
		$where = array('id' => $corporate_comp_id);
		$this->db->select("*")
				 ->from('corporate_company')
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

	public function getAccountIDBydesc($desc,$comp)
	{
		$data = array();
		$where = array('account_description' => $desc,'company_id' => $comp);
		$this->db->select("account_master.account_id,account_master.account_description")
				 ->from('account_master')
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

	public function GetGSTRateByID($gstType,$rateID)
	{
		$data = array();
		$where = array('gstType' => $gstType,'id' => $rateID);
		$this->db->select("*")
				 ->from('gst_master')
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


	public function getLatestVoucherSerialNoNew($yrId,$comp)
	{
		 $lastnumber = 0;
		 $sql="SELECT last_srl  FROM voucher_srl_master WHERE voucher_srl_master.year_id=".$yrId." 
		 AND voucher_srl_master.company_id=".$comp." LOCK IN SHARE MODE";
		 $query = $this->db->query($sql);
		
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{   $row = $query->row();
			$lastnumber=$row->last_srl;
		}
		
		$digit = (int)(log($lastnumber,10)+1) ;  
        if($digit==6)
		{
            $voucher_serail = $lastnumber;
        }
		elseif($digit==5) 
		{
            $voucher_serail = "0".$lastnumber;
        }
		elseif($digit==4)
		{
            $voucher_serail = "00".$lastnumber;
        }
		elseif($digit==3)
		{
            $voucher_serail ="000".$lastnumber;
        }
		elseif($digit==2)
		{
            $voucher_serail = "0000".$lastnumber;
        }
		elseif($digit==1)
		{
            $voucher_serail ="00000".$lastnumber;
        }
		$lastnumber = $lastnumber + 1;
		
		 $updArry = array('last_srl' => $lastnumber);
		 //update

        $array = array('company_id' => $comp, 'year_id' => $yrId);
        $this->db->where($array); 
        $this->db->update('voucher_srl_master', $updArry);
	
		return $voucher_serail;

	}


	
	public function getAccountIdByPaymentMode($branch,$mode,$comp)
	{
		$data = array();
		$where = array('branch' => $branch,
						'payment_mode' => $mode,
						'company_id' => $comp,
						'is_active' => 'Y',
					);
		$this->db->select("*")
				 ->from('branch_acc_payment')
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

	

	public function getCashBackOnSaleAmt($branch,$card_code,$company)
	{
		$data = array();
		$where = array('branch' => $branch,
						'package' => $card_code,
						'company_id' => $company,
						'is_active' => 'Y',
					);
		$this->db->select("*")
				 ->from('on_sale_cash_back_master')
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

	public function getVoucherDetailsTotalAmount($voucher_mst_id,$tran_tag)
	{
		$data = 0;
		$where = array(
						'master_id' => $voucher_mst_id,
						'tran_tag' => $tran_tag,	
					  );
		$this->db->select("
							IFNULL(SUM(voucher_detail.amount),0) AS total_amt
						")
				->from('voucher_detail')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->total_amt;
             
        }
		else
		{
            return $data;
        }


	}


	public function getCardDetail($branch,$card,$company)
	{
        $data = array();
		$where = array('card_code' => $card,
						'branch_cd' => $branch,
						'company_id' => $company
					 );
	   
		$this->db->select("*")
				->from('card_detail')
				->where($where);
				;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
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

	public function getMemberDetailsByCode($membershipno,$company)
	{
		$data = array();
		$where = array('MEMBERSHIP_NO' => $membershipno);
		$this->db->select("*")
				 ->from('customer_master')
				 ->join('employee_master','employee_master.empl_id = customer_master.trainer_id','LEFT')
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

	public function getCashbackAmtConversion($memno)
	{
		$data = 0;
		$where = array(
						'membership_no' => $memno,
						'is_redeemed' => 'N',	
						'is_approved' => 'Y'	
					  );
		$this->db->select("*")
				->from('cash_back_admin')
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

	
	public function getEnquiryDetail($enq_no,$company_id)
	{
        $data = array();
		$where = array(
						'enquiry_master.company_id' => $company_id
					 );
	    
		$this->db->select("*")
				->from('enquiry_master')
				->where($where)
				->like('ENQ_NO', $enq_no)
				->order_by('FIRST_NAME', 'asc');
				;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
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


	public function getSerialBranch($branch,$card,$company)
	{
   	     $data = [];
		 $where = array(
                        'CUS_BRANCH'=>$branch,
                        'CUS_CARD'=>$card,
                        'company_id'=>$company
                  );  
		$this->db->select("*")
				->from('customer_master')
				->where($where)
				->order_by('SRL_NO', 'desc')
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



	public function GetMemberByMobileNo($mbl,$company)
	{
		$data=[];
		$sql = "SELECT 
					payment_master.`PAYMENT_ID`,
					payment_master.`MEMBERSHIP_NO` AS memberhip,
					payment_master.`FROM_DT`,
					payment_master.`VALID_UPTO`,
					payment_master.`FRESH_RENEWAL`,
					payment_master.`PAYMENT_DT`,
					payment_master.`VALIDITY_STRING`,
					payment_master.`payment_from`,
					payment_master.`BRANCH_CODE`,
					payment_master.`voucher_master_id`,
					payment_master.`IS_GST`,
					customer_master.`CUS_ID`,
					customer_master.`CUS_CARD`,
					customer_master.`CUS_NAME`,
					customer_master.`CUS_SEX`,
					customer_master.`CUS_DOB`,
					customer_master.`CUS_PHONE`,
					customer_master.`CUS_EMAIL`,
					customer_master.`IS_ACTIVE`,
					customer_master.`IS_COMPLI`,
					customer_master.`REGISTRATION_DT`,
					customer_master.`done_by`,
					customer_master.`member_acc_code`
				FROM payment_master 
				INNER JOIN customer_master
				ON customer_master.`MEMBERSHIP_NO`=payment_master.`MEMBERSHIP_NO`
				WHERE 
				payment_master.`MEMBERSHIP_NO` IN 
				(SELECT customer_master.`MEMBERSHIP_NO` FROM customer_master WHERE customer_master.`CUS_PHONE`='".$mbl."')
				 AND customer_master.`IS_ACTIVE`='Y' and  customer_master.`company_id`='".$company."' AND payment_master.payment_from NOT IN ('DUE','PRODSALE','compl')";
		 $query = $this->db->query($sql);
		
		#echo "<br>".$this->db->last_query();
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


	public function getMemberInfoByDateAndBrnch($fdt,$tdt,$brn,$company)
	{
		$data=[];
		$whereBrn = "";
		if($brn!="0")
		{
			$whereBrn = " AND customer_master.`CUS_BRANCH`='".$brn."'";
		}
		else
		{
			$whereBrn = "";
		}
		
		$sql = "SELECT 
					payment_master.`PAYMENT_ID`,
					payment_master.`MEMBERSHIP_NO` AS memberhip,
					payment_master.`FROM_DT`,
					payment_master.`VALID_UPTO`,
					payment_master.`FRESH_RENEWAL`,
					payment_master.`PAYMENT_DT`,
					payment_master.`VALIDITY_STRING`,
					payment_master.`payment_from`,
					payment_master.`BRANCH_CODE`,
					payment_master.`voucher_master_id`,
					payment_master.`IS_GST`,
					customer_master.`CUS_ID`,
					customer_master.`CUS_CARD`,
					customer_master.`CUS_NAME`,
					customer_master.`CUS_SEX`,
					customer_master.`CUS_DOB`,
					customer_master.`CUS_PHONE`,
					customer_master.`CUS_EMAIL`,
					customer_master.`IS_ACTIVE`,
					customer_master.`IS_COMPLI`,
					customer_master.`REGISTRATION_DT`,
					customer_master.`done_by`,
					customer_master.`member_acc_code`
				FROM payment_master 
				INNER JOIN customer_master
				ON customer_master.`MEMBERSHIP_NO`=payment_master.`MEMBERSHIP_NO`
				WHERE payment_master.`PAYMENT_DT` BETWEEN '".$fdt."' AND '".$tdt."'
				AND  customer_master.`company_id`='".$company."'
				".$whereBrn."
				AND customer_master.`IS_ACTIVE`='Y' AND payment_master.payment_from NOT IN ('DUE','PRODSALE','compl')";
		 $query = $this->db->query($sql);
		
		#echo "<br>".$this->db->last_query();
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


	public function GetPaymentData($pid)
	{
		$data = array();
		$where = array('PAYMENT_ID' => $pid);
		$this->db->select("*")
				 ->from('payment_master')				
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


	
	public function GetDueDetailData($pid)
	{
		$data = array();
		$where = array('from_payment_id' => $pid);
		$this->db->select("*")
				 ->from('due_payable')				
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

	
	public function getCategoryByCode($card,$company)
	{
		$data = [];
		$where = array(
						'product_category.start_letter'=>SUBSTR($card,1,1),
						'product_category.company_id'=>$company
					); 
		
		$this->db->select("*")
				->from('product_category')
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


	public function isDuePaid($mno,$validity,$pid)
	{
		$data=0;
		$sql = "SELECT * FROM `due_payable` WHERE due_payable.`from_payment_id`=".$pid."  AND 
		`due_payable`.`membershipno`='".$mno."' AND due_payable.`validity_string`='".$validity."' 
		AND due_payable.`payment_amount`>0";
		$query = $this->db->query($sql);
		
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
         //  $row = $query->row();
           return $data = $query->num_rows();
             
        }
		else
		{
            return $data;
        }
	}

	


 

}/* end of class */