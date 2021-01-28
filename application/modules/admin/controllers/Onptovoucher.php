<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Onptovoucher extends MY_Controller{

function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		 $this->load->model('vouchermodel','vouchermodel',TRUE);	
		 $this->load->model('onpvouchermodel','onpvouchermodel',TRUE);	
          $this->load->module('template');		

  }
  
  public function index(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
       
        $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
        
        $data['view_file'] = 'dashboard/account/onp_voucher/onp_voucher_list';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function getOnlinePaymentListByBranch(){ 

   
    if($this->session->userdata('mantra_user_detail'))
    {   
        $session = $this->session->userdata('mantra_user_detail');
        $branch = $this->input->post('branch');

         $year_id = $session['yearid'];
         $company_id = $session['companyid'];

        $data['OnlinePaymentList'] = $this->onpvouchermodel->getOnlinePaymentListByBranch($branch,$company_id,$year_id);
        //pre($data['OnlinePaymentList']);exit;
        $page = 'dashboard/account/onp_voucher/onp_voucher_partial_list';
        $this->load->view($page,$data); 
		
    }else{
        redirect('admin','refresh');
  
  }

  }


  public function postonpvoucher(){ 

   
    if($this->session->userdata('mantra_user_detail'))
    {   
        $session = $this->session->userdata('mantra_user_detail');
        $membership = $this->input->post('membership');
        $paymentid = $this->input->post('paymentid');
        $branchid = $this->input->post('branchid');
        $payment_mode = $this->input->post('payment_mode');
        $mno = $membership;
         $year_id = $session['yearid'];
         $company_id = $session['companyid'];
         $rowAccountmap = $this->vouchermodel->checkAccountMappingExistance($branchid,$payment_mode,$company_id);
        
         if($rowAccountmap > 0){
           
           $paymentdtl = $this->vouchermodel->getDetailsByPaymentId($paymentid);
          
          $payment_date=$paymentdtl->PAYMENT_DT;
          $card = $paymentdtl->CARD_CODE;
          $card_id = $paymentdtl->card_id;
          $payment_now = $paymentdtl->AMOUNT;         
          $cgstRateID = $paymentdtl->CGST_RATE_ID;
          $cgstAmount = $paymentdtl->CGST_AMT;         
          $sgstRateID = $paymentdtl->SGST_RATE_ID;
          $sgstAmount = $paymentdtl->SGST_AMT;         
          $phone=$paymentdtl->CUS_PHONE;         
          $branch_code = $paymentdtl->BRANCH_CODE;         
          $payment_from=$paymentdtl->payment_from;

          if($card_id != ""){
            $where_card = array('CARD_ID'=>$card_id);
            $carddtl = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where_card);
            $card_category = $carddtl->CARD_PREFIX;
            $card_desc = $carddtl->CARD_DESC;
            $card_acc_id = $carddtl->account_id;          
          }
          $cgstTaxAmt = 0;
          $sgstTaxAmt = 0;
       
          $isGST = "N";

          if($cgstAmount>0 && $sgstAmount>0)
          {
            $isGST = "Y";
          }

          if($cgstAmount>0)
          {
            $rowCGSTData =  $this->vouchermodel->GetGSTRateByID('CGST',$cgstRateID);
              $cgstrate= $rowCGSTData->rate;
              $cgstAccID = $rowCGSTData->accountId;
              $cgstTaxAmt = (($cgstrate/100) * $payment_now);

          }
      
          if($sgstAmount>0)
          {
            $rowSGSTData = $this->vouchermodel->GetGSTRateByID('SGST',$sgstRateID);            
              $sgstrate=  $rowSGSTData->rate;
              $sgstAccID = $rowSGSTData->accountId;
            $sgstTaxAmt = (($sgstrate/100) * $payment_now);
          }
          $total_amount = $payment_now + $cgstTaxAmt + $sgstTaxAmt;

          $checkExistance = $this->vouchermodel->checkMobileExistance($phone);
          if($checkExistance > 0){

            $member_acc_code = $this->vouchermodel->getMemberAccountCodeByMobile($phone);

          }else{

          }

          $narration="Online Payment";
		      $sundry_debtor = "Sundry Debtor";

          $SundDebAcc = $this->vouchermodel->getAccountIDBydesc($sundry_debtor,$company_id);
          $mem_account_id = $SundDebAcc->account_id; //Account ID Consider for Member          
          $membership_ref = $mno;

          $voucher_master = array();
          $voucher_detail = array();
          $voucherCustomer = array();
          $voucherSale = array();
          
          $debit_voucherArry = array();
          $credit_voucherArry = array();

          $voucherDtlArry1 = array();
          $voucherDtlArry2 = array();
          $voucherDtlArry3 = array();
          $voucherDtlArry4 = array();

          if($branch_code!="LT" && $branch_code!="TR"  && $payment_now>0)
          {
            
              if($payment_from == "HYG"){                    
                   $voucherno_prefix = 'HY';
                  $totalAmt = 0;
                  $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoFromVoucherMst($payment_from,$year_id,$company_id);
                  $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id);
                  $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentMode($branchid,$payment_mode,$company_id);
                  $hygine_acc_id = $this->vouchermodel->getHygineChargesAccountId($branchid);
                  $totalAmt = $payment_now+$cgstTaxAmt+$sgstTaxAmt;
                 // voucher master insert data
                  $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_date,$branchid,$payment_from,$narration,$paymentid,$totalAmt);
                  
                  if($voucher_master_id > 0){
                  // voucher details insert data                 
                  $this->insertvoucherdetails($voucher_master_id,'Cr',$hygine_acc_id,$payment_now,1);
                  $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
                  $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
                  $this->insertvoucherdetails($voucher_master_id,'Dr',$debit_acc_id,$totalAmt,4,$member_acc_code,$membership_ref);
                  $where_payment = array('PAYMENT_ID'=>$paymentid);
                  $upd_payment = array('voucher_master_id'=>$voucher_master_id);
                  $upd_enq = $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment,$where_payment);
                  }
                 

              }else  if($payment_from == "ONLCOU"){
                     $voucherno_prefix = 'OC';
                    $totalAmt = 0;
                    $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoFromVoucherMst($payment_from,$year_id,$company_id);
                    $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id);
                    $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentMode($branchid,$payment_mode,$company_id);
                    $onlinecon_acc_id = 11150;
                    $totalAmt = $payment_now+$cgstTaxAmt+$sgstTaxAmt;
                  // voucher master insert data
                    $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_date,$branchid,$payment_from,$narration,$paymentid,$totalAmt);
                    
                    if($voucher_master_id > 0){
                    // voucher details insert data                 
                    $this->insertvoucherdetails($voucher_master_id,'Cr',$onlinecon_acc_id,$payment_now,1);
                    $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
                    $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
                    $this->insertvoucherdetails($voucher_master_id,'Dr',$debit_acc_id,$totalAmt,4,$member_acc_code,$membership_ref);
                    $where_payment = array('PAYMENT_ID'=>$paymentid);
                    $upd_payment = array('voucher_master_id'=>$voucher_master_id);
                    $upd_enq = $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment,$where_payment);
                    }
              }else{
                   $totalAmt = 0;
                  $voucherno_prefix = 'RG';
                  $serial_char = 'A';
                  $payment_from = "REG";
                  $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoNew($year_id,$company_id);
                  $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char);
                  $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentMode($branchid,$payment_mode,$company_id);
                  $totalAmt = $payment_now+$cgstTaxAmt+$sgstTaxAmt;
                  // voucher master insert data for voucher A
                   $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_date,$branchid,$payment_from,$narration,$paymentid,$totalAmt,$card_category,$card_id,$card,$card_desc);
                   // voucher details insert data  for voucher A
                   if($voucher_master_id > 0){

                   $this->insertvoucherdetails($voucher_master_id,'Cr',$card_acc_id,$payment_now,1);
                   $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
                   $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
                   $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$totalAmt,4,$member_acc_code,$membership_ref);
                   }

                   // voucher master insert data for voucher B
                   $serial_char2 = 'B';
                   $voucher_no2 = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char2);

                   $voucher_master_id2 = $this->insertvouchermaster($voucher_srl,$voucher_no2,$payment_date,$branchid,$payment_from,$narration,$paymentid,$totalAmt,$card_category,$card_id,$card,$card_desc);
                   // voucher details insert data  for voucher B
                   if($voucher_master_id > 0 && $voucher_master_id2 > 0){
                   $this->insertvoucherdetails($voucher_master_id2,'Cr',$mem_account_id,$totalAmt,1,$member_acc_code,$membership_ref);
                   $this->insertvoucherdetails($voucher_master_id2,'Dr',$debit_acc_id,$totalAmt,2);

                   $where_voucher_srl = array('year_id'=>$year_id,'company_id'=>$company_id);
                   $voucher_arr = array('last_srl'=>$voucher_srl+1);
                   $voucher_master = $this->commondatamodel->updateSingleTableData('voucher_srl_master',$voucher_arr,$where_voucher_srl);
    

                   $where_payment = array('PAYMENT_ID'=>$paymentid);
                   $upd_payment = array('voucher_master_id'=>$voucher_master_id,'second_voucher_mast_id'=>$voucher_master_id2);
                   $upd_enq = $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment,$where_payment);
                   }
                  
              }

          }

          if($payment_from == "HYG"){
            $json_response = array(
               "msg_status" => 1,
                "msg_data" => "Voucher Successfully created !",
                "voucher_no_a" => $voucher_no,
                "voucher_no_b" => ""
               );
     
       }else if($payment_from == "ONLCOU"){
         $json_response = array(
              "msg_status" => 1,
               "msg_data" => "Voucher Successfully created !",
               "voucher_no_a" => $voucher_no,
               "voucher_no_b" => ""
              );
     
      }else if($payment_from != "HYG" && $payment_from != "ONLCOU"){
        $json_response = array(
               "msg_status" => 1,
                "msg_data" => "Voucher Successfully created !",
                "voucher_no_a" => $voucher_no,
                "voucher_no_b" => $voucher_no2
               );
             }

          

         }else{
              $json_response = array(
                "msg_status" => 0,
                "msg_data" => "This Voucher Can't be prepared !"
            );
         }
 

        header('Content-Type: application/json');
        echo json_encode( $json_response );
        exit; 
       
		
    }else{
        redirect('admin','refresh');
  
  }

  }


  private function insertvouchermaster($voucher_srl,$voucher_no,$payment_date,$branch_id,$tran_type,$narration,$paymentid,$totalAmt=0,$card_category=NULL,$card_id=NULL,$card=NULL,$card_desc=NULL){
    $session = $this->session->userdata('mantra_user_detail');
      $voucher_master = array(
        "srl_no" => $voucher_srl,
        "voucher_no" => $voucher_no,
        "voucher_date" => date('Y-m-d',strtotime($payment_date)),
        "branch_id" => $branch_id,
        "tran_type" => $tran_type,
        "tran_sub_type" => '',
        "pkg_cat" => $card_category,
        "pkg_id" => $card_id,
        "pkg_code" =>$card,
        "pkg_desc" => $card_desc,
        "narration" => $narration,
        "cheque_no" => '',
        "cheque_date" => NULL,
        "bank_name" => '',
        "bank_branch" => '',
        "total_dr_amt" => $totalAmt,
        "total_cr_amt" => $totalAmt,
        "user_id" => $session['userid'],
        "year_id" => $session['yearid'],
        "is_daily_collection" => 'Y',
        "company_id" => $session['companyid'],
        'parent_payment_id'=>$paymentid
        );
        //pre($voucher_master);exit;
        $voucher_master_id = $this->commondatamodel->insertSingleTableData('voucher_master',$voucher_master);
        
        return $voucher_master_id;
                    
     
  }

  private function insertvoucherdetails($voucher_master_id,$tran_tag,$acc_id,$payment_now,$srl=1,$member_acc_code=NULL,$membership_ref=NULL){
    $session = $this->session->userdata('mantra_user_detail');
    $voucherDtlArry = array(
			"master_id" => $voucher_master_id,
			"srl_no" => $srl,
			"tran_tag" => $tran_tag,
			"acc_id" => $acc_id, 
			"pay_to_id" => '',
			"pay_month" => '',
			"amount_old" => '0.00',
			"amount" => $payment_now,
			"accountcode" => $member_acc_code,
			"membership_no" => $membership_ref
      );
      $voucher_master_id = $this->commondatamodel->insertSingleTableData('voucher_detail',$voucherDtlArry);

  }


}