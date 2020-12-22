<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Amcmodel extends CI_Model{
    public function getAmcList()
	{
		
        $data = array(); 

        $this->db->select("amc_master.*,statutory_master.statutory_name")                
                ->from('amc_master')  
                ->join('statutory_master','amc_master.statutory_id = statutory_master.id','INNER') ;             
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