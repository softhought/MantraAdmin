<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Smsmodel extends CI_Model{


    public function getSmsConfig($company_id)
	{
		
        $data = array(); 
        $where = array('company_id'=>$company_id);
        $this->db->select("*") 
                ->from('sms_configuration_master')                      
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

    public function getSmsLog($company_id)
	{
		
        $data = array(); 
        $where = array('company_id'=>$company_id);
        $this->db->select("*") 
                ->from('sms_log')                      
                ->where($where)
                ->order_by('sms_log.sms_id');            
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