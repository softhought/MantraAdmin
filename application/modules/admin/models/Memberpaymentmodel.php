<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Memberpaymentmodel extends CI_Model{

       public function getDetailMobilePayModuleRev($company_id,$mobile_no)
	{
		$data = [];
		$where = array(
                        'CUS_PHONE' => $mobile_no,
                        'company_id' => $company_id,
                       
                      );
		$this->db->select("*")
				 ->from('customer_master')				
                 ->where($where)
                 ->order_by('PAYMENT_DT','desc')
                 ->order_by('CUS_ID','desc')
				 ;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;         
        }
		else
		{
            return $data;
        }
    }
    

 public function GetLastAttendeceDt($member_id)
	{
        $data = array();
        $where = array('member_attendance.member_id' => $member_id );
		$this->db->select("*")
				->from('member_attendance')
                ->where($where) 
                ->order_by('att_date','desc')
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
    
    public function GetAllValidity($membership_no)
	{
		$data = [];
		$where = array(
                        'MEMBERSHIP_NO' => $membership_no
    
                      );
		$this->db->select("*")
				 ->from('payment_master')				
                 ->where($where)
                 ->where("FRESH_RENEWAL !=",'D')
                 ->where("FRESH_RENEWAL !=",'P')
                 ->where("FRESH_RENEWAL !=",'C')
                 ->order_by('payment_id','desc')
                 
				 ;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;         
        }
		else
		{
            return $data;
        }
    }

     public function GetExtViaApplication($membership_no,$validity)
	{
		$data = [];
		$where = array(
                        'membership_no' => $membership_no,
                        'validity_period' => $validity
    
                      );
		$this->db->select("*")
				 ->from('application_extension')				
                 ->where($where)
				 ;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;         
        }
		else
		{
            return $data;
        }
    }


     public function GetPaymentByValidityDesc($membership_no,$validity,$payment_from)
	{
        $data = array();
        $where = array(
                        'MEMBERSHIP_NO' => $membership_no,
                        'VALIDITY_STRING' => $validity,
                        'payment_from' => $payment_from,
                         );
		$this->db->select("*")
				->from('payment_master')
                ->where($where) 
                ->where("FRESH_RENEWAL !=",'P')
                ->order_by('payment_id','asc')
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


    public function GetPaymentBypaymentid($paymentid)
	{
		$data = [];
		$where = array(
                        'PAYMENT_ID' => $paymentid,
    
                      );
		$this->db->select("*")
				 ->from('payment_master')				
                 ->where($where)
				 ;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;         
        }
		else
		{
            return $data;
        }
    }

    public function GetPaymentByValidity($membership_no,$validity)
	{
		$data = [];
		 $where = array(
                        'MEMBERSHIP_NO' => $membership_no,
                        'VALIDITY_STRING' => $validity,
                        
                         );
		$this->db->select("*")
                 ->from('payment_master')	
                 ->where("FRESH_RENEWAL !=",'P')
                 ->where("FRESH_RENEWAL !=",'H')			
                 ->where($where)
				 ;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;         
        }
		else
		{
            return $data;
        }
    }

      public function GetDueByValidity($membership_no,$validity)
	{
		$data = [];
		 $where = array(
                        'membershipno' => $membership_no,
                        'validity_string' => $validity,
                        
                         );
		$this->db->select("*")
                 ->from('due_payable')				
                 ->where($where)
                 ->where('payment_amount', null)
                 ->order_by('tran_id','desc')
				 ;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;         
        }
		else
		{
            return $data;
        }
    }

 

}/* end of class  */