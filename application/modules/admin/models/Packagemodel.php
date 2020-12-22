<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packagemodel extends CI_Model{
    public function getAllfacilitydata($cardId)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where_carddtl = array('card_detail.card_id'=>$cardId);  
		$this->db->select("card_detail.*,coupon_master.coupon_title,branch_master.BRANCH_NAME")
                ->from('card_detail')
                ->join('coupon_master','card_detail.coupon_id = coupon_master.coupon_id','INNER')
                ->join('branch_master','card_detail.branch_id = branch_master.BRANCH_ID','INNER')
				->where('card_detail.company_id',$session['companyid'])
				->where($where_carddtl)
                ->order_by('card_detail.branch_cd','ASC');
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
    
    public function getAllratedetails($cardId)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where_carddtl = array('rate_detail.card_id'=>$cardId);  
		$this->db->select("rate_detail.*,branch_master.BRANCH_NAME")
                ->from('rate_detail')               
                ->join('branch_master','rate_detail.branch_id = branch_master.BRANCH_ID','INNER')
				->where('rate_detail.company_id',$session['companyid'])
				->where($where_carddtl);
               
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
    
    public function getSubGroup($sub_grp_desc)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = "";
        $where = array('sub_group_master.sub_group_desc'=>$sub_grp_desc,'sub_group_master.is_active'=>'Y');  
		$this->db->select("sub_group_master.sub_group_id,sub_group_master.sub_group_desc")
                ->from('sub_group_master')               
                ->join('group_master','group_master.group_id = sub_group_master.group_id','LEFT')				
                ->where($where)
                ->limit(1);
               
               
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row();
            return $data = $row->sub_group_id;

            return $data;
             
        }
		else
		{
             return $data;
         }
	}


}