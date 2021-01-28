<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class vouchermodel extends CI_Model{
    public function GetCardList($category)
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where = array('card_master.IS_ACTIVE'=>'Y','card_master.PROD_CATEGORY_ID'=>$category);  
		$this->db->select("CARD_ID,CARD_CODE,CARD_DESC")
                ->from('card_master')                
				->where($where)
                ->order_by('CARD_DESC','ASC');
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

    public function GetEmployeeList()
	{
		$session = $this->session->userdata('mantra_user_detail');
        $data = array();
        $where = array('is_active'=>'Y','company_id'=>$session['companyid']);  
		$this->db->select("empl_id, empl_name")
                ->from('employee_master')                
				->where($where)
                ->order_by('empl_name','ASC');
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


    public function GetAccountList($trn,$tag,$pkg,$comp)
	{
		
        $data = array();
        $where = array('account_master.is_active'=>'Y','account_master.company_id'=>$comp);
        if($trn=="CSH"){

            $where_group = array('account_master.sub_group_id'=>4); 
            $where_group2 = array();
            $where_and = array();
        }else if($trn=="BNK"){
            $where_group = array('account_master.sub_group_id'=>5); 
            $where_group2 = array();
            $where_and = array();
        }else if($trn=="CN"){

            $where_group = array('account_master.sub_group_id'=>4); 
            $where_group2 = array('account_master.sub_group_id'=>5);
            $where_and = array();
        }else if($trn=="JRN"){

            $where_group = array('account_master.sub_group_id != '=>4,'account_master.sub_group_id != '=>5); 
            $where_group2 = array();
            $where_and = "account_master.account_id NOT IN (SELECT gst_master_input.accountId FROM gst_master_input WHERE gst_master_input.acc_type='O')";
        }
        else if($trn=="OTH"){
            if($pkg==""){

            $where_group = array(); 
            $where_group2 = array();
            $where_and = array();
          }
        }

		$this->db->select("*")
                ->from('account_master')                
				->where($where)
				->where($where_group)
				->or_where($where_group2)
				->where($where_and)
                ->order_by('account_master.account_description','ASC');
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

    public function GetMaxsrl($year_id,$company_id)
	{
		
        $data = 1;
        $where = array('company_id'=>$company_id,'year_id'=>$year_id);  
		$this->db->select("MAX(srl_no) AS maxSrlNo")
                ->from('voucher_master')                
				->where($where)                
                ->limit(1);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row();
            return $data = $row->maxSrlNo + 1;           
             
        }
		else
		{
             return $data;
         }
    }

    public function Getyearpad($year_id)
	{
		
        $data = "";
        $where = array('year_id'=>$year_id);  
		$this->db->select("DATE_FORMAT(starting_date,'%y') AS startYr,DATE_FORMAT(ending_date,'%y') AS endYr")
                ->from('year_master')                
				->where($where)                
                ->limit(1);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row();
            return $data = $row->startYr.'-'.$row->endYr;           
             
        }
		else
		{
             return $data;
         }
    }


    public function getallvoucherlist($from_dt,$to_date,$branch,$tranction_type,$collection_type,$comp)
	{
		
        $data = array();
        $where = array('voucher_master.company_id'=>$comp);  
         if($from_dt != "" && $to_date != ""){
             $where_between = "voucher_date BETWEEN '".$from_dt."' AND '".$to_date."'";
         }else{
            $where_between = array();
         }
         if($branch != ""){
            $where_brn = array('branch_id'=>$branch);
        }else{
           $where_brn = array();
        }
        if($tranction_type != "" && $tranction_type != "REG"){
            $where_trn = array('tran_sub_type'=>$tranction_type);
        }else if($tranction_type == "REG"){
            $where_trn = array('tran_type'=>$tranction_type);
        }else{
            $where_trn = array();
         }
        if($collection_type != ""){
            $where_coll = array('is_daily_collection'=>$collection_type);
        }else{
           $where_coll = array('is_daily_collection'=>'Y');
        }

		$this->db->select("id,voucher_no,voucher_date,narration,tran_type,tran_sub_type,total_dr_amt,auto_voucher_type")
                ->from('voucher_master')                
				->where($where)
				->where($where_between)
				->where($where_brn)
				->where($where_trn)
				->where($where_coll)
                ->order_by('voucher_date','ASC');
                // ->limit(10);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = array(
                                'id'=>$rows->id,
                                'voucher_no'=>$rows->voucher_no,
                                'voucher_date'=>$rows->voucher_date,
                                'narration'=>$rows->narration,
                                'tran_type'=>$rows->tran_type,
                                'tran_sub_type'=>$rows->tran_sub_type,
                                'total_dr_amt'=>$rows->total_dr_amt,
                                'auto_voucher_type'=>$rows->auto_voucher_type,
                                'voucherdtl'=>$this->getvoucherdtl($rows->id)
                              );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getvoucherdtl($master_id)
	{
		
        $data = array();
        $where = array('voucher_detail.master_id'=>$master_id);  
		$this->db->select("voucher_detail.*,account_master.account_description,employee_master.empl_name")
                ->from('voucher_detail')  
                ->join('account_master','voucher_detail.acc_id = account_master.account_id','INNER')              
                ->join('employee_master','voucher_detail.pay_to_id = employee_master.empl_id','LEFT')              
				->where($where);
                
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

    public function getLatestVoucherSerialNoNew($year_id,$comp)
	{		
        $lastsrlno =(int)(0);       
		$sql = "SELECT last_srl FROM voucher_srl_master WHERE year_id=".$year_id." AND company_id=".$comp." LOCK IN SHARE MODE";          
        $query = $this->db->query($sql);
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $lastsrlno = $row->last_srl;
            return $lastsrlno;
             
        }
		else
		{
             return $lastsrlno;
         }
    }

    public function GenerateVoucherNoNew($voucherno_prefix,$serial,$yrID,$serial_char=""){
        $year = $this->Getyearpad($yrID); 
        
        if($serial_char != ""){  
            $srl_pad=str_repeat("0",(6-strlen($serial))).$serial.$serial_char;  
        }else{
            $srl_pad=str_repeat("0",(6-strlen($serial))).$serial;
        }    
        $vocherno = $voucherno_prefix."/".$srl_pad."/".$year;
        return $vocherno;
    }

//ONP voucher 
   public function checkAccountMappingExistance($branch,$payment_mode,$company_id)
	{		
        $no_of_rows = (int)(0);
        $where = array('branch_id'=>$branch,'payment_mode'=>$payment_mode,'is_active'=>'Y','company_id'=>$company_id);
		$this->db->select("count(*) as no_of_rows")
                 ->from('branch_acc_payment')                             
				->where($where);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $no_of_rows = $row->no_of_rows;
            return $no_of_rows;
             
        }
		else
		{
             return $no_of_rows;
         }
    }

    public function GetGSTRateByID($gstType,$rateID)
	{		
        $data = array();   
        $where = array('gst_master.gstType'=>$gstType,'gst_master.id'=>$rateID);
        $this->db->select("*")
                 ->from('gst_master')                             
				->where($where);
                
                // ->limit(10);
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
    public function checkMobileExistance($mobile)
	{		
        $no_of_rows = (int)(0);
        $where = array('customer_master.CUS_PHONE'=>$mobile);
		$this->db->select("count(*) as no_of_rows")
                 ->from('customer_master')                             
				->where($where);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $no_of_rows = $row->no_of_rows;
            return $no_of_rows;
             
        }
		else
		{
             return $no_of_rows;
         }
    }


    public function getMemberAccountCodeByMobile($mobile)
	{		
        $data = "";   
        $where = array('customer_master.CUS_PHONE'=>$mobile);
        $this->db->select("*")
                 ->from('customer_master')                             
                ->where($where)
                ->order_by('CUS_ID','DESC')
                ->limit(1);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $data = $row->member_acc_code;
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getAccountIDBydesc($desc,$comp)
	{		
        $data = array();   
        $where = array('account_master.account_description'=>$desc,'account_master.company_id'=>$comp);
        $this->db->select("*")
                 ->from('account_master')                             
                ->where($where)
                ->order_by('account_id','DESC')
                ->limit(1);
                
                // ->limit(10);
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

    public function getLatestVoucherSerialNoFromVoucherMst($payment_from,$year_id,$company_id)
	{		
        $lastsrlno =(int)(0);       
		$sql = "SELECT max(srl_no) AS last_srl FROM voucher_master WHERE year_id=".$year_id." AND company_id=".$company_id." AND tran_type = '".$payment_from."'  LOCK IN SHARE MODE";          
        $query = $this->db->query($sql);
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $lastsrlno = $row->last_srl+1;
            return $lastsrlno;
             
        }
		else
		{
             return $lastsrlno;
         }
    }

    public function getAccountIdByPaymentMode($branch_id,$payment_mode,$comp)
	{		
        $accountid = 0;   
        $where = array('branch_acc_payment.branch_id'=>$branch_id,'branch_acc_payment.payment_mode'=>$payment_mode,'branch_acc_payment.is_active'=>'Y','branch_acc_payment.company_id'=>$comp);
        $this->db->select("branch_acc_payment.account_id")
                 ->from('branch_acc_payment')                             
                ->where($where)
                ->order_by('id','DESC')               
                ->limit(1);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $accountid = $row->account_id;
            return $accountid;
             
        }
		else
		{
             return $accountid;
         }
    }

    public function getHygineChargesAccountId($branch_id)
	{		
        $accountid = 0;   
        $where = array('branch_id'=>$branch_id);
        $this->db->select("account_id")
                 ->from('gym_hygiene_charges')                             
                ->where($where)               
                ->limit(1);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $accountid = $row->account_id;
            return $accountid;
             
        }
		else
		{
             return $accountid;
         }
    }

    public function getDetailsByPaymentId($paymentid)
	{		
        $data = array();   
        $where = array('payment_master.PAYMENT_ID'=>$paymentid);
        $this->db->select("customer_master.MEMBERSHIP_NO,
                            customer_master.CUS_PHONE,
                            customer_master.CUS_NAME,                            
                            payment_master.AMOUNT,
                            payment_master.PAYMENT_DT,
                            payment_master.CGST_RATE_ID,
                            payment_master.CGST_AMT,
                            payment_master.SGST_AMT,
                            payment_master.SGST_RATE_ID,
                            payment_master.payment_from,
                            payment_master.CARD_CODE,
                            payment_master.BRANCH_CODE,
                            payment_master.card_id")
                 ->from('payment_master')
                 ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','INNER')                             
                ->where($where)               
                ->limit(1);
                
                // ->limit(10);
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


//renewal reminder
public function gen_rcpt_serial_brn_fin($branch_id,$year_id,$comp)
	{		
        $serial = 0;   
        $where = array('BRANCH_CODE'=>$branch_id,'FIN_ID'=>$year_id,'company_id'=>$comp);
        $this->db->select("RCPT_NO")
                 ->from('payment_master')                                              
                ->where($where)   
                ->order_by('RCPT_NO','DESC')            
                ->limit(1);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $serial = $row->RCPT_NO+1;
            return $serial;
             
        }
		else
		{
             return $serial;
         }
    }

public function get_duration($card,$comp)
	{		
        $card_duration = 0;   
        $where = array('CARD_CODE'=>$card,'company_id'=>$comp);
        $this->db->select("CARD_ACTIVE_DAYS")
                 ->from('card_master')                                              
                ->where($where)                            
                ->limit(1);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $card_duration = $row->CARD_ACTIVE_DAYS;
            return $card_duration;
             
        }
		else
		{
             return $card_duration;
         }
    }

    public function getAccountIdByPaymentModeByBrnCode($branch_code,$payment_mode,$comp)
	{		
        $accountid = 0;   
        $where = array('branch_acc_payment.branch'=>$branch_code,'branch_acc_payment.payment_mode'=>$payment_mode,'branch_acc_payment.is_active'=>'Y','branch_acc_payment.company_id'=>$comp);
        $this->db->select("branch_acc_payment.account_id")
                 ->from('branch_acc_payment')                             
                ->where($where)
                ->order_by('id','DESC')               
                ->limit(1);
                
                // ->limit(10);
		$query = $this->db->get();
        
        #echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            $row = $query->row(); 
            $accountid = $row->account_id;
            return $accountid;
             
        }
		else
		{
             return $accountid;
         }
    }


}