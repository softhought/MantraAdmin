<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accountmodel extends CI_Model{

    public function getAllAccountList($company_id,$year_id)
    {

        $where = array('account_master.company_id' => $company_id);

        $data = array();    
        $query = $this->db->select("account_master.*,sub_group_master.sub_group_desc")
                          ->from('account_master')
                          ->join('sub_group_master','sub_group_master.sub_group_id = account_master.sub_group_id','INNER')   
                          ->where($where)
                          ->order_by('account_master.account_description','ASC');
      
		$query = $this->db->get();
		// echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
            //	$data[] = $rows;
            
            $data[] = [
                    "accountData" => $rows,
                    "openingBalance" => $this->getAccountOpeningBalance($company_id,$year_id,$rows->account_id)                 
                ];
            }
            return $data;            

        }
		else
		{
             return $data;
         }

    }

    public function getAccountOpeningBalance($company_id,$year_id,$account_id)
	{
		$data = 0;
		$where = array(
                        'companyId' => $company_id,
                        'AccountId' => $account_id,
                        'AccountingYearId' => $year_id,
                      );
		$this->db->select("*")
				 ->from('account_opening_master')				
				 ->where($where)
				 ->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->OpeningBalance;           
        }
		else
		{
            return $data;
        }
	}

}