<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accountsubgroupmodel extends CI_Model{

    public function getAcountSubGroupList($company_id)
    {

        $where = array('sub_group_master.company_id' => $company_id);

        $data = array();    
        $query = $this->db->select("sub_group_master.*,group_master.group_description")
                          ->from('sub_group_master')
                          ->join('group_master','group_master.group_id = sub_group_master.group_id','INNER')   
                          ->where($where)
                          ->order_by('sub_group_master.sub_group_desc','ASC');
      
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


} /* end of class */