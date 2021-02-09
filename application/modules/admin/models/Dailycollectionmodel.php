<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dailycollectionmodel extends CI_Model{

    public function getAllCashAccountByComId($comp)
	{
        $data = array();
      
        $where = array('company_id'=>$comp,'sub_group_id'=>4,'is_active'=>'Y');
        
       
		$this->db->select("*")
                ->from('account_master')                                         
                ->where($where);
               
                
                
				
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

    public function getOpening($brn,$comp)
	{
        $data = 0;
        $where = array('branch_id'=>$brn,'company_id'=>$comp);
       
		$this->db->select("*")
                ->from('cash_opening')                            
                ->where($where)
                ->order_by('tran_id','DESC')
                ->limit(1);
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $data = $row->open_balance;
            return $data;
             
        }
		else
		{
             return $data;
         }
    }



public function getCollTotalAmtFromPayment($dt1,$dt2,$brn_id,$comp,$payment_mode)
	{
        $data = 0;
        $where = array('collection_branch_id'=>$brn_id,'payment_master.company_id'=>$comp,'PAYMENT_MODE'=>$payment_mode);
       
        if($dt1 != "" && $dt2 != ""){
            $where_between = "PAYMENT_DT BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("sum(TOTAL_AMOUNT) as np_amt")
                ->from('payment_master')                            
                ->where($where)
                ->where($where_between);
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $data = $row->np_amt;
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getCollAllProduct($dt1,$dt2,$brn_id,$comp,$payment_mode)
	{
        $data = 0;
        $where = array('collection_branch_id'=>$brn_id,'product_sale.company_id'=>$comp,'payment_mode'=>$payment_mode);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "DATE_OF_SALE BETWEEN '".$dt1."' AND '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("sum(TOTAL_AMT) as prod_amt")
                ->from('product_sale')                            
                ->where($where)
                ->where($where_between);                
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $data = $row->prod_amt;
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getCashRcvdDaily($dt1,$dt2,$brn_id,$comp,$cash_account_id)
	{
        $cash_rcvd = 0;
        $not_in = array('REG','WST','WOST','HYG');
        
        $where = array('b.branch_id'=>$brn_id,'b.company_id'=>$comp,'a.tran_tag'=>'DR','b.is_daily_collection'=>'Y','a.acc_id'=>$cash_account_id);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "b.voucher_date BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
        
		$this->db->select("a.master_id,a.amount,b.voucher_date")
                ->from('voucher_detail as a')
                ->join('voucher_master as b','a.master_id = b.id','LEFT')                                         
                ->where($where)
                ->where($where_between)
                ->where_not_in('b.tran_type',$not_in);
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$cash_rcvd+= $rows->amount;
            }
            return $cash_rcvd;
             
        }
		else
		{
             return $cash_rcvd;
         }
    }

    public function getCashDepositDaily($dt1,$dt2,$brn_id,$comp)
	{
        $data = 0;
        $where = array('branch_id'=>$brn_id,'cash_deposit.company_id'=>$comp);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "date_of_deposit BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("sum(deposit_amt) as deposit_amt")
                ->from('cash_deposit')                            
                ->where($where)
                ->where($where_between);
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $data = $row->deposit_amt;
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getCashExpDaily($dt1,$dt2,$brn_id,$comp,$cash_account_id)
	{
        $cash_exp = 0;
      
        $where = array('b.branch_id'=>$brn_id,'b.company_id'=>$comp,'a.tran_tag'=>'CR','b.is_daily_collection'=>'Y','substr(b.voucher_no,1,2) != ' => 'CD','a.acc_id'=>$cash_account_id);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "b.voucher_date BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("a.master_id,a.amount,b.voucher_date,b.narration")
                ->from('voucher_detail as a')
                ->join('voucher_master as b','a.master_id = b.id','LEFT')                                           
                ->where($where)
                ->where($where_between);
                
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$cash_exp+= $rows->amount;
            }
            return $cash_exp;
             
        }
		else
		{
             return $cash_exp;
         }
    }

    public function getCollTotalAmtFromPaymentStr($dt1,$dt2,$brn_id,$comp,$payment_mode)
	{
        $data = array();
        $where = array('payment_master.collection_branch_id'=>$brn_id,'payment_master.company_id'=>$comp,'payment_master.PAYMENT_MODE'=>$payment_mode);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "payment_master.PAYMENT_DT BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("payment_master.*,customer_master.CUS_NAME,customer_master.CUS_PHONE")
                ->from('payment_master')
                ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','LEFT')                            
                ->where($where)
                ->where($where_between)
                ->group_by('payment_master.PAYMENT_ID');
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]= $rows;
            }
            
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getCollAllProductWOSTStr($dt1,$dt2,$brn_id,$comp,$payment_mode)
	{
        $data = array();
        $where = array('collection_branch_id'=>$brn_id,'company_id'=>$comp,'payment_mode'=>$payment_mode);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "DATE_OF_SALE BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("*")
                ->from('product_sale')                            
                ->where($where)
                ->where($where_between);
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]= $rows;
            } 
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getCashRcvdDailydtl($dt1,$dt2,$brn_id,$comp,$cash_account_id)
	{
        $data = array();
        $not_in = array('REG','WST','WOST','HYG');
        
        $where = array('b.branch_id'=>$brn_id,'b.company_id'=>$comp,'a.tran_tag'=>'DR','b.is_daily_collection'=>'Y','a.acc_id'=>$cash_account_id);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "b.voucher_date BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
        
		$this->db->select("a.master_id,a.amount,b.voucher_date")
                ->from('voucher_detail as a')
                ->join('voucher_master as b','a.master_id = b.id','LEFT')                                         
                ->where($where)
                ->where($where_between)
                ->where_not_in('b.tran_type',$not_in);
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]= array(
                                'master_id'=>$rows->master_id,
                                'amount'=>$rows->amount,
                                'voucher_date'=>$rows->voucher_date,
                                'cashdtl'=>$this->GetVchCashReceivdDtl($rows->master_id),
                                );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

public function GetVchCashReceivdDtl($master_id)
	{
        $data = array();
       
        
        $where = array('a.master_id'=>$master_id,'a.tran_tag'=>'Dr');
        
        
		$this->db->select("a.id,a.tran_tag,a.acc_id,a.amount,b.account_description")
                ->from('voucher_detail as a')
                ->join('account_master as b','a.acc_id = b.account_id','INNER')                                         
                ->where($where);
                               
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[]= $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getCashExpDailydtl($dt1,$dt2,$brn_id,$comp,$cash_account_id)
	{
        $data = array();
      
        $where = array('b.branch_id'=>$brn_id,'b.company_id'=>$comp,'a.tran_tag'=>'CR','b.is_daily_collection'=>'Y','substr(b.voucher_no,1,2) != ' => 'CD','a.acc_id'=>$cash_account_id);
        if($dt1 != "" && $dt2 != ""){
            $where_between = "b.voucher_date BETWEEN '".$dt1."' and '".$dt2."'";
        }else{
            $where_between = array();
        }
       
		$this->db->select("a.master_id,a.amount,b.voucher_date,b.narration")
                ->from('voucher_detail as a')
                ->join('voucher_master as b','a.master_id = b.id','LEFT')                                           
                ->where($where)
                ->where($where_between);
                
                
				
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[]= array(
                                'master_id'=>$rows->master_id,
                                'amount'=>$rows->amount,
                                'voucher_date'=>$rows->voucher_date,
                                'narration'=>$rows->narration,
                                'cashdtl'=>$this->GetVchCashReceivdDtl($rows->master_id),
                                );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
}