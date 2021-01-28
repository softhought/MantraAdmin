<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Renewalremidermodel extends CI_Model{

    public function getAllRenewalreminder($from_dt,$to_date,$branch_id,$card,$trainer,$mobile_no,$mem_no)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        
        $where = "a.FRESH_RENEWAL!='D' and a.FRESH_RENEWAL!='P' and a.FRESH_RENEWAL!='C' and b.IS_ACTIVE='Y' and a.FRESH_RENEWAL!='H' and a.FRESH_RENEWAL!='OC'";
        if($from_dt != "" && $to_date != ""){
           $where2 = "a.EXPIRY_DT BETWEEN '".$from_dt."' AND '".$to_date."'";
        }else{
            $where2 = array();
        }if($branch_id != ""){
            $where3 = array("a.branch_id"=>$branch_id);
         }else{
             $where3 = array();
         }
         if($card != ""){
            $where4 = array("a.card_id"=>$card);
         }else{
             $where4 = array();
         }
         if($trainer != ""){
            $where_trainer = array("b.trainer_id"=>$trainer);
         }else{
             $where_trainer = array();
         }
        //  if($mobile_no != ""){
        //     $where_mob = array("b.CUS_PHONE"=>$mobile_no);
        //  }else{
        //      $where_mob = array();
        //  }
         if($mem_no != ""){
            $where_mem = array("b.MEMBERSHIP_NO"=>$mem_no);
         }else{
             $where_mem = array();
         }
         
      
		$this->db->select("a.PAYMENT_ID,
                    a.PAYMENT_ID,
                    a.BRANCH_CODE,
                    a.MEMBERSHIP_NO,
                    a.CARD_CODE,
                    a.FROM_DT,
                    a.VALID_UPTO,
                    a.EXPIRY_DT,
                    a.ADMISSION,
                    a.SUBSCRIPTION,
                    a.PRM_AMOUNT,
                    a.AMOUNT,
                    a.SERVICE_TAX,
                    a.TOTAL_AMOUNT,
                    a.PAYMENT_DT,
                    a.RENEW_ID,
                    a.VALIDITY_STRING,
                    a.FRESH_RENEWAL,
                    a.card_id,
                    a.DUE_AMOUNT,
                    a.EXPIRY_DT,
                    b.CUS_ID,
                    b.CUS_NAME,
                    b.CUS_PHONE,
                    b.CUS_BRANCH,
                    b.CUS_CARD,
                    b.EXT_MEMBERSHIP_NO,
                    b.member_acc_code,
                    branch_master.BRANCH_NAME,
                    employee_master.empl_name,
                    employee_master.empl_id,
                    card_master.CARD_DESC,
                    card_master.CARD_ID,
                    rate_detail.renewal_rate,
                    renewaltable.payment_id AS ren_paymentId,
                    renewaltable.renewal_date,
                    ren_pay.PAYMENT_DT` AS ren_PAYMENT_DT,
                    ren_pay.TOTAL_AMOUNT` AS ren_TOTAL_AMOUNT,
                    ren_pay.AMOUNT AS ren_AMOUNT,
                    ren_pay.DUE_AMOUNT AS ren_DUE_AMOUNT")
                ->from('payment_master AS a')
                ->join('customer_master as b','a.MEMBERSHIP_NO = b.MEMBERSHIP_NO','INNER')
                ->join('branch_master','a.branch_id = branch_master.BRANCH_ID','INNER')
                ->join('employee_master','employee_master.empl_id = b.trainer_id','LEFT')
                ->join('card_master','card_master.CARD_ID = a.card_id','INNER')
                ->join('rate_detail','rate_detail.card_id = card_master.CARD_ID AND rate_detail.branch_id = branch_master.BRANCH_ID  AND rate_detail.company_id = "'.$session['companyid'].'"','INNER')                
                ->join('renewaltable','renewaltable.renew_id = a.RENEW_ID','LEFT')
                ->join('payment_master AS ren_pay','ren_pay.PAYMENT_ID = renewaltable.payment_id','LEFT')
                ->where($where)
				->where($where2)
				->where($where3)
				->where($where4)
				->where($where_trainer)
				// ->where($where_mob)
				->where($where_mem)
				->where('a.company_id',$session['companyid'])
                ->order_by('a.EXPIRY_DT','ASC');
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = array(
                                 'PAYMENT_ID'=>$rows->PAYMENT_ID,
                                 'BRANCH_CODE'=>$rows->BRANCH_CODE,
                                 'MEMBERSHIP_NO'=>$rows->MEMBERSHIP_NO,
                                 'CARD_CODE'=>$rows->CARD_CODE,
                                 'FROM_DT'=>$rows->FROM_DT,
                                 'VALID_UPTO'=>$rows->VALID_UPTO,
                                 'EXPIRY_DT'=>$rows->EXPIRY_DT,
                                 'ADMISSION'=>$rows->ADMISSION,
                                 'SUBSCRIPTION'=>$rows->SUBSCRIPTION,
                                 'PRM_AMOUNT'=>$rows->PRM_AMOUNT,
                                 'AMOUNT'=>$rows->AMOUNT,
                                 'DUE_AMOUNT'=>$rows->DUE_AMOUNT,
                                 'SERVICE_TAX'=>$rows->SERVICE_TAX,
                                 'TOTAL_AMOUNT'=>$rows->TOTAL_AMOUNT,
                                 'PAYMENT_DT'=>$rows->PAYMENT_DT,
                                 'RENEW_ID'=>$rows->RENEW_ID,
                                 'VALIDITY_STRING'=>$rows->VALIDITY_STRING,
                                 'FRESH_RENEWAL'=>$rows->FRESH_RENEWAL,
                                 'card_id'=>$rows->card_id,
                                 'CUS_ID'=>$rows->CUS_ID,
                                 'CUS_NAME'=>$rows->CUS_NAME,
                                 'CUS_PHONE'=>$rows->CUS_PHONE,
                                 'BRANCH_NAME'=>$rows->BRANCH_NAME,                                 
                                 'empl_id'=>$rows->empl_id,                                 
                                 'empl_name'=>$rows->empl_name,                                 
                                 'renewal_rate'=>$rows->renewal_rate,                                 
                                 'member_acc_code'=>$rows->member_acc_code,                                                                 
                                 'convertion_dtl'=>$this->getConversion($rows->MEMBERSHIP_NO),                                 
                                 'totAtt'=>$this->getTotalAttendance($rows->MEMBERSHIP_NO,$rows->FROM_DT,$rows->VALID_UPTO),
                                 'last_att_date'=>$this->getLastAttDate($rows->MEMBERSHIP_NO),
                                 'promo_amt'=>$this->GetPromoCaseWithMemberAccCode($rows->member_acc_code),
                                 'cash_amt'=>$this->GetCashbackWithMemberAccCode($rows->member_acc_code),
                                 'tot_calling'=>$this->getTotalRenewalEnqCall($rows->CUS_ID,$rows->PAYMENT_ID,'RENEWAL'),
                                 'prepaymentdtl'=>$this->getprepaymentdtl($rows->PAYMENT_ID,$rows->CUS_ID),
                                 
                                
                );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getConversion($MEMBERSHIP_NO)
	{		
        $data = array();       
        $where = array('customer_master.EXT_MEMBERSHIP_NO'=>$MEMBERSHIP_NO);      
      
		$this->db->select("payment_master.*")
                ->from('customer_master') 
                ->join('payment_master','customer_master.MEMBERSHIP_NO = payment_master.MEMBERSHIP_NO','INNER')               
                ->where($where)
                ->limit(1);				               
                
		$query = $this->db->get();
		#echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
            $data = $row;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getprepaymentdtl($payment_id,$cus_id)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where = 'PAYMENT_ID = (SELECT min(PAYMENT_ID) FROM payment_master WHERE CUST_ID = "'.$cus_id.'" and PAYMENT_ID < "'.$payment_id.'" and payment_master.FRESH_RENEWAL!="D" and payment_master.FRESH_RENEWAL!="P" and payment_master.FRESH_RENEWAL!="C" and payment_master.FRESH_RENEWAL!="H" and payment_master.FRESH_RENEWAL!="OC")';
       
      
		$this->db->select("*")
                ->from('payment_master')                
                ->where($where)
                ->limit(1);				               
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
            $data = $row;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getTotalAttendance($mno,$fdt,$ldt)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data =0;

        $where = array('membershipno'=>$mno);
        $where2 = "att_date BETWEEN '".$fdt."' AND '".$ldt."'";  
		$this->db->select("count(*) as totalatt")
                ->from('member_attendance')                
				->where($where)
				->where($where2);               
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
             $data = $row->totalatt;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getLastAttDate($membership)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data =0;

        $where = array('member_attendance.membershipno'=>$membership);
         
		$this->db->select("*")
                ->from('member_attendance')                
                ->where($where)
                ->order_by('att_date','DESC')
                ->limit(1);
				              
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
             $data = $row->att_date;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function GetPromoCaseWithMemberAccCode($member_acc_code)
	{
        $promo_amt = 0;
		$where1 = array('promo_cashbck_assign_to_mem.is_promo' => 'Y',
						'promo_cashbck_assign_to_mem.member_acc_code' => $member_acc_code
					 );
	    $where2='promo_cashbck_assign_to_mem.amount!=0  AND promo_master.valid_upto >= CAST(NOW() AS DATE)';
		$this->db->select("promo_cashbck_assign_to_mem.*")
				->from('promo_cashbck_assign_to_mem')
				->join('promo_master','promo_master.id = promo_cashbck_assign_to_mem.transaction_id','INNER')
				->where($where1)
				->where($where2)
				;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$promo_amt+= $rows->amount;
            }
            return $promo_amt; 
        }
		else
		{
             return $promo_amt;
         }
    }
    
    public function GetCashbackWithMemberAccCode($member_acc_code)
	{
        $cash_amt = 0;
		$where1 = array('promo_cashbck_assign_to_mem.is_promo' => 'N',
						'promo_cashbck_assign_to_mem.member_acc_code' => $member_acc_code
					 );
	    $where2='promo_cashbck_assign_to_mem.amount > 0 AND promo_cashbck_assign_to_mem.expire_dt >= CURDATE()';
		$this->db->select("promo_cashbck_assign_to_mem.*")
				->from('promo_cashbck_assign_to_mem')
				->where($where1)
                ->where($where2)
                ->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
		if($query->num_rows()> 0)
		{
            $row = $query->row();
            $cash_amt = $row->amount;
          
            return $cash_amt; 
        }
		else
		{
             return $cash_amt;
         }
    }
    
    public function getTotalRenewalEnqCall($mid,$pid,$wing)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $totalcall =0;

        $where = array('enquiry_detail.member_id'=>$mid,'enquiry_detail.payment_id'=>$pid,'for_the_wing'=>$wing);
      
		$this->db->select("count(*) as totalcall")
                ->from('enquiry_detail')                
				->where($where);
				               
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
             $totalcall = $row->totalcall;
           
            return $totalcall;
             
        }
		else
		{
             return $totalcall;
         }
    }


    public function getRenEnqDetail($mid,$pid)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();

        $where = array('enquiry_detail.member_id'=>$mid,'enquiry_detail.payment_id'=>$pid);
      
		$this->db->select("enquiry_master.ID,
                            enquiry_master.ENQ_NO,
                            enquiry_master.DATE_OF_ENQ")
                ->from('enquiry_detail')                
                ->join('enquiry_master','enquiry_master.ID = enquiry_detail.enq_id','INNER')
				->where($where)				               
                 ->limit(1);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
             $data = $row;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getMembershipPaymtdtl($mno)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();

        $where = array('MEMBERSHIP_NO'=>$mno);
         $where_notin = array('D','P','C','H','OC');
		$this->db->select("*")
                ->from('payment_master') 
                ->where($where)
                ->where_not_in('FRESH_RENEWAL',$where_notin)
                ->order_by('payment_id','DESC')				               
                 ->limit(1);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            
            $row = $query->row();
             $data = $row;
           
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getEnquiryRenewalRow($mid,$pid)
	{
        $data = array();
		$where1 = array('enquiry_detail.member_id' => $mid,
                        'enquiry_detail.payment_id' => $pid,
                        'enquiry_detail.for_the_wing'=>'RENEWAL'
					 );
	   
		$this->db->select("enquiry_master.ID AS enqMastID,
                    enquiry_master.DATE_OF_ENQ,
                    enquiry_detail.enq_date,
                    enquiry_master.ENQ_NO,
                    enquiry_master.for_the_wing,
                    enquiry_detail.member_id,
                    enquiry_detail.payment_id,
                    enquiry_detail.enq_remarks,
                    enquiry_detail.followup_date,
                    reason_master.reason_title,
                    users.name")
				->from('enquiry_detail')
				->join('enquiry_master','enquiry_master.ID=enquiry_detail.enq_id','LEFT')
                ->join('reason_master','reason_master.reason_id = enquiry_detail.remarks_id','LEFT')
                ->join('users','enquiry_detail.user_id = users.id','LEFT')
				->where($where1)
                // ->group_by('enquiry_detail.enq_id')
                ->order_by('enqMastID','DESC');
               
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
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

    public function getRateDetailByCompany($branch,$card,$company_id)
	{
        $data = array();
        $where = array('rate_detail.card_code' => $card,'rate_detail.branch_code' => $branch,'card_master.company_id' => $company_id );
		$this->db->select("rate_detail.`rate_id`,
							rate_detail.`card_id`,
							rate_detail.`card_code`,
							rate_detail.`package_rate`,
							rate_detail.`renewal_rate`,
							rate_detail.`discount_rate`,
							rate_detail.`branch_code`")
				->from('rate_detail')
				->join('card_master','card_master.CARD_ID = rate_detail.card_id','INNER')
                ->where($where)
                ->limit(1);
		$query = $this->db->get();
		#q();
		if($query->num_rows()> 0)
		{
            $row = $query->row();
             $data = $row;
            return $data; 
        }
		else
		{
             return $data;
         }
	}
    
public function getinstallmentperiod($comp)
	{
        $data = array();
		$where = array('company_id'=>$comp
					 );
	   
		$this->db->select("*")
				->from('installment_phase')				
				->where($where);
               
               
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
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