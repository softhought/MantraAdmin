<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashdepositmodel extends CI_Model{

    public function getAllCashDepostit($from_dt,$to_date,$branch,$comp)
	{
        $data = array();
        $where = array('cash_deposit.company_id'=>$comp);
        if($from_dt != "" && $to_date != ""){

            $where_frm = "cash_deposit.date_of_deposit BETWEEN '".$from_dt."' AND '".$to_date."'";
        }else{
            $where_frm = array();
        }
        if($branch != ""){
            $where_brn = array('cash_deposit.branch_id' =>$branch);
        }else{
            $where_brn = array();
        }
		$this->db->select("cash_deposit.*,
        branch_master.BRANCH_NAME")
                ->from('cash_deposit')
                ->join('branch_master','cash_deposit.branch_id = branch_master.BRANCH_ID','INNER')               
				->where($where)
				->where($where_brn)
				->where($where_frm);
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

    public function getCreditDebitAccountList($company_id,$subgroupids)
	{
        $data = array();
        $where = array('account_master.company_id'=>$company_id,'is_active'=>'Y');
       
		$this->db->select("*")
                ->from('account_master')                            
				->where($where)
                ->where_in('sub_group_id',$subgroupids)
                ->order_by('account_description');
				
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