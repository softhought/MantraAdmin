<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branchmodel extends CI_Model{

    public function getbranchlistwithcompany()

    {

        $data = array();    
        $query = $this->db->select("branch_master.*,company_master.company_name")
                          ->from('branch_master')
                          ->join('company_master','branch_master.company_id = company_master.comany_id','INNER')   
                          ->order_by('branch_master.BRANCH_NAME','ASC');
      
		$query = $this->db->get();
		// echo $this->db->last_query();
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