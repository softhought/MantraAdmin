<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class onpvouchermodel extends CI_Model{

    public function getOnlinePaymentListByBranch($branch,$company_id,$year_id)
	{
        $data = array();
        $where = array('payment_master.company_id'=>$company_id,'payment_master.FIN_ID'=>$year_id,'payment_master.PAYMENT_MODE'=>'ONP','payment_master.payment_from <>'=>'INS');
       
        if($branch != ""){
            $where_brn = array('payment_master.branch_id' =>$branch);
        }else{
            $where_brn = array();
        }
		$this->db->select("customer_master.MEMBERSHIP_NO,
                            (CASE WHEN payment_master.MEMBERSHIP_NO IS NULL THEN
                            compliment_consumption.guest_mobile
                            ELSE  
                            customer_master.CUS_PHONE
                            END) AS CUS_PHONE,
                            (CASE WHEN payment_master.MEMBERSHIP_NO IS NULL THEN
                            compliment_consumption.guest_name
                            ELSE  
                            customer_master.CUS_NAME
                            END) AS CUS_NAME,
                            customer_master.CUS_CARD,
                            payment_master.PAYMENT_ID,
                            payment_master.AMOUNT,
                            payment_master.PAYMENT_DT,
                            payment_master.voucher_master_id,
                            payment_master.branch_id,
                            payment_master.second_voucher_mast_id,
                            voucher_a.voucher_no AS voucher_no_a,
                            voucher_b.voucher_no AS voucher_no_b,
                            branch_master.BRANCH_NAME,
                            branch_master.BRANCH_CODE")
                ->from('payment_master')
                ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','LEFT')               
                ->join('compliment_consumption','payment_master.PAYMENT_ID = compliment_consumption.payment_id','LEFT')
                ->join('branch_master','payment_master.branch_id = branch_master.BRANCH_ID','INNER')               
                ->join('voucher_master as voucher_a','payment_master.voucher_master_id = voucher_a.id','LEFT')               
                ->join('voucher_master as voucher_b','payment_master.second_voucher_mast_id = voucher_b.id','LEFT')               
				->where($where)
				->where($where_brn);
				
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