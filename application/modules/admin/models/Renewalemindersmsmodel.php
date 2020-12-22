<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Renewalemindersmsmodel extends CI_Model{
    public function GetCardList($category)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where = array('card_master.IS_ACTIVE'=>'Y','card_master.PROD_CATEGORY_ID'=>$category);  
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

    public function getAllRenewalremindersms($from_dt,$to_date,$branch_id,$card,$trainer,$mobile_no,$mem_no)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        
        $where = "a.FRESH_RENEWAL!='D' and a.FRESH_RENEWAL!='P' and a.FRESH_RENEWAL!='C' and b.IS_ACTIVE='Y' and a.FRESH_RENEWAL!='H' and a.FRESH_RENEWAL!='OC' and b.EXT_MEMBERSHIP_NO = ''";
        if($from_dt != "" && $to_date != ""){
           $where2 = "a.VALID_UPTO BETWEEN '".$from_dt."' AND '".$to_date."'";
        }else{
            $where2 = array();
        }if($branch_id != ""){
            $where3 = array("a.branch_id"=>$branch_id);
         }else{
             $where3 = array();
         }
         if($card != ""){
            $where4 = array("a.card_id"=>$card);
         }else{
             $where4 = array();
         }
         if($trainer != ""){
            $where_trainer = array("b.trainer_id"=>$trainer);
         }else{
             $where_trainer = array();
         }
         if($mobile_no != ""){
            $where_mob = array("b.CUS_PHONE"=>$mobile_no);
         }else{
             $where_mob = array();
         }
         if($mem_no != ""){
            $where_mem = array("b.MEMBERSHIP_NO"=>$mem_no);
         }else{
             $where_mem = array();
         }
         
      
		$this->db->select("a.PAYMENT_ID,
                            a.BRANCH_CODE,
                            a.MEMBERSHIP_NO,
                            a.CARD_CODE,
                            a.FROM_DT,
                            a.VALID_UPTO,
                            a.EXPIRY_DT,
                            a.ADMISSION,
                            a.SUBSCRIPTION,
                            a.PRM_AMOUNT,
                            a.AMOUNT,
                            a.SERVICE_TAX,
                            a.TOTAL_AMOUNT,
                            a.PAYMENT_DT,
                            a.RENEW_ID,
                            a.VALIDITY_STRING,
                            a.FRESH_RENEWAL,
                            a.card_id,
                            b.EXT_MEMBERSHIP_NO,
                            b.CUS_ID,
                            b.CUS_NAME,
                            b.CUS_PHONE,
                            branch.BRANCH_NAME,
                            r.renewal_rate")
                ->from('payment_master AS a')
                ->join('customer_master as b','a.MEMBERSHIP_NO = b.MEMBERSHIP_NO','INNER')
                ->join('branch_master as branch','a.branch_id = branch.BRANCH_ID','INNER')
                ->join('rate_detail as r','a.card_id = r.card_id and a.branch_id = r.branch_id','INNER')                
				->where($where)
				->where($where2)
				->where($where3)
				->where($where4)
				->where($where_trainer)
				->where($where_mob)
				->where($where_mem)
				->where('a.company_id',$session['companyid'])
                ->order_by('a.VALID_UPTO','ASC');
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = array(
                                 'PAYMENT_ID'=>$rows->PAYMENT_ID,
                                 'BRANCH_CODE'=>$rows->BRANCH_CODE,
                                 'MEMBERSHIP_NO'=>$rows->MEMBERSHIP_NO,
                                 'CARD_CODE'=>$rows->CARD_CODE,
                                 'FROM_DT'=>$rows->FROM_DT,
                                 'VALID_UPTO'=>$rows->VALID_UPTO,
                                 'EXPIRY_DT'=>$rows->EXPIRY_DT,
                                 'ADMISSION'=>$rows->ADMISSION,
                                 'SUBSCRIPTION'=>$rows->SUBSCRIPTION,
                                 'PRM_AMOUNT'=>$rows->PRM_AMOUNT,
                                 'AMOUNT'=>$rows->AMOUNT,
                                 'SERVICE_TAX'=>$rows->SERVICE_TAX,
                                 'TOTAL_AMOUNT'=>$rows->TOTAL_AMOUNT,
                                 'PAYMENT_DT'=>$rows->PAYMENT_DT,
                                 'RENEW_ID'=>$rows->RENEW_ID,
                                 'VALIDITY_STRING'=>$rows->VALIDITY_STRING,
                                 'FRESH_RENEWAL'=>$rows->FRESH_RENEWAL,
                                 'card_id'=>$rows->card_id,
                                 'CUS_ID'=>$rows->CUS_ID,
                                 'CUS_NAME'=>$rows->CUS_NAME,
                                 'CUS_PHONE'=>$rows->CUS_PHONE,
                                 'BRANCH_NAME'=>$rows->BRANCH_NAME,
                                 'EXT_MEMBERSHIP_NO'=>$rows->EXT_MEMBERSHIP_NO,
                                 'renewal_rate'=>$rows->renewal_rate,
                                 'totAtt'=>$this->getTotalAttendance($rows->MEMBERSHIP_NO,$rows->FROM_DT,$rows->VALID_UPTO),
                                 'totalsms'=>$this->getSMSCount($rows->MEMBERSHIP_NO,$rows->VALIDITY_STRING),
                                 'prepaymentdtl'=>$this->getprepaymentdtl($rows->PAYMENT_ID,$rows->CUS_ID),
                                 
                                
                );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getTotalAttendance($mno,$fdt,$ldt)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data =0;

        $where = array('membershipno'=>$mno);
        $where2 = "att_date BETWEEN '".$fdt."' AND '".$ldt."'";  
		$this->db->select("count(*) as totalatt")
                ->from('member_attendance')                
				->where($where)
				->where($where2);               
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
             $data = $row->totalatt;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getSMSCount($mno,$vald)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data =0;

        $where = array('membership_no'=>$mno,'validity_string'=>$vald,'sending_stat'=>1);
      
		$this->db->select("count(*) as totalsms")
                ->from('sms_other_detail')                
				->where($where);				               
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
           $data = $row->totalsms;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getprepaymentdtl($payment_id,$cus_id)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data ="";
        $where = 'PAYMENT_ID = (SELECT min(PAYMENT_ID) FROM payment_master WHERE CUST_ID = "'.$cus_id.'" and PAYMENT_ID < "'.$payment_id.'" and payment_master.FRESH_RENEWAL!="D" and payment_master.FRESH_RENEWAL!="P" and payment_master.FRESH_RENEWAL!="C" and payment_master.FRESH_RENEWAL!="H" and payment_master.FRESH_RENEWAL!="OC")';
       
      
		$this->db->select("PAYMENT_DT,PAYMENT_ID")
                ->from('payment_master')                
                ->where($where)
                ->limit(1);				               
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
            $data = $row->PAYMENT_DT;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }


    public function GetTrainerListAll()
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where = array('employee_master.company_id'=>$session['companyid']);  
		$this->db->select("employee_master.empl_id,employee_master.empl_name,employee_master.branch_id")
                ->from('employee_master')
                ->join('team_mantra',' employee_master.empl_id=team_mantra.empl_id','INNER')                
				->where($where)
                ->order_by('employee_master.empl_name','ASC');
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

    public function getMobileDetail($table,$where,$order)
	{
		$session = $this->session->userdata('mantra_user_detail');
		$data = array();
		$this->db->select("*")
				->from($table)
				->where('company_id',$session['companyid'])
				->where($where)
				->order_by($order,'DESC')
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();exit;
		
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

    public function getpaymenthistory($member_id)
	{
		
        $data = array();
        $where = array('CUST_ID'=>$member_id); 
        $where2 = "payment_master.FRESH_RENEWAL!='D' and payment_master.FRESH_RENEWAL!='P' and payment_master.FRESH_RENEWAL!='C' and payment_master.FRESH_RENEWAL!='H' and payment_master.FRESH_RENEWAL!='OC'";
		$this->db->select("*")
                ->from('payment_master')                
				->where($where)
				->where($where2);               
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
}