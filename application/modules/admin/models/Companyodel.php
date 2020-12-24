<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companyodel extends CI_Model{
    public function getcompanyList()
	{
        
        $data = array(); 
       
       
        $this->db->select("company_master.*,zone_master.zone_name")                
                ->from('company_master')  
                ->join('zone_master','company_master.zone_id = zone_master.zone_id','LEFT')
                ->order_by('company_master.company_name');             
               
                        
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