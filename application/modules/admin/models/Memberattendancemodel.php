<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Memberattendancemodel extends CI_Model{

    public function GetCurrentPackage($mobile_no)
	{
        $session = $this->session->userdata('mantra_user_detail');
        $company_id = $session['companyid'];
        $data = array();
        $date = date("Y-m-d");
        $where = array('customer_master.IS_ACTIVE'=>'Y','customer_master.pack_type'=>'M','DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >='=>$date,'payment_master.FROM_DT <='=>$date);
        $where_in = array('F','R','RA');
       
        $query = $this->db->select("customer_master.CUS_ID,
                                    customer_master.MEMBERSHIP_NO,
                                    customer_master.CUS_BRANCH,
                                    customer_master.CUS_CARD,
                                    customer_master.CUS_NAME,
                                    customer_master.CUS_PHONE,
                                    customer_master.CUS_EMAIL,
                                    customer_master.CUS_ADRESS,
                                    customer_master.CUS_DOB,
                                    customer_master.CUS_SEX,
                                    customer_master.EXT_MEMBERSHIP_NO,
                                    customer_master.EXT_MEMBERSHIP_ID,
                                    customer_master.member_acc_code,
                                    payment_master.VALIDITY_STRING,
                                    payment_master.PAYMENT_ID")
                          ->from('payment_master')
                          ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','INNER')   
                          ->join('application_extension','payment_master.MEMBERSHIP_NO = application_extension.membership_no AND payment_master.VALIDITY_STRING = application_extension.validity_period','LEFT') 
                          ->where('payment_master.MEMBERSHIP_NO IN (SELECT customer_master.`MEMBERSHIP_NO` FROM customer_master WHERE customer_master.`CUS_PHONE`='.$mobile_no.' AND customer_master.`company_id` = '.$company_id.')',NULL)   
                          ->where($where)
                          ->where_in('payment_master.FRESH_RENEWAL',$where_in); 
                                                
      
        $query = $this->db->get();
        //  echo $this->db->last_query();exit;
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

public function getAllattendance($from_dt,$to_date,$branch_id,$mobile_no,$cus_id)
	{
        $data = array();
        $session = $this->session->userdata('mantra_user_detail');
        $company_id = $session['companyid'];
        $where_comp = array('member_attendance.company_id'=>$company_id);
        if($from_dt != "" && $to_date != ""){
            $where = 'member_attendance.att_date between "'.$from_dt.'" AND "'.$to_date.'"';
        }else{
            $where = array();
        }      
       if($branch_id != ""){
           $where_brnid = array('member_attendance.branch_id'=>$branch_id);
       }else{
        $where_brnid = array();
       }
       if($mobile_no != "" && $cus_id != ""){
         $where2 = array('member_attendance.mobile_no'=>$mobile_no,'member_attendance.member_id'=>$cus_id);
       }else{
         $where2 = array();
       }

        $query = $this->db->select("member_attendance.*,customer_master.CUS_NAME,customer_master.CUS_CARD,branch_master.BRANCH_NAME")
                          ->from('member_attendance')
                          ->join('customer_master','member_attendance.member_id = customer_master.CUS_ID','INNER')   
                          ->join('branch_master','member_attendance.branch_id = branch_master.BRANCH_ID','LEFT')                           
                          ->where($where_comp)   
                          ->where($where)   
                          ->where($where_brnid)
                          ->where($where2)
                          ->order_by('member_attendance.att_date','DESC')                         
                          ->order_by('member_attendance.membershipno','DESC'); 
      
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
public function getmemattendence($att_date,$brn_id,$dt1,$dt2){
    $session = $this->session->userdata('mantra_user_detail');
    $company_id = $session['companyid'];
    $where_comp = array('member_attendance.company_id'=>$company_id);
        $where = array('att_date'=>$att_date,'branch_id'=>$brn_id);
        $where2 = 'HOUR(in_time) between "'.$dt1.'" and "'.$dt2.'"';
        $query = $this->db->select("count(*) as cnt0608")
                           ->from('member_attendance')
                           ->where($where_comp)
                           ->where($where)
                           ->where($where2);

        $query = $this->db->get();
   #echo $this->db->last_query();exit;
        if ($query->num_rows()> 0)		{
                $row = $query->row();
                $ary0608 = $row->cnt0608;
           }
           else
           {
               $ary0608 = 0;
   
           }
         return $ary0608;
   
   }
    
public function getMemberPressentDays($from_dt,$to_date,$branch_id,$mobile_no,$cus_id){

    $data = array();
    $session = $this->session->userdata('mantra_user_detail');
    $company_id = $session['companyid'];
    $where_comp = array('customer_master.company_id'=>$company_id);

    if($from_dt != "" && $to_date != ""){
        $where = 'member_attendance.att_date between "'.$from_dt.'" AND "'.$to_date.'"';
    }else{
        $where = array();
    }      
   if($branch_id != ""){
       $where_brnid = array('customer_master.branch_id'=>$branch_id);
   }else{
    $where_brnid = array();
   }
   if($mobile_no != "" && $cus_id != ""){
     $where2 = array('customer_master.CUS_ID'=>$cus_id);
   }else{
     $where2 = array();
   }

   $query = $this->db->select("customer_master.MEMBERSHIP_NO,customer_master.CUS_NAME,customer_master.CUS_PHONE,COUNT(member_attendance.att_date) AS daysAttn")
                          ->from('customer_master')
                          ->join('member_attendance','customer_master.CUS_ID = member_attendance.member_id','LEFT') 
                          ->where($where_comp)   
                          ->where('customer_master.IS_ACTIVE <>','A')   
                          ->where($where)   
                          ->where($where_brnid)
                          ->where($where2)                         
                          ->group_by('customer_master.MEMBERSHIP_NO','ASC')
                          ->order_by('COUNT(member_attendance.att_date)','DESC'); 

     $query = $this->db->get();
#echo $this->db->last_query();exit;
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = array(
                               'MEMBERSHIP_NO'=>$rows->MEMBERSHIP_NO,
                               'CUS_NAME'=>$rows->CUS_NAME,
                               'CUS_PHONE'=>$rows->CUS_PHONE,
                               'daysAttn'=>$rows->daysAttn,
                               'validty'=>$this->GetValidity($rows->MEMBERSHIP_NO)
                                );
            }
        
            return $data;
            
        }
        else
        {
            return $data;
        }

}

public function GetValidity($mno){
    $session = $this->session->userdata('mantra_user_detail');
    $company_id = $session['companyid'];
    $where_comp = array('payment_master.company_id'=>$company_id);
    $date = date('Y-m-d');
    $where = array('payment_master.MEMBERSHIP_NO'=>$mno);
    $where_date = "DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >= '".$date."'";$wherenotin = array('D', 'P', 'C','H','OC');
        $query = $this->db->select("*")
                           ->from('payment_master')
                           ->join('application_extension','payment_master.MEMBERSHIP_NO = application_extension.membership_no AND application_extension.validity_period = payment_master.VALIDITY_STRING','LEFT')
                           ->where($where_comp)
                           ->where($where)
                           ->where($where_date)
                           ->where('payment_master.FROM_DT <= ',$date)
                           ->where_not_in('payment_master.FRESH_RENEWAL',$wherenotin)
                           ->order_by('payment_master.PAYMENT_ID','DESC')
                           ->limit('1');
        $query = $this->db->get();
   #echo $this->db->last_query();exit;
        if ($query->num_rows()> 0)		{
                $row = $query->row();
                $validty = $row->VALIDITY_STRING;
           }
           else
           {
               $validty = "";
   
           }
         return $validty;
   
   }

}