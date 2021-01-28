<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exchangepackagemodel extends CI_Model{

    public function getUsers($company_id)
	{
        $data = array();
        $where = array('is_active' => 'Y','company_id' => $company_id );
		$this->db->select("*")
				->from('users')
				->where($where)
				->order_by('name', 'asc');
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

	public function getMemberInfo($cus_id)
	{
		$data = array();
		$date = date("Y-m-d");
		$where = array('payment_master.CUST_ID' => $cus_id,'DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >='=>$date,'payment_master.FROM_DT <='=>$date);
		$where_in = array('F','R');

		$this->db->select("*")
				->from('payment_master')
				->join('application_extension','payment_master.CUST_ID = application_extension.member_id AND payment_master.VALIDITY_STRING = application_extension.validity_period','LEFT')
				->where($where)
				->order_by('name', 'asc');
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

	public function getDetailCustomer($cus_id)
	{
		$data = array();
		$date = date("Y-m-d");
		$where = array('customer_master.CUS_ID' => $cus_id,'DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >='=>$date,'payment_master.FROM_DT <='=>$date);
		$where_in = array('F','R');

		$this->db->select("
					   customer_master.MEMBERSHIP_NO,
					   customer_master.CUS_NAME,
					   customer_master.CUS_ADRESS,
					   customer_master.CUS_BRANCH,
					   customer_master.branch_id,
					   customer_master.REGISTRATION_DT,
					   customer_master.CUS_PHONE,
					   customer_master.CUS_PHONE2,
					   customer_master.CUS_EMAIL,
					   customer_master.CUS_CARD,
					   card_master.CARD_DESC,
					   card_master.EXTENSION_DAYS,
					   payment_master.PAYMENT_ID,
					   payment_master.VALID_UPTO,
					   payment_master.VALIDITY_STRING,
					   payment_master.FROM_DT,
					   payment_master.SUBSCRIPTION,
					   payment_master.AMOUNT,
					   payment_master.DISCOUNT_CONV,
					   payment_master.DISCOUNT_OFFER,
					   payment_master.DISCOUNT_NEGO,
					   payment_master.WALLET_AMT,
					   IFNULL(application_extension.grant_days,0) as grant_days,
					   ")
				->from('customer_master')
				->join('payment_master','customer_master.MEMBERSHIP_NO = payment_master.MEMBERSHIP_NO','INNER')
				->join('application_extension','payment_master.CUST_ID = application_extension.member_id AND payment_master.VALIDITY_STRING = application_extension.validity_period','LEFT')
				->join('card_master','customer_master.CUS_CARD = card_master.CARD_CODE','LEFT')
				->where($where)
				->order_by('payment_master.PAYMENT_ID')
				->limit(1);
		$query = $this->db->get();
		#q();
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
	public function GetPaymentByValidity($mno,$validity)
	{
		 $data = array();
		 $where = array(
                        'MEMBERSHIP_NO'=>$mno,
						'VALIDITY_STRING'=>$validity,
						'FRESH_RENEWAL !='=>'P',                        
						'FRESH_RENEWAL !='=>'H',                        
						'FRESH_RENEWAL !='=>'OC'                        
                  );  
		$this->db->select("*")
				->from('payment_master')
				->where($where)
				->order_by('PAYMENT_ID','DESC');
				
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
	public function getDuePaid($mno,$validity,$pid)
	{
		 $data = 0;
		 $where = array(
                        'membershipno'=>$mno,
                        'validity_string'=>$validity,
                        'from_payment_id'=>$pid
                  );  
		$this->db->select("SUM(due_payable.payment_amount) AS duePaidAmt")
				->from('due_payable')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->duePaidAmt;
             
        }
		else
		{
            return $data;
        }
	}
	public function Getpaymentdetails($mother_mem_no,$mother_validity)
	{
		 $data = array();
		 $where = array(
                        'payment_master.MEMBERSHIP_NO'=>$mother_mem_no,
                        'payment_master.VALIDITY_STRING'=>$mother_validity                        
				  ); 
		$where_in = array('F','R');		   
		$this->db->select("*")
				->from('payment_master')
				->where($where)
				->where_in('payment_master.FRESH_RENEWAL',$where_in)
				->order_by('payment_master.PAYMENT_ID','DESC')
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
	public function getcomplconsumptionbymem($mother_mem_no,$mother_validity)
	{
		 $data = array();
		 $where = array(
                        'membership_no'=>$mother_mem_no,
						'validity_string'=>$mother_validity						                      
                  );  
		$this->db->select("*")
				->from('compliment_consumption')
				->where($where)
				->order_by('tran_id','DESC');
				
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


}


