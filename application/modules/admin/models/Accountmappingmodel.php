<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accountmappingmodel extends CI_Model{

    public function getAllAccountMappingList($company_id)
    {

        $where = array('branch_acc_payment.company_id' => $company_id);

        $data = array();    
        $query = $this->db->select("branch_acc_payment.*,branch_master.BRANCH_NAME,
                            branch_acc_payment.payment_mode,
                            account_master.account_description")
                          ->from('branch_acc_payment')
                          ->join('account_master','account_master.account_id = branch_acc_payment.account_id','INNER')   
                          ->join('branch_master','branch_master.BRANCH_CODE = branch_acc_payment.branch','INNER')   
                          ->where($where)
                          ->order_by('branch_acc_payment.payment_mode','ASC')
                          ->order_by('account_master.account_description','ASC');
      
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



}/* end of class */