<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Birthdatwishmodel extends CI_Model{
    public function getBirthdayList($currentDate,$branch_id)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        if($branch_id != ''){
            $where_brn = array('customer_master.branch_id'=>$branch_id);
        }else{
            $where_brn = array();
        }
        $where = array('customer_master.company_id'=>$session['companyid']);  
        $where2 = 'customer_master.CUS_DOB LIKE "%'.$currentDate.'"';
        $this->db->select("customer_master.MEMBERSHIP_NO,customer_master.CUS_NAME,customer_master.CUS_DOB,customer_master.CUS_PHONE,branch_master.BRANCH_NAME")
                 ->join('branch_master','customer_master.branch_id = branch_master.BRANCH_ID','INNER')
                ->from('customer_master')                
				->where($where)
				->where($where2)
				->where($where_brn)
                ->order_by('customer_master.CUS_NAME','ASC');
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