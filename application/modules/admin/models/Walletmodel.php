<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Walletmodel extends CI_Model{

	public function getMemberAccCodebymobile($mobile,$company_id)
	{
		$where = array('customer_master.CUS_PHONE' => $mobile,'customer_master.company_id' => $company_id );
		$data = array();
		$this->db->select("customer_master.member_acc_code,
							customer_master.CUS_BRANCH,
							payment_master.MEMBERSHIP_NO,
							payment_master.EXPIRY_DT,
							payment_master.VALIDITY_STRING 
							")
				->from('customer_master')
				->where($where)
				->join('payment_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','INNER')
				->order_by('customer_master.CUS_ID', 'desc')
				->limit(1);
		$query = $this->db->get();		
		#echo "<br>".$this->db->last_query();		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;             
        }
		else
		{
            return $data;
        }
	}

    public function GetPromoCaseWithMemberAccCode($member_acc_code)
	{
        $data = array();
		$where1 = array('promo_cashbck_assign_to_mem.is_promo' => 'Y',
						'promo_cashbck_assign_to_mem.member_acc_code' => $member_acc_code
					 );
	    $where2='promo_cashbck_assign_to_mem.amount!=0  AND promo_master.valid_upto >= CAST(NOW() AS DATE)';
		$this->db->select("*")
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
				$data[] = $rows;
            }
            return $data; 
        }
		else
		{
             return $data;
         }
	}
	
	public function GetCashbackWithMemberAccCode($member_acc_code)
	{
        $data = array();
		$where1 = array('promo_cashbck_assign_to_mem.is_promo' => 'N',
						'promo_cashbck_assign_to_mem.member_acc_code' => $member_acc_code
					 );
	    $where2='promo_cashbck_assign_to_mem.amount > 0 AND promo_cashbck_assign_to_mem.expire_dt >= CURDATE()';
		$this->db->select("*")
				->from('promo_cashbck_assign_to_mem')
				->where($where1)
				->where($where2)
				;
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
	

	public function getOnSaleCashBackAmtandId($brn,$card,$company)
	{
		$data = [];
		$where = array(
						'branch' => $brn,
						'package' => $card,	
						'company_id' => $company,	
						'is_active' => 'Y',	
					  );
		$this->db->select("
							on_sale_cash_back_master.cashback_amt AS cashback_amt,
							id,branch
						")
				->from('on_sale_cash_back_master')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
             
        }
		else
		{
            return $data;
        }


	}


	public function getPromodetailByIdnew($promo_id)
	{
		$data = 0;
		$where = array(
						'id' => $promo_id	
					  );
		$this->db->select("*")
				->from('promo_master')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->amount;
             
        }
		else
		{
            return $data;
        }


	}


	public function getwithoutexpirecaseback($member_acc_code)
	{
		$data = array();
		$sql="SELECT * FROM promo_cashbck_assign_to_mem WHERE member_acc_code = '".$member_acc_code."' 
				AND is_promo = 'N' AND expire_dt >= CURDATE() LIMIT 1";
		$query = $this->db->query($sql);
	
		#q();
			if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->amount;
             
        }
		else
		{
            return $data;
        }
	}


	public function getexistscasebackgreterzero($member_acc_code)
	{
		$data = array();
		$sql="SELECT * FROM promo_cashbck_assign_to_mem WHERE member_acc_code = '".$member_acc_code."' AND is_promo = 'N' AND amount > 0 LIMIT 1";
		$query = $this->db->query($sql);
	
		#q();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
             
        }
		else
		{
            return $data;
        }
	}

	public function getReferralCaseback($brn,$card,$company_id)
	{
		$data = 0;
		$where = array(
						'branch' => $brn,	
						'package' => $card,	
						'company_id' => $company_id,	
					  );
		$this->db->select("IFNULL(on_ref_case_back_master.`ref_case_amt`,0) AS ref_case_amt,id,branch")
				->from('on_ref_case_back_master')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->amount;
             
        }
		else
		{
            return $data;
        }


	}



	public function getCashbackdetailById($caseback_id)
	{
		$data = 0;
		$where = array(
						'id' => $caseback_id,	
							
					  );
		$this->db->select("*")
				->from('promo_cashbck_assign_to_mem')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->amount;
             
        }
		else
		{
            return $data;
        }


	}

	public function getexistscasebackfromassign($caseback_id)
	{
		$data = [];
		$where = array(
						'id' => $caseback_id,								
					  );
		$this->db->select("*")
				->from('promo_cashbck_assign_to_mem')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
             
        }
		else
		{
            return $data;
        }


	}

		public function getexistscaseback($member_acc_code)
	{
		$data = [];
		$where = array(
						'member_acc_code' => $member_acc_code,								
						'is_promo' => 'N',								
					  );
		$this->db->select("*")
				->from('promo_cashbck_assign_to_mem')
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
             
        }
		else
		{
            return $data;
        }


	}

//Start added by anil on 13-01-2021
public function getCashBackOnSaleAmt($branch,$card_code,$company)
	{
		$cashback_amt = 0;
		$where = array('branch' => $branch,
						'package' => $card_code,
						'company_id' => $company,
						'is_active' => 'Y',
					);
		$this->db->select("*")
				 ->from('on_sale_cash_back_master')
				 ->where($where)
				 ->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
			$row = $query->row();
			$cashback_amt = $row->cashback_amt;
		  
		   return $cashback_amt;
             
        }
		else
		{
            return $cashback_amt;
        }
	}

	public function GetPromoWithMemberAccCode($member_acc_code)
	{
        $data = array();
		$where1 = array('promo_cashbck_assign_to_mem.is_promo' => 'Y',
						'promo_cashbck_assign_to_mem.member_acc_code' => $member_acc_code
					 );
	    $where2='promo_cashbck_assign_to_mem.amount!=0  AND promo_master.valid_upto >= CAST(NOW() AS DATE)';
		$this->db->select("promo_cashbck_assign_to_mem.*,promo_master.title")
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
				$data[] = $rows;
            }
            return $data; 
        }
		else
		{
             return $data;
         }
	}

	public function getCashbackExiredate($member_acc_code,$new_valid_upto){

        $data =array();

       $sql ="SELECT * FROM promo_cashbck_assign_to_mem WHERE member_acc_code = '$member_acc_code' AND is_promo = 'N' AND expire_dt < '$new_valid_upto'";       

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
             $row = $query->row();    
             $data = $row;           

        }
        return $data;

	}
	public function getwithoutexpirecashback($member_acc_code){

        $data =array();

        $sql ="SELECT * FROM promo_cashbck_assign_to_mem WHERE member_acc_code = '$member_acc_code' AND is_promo = 'N' AND expire_dt >= CURDATE()";       

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
             $row = $query->row();    
             $data = $row;           

        }
        return $data;

	}


//End added by anil on 13-01-2021



}/* end of class */