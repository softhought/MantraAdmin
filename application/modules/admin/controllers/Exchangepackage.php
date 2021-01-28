<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Exchangepackage extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		  $this->load->model('renewalremidermodel','renewalremidermodel',TRUE);		  
		  $this->load->model('renewalemindersmsmodel','renewalemindersmsmodel',TRUE);		  
		  $this->load->model('walletmodel','walletmodel',TRUE);		  
		  $this->load->model('registrationmodel','registrationmodel',TRUE);		  
		  $this->load->model('vouchermodel','vouchermodel',TRUE);		  
		  $this->load->model('corporatecompanymodel','corporatecompanymodel',TRUE);		  
		  $this->load->model('exchangepackagemodel','exchangepackagemodel',TRUE);		  
          $this->load->module('template');		

    }
    public function addeditexchangepack(){
   
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];
            if($this->uri->segment(4) == NULL){
      
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";  
                $data['btnTextLoader'] = "Saving..."; 
                $data['cus_id'] =$this->uri->segment(4);
                
               
                
      
               }
      
               $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
               $data['cardlist'] = $this->registrationmodel->getCardList($company_id); 
               $data['dueinstallmentlist'] = $this->renewalremidermodel->getinstallmentperiod($company_id); 
               $data['cgstlist'] = $this->registrationmodel->GetGSTRate('CGST',$company_id);
               $data['sgstlist'] = $this->registrationmodel->GetGSTRate('SGST',$company_id);
               $data['trainerlist'] = $this->renewalemindersmsmodel->GetTrainerListAll($company_id);
               $data['userlist'] = $this->exchangepackagemodel->getUsers($company_id);
               //pre($data['walletdtl']);exit;
      
           $data['view_file'] = 'dashboard/registration/exchange-package/addedit_exchange_package';        
      
            $this->template->admin_template($data); 
      
        
        }else{
      
            redirect('admin','refresh');
      }
      
      }
    
public function getCurrentPackage(){

       
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];
            $mobile_no =  $this->input->post('mobile_no');
            
            
            $packagelist = $this->commondatamodel->getCurrentPackage($mobile_no,$company_id);  
            //pre($locationlist);exit;
            $currentpack = '';
            $currentpack.='<option value="">Select</option>';
            if(!empty($packagelist)){
            foreach($packagelist as $packagelist){
                $member_acc_code = $packagelist->member_acc_code;
                $name = $packagelist->CUS_CARD." - ".$packagelist->CUS_NAME." - ".$packagelist->MEMBERSHIP_NO;
              $currentpack.='<option value="'.$packagelist->CUS_ID.'">'.$name.'</option>';
            }
          }

          $promoList = $this->walletmodel->GetPromoWithMemberAccCode($member_acc_code);
          $cashbackList = $this->walletmodel->GetCashbackWithMemberAccCode($member_acc_code);
          $walletdtl = array();
          $walletdtlview = "";
          if(empty($promoList)){
            $walletdtl = $cashbackList ;
            }else if(empty($cashbackList)){
             $walletdtl = $promoList;
            }else{
              $walletdtl = array_merge($promoList, $cashbackList);
           }
           $wallet_cash = 1;
           if(empty($walletdtl)){
               $wallet_cash = 0;
           }

           $walletdtlview.="<option value=''>Select</option>";
           foreach($walletdtl as $walletdtl){

            if($walletdtl->is_promo == 'Y'){
                $walletdtlview.="<option data-amount=".$walletdtl->amount." data-ispromo=".$walletdtl->is_promo." value=".$walletdtl->is_promo.'_'.$walletdtl->id.'_'.$walletdtl->amount.">".$walletdtl->title.' - '.$walletdtl->amount."</option>";

            }else{

                $walletdtlview.="<option data-amount=".$walletdtl->amount." data-ispromo=".$walletdtl->is_promo." value=".$walletdtl->is_promo.'_'.$walletdtl->id.'_'.$walletdtl->amount.">".'Cashback'.' - '.$walletdtl->amount."</option>";

           }
        }
                               


            $json_response = array('currentpack'=>$currentpack,'walletdtlview'=>$walletdtlview,'wallet_cash'=>$wallet_cash);
            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit; 
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }

    public function getpackageandmemberdtl(){

       
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];

            $cus_id =  $this->input->post('cus_id');

            $memberdtl = $this->exchangepackagemodel->getDetailCustomer($cus_id);
            
            $customerdtl = array();            
            $mno = $memberdtl->MEMBERSHIP_NO;
            $validity = $memberdtl->VALIDITY_STRING;
            $branch_id = $memberdtl->branch_id;
            $pid = $memberdtl->PAYMENT_ID;
            $paidamount = $memberdtl->AMOUNT;
            $appGrantDys = $memberdtl->grant_days;
            $prm = $memberdtl->SUBSCRIPTION;
            $disc = 0;$sum_payment=0;
            $actualExpiryDt =  date('Y-m-d', strtotime($memberdtl->VALID_UPTO. ' + '.$appGrantDys.' days'));

            $due_paidAmt = $this->exchangepackagemodel->getDuePaid($mno,$validity,$pid);
            $totalPaid = $paidamount+$due_paidAmt;

            $paymentdtl = $this->exchangepackagemodel->GetPaymentByValidity($mno,$validity);

            foreach($paymentdtl as $paymentdtl){
                $sum_payment=$sum_payment + $paymentdtl->AMOUNT;
                $disc= $disc + ($paymentdtl->DISCOUNT_CONV + $paymentdtl->DISCOUNT_OFFER + $paymentdtl->DISCOUNT_NEGO + $paymentdtl->WALLET_AMT);
            }

            $due=$prm-($sum_payment+$disc);

            if($due<0)
            {
                $due = 0;
            }
                $customerdtl = array(
                                            'MEMBERSHIP_NO'=>$mno,
                                            'REGISTRATION_DT'=>date('d-m-Y',strtotime($memberdtl->REGISTRATION_DT)),
                                            'CARD_DESC'=>$memberdtl->CARD_DESC,
                                            'VALIDITY_STRING'=>$validity,
                                            'CUS_NAME'=>$memberdtl->CUS_NAME,
                                            'CUS_PHONE'=>$memberdtl->CUS_PHONE,
                                            'grant_days'=>$appGrantDys,
                                            'actualExpiryDt'=>date('d-m-Y',strtotime($actualExpiryDt)),
                                            'FROM_DT'=>date('d-m-Y',strtotime($memberdtl->FROM_DT)),
                                            'start_dt'=>date('Y-m-d',strtotime($memberdtl->FROM_DT)),
                                            'totalPaid'=>$totalPaid,
                                            'DUE'=>$due,
                                            'branch_id'=>$branch_id,
                                         );
          

            //pre($customerdtl);exit;
            $json_response = array('customerdtl'=>$customerdtl);
            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;

        }else{
            redirect('admin','refresh');
      
      }
    
    }
    public function getpackagedtl(){

       
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];

            $card_id =  $this->input->post('card_id');
            $card_code =  $this->input->post('card_code');
            $branch_code =  $this->input->post('branch_code');

            $where = array('CARD_ID'=>$card_id);
            $carddtl= $this->commondatamodel->getSingleRowByWhereCls('card_master',$where); 

            $where_sale = array('branch'=>$branch_code,'package'=>$card_code,'company_id'=>$company_id,'is_active'=>'Y');
            $cashbackdtl = $this->commondatamodel->getSingleRowByWhereCls('on_sale_cash_back_master',$where_sale);

            $ratedtl= $this->renewalremidermodel->getRateDetailByCompany($branch_code,$card_code,$company_id);
            if(!empty($ratedtl)){
                $package_rate = $ratedtl->package_rate;
            }else{
             $package_rate = 0;
            }
            if(!empty($cashbackdtl)){
                $cashback_on_sale = $cashbackdtl->cashback_amt;
            }else{
             $cashback_on_sale = 0;
            }
           if(!empty($carddtl)){
               $card_activedays = $carddtl->CARD_ACTIVE_DAYS;
           }else{
            $card_activedays = 0;
           }

            $json_response = array('card_activedays'=>$card_activedays,'cashback_on_sale'=>$cashback_on_sale,'package_rate'=>$package_rate);
            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;

        }else{
            redirect('admin','refresh');
      
      }
    
    }

    public function addedit_action(){
        if($this->session->userdata('mantra_user_detail'))
    
        {
    
          $session = $this->session->userdata('mantra_user_detail');
          $comp = $session['companyid'];
          $year_id = $session['yearid'];
          $user_id = $session['userid'];
         
          $mode = trim(htmlspecialchars($this->input->post('mode')));
          $cus_id = trim(htmlspecialchars($this->input->post('cus_id')));
          $transfer_branch = trim(htmlspecialchars($this->input->post('transfer_branch')));
          $branch_id = trim(htmlspecialchars($this->input->post('branch')));
          $where_brn = array('BRANCH_ID'=>$branch_id);
          $branch_code = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_brn)->BRANCH_CODE; 

          $trainer = trim(htmlspecialchars($this->input->post('trainer')));
          $mother_mem_no = trim(htmlspecialchars($this->input->post('membership_no')));
          $mother_validity = trim(htmlspecialchars($this->input->post('validity_pd')));

          $where = array('CUS_ID'=>$cus_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $total_amount =0;
          $member_acc_code=$memberdtl->member_acc_code;
          $phone=$memberdtl->CUS_PHONE;
          $old_card_code=$memberdtl->CUS_CARD;
          $old_card_id=$memberdtl->card_id;
          $corporate_comp_id = $memberdtl->corporate_comp_id;
          $old_branch = $memberdtl->CUS_BRANCH;
         

          $prv_pckg_paid_amt = trim(htmlspecialchars($this->input->post('prv_pckg_paid_amt')));
          if(trim(htmlspecialchars($this->input->post('packg_start_dt'))) != ''){          
              $open_date = date('Y-m-d',strtotime($this->input->post('packg_start_dt')));
             }else{
              $open_date=NULL;
             }

             

             $rowPaymentdetails=$this->exchangepackagemodel->Getpaymentdetails($mother_mem_no,$mother_validity);
             
               $payment_date=$rowPaymentdetails->PAYMENT_DT;
               $valid_upto=$rowPaymentdetails->VALID_UPTO;
               $expiry_dt=$rowPaymentdetails->EXPIRY_DT;
              

          if($transfer_branch == 'TOB' || $transfer_branch == 'TSB'){

            

              if($transfer_branch == 'TOB'){
                $from_branch = trim(htmlspecialchars($this->input->post('from_branch')));
                $where_brn = array('BRANCH_ID'=>$from_branch);
                $transfer_from_branch = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_brn)->BRANCH_CODE; 
       
                $transfer_to_branch = $branch_code;
              }else{
                $transfer_from_branch = NULL;
                $transfer_to_branch = NULL;
              }
            
           
            if(trim(htmlspecialchars($this->input->post('payment_dt'))) != ''){          
             $payment_dt = date('Y-m-d',strtotime($this->input->post('payment_dt')));
            }else{
             $payment_dt=NULL;
            }
            if($this->input->post('complimentry') == 'on'){
             $is_compl = 'Y';
           }
           else{
             $is_compl = 'N';
           }
         
           $card_id = trim(htmlspecialchars($this->input->post('sel_card')));

           $where_card = array('CARD_ID'=>$card_id);
           $card_code = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where_card)->CARD_CODE;

           $grantdays = trim(htmlspecialchars($this->input->post('grantdays')));
           $subscription_amt = trim(htmlspecialchars($this->input->post('package_rate')));
           $paid_amt = trim(htmlspecialchars($this->input->post('paid_amt')));
           $disc_nego = trim(htmlspecialchars($this->input->post('disc_nego')));
           $disc_conv = trim(htmlspecialchars($this->input->post('disc_conv')));
           $disc_offer = trim(htmlspecialchars($this->input->post('disc_offer')));
           $rem_nego = trim(htmlspecialchars($this->input->post('rem_nego')));
            $wallet_cashback = $this->input->post('wallet_cashback');
            $cashback_amt = 0;
           if($wallet_cashback != ""){
              $wallet_cashback_dtl = explode('_',$wallet_cashback);
     
               $is_promo = $wallet_cashback_dtl[0];
             if($is_promo == 'Y'){
               $promo_cashback_id = $wallet_cashback_dtl[1];
             }else{
               $promo_cashback_id = $wallet_cashback_dtl[1];
             }
            
             $cashback_amt = $wallet_cashback_dtl[2];
           }
           
             
         
           $premium_amt = trim(htmlspecialchars($this->input->post('premium_amt')));
           $payment_now = trim(htmlspecialchars($this->input->post('payment_now')));
     
           $due_amt = trim(htmlspecialchars($this->input->post('due_amt')));
          
           $cgstRateID = trim(htmlspecialchars($this->input->post('cgstrate')));
           $sgstRateID = trim(htmlspecialchars($this->input->post('sgstrate')));
           $payable_amt = trim(htmlspecialchars($this->input->post('payable_amt')));
           $payment_mode = trim(htmlspecialchars($this->input->post('payment_mode')));
     
           $cheque_no = trim(htmlspecialchars($this->input->post('cheque_no')));
           if(trim(htmlspecialchars($this->input->post('cheque_date'))) != ''){          
             $cheque_date = date('Y-m-d',strtotime($this->input->post('cheque_date')));
            }else{
             $cheque_date=NULL;
            }
         
           $cheque_bank = trim(htmlspecialchars($this->input->post('cheque_bank')));
           $cheque_branch = trim(htmlspecialchars($this->input->post('cheque_branch')));
           $dony_by = trim(htmlspecialchars($this->input->post('dony_by')));
           if($this->input->post('hold_mno') == 'on'){
            $is_act = 'H';
          }
          else{
            $is_act = 'Y';
          }
           $collection_branch_id = trim(htmlspecialchars($this->input->post('collection_branch')));
     
           $where_col_brn = array('BRANCH_ID'=>$collection_branch_id);
           $coll_branch_dtl= $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_col_brn);
           $coll_brn_code = $coll_branch_dtl->BRANCH_CODE;

           $srl=$this->gen_serial_brn($branch_code,$card_code,$comp);               
           $mno=$this->gen_mem_no_pad($branch_code,$card_code,$srl,$comp); 

            
           $cgstTaxAmt = 0;
          $total_amount = 0;
          $sgstTaxAmt = 0;
         /********---CGST------**********/
          if($cgstRateID>0)
          {	
            $rowCGSTData =  $this->vouchermodel->GetGSTRateByID('CGST',$cgstRateID);
            $cgstrate= $rowCGSTData->rate;
            $cgstAccID = $rowCGSTData->accountId;
            $cgstTaxAmt = (($cgstrate/100) * $payment_now);
          }
         
          /*------********----SGST--------*/	
          if($sgstRateID>0)
          {
              $rowSGSTData = $this->vouchermodel->GetGSTRateByID('SGST',$sgstRateID);            
              $sgstrate=  $rowSGSTData->rate;
              $sgstAccID = $rowSGSTData->accountId;
              $sgstTaxAmt = (($sgstrate/100) * $payment_now);
          }

          $total_amount = $payment_now + $cgstTaxAmt + $sgstTaxAmt;  
          if ($is_compl=="N")
          {                
                $rcpt_srl= $this->vouchermodel->gen_rcpt_serial_brn_fin($branch_code,$year_id,$comp);
          }else {
                $rcpt_srl=0;
          }

          $duration = $this->vouchermodel->get_duration($card_code,$comp);

           $totalDys = $duration+$grantdays;
           $valid_upto =  date('Y-m-d', strtotime($open_date. ' + '.$totalDys.' days')); 
             
           $valid_string=$open_date." - ".$valid_upto;

           $rowCard = $this->registrationmodel->getCardDtlByCode($card_code,$comp);
            $card_id = $rowCard->CARD_ID;
            $card_category = $rowCard->CARD_PREFIX;
            $card_desc = $rowCard->CARD_DESC;
            $card_acc_id = $rowCard->account_id;

            if($corporate_comp_id > 0)
            {            
              $rowCorpoComp = $this->corporatecompanymodel->getCorporateCompanydata($corporate_comp_id);
              $mem_account_id = $rowCorpoComp->account_id; //Account ID Consider for Member
             
              $membership_ref = NULL;
              $mem_acc_code = NULL;
            }
            else
            {
              $sundry_debtor = "Sundry Debtor";
              $rowGetSundDebAcc = $this->vouchermodel->getAccountIDBydesc($sundry_debtor,$comp);          
              $mem_account_id = $rowGetSundDebAcc->account_id; //Account ID Consider for Member           
              $membership_ref = $mno;
              $mem_acc_code = $member_acc_code;
            }

            if($branch_code!="LT" && $branch_code!="TR" && $is_compl=="N"  && $payment_now>0)
          {
           
            $cust_ins_id = $this->insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_dt,$is_act,$dony_by,$is_compl,$transfer_from_branch,$transfer_to_branch);

            $disc_conv+= $prv_pckg_paid_amt;
            $payment_from = 'EXC';

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$subscription_amt,$disc_conv,$disc_offer,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cust_ins_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,0,$payment_from);

            $where_cus = array('CUS_ID'=>$cust_ins_id);
            $upd_customer = array('PAYMENT_ID'=>$payment_master_id);
            $this->commondatamodel->updateSingleTableData('customer_master',$upd_customer,$where_cus);
            $where_mother_cus = array('CUS_ID'=>$cus_id);
            $upd_mother_customer = array('IS_ACTIVE'=>'N');
            $this->commondatamodel->updateSingleTableData('customer_master',$upd_mother_customer,$where_mother_cus);

             //  insert voucher master
             $narration = 'Exchange Package '.$old_card_code.' To '.$card_code;
             $voucherno_prefix = 'RG';
             $serial_char = 'A';
             $payment_from = "REG";
             $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoNew($year_id,$comp);
             $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char);
             $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentModeByBrnCode($branch_code,$payment_mode,$comp);
             
             // voucher master insert data for voucher A
              $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$total_amount,$card_category,$card_id,$card_code,$card_desc);
              // voucher details insert data  for voucher A
              if($voucher_master_id > 0){
 
               $this->insertvoucherdetails($voucher_master_id,'Cr',$card_acc_id,$payment_now,1);
               $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
               $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
               $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$total_amount,4,$member_acc_code,$membership_ref);
               }
 
               // voucher master insert data for voucher B
               $serial_char2 = 'B';
               $voucher_no2 = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char2);
 
               $voucher_master_id2 = $this->insertvouchermaster($voucher_srl,$voucher_no2,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$total_amount,$card_category,$card_id,$card_code,$card_desc,$cheque_no,$cheque_date,$cheque_bank,   $cheque_branch);
               // voucher details insert data  for voucher B
               if($voucher_master_id > 0 && $voucher_master_id2 > 0){
               $this->insertvoucherdetails($voucher_master_id2,'Cr',$mem_account_id,$total_amount,1,$member_acc_code,$membership_ref);
               $this->insertvoucherdetails($voucher_master_id2,'Dr',$debit_acc_id,$total_amount,2);
 
               $where_voucher_srl = array('year_id'=>$year_id,'company_id'=>$comp);
               $voucher_arr = array('last_srl'=>$voucher_srl+1);
               $voucher_master = $this->commondatamodel->updateSingleTableData('voucher_srl_master',$voucher_arr,$where_voucher_srl);
 
 
               $where_payment = array('PAYMENT_ID'=>$payment_master_id);
               $upd_payment = array('voucher_master_id'=>$voucher_master_id,'second_voucher_mast_id'=>$voucher_master_id2);
               $upd_enq = $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment,$where_payment);
               }

               // Amount Distribution Per Month

              $this->calmemberAmountDistribution($mno,$branch_code,$card_code,$open_date,$valid_upto,$valid_string,$premium_amt,$payment_master_id,$comp);

              //Start due payable insert
              if($due_amt > 0){
                $installment_period = trim($this->input->post('installment_phase'));
                 if($installment_period > 0){

                   $installment_dt = $this->input->post('installment_dt');
                   $installmentamt = $this->input->post('installmentamt');
                   $dueinstallmentchrg = $this->input->post('dueinstallmentchrg');
                   $installmentcheque = $this->input->post('installmentcheque');
                   $installmentbank = $this->input->post('installmentbank');
                   $installmentbranch = $this->input->post('installmentbranch');
                   //pre($installment_dt);exit;

                   for($i=0;$i<$installment_period;$i++){

                         if($installment_dt[$i] != ""){ 
                           $date_installment = date('Y-m-d',strtotime($installment_dt[$i])); 
                         }else{
                           $date_installment = NULL;
                         }
                         $due_payable_amt = $installmentamt[$i];
                         $installment_charge = $dueinstallmentchrg[$i];
                         $pybl_cheque_no = $installmentcheque[$i];
                         $pybl_bank = $installmentbank[$i];
                         $pybl_branch = $installmentbranch[$i];
                         $due_amt = $due_payable_amt - $installment_charge;
                         $from_where = 'EXC';

                         $this->insertduepayable($cust_ins_id,$mno,$date_installment,$due_amt,$installment_charge,$due_payable_amt,$branch_code,$card_code,$valid_string,$from_where,$payment_master_id,$pybl_cheque_no,$pybl_bank,$pybl_branch,$card_id);
                       }
                 }                 

             } 
             
             //End due payable insert

              // start cash back insert data

              if($wallet_cashback != "" && ($is_promo == "Y" || $is_promo == "N")){

                $getPromoDetail = $this->commondatamodel->getSingleRowByWhereCls("promo_cashbck_assign_to_mem",["promo_cashbck_assign_to_mem.id"=>$promo_cashback_id]);
    
                    $insert_promo = [];
                    $insert_promo = [
                        "promo_cashback_id" => $getPromoDetail->transaction_id,
                        "mobile_no" => $phone,
                        "amount" => $cashback_amt,
                        "payment_id" => $payment_master_id,
                        "is_debit" => 'Y',
                        "tran_module" => 'EXC',
                        "tran_date" => date("Y-m-d H:i:s"),
                        "promo_cashback_assign_id" =>($is_promo == "Y") ? 0 : $promo_cashback_id,
                        "case_dtl_type" => "For Exchange ".$card_code." Package",
                        "member_acc_code" => $member_acc_code,
                        "attendance_month" => NULL,
                        "membership_no" => ($is_promo == "Y") ? NULL :$getPromoDetail->membership_no,
                        "validity_string" => ($is_promo == "Y") ? NULL : $getPromoDetail->validity_string,
                        "expire_dt" => ($is_promo == "Y") ? NULL : $getPromoDetail->expire_dt
                        
                    ]; 

                    $promo_or_cash_back = $this->commondatamodel->insertSingleTableData("promo_cashbck_pmnt_dtl",$insert_promo);
    
                    // Update Cash Back Or Promo
                    $promoOrgBalance = $getPromoDetail->amount;
                    $remaningBalance = 0;
                    $remaningBalance = $promoOrgBalance - $cashback_amt;
    
                 $update_balance = $this->commondatamodel->updateSingleTableData("promo_cashbck_assign_to_mem",["promo_cashbck_assign_to_mem.amount"=>$remaningBalance],["promo_cashbck_assign_to_mem.id"=>$promo_cashback_id]);	
                    
                $this->cashbackaction($cust_ins_id,$mno,$valid_string,$valid_upto,$card_code,$branch_code);


              }else{

                $this->cashbackaction($cust_ins_id,$mno,$valid_string,$valid_upto,$card_code,$branch_code);

              }
              // end cash back insert data




          }else{

            $cust_ins_id = $this->insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_dt,$is_act,$dony_by,$is_compl,$transfer_from_branch,$transfer_to_branch);

            $disc_conv+= $prv_pckg_paid_amt;
            $payment_from = 'EXC';

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$subscription_amt,$disc_conv,$disc_offer,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cust_ins_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,0,$payment_from);

            $where_cus = array('CUS_ID'=>$cust_ins_id);
            $upd_customer = array('PAYMENT_ID'=>$payment_master_id);
            $this->commondatamodel->updateSingleTableData('customer_master',$upd_customer,$where_cus);
            $where_mother_cus = array('CUS_ID'=>$cus_id);
            $upd_mother_customer = array('IS_ACTIVE'=>'N');
            $this->commondatamodel->updateSingleTableData('customer_master',$upd_mother_customer,$where_mother_cus);

             }

           

          }else  if($transfer_branch == 'TRN'){
            
             $is_act='Y';$dony_by=NULL;$is_compl='N';
             $transfer_from_branch = $old_branch;
             $transfer_to_branch = $branch_code;

             $srl=$this->gen_serial_brn($branch_code,$old_card_code,$comp);               
             $mno=$this->gen_mem_no_pad($branch_code,$old_card_code,$srl,$comp); 
             $card_code = $old_card_code;
             $card_id = $old_card_id;
             $valid_string = $mother_validity;
             $cust_ins_id = $this->insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_date,$is_act,$dony_by,$is_compl,$transfer_from_branch,$transfer_to_branch);
             $payment_from = 'TRN';
             $payment_master_id = $this->insertpaymentmaster($mno,$old_card_code,$open_date,$valid_upto,0,0,NULL,0,0,0,0,0,0,0,NULL,0,NULL,0,$payment_date,$branch_code,NULL,NULL,NULL,NULL,NULL,NULL,$cust_ins_id,$mother_validity,NULL,0,NULL,$branch_id,$old_card_id,0,$payment_from);

             $where_cus = array('CUS_ID'=>$cust_ins_id);
             $upd_customer = array('PAYMENT_ID'=>$payment_master_id);
             $this->commondatamodel->updateSingleTableData('customer_master',$upd_customer,$where_cus);
             $where_mother_cus = array('CUS_ID'=>$cus_id);
             $upd_mother_customer = array('IS_ACTIVE'=>'N');
             $this->commondatamodel->updateSingleTableData('customer_master',$upd_mother_customer,$where_mother_cus);
            
          } 

           //start insert member compaliment 
          
           $rowCardDetail=$this->registrationmodel->getCardDetail($branch_code,$card_code,$comp);
          
           foreach($rowCardDetail as $row_detail)
           {
               $coupon_id=$row_detail->coupon_id;
               $qty=$row_detail->qty;
               $desc=$row_detail->detail_description;

               $insert_mem_comp_arr['member_id']=$cust_ins_id;
               $insert_mem_comp_arr['membership_no']=$mno;
               $insert_mem_comp_arr['coupon_id']=$coupon_id;
               $insert_mem_comp_arr['pack_compl']=$desc;
               $insert_mem_comp_arr['qty']=$qty;
               $insert_mem_comp_arr['card_code']=$card_code;
               $insert_mem_comp_arr['branch_code']=$branch_code;
               $insert_mem_comp_arr['validity_string']=$valid_string;
               $insert_mem_comp_arr['renew_id']=NULL;

               $this->commondatamodel->insertSingleTableData("member_compliment",$insert_mem_comp_arr);

           }

            //$oldvalidity=$obj_reg_inc->getoldvalidity($mother_mem_no);
            $prememcompl=$this->exchangepackagemodel->getcomplconsumptionbymem($mother_mem_no,$mother_validity);

            foreach($prememcompl as $prememcompl){
                    $insert_predata = array(
		                              'date_of_consmp'=>$prememcompl['date_of_consmp'],
		                              'member_id'=>$prememcompl['member_id'],
		                              'membership_no'=>$mno,
		                              'card_code'=>$card_code,
		                              'branch_code'=>$branch_code,
		                              'coupon_id'=>$prememcompl['coupon_id'],
		                              'consumed_amt'=>$prememcompl['consumed_amt'],
		                              'coupon_rate'=>$prememcompl['coupon_rate'],
		                              'disc_rate'=>$prememcompl['disc_rate'],
		                              'coupon_value'=>$prememcompl['coupon_value'],
		                              'payment_id'=>$prememcompl['payment_id'],
		                              'facility_tag'=>$prememcompl['facility_tag'],
		                              'validity_string'=>$valid_string,
		                              'guest_mobile'=>$prememcompl['guest_mobile'],
		                              'guest_name'=>$prememcompl['guest_name'],
		                              'gender'=>$prememcompl['gender'],
		                              'guest_email'=>$prememcompl['guest_email'],
		                              'message'=>$prememcompl['message'],
		                              'tran_from'=>$prememcompl['tran_from'],
		                              'cus_type'=>$prememcompl['cus_type'],
		                              'online_counselling_id'=>$prememcompl['online_counselling_id'],
		                              'booking_master_id'=>$prememcompl['booking_master_id'],
		                              'is_present'=>$prememcompl['is_present'],
		                              'is_cancel'=>$prememcompl['is_cancel'],
		                              'copied_from'=>($prememcompl['copied_from'] == "") ? $mother_mem_no : $prememcompl['copied_from']
						          );
            $this->commondatamodel->insertSingleTableData("compliment_consumption",$insert_predata);
        
        }
                        
           //end insert member compaliment
           $sent_msg = 'N';

           $isSms= $this->isSmsFacility($comp);
                 
          //  if($isSms=='Y'){

          //     $message = "Your Mantra membership no ".$mno." has been successfully renewed with payment of Rs. ".$total_amount." Thank You for being part of Mantra family!";
              
          //     $sent_msg =  mantraSend($phone,$message);
          //  }


                 
          if($payment_master_id){

            $json_response = array(
                "msg_status" => 1,
                "msg_data"=>'Saved Successfully',              
                "mode"=>$mode,
                "cust_ins_id"=>$cust_ins_id, 
                "pmt_ins_id"=>$payment_master_id, 
                "sent_msg"=>$sent_msg 
               
            );
    
           } else{
            $json_response = array(
                "msg_status" => 0,
                "msg_data" => "There is some problem while updating ...Please try again."     
    
            );
        }
    
          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit;       
    
        }else{
        redirect('admin','refresh');
    
       }
    
    }
    private function insertduepayable($cus_id,$mno,$date_installment,$due_amt,$installment_charge,$due_payable_amt,$branch_code,$card_code,$valid_string,$from_where,$payment_master_id,$pybl_cheque_no,$pybl_bank,$pybl_branch,$card_id){
      $session = $this->session->userdata('mantra_user_detail');
    
      $due_insert_arr = array(
        "member_id" => $cus_id,
        "membershipno" => $mno,
        "due_pybl_date" => $date_installment,
        "due_amt" => $due_amt, 
        "due_installment_chrgs" => $installment_charge,
        "due_pybl_amt" => $due_payable_amt,
        "BRANCH_CODE" => $branch_code,
        "CARD_CODE" => $card_code,
        "validity_string" => $valid_string,
        "from_where" => $from_where,
        "from_payment_id" => $payment_master_id,
        "company_id" => $session['companyid'],
        "pybl_cheque_no" => $pybl_cheque_no,
        "pybl_bank" => $pybl_bank,
        "pybl_branch" => $pybl_branch,
        'card_id'=>$card_id
       
        );
         $this->commondatamodel->insertSingleTableData('due_payable',$due_insert_arr);
    
    }  
    private function insertvouchermaster($voucher_srl,$voucher_no,$payment_date,$branch_id,$tran_type,$narration,$paymentid,$totalAmt=0,$card_category=NULL,$card_id=NULL,$card=NULL,$card_desc=NULL,$cheque_no=NULL,$cheque_date=NULL,$cheque_bank=NULL,$cheque_branch=NULL){
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
          "cheque_no" => $cheque_no,
          "cheque_date" =>$cheque_date,
          "bank_name" => $cheque_bank,
          "bank_branch" => $cheque_branch,
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
private function insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$subscription_amt,$disc_conv,$disc_offer,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$totalAmt,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$user_given_extentiondays,$payment_from){
      $session = $this->session->userdata('mantra_user_detail');
      $payment_arr = array(
                            'MEMBERSHIP_NO'=>$mno,
                            'CARD_CODE'=>$card_code,
                            'FROM_DT'=>$open_date,
                            'VALID_UPTO'=>$valid_upto,
                            'EXPIRY_DT'=>$valid_upto,
                            'ADMISSION'=>0,
                            'SUBSCRIPTION'=>$subscription_amt,
                            'DISCOUNT_CONV'=>$disc_conv,
                            'DISCOUNT_OFFER'=>$disc_offer,
                            'DISCOUNT_NEGO'=>$disc_nego,
                            'NEGO_REMARK'=>$rem_nego,
                            'CASHBACK_AMT'=>0,
                            'WALLET_AMT'=>$cashback_amt,
                            'PRM_AMOUNT'=>$premium_amt,
                            'AMOUNT'=>$payment_now,
                            'MNTN_CHG'=>0,
                            'DUE_AMOUNT'=>$due_amt,
                            'SERVICE_TAX'=>NULL,
                            'CGST_RATE_ID'=>$cgstRateID,
                            'CGST_AMT'=>$cgstTaxAmt,
                            'SGST_RATE_ID'=>$sgstRateID,
                            'SGST_AMT'=>$sgstTaxAmt,
                            'TOTAL_AMOUNT'=>$totalAmt,
                            'PAYMENT_DT'=>$payment_dt,
                            'FRESH_RENEWAL'=>'F',
                            'BRANCH_CODE'=>$branch_code,
                            'USER_ID'=>$session['userid'],
                            'FIN_ID'=>$session['yearid'],
                            'RCPT_NO'=>$rcpt_srl,
                            'PAYMENT_MODE'=>$payment_mode,
                            'CHQ_NO'=>$cheque_no,
                            'CHQ_DT'=>$cheque_date,
                            'BANK_NAME'=>$cheque_bank,
                            'BRANCH_NAME'=>$cheque_branch,
                            'CUST_ID'=>$cus_id,
                            'VALIDITY_STRING'=>$valid_string,
                            'payment_from'=>$payment_from,
                            'collection_at'=>$coll_brn_code,
                            'voucher_master_id'=>0,
                            'second_voucher_mast_id'=>0,
                            'IS_GST'=>'Y',
                            'company_id'=>$session['companyid'],
                            'corporate_comp_id'=>$corporate_comp_id,
                            'covid_extention_days'=>0,
                            'user_given_extention'=>$user_given_extentiondays,
                            'card_id'=>$card_id,
                            'branch_id'=>$branch_id,
                            'collection_branch_id'=>$collection_branch_id,
                          );
        $payment_master_id = $this->commondatamodel->insertSingleTableData('payment_master',$payment_arr);
          
        return $payment_master_id;                 
                        
    }



 private function insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_date,$is_act,$dony_by,$is_compl,$transfer_from_branch,$transfer_to_branch)
 {

  $where = array('CUS_ID'=>$cus_id);
  $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 
  //pre($memberdtl);
  $mother_mem_no = $memberdtl->MEMBERSHIP_NO;
  
  $phone = $memberdtl->CUS_PHONE;
  
  unset(
    $memberdtl->CUS_ID,$memberdtl->CUS_CARD,$memberdtl->CUS_BRANCH,$memberdtl->MEMBERSHIP_NO,
    $memberdtl->USER_ID,$memberdtl->FIN_ID,$memberdtl->EXCHNG_MEMBERSHIP_NO,
    $memberdtl->EXCHNG_MEMBERSHIP_ID,$memberdtl->PAYMENT_DT,
    $memberdtl->PAYMENT_ID,$memberdtl->IS_COMPLI,$memberdtl->trainer_id,
    $memberdtl->REGISTRATION_DT,$memberdtl->SRL_NO,$memberdtl->pack_type,$memberdtl->done_by,
    $memberdtl->IS_ACTIVE,$memberdtl->is_converted,$memberdtl->entry_mode,$memberdtl->company_id,
    $memberdtl->transfer_from_branch,$memberdtl->transfer_to_branch,$memberdtl->whatsup_number,
    $memberdtl->branch_id,$memberdtl->card_id,$memberdtl->first_due_date,$memberdtl->first_due_amount,$memberdtl->second_due_date,$memberdtl->second_due_amount,$memberdtl->third_due_date,$memberdtl->third_due_amount,$memberdtl->fourth_due_date,$memberdtl->fourth_due_amount,$memberdtl->fifth_due_date,$memberdtl->fifth_due_amount,$memberdtl->sixth_due_date,$memberdtl->sixth_due_amount
  );

  $memberdtl->CUS_BRANCH=$branch_code;
  $memberdtl->CUS_CARD=$card_code;
  $memberdtl->MEMBERSHIP_NO=$mno;
  $memberdtl->USER_ID=$user_id;
  $memberdtl->FIN_ID=$year_id;
  $memberdtl->EXCHNG_MEMBERSHIP_NO=$mother_mem_no;
  $memberdtl->EXCHNG_MEMBERSHIP_ID=$cus_id;
  $memberdtl->PAYMENT_DT=$open_date;
  $memberdtl->IS_ACTIVE=$is_act;
  $memberdtl->IS_COMPLI=$is_compl;
  $memberdtl->trainer_id=$trainer;
  $memberdtl->REGISTRATION_DT=$open_date;
  $memberdtl->SRL_NO=$srl;
  $memberdtl->pack_type='M';
  $memberdtl->done_by=$dony_by;
  $memberdtl->is_converted='N';
  $memberdtl->entry_mode='EP';
  $memberdtl->company_id=$comp;
  $memberdtl->transfer_from_branch=$transfer_from_branch;
  $memberdtl->transfer_to_branch=$transfer_to_branch;
  $memberdtl->whatsup_number=$phone;
  $memberdtl->branch_id=$branch_id;
  $memberdtl->card_id=$card_id;
  

  $cust_id = $this->commondatamodel->insertSingleTableData('customer_master',$memberdtl);
  return $cust_id;
   
 }   

 function calmemberAmountDistribution($mem,$branch,$card,$fdate,$tdate,$valdstr,$packgamount,$payment_id,$compid)
 {
   $from_dt = $fdate; 
   $to_date = $tdate; 
 
   $arr_months = array();
   $date1 = new DateTime($from_dt);
   $date2 = new DateTime($to_date);
   $month1 = new DateTime($date1->format('Y-m')); //The first day of the month of date 1
 
   while ($month1 < $date2) { 
     $arr_months[$month1->format('Y-m-t')] = cal_days_in_month(CAL_GREGORIAN, $month1->format('m'), $month1->format('Y')); //Add it to the array
     $month1->modify('+1 month'); 
     }
 
     $days_no = 0;
     $distAmount = 0;
     $insert_array = array();
     
     $month_keys = array_keys($arr_months);
     $fdate = reset($month_keys);
    
     $last_date = end($month_keys);
     $fisrt_dy_last_month = date('Y-m-01',strtotime($last_date));
 
     $total_package_dy = $this->getNoOfDays(date('Y-m-d',strtotime($from_dt)),date('Y-m-d',strtotime($to_date)));
 
     foreach ($arr_months as $key => $value) 
     {
       if($key==$fdate)
       {
         $days_no = $this->getNoOfDays(date('Y-m-d',strtotime($fdate)),date('Y-m-d',strtotime($from_dt)));
         
       }
       elseif($key==$last_date)
       {
          $days_no = $this->getNoOfDays(date('Y-m-d',strtotime($to_date)),date('Y-m-d',strtotime($fisrt_dy_last_month)))+1;
       }
       else
       {
         $days_no = $value;
       }
       
 
       $distAmount = $this->getDistributedAmtForMonths($total_package_dy,$days_no,$packgamount);
       $insert_array = array(
         "membership_no" => $mem,
         "valid_from" => date('Y-m-d',strtotime($fdate)),
         "valid_to" => date('Y-m-d',strtotime($tdate)),
         "branch" => $branch,
         "card_code" =>$card,
         "no_of_days" => $days_no,
         "for_month" =>  date('M',strtotime($key)),
         "for_year" => date('Y',strtotime($key)),
         "date_for_month" => $key,
         "process_on" => date('Y-m-d'),
         "amount" => $distAmount,
         "total_package_amt" => $packgamount,
         "validity_string" => $valdstr,
         "payment_id" => $payment_id,
         "company_id" => $compid
       );
       
      $this->commondatamodel->insertSingleTableData('member_per_month_service_detail',$insert_array);
 
       
     
     }
 }
 
 function getNoOfDays($fdate,$tdate)
 {
   $days = 0;
   $date1 = new DateTime($fdate);
   $date2 = new DateTime($tdate);
   $days = $date2->diff($date1)->format("%a");
   return $days;
   
 }
 
 function getDistributedAmtForMonths($total_package_dy,$daysno,$ttlamt)
 {
 
   $dist_Amount = 0;
   $dist_Amount = ($ttlamt*$daysno)/$total_package_dy;
   //$dist_Amount = number_format($dist_Amount,2);
    return $dist_Amount;
 }
 
 private function cashbackaction($cus_id,$mno,$valid_string,$valid_upto,$card_code,$branch_code){
   
   $where = array('CUS_ID'=>$cus_id);
   $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 
   $cus_name = $memberdtl->CUS_NAME;
   $member_acc_code=$memberdtl->member_acc_code;
   $phone=$memberdtl->CUS_PHONE;
          
   $session = $this->session->userdata('mantra_user_detail');
   $comp = $session['companyid'];
   $branch = $branch_code;$card = $card_code;
   $membership_no = $mno;
   $newValidityString = $valid_string;
   $new_valid_upto = $valid_upto;
 
   $cashbackonsale = $this->registrationmodel->getCashBackOnSaleAmt($branch,$card,$comp);
   
   $getwithoutexpirecash = $this->walletmodel->getwithoutexpirecashback($member_acc_code);
   $getexistscaseback = $this->walletmodel->getexistscaseback($member_acc_code);
  //pre($getwithoutexpirecash);exit;
           
   //Cashback master data			 
   $caseback_assign_to_mem_arr['mobile_no'] = $phone;
   $caseback_assign_to_mem_arr['branch_code'] = $branch;
   $caseback_assign_to_mem_arr['is_promo']= 'N';
   $caseback_assign_to_mem_arr['is_expired']='N';
   $caseback_assign_to_mem_arr['member_acc_code']=$member_acc_code;
   //$caseback_assign_to_mem_arr['membership_no']=$member['MEMBERSHIP_NO'];
  
   //cashback detail 
   $cashbck_pmnt_dtl_arr['mobile_no']= $phone;				
   $cashbck_pmnt_dtl_arr['payment_id']=NULL ;
   $cashbck_pmnt_dtl_arr['is_debit']='N' ;
   $cashbck_pmnt_dtl_arr['tran_module']='EXC';
   $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']='0';
   $cashbck_pmnt_dtl_arr['case_dtl_type']='For Exchange '.$card.' Package';
   $cashbck_pmnt_dtl_arr['member_acc_code']=$member_acc_code;
    //$cashbck_pmnt_dtl_arr['membership_no']=$member['MEMBERSHIP_NO']; 
    
   
   if(!empty($cashbackonsale)){
 
       $cur_cashback_amt = $cashbackonsale->cashback_amt;
       $cashbackId = $cashbackonsale->id;
       $caseback_assign_to_mem_arr['transaction_id']=$cashbackId;
       $cashbck_pmnt_dtl_arr['promo_cashback_id']= $cashbackId;
 
       if(!empty($getwithoutexpirecash)){
 
           $cashbackExpiredate = $this->walletmodel->getCashbackExiredate($member_acc_code,$new_valid_upto);
          //$old_validity = $member['FROM_DT']." - ".$member['EXPIRY_DT'];
           if(!empty($cashbackExpiredate)){
               $caseback_assign_to_mem_arr['membership_no']=$membership_no; 
               $caseback_assign_to_mem_arr['validity_string']=$newValidityString;
               $caseback_assign_to_mem_arr['expire_dt']=$new_valid_upto;				
                     
           }
 
               $cashbck_pmnt_dtl_arr['membership_no']=$membership_no; 
               $cashbck_pmnt_dtl_arr['validity_string']= $newValidityString;      
               $cashbck_pmnt_dtl_arr['expire_dt']= $new_valid_upto; 
   
          
           $pre_caseback_amt = $getwithoutexpirecash->amount;
           $amount_Deduct = $cur_cashback_amt + $pre_caseback_amt;
 
           $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;							      
 
           $wherecashbackmst = array("member_acc_code"=>$member_acc_code,"is_promo"=>'N');
 
           $update_caseback = $this->commondatamodel->updateSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr,$wherecashbackmst);
 
           $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$getwithoutexpirecash->id;
           $cashbck_pmnt_dtl_arr['amount']=$cur_cashback_amt;
 
               //  echo "<pre>";
               //  print_r($cashbck_pmnt_dtl_arr);
               //  echo "<pre>";exit;
          
           $insert_caseback = $this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);
       
 
       }else{
 
           $caseback_assign_to_mem_arr['amount'] = $cashbackonsale->cashback_amt;
 
 
           if(!empty($getexistscaseback)){
 
               $pre_caseback_amt = $getexistscaseback->amount;
               $caseback_assign_id = $getexistscaseback->id;
 
               $caseback_assign_to_mem_arr['membership_no']=$membership_no; 
               $caseback_assign_to_mem_arr['validity_string']=$newValidityString;
               $caseback_assign_to_mem_arr['expire_dt']=$new_valid_upto;	
               
               $wherecashbackmst = array("member_acc_code"=>$member_acc_code,"is_promo"=>'N');
 
               $update_caseback = $this->commondatamodel->updateSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr,$wherecashbackmst);
               
               //for expire amount 
               $cashbck_pmnt_dtl_arr['amount']=$pre_caseback_amt;
               $cashbck_pmnt_dtl_arr['case_dtl_type']='CashBack Expire'; 
               $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id; 
               $cashbck_pmnt_dtl_arr['is_debit']='Y' ;
               $cashbck_pmnt_dtl_arr['membership_no']=$getexistscaseback->membership_no;     
               $cashbck_pmnt_dtl_arr['validity_string']=$getexistscaseback->validity_string;      
               $cashbck_pmnt_dtl_arr['expire_dt']=$getexistscaseback->expire_dt; 
 
              
               $insert_caseback = $this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);
       
               
               //for new cashback
               $cashbck_pmnt_dtl_arr['amount']=$cashbackonsale->cashback_amt;	
               $cashbck_pmnt_dtl_arr['is_debit']='N' ;	
               $cashbck_pmnt_dtl_arr['case_dtl_type']='For Exchange '.$card.' Package';						
               $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;
               $cashbck_pmnt_dtl_arr['membership_no']=$membership_no;      
               $cashbck_pmnt_dtl_arr['validity_string']=$newValidityString;      
               $cashbck_pmnt_dtl_arr['expire_dt']=$new_valid_upto;
 
               $insert_caseback = $this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);								
 
           }else{
 
 
               $caseback_assign_to_mem_arr['amount'] = $cashbackonsale->cashback_amt;
               $caseback_assign_to_mem_arr['membership_no']=$membership_no; 
               $caseback_assign_to_mem_arr['validity_string']=$newValidityString;
               $caseback_assign_to_mem_arr['expire_dt']=$new_valid_upto;
 
               $insert_caseback = $this->commondatamodel->insertSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr);	
               //  echo "<pre>";
               //  print_r($caseback_assign_to_mem_arr);
               //  echo "<pre>";
               $cashbck_pmnt_dtl_arr['membership_no']=$membership_no;
               $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$insert_caseback;
               $cashbck_pmnt_dtl_arr['amount']=$cashbackonsale->cashback_amt;								
               $cashbck_pmnt_dtl_arr['validity_string']= $newValidityString;      
               $cashbck_pmnt_dtl_arr['expire_dt']= $new_valid_upto; 
               // echo "<pre>";
               // print_r($cashbck_pmnt_dtl_arr);
               // echo "<pre>";exit;
 
               $insert_casebackdtl = $this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);
 
           }
 
       }
 
     
     }
 
   return 1;
 
 }



 public function gen_serial_brn($branch,$card,$company){
  $srl=1;       
  
  $result = $this->registrationmodel->getSerialBranch($branch,$card,$company);  
  
  if($result){
   $srl=$result->SRL_NO+1;
  }
  return $srl;
}


public function gen_mem_no_pad($branch,$card,$srl,$company)
{

 $zero=''; 

  $short_name = $this->commondatamodel->getSingleRowByWhereCls('company_master',array('comany_id'=>$company))->short_name; 
  $srl_len=strlen($srl);
  $rem_len=8-$srl_len;
  for ($i=1; $i<=$rem_len; $i++)
  {
     $zero=$zero."0";
  }
  $mSrl_no_txt=$short_name.$branch.$card.$zero.$srl;

  return $mSrl_no_txt;
}
public function isSmsFacility($company_id){

  return $sms_facility = $this->commondatamodel->getSingleRowByWhereCls('company_master',array('comany_id'=>$company_id))->sms_facility; 

 }
}