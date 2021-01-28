<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dueremindermodel extends CI_Model{

    public function getAllduereminder($from_dt,$to_date,$branch_code,$card)
	{
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
        $data = array();
        
        $where = array('due_payable.company_id'=> $comp);

        if($from_dt != "" && $to_date != ""){
           $where_between = "due_pybl_date BETWEEN '".$from_dt."' AND '".$to_date."'";
        }else{
            $where_between = array();
        }if($branch_code != ""){
            $where_brn = array("due_payable.BRANCH_CODE"=>$branch_code);
         }else{
             $where_brn = array();
         }
         if($card != ""){
            $where_card = array("due_payable.CARD_CODE"=>$card);
         }else{
            $where_card = array();
         }

         $this->db->select(
                  "due_payable.*,
                  card_master.CARD_DESC,
                  customer_master.CUS_NAME,
                  customer_master.REGISTRATION_DT,
                  customer_master.CUS_PHONE,
                  customer_master.PAYMENT_DT,
                  payment_master.PRM_AMOUNT,
                  payment_master.AMOUNT,
                  ")
                ->from('due_payable') 
                ->join('card_master','due_payable.card_id = card_master.CARD_ID','INNER')
                ->join('customer_master','due_payable.member_id = customer_master.CUS_ID','INNER')
                ->join('employee_master','customer_master.trainer_id = employee_master.empl_id','LEFT')
                ->join('payment_master','due_payable.from_payment_id = payment_master.PAYMENT_ID','INNER')
                               
                ->where($where)
                ->where($where_between)
                ->where($where_brn)
                ->where($where_card)
                 ->where('due_payable.payment_id IS NULL')
                ->or_where('due_payable.payment_id','')
                ->order_by('due_payable.due_pybl_date','DESC');

        $query = $this->db->get();
       # echo $this->db->last_query();
        
       if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
			{
				$data[]=  $rows;
            }      
             return $data;
                     
        }
        else
         {
             return $data;
        }       	
    }  


}

