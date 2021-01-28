<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Corporatecompanymodel extends CI_Model{
    public function getCorporateCompanydata($corporate_comp_id)
	{
	
        $data = array();
        $where = array('id'=>$corporate_comp_id);  
		$this->db->select("*")
                ->from('corporate_company')                
				->where($where)                
                 ->limit(1);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row();
            $data = $row;
            return $data;
             
        }
		else
		{
             return $data;
         }
    }


}