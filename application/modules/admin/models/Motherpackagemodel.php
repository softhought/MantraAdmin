<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Motherpackagemodel extends CI_Model{

    public function GetCardList()
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where = array('card_master.IS_ACTIVE'=>'Y','card_master.company_id'=>$session['companyid']);  
		$this->db->select("CARD_ID,CARD_CODE,CARD_DESC")
                ->from('card_master')                
				->where($where)
                ->order_by('CARD_DESC','ASC');
                // ->limit(10);
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

    public function getenquiryreportlist($from_dt,$to_date,$branch,$status,$search_by,$package,$trainer,$doneby,$close_by)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $comp = $session['companyid'];
       $where = "customer_master.IS_ACTIVE = 'Y' AND customer_master.pack_type = 'M' AND payment_master.company_id = '$comp' AND payment_master.FRESH_RENEWAL NOT IN ('P','H','D','OC','R','RA')";
        

        if($from_dt != "" && $to_date != "" && $search_by == 'PAYMENT DATE'){

        $wherefrom = "payment_master.PAYMENT_DT BETWEEN '$from_dt' AND '$to_date'";

        }else if($from_dt != "" && $to_date != "" && $search_by == 'REG DATE'){

            $wherefrom = "customer_master.REGISTRATION_DT BETWEEN '$from_dt' AND '$to_date'";

        }else{
            $wherefrom = array();
        }

        if($status != 'ALL'){

            if($status == "FRESH"){
                $wherestat = "payment_master.payment_from <> 'CON'";
            }else{
                $wherestat = "payment_master.payment_from = 'CON'";
            }

        }else{
            $wherestat = array();
        }


        if($branch != ''){
            $wherebrn = "payment_master.branch_id = '$branch'";
        }else{
            $wherebrn = array();
        }

        if($package != ''){
            $wherecard = "payment_master.card_id = '$package'";
        }else{
            $wherecard = array();
        }
        
        if($trainer != ''){
            $wheretrainer = "customer_master.trainer_id = '$trainer'";
        }else{
            $wheretrainer = array();

        }
        
        if($doneby != ''){
            $wheredoneby = "customer_master.done_by = '$doneby'";
        }else{
            $wheredoneby = array();
        }
        if($close_by != 0){
            $wherecloseby = "payment_master.USER_ID = '$close_by'";
        }else{
            $wherecloseby = array();
        } 
        $this->db->select("
                        payment_master.PAYMENT_ID,
                        payment_master.MEMBERSHIP_NO,
                        customer_master.CUS_ID,
                        customer_master.REGISTRATION_DT,
                        payment_master.PAYMENT_DT,
                        payment_master.FROM_DT,
                        payment_master.EXPIRY_DT,
                        payment_master.PAYMENT_MODE,
                        payment_master.RCPT_NO,
                        customer_master.CUS_NAME,
                        customer_master.CUS_SEX,
                        customer_master.CUS_ADRESS,
                        customer_master.CUS_PHONE,
                        customer_master.CUS_EMAIL,
                        customer_master.done_by,
                        customer_master.ENQ_ID,
                        customer_master.whatsup_number,
                        users.name AS doneByName,
                        employee_master.empl_name AS Trainer,
                        enquiry_master.user_id,
                        d.name AS closedByName,
                        payment_master.IS_GST")
                ->from('payment_master')
                ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','INNER')                
                ->join('users','customer_master.done_by = users.id','LEFT')                
                ->join('employee_master','customer_master.trainer_id = employee_master.empl_id','LEFT')                
                ->join('enquiry_master','customer_master.ENQ_ID = enquiry_master.ID','LEFT')                
                ->join('users as d','enquiry_master.user_id = d.id','LEFT')                
				->where($where)
				->where($wherefrom)
				->where($wherestat)
				->where($wherebrn)
				->where($wherecard)
				->where($wheretrainer)
				->where($wheredoneby)
				->where($wherecloseby)
                ->order_by('payment_master.PAYMENT_ID','DESC');
                // ->limit(10);
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

    public function getpaymentdtl($payment_id,$cus_id)
	{
		$data = 0;
		$where = array('payment_master.PAYMENT_ID' => $payment_id,'customer_master.CUS_ID'=>$cus_id);
	   // print_r($where);exit;
        $query=$this->db->select("
                                   payment_master.*,
                                   customer_master.CUS_NAME AS cus_name,
                                   customer_master.CUS_PHONE AS cus_mobile,
                                   customer_master.CUS_ADRESS,
                                   card_master.CARD_DESC,
                                   corporate_company.*,
                                   branch_master.gst_no,
                                   branch_master.branch_address,
                                   company_master.company_name
									")
						->from('payment_master')						
						->join('customer_master','customer_master.CUS_ID =  payment_master.CUST_ID','LEFT')						
						->join('card_master','payment_master.card_id =  card_master.CARD_ID','INNER')						
						->join('corporate_company','payment_master.corporate_comp_id =  corporate_company.id','LEFT')			
						->join('company_master','payment_master.company_id =  company_master.comany_id','INNER')		
						->join('branch_master','payment_master.branch_id =  branch_master.BRANCH_ID','INNER')					
                        ->where($where)
                        ->limit(1)
                        ->get();
                        
							#echo $this->db->last_query();exit;
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
    

    public function getmemeberdtl($cus_id)
	{
		$data = 0;
		$where = array('customer_master.CUS_ID'=>$cus_id);
	   // print_r($where);exit;
        $query=$this->db->select("                                   
                                   customer_master.*,
                                   card_master.CARD_DESC,
                                   branch_master.branch_address,                                 
									")
						->from('customer_master')	
						->join('card_master','customer_master.card_id =  card_master.CARD_ID','INNER')								
						->join('branch_master','customer_master.branch_id =  branch_master.BRANCH_ID','INNER')					
                        ->where($where)
                        ->limit(1)
                        ->get();
                        
							#echo $this->db->last_query();exit;
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

    public function getCardDetailByType($branch,$card,$type,$sub_type)
	{
		$data =  array();
		$where = array('card_id'=>$card,'branch_id'=>$branch,'detail_description'=>$type,'sub_description'=>$sub_type);
	   // print_r($where);exit;
        $query=$this->db->select("card_detail.*,coupon_master.coupon_title")
                        ->from('card_detail')
                        ->join('coupon_master','card_detail.coupon_id =  coupon_master.coupon_id','INNER')										
                        ->where($where)                      
                        ->get();
                        
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
    

    public function getCardDetailBygroup($branch,$card,$group)
	{
		$data =  array();
		$where = array('card_id'=>$card,'branch_id'=>$branch,'grp_for_hf'=>$group);
	   // print_r($where);exit;
        $query=$this->db->select("card_detail.*,coupon_master.coupon_title")
                        ->from('card_detail')
                        ->join('coupon_master','card_detail.coupon_id =  coupon_master.coupon_id','INNER')										
                        ->where($where)                      
                        ->get();
                        
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

    public function getCardDetailByCompl($branch,$card,$type)
	{
		$data =  array();
		$where = array('card_id'=>$card,'branch_id'=>$branch,'detail_description'=>$type);
	   // print_r($where);exit;
        $query=$this->db->select("card_detail.*,coupon_master.coupon_title")
                        ->from('card_detail')
                        ->join('coupon_master','card_detail.coupon_id =  coupon_master.coupon_id','INNER')										
                        ->where($where)                      
                        ->get();
                        
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



}