<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productsalemodel extends CI_Model{

    public function getCurrentMembersListByBranch($branch,$sel_card,$company_id)
	{
        $data = array();
        if($branch != ""){
            $where_brn = ' and customer_master.branch_id = '.$branch.'';
        }else{
            $where_brn = '';
        } if($sel_card != ""){
            $where_card = ' and customer_master.card_id ='.$sel_card.'';
        }else{
            $where_card ='';
        }
        $where_comp = ' and customer_master.company_id = '.$company_id.'';
        $date = date("Y-m-d");

        $where = array('DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >='=>$date,'payment_master.FROM_DT <='=>$date);

        $where_in = array('F','R');

        $this->db->select("
                            customer_master.CUS_ID,
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
                            customer_master.EXT_MEMBERSHIP_ID
                            ")
                ->from('payment_master')
                ->join('customer_master','customer_master.MEMBERSHIP_NO = payment_master.MEMBERSHIP_NO','INNER')
                ->join('application_extension','payment_master.MEMBERSHIP_NO = application_extension.membership_no AND payment_master.VALIDITY_STRING = application_extension.validity_period','LEFT') 
                ->where('payment_master.MEMBERSHIP_NO IN (SELECT customer_master.MEMBERSHIP_NO FROM customer_master WHERE customer_master.IS_ACTIVE = "Y" AND customer_master.pack_type= "M"'.$where_brn.''.$where_card.''.$where_comp.')',NULL) 
                ->where($where)
                ->where_in('payment_master.FRESH_RENEWAL',$where_in)
                ->order_by('customer_master.CUS_NAME'); 
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

    public function GetValidity($membership)
	{
        $data = [];
        $date = date("Y-m-d");
        $where = array('MEMBERSHIP_NO'=>$membership); 
        $where = array('DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >='=>$date,'payment_master.FROM_DT <='=>$date);

		$ignore = array('D','P','C','H','OC');
		$this->db->select("*")
                ->from('payment_master')
                ->join('application_extension','payment_master.MEMBERSHIP_NO = application_extension.membership_no AND payment_master.VALIDITY_STRING = application_extension.validity_period','LEFT') 
				->where($where)
				->where_not_in('payment_master.FRESH_RENEWAL', $ignore)
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

    public function getAllSaleAcoountlist($company_id)
	{
        $data = array();
       
        $where2 = array('account_master.company_id'=>$company_id,'account_master.is_active'=>'Y'); 
        $where = array('sub_group_master.sub_group_desc'=>'SALES A/C');

		
		$this->db->select("*")
                ->from('account_master')
                ->join('sub_group_master','sub_group_master.sub_group_id = account_master.sub_group_id','INNER') 
				->where($where)
				->where($where2)				
				->order_by('account_master.account_description');
				
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