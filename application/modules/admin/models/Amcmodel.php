<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Amcmodel extends CI_Model{
    public function getAmcList($companyid)
	{
        
        $data = array(); 
       
        $where_comp = array('amc_master.company_id'=>$companyid);
        $this->db->select("amc_master.*,statutory_master.statutory_name,account_master.account_description")                
                ->from('amc_master')  
                ->join('statutory_master','amc_master.statutory_id = statutory_master.id','INNER')             
                ->join('account_master','amc_master.account_id = account_master.account_id','INNER')
                ->where($where_comp);             
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

    public function getVendorList()
	{
		
        $data = array(); 
        $where = array('group_master.group_description'=>'SUNDRY CREDITORS');
        $this->db->select("account_master.*")                
                ->from('account_master')  
                ->join('sub_group_master','account_master.sub_group_id = sub_group_master.sub_group_id','INNER')             
                ->join('group_master','sub_group_master.group_id = group_master.group_id','INNER')
                ->where($where);            
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

public function getallamcforcalender($statutory_id,$comp)
	{
        $session = $this->session->userdata('user_detail');
        $where_comp = array('amc_master.company_id'=>$comp);
        $data = array();
        if($statutory_id == ''){
            $where = [];
        }else{
            $where = array('amc_master.statutory_id'=>$statutory_id);
        }
		$this->db->select("amc_master.*,statutory_master.statutory_name")
                ->from('amc_master')
                ->join('statutory_master','amc_master.statutory_id = statutory_master.id','INNER')     
                ->where($where)               
                ->where($where_comp);               
        $query = $this->db->get();
         #echo $this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[] = array('title'=>$rows->statutory_name,
                                'start'=>date('Y-m-d',strtotime($rows->expiry_date))
                            );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }


}