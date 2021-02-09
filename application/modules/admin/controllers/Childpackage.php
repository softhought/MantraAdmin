<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Childpackage extends MY_Controller{

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
		  $this->load->model('childpackagemodel','childpackagemodel',TRUE);		  
          $this->load->module('template');		

    }
    public function conformation(){

      $session = $this->session->userdata('mantra_user_detail');
       if($this->session->userdata('mantra_user_detail'))
        {  
           $customer_id=0;
           $payment_id=0;
           $sent_msg  = 'N';
           if($this->uri->segment(4) != NULL){
             $customer_id = $this->uri->segment(4);   
           }
           if($this->uri->segment(5) != NULL){
  
               $payment_id = $this->uri->segment(5);   
              
           }
           if($this->uri->segment(6) != NULL){
  
              $sent_msg = $this->uri->segment(6);   
             
          }
          if($sent_msg == 'Y'){
            $data['sms'] = 'Send Successfully';
          }else{
           $data['sms'] = 'Not Send';
          }
                $where = array('CUS_ID'=>$customer_id);      
                $data['customerData'] = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);   
  
               // pre( $data['customerData']);exit;
  
                $where_payment = array('PAYMENT_ID'=>$payment_id);      
                $data['paymentData'] = $this->commondatamodel->getSingleRowByWhereCls('payment_master',$where_payment); 
  
           $data['view_file'] = 'dashboard/registration/child-package/conformation';    
           //  $data['view_file'] = 'dashboard/franchisee/createcompany_view';      
           $this->template->admin_template($data);  
        }else{
           redirect('admin','refresh');
        }
  
  
       }
    public function addeditchildpack(){
   
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
             
              //  $data['dueinstallmentlist'] = $this->renewalremidermodel->getinstallmentperiod($company_id); 
              $data['dueinstallmentlist'] = $this->commondatamodel->getAllDropdownData('installment_phase'); 
               $data['cgstlist'] = $this->registrationmodel->GetGSTRate('CGST',$company_id);
               $data['sgstlist'] = $this->registrationmodel->GetGSTRate('SGST',$company_id);
               $data['trainerlist'] = $this->renewalemindersmsmodel->GetTrainerListAll($company_id);
               $data['userlist'] = $this->exchangepackagemodel->getUsers($company_id);
               $data['corporatecomlist'] = $this->registrationmodel->getAllCorporateCompanyList($company_id);
               $data['cardlist'] = $this->childpackagemodel->GetCardChildList($company_id);
               //pre($data['walletdtl']);exit;
      
           $data['view_file'] = 'dashboard/registration/child-package/addedit_childpackage';        
      
            $this->template->admin_template($data); 
      
        
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

          $branch_id = trim(htmlspecialchars($this->input->post('branch')));
          $corporate_comp_id = trim(htmlspecialchars($this->input->post('corporate_company')));
          $where_brn = array('BRANCH_ID'=>$branch_id);
          $branch_code = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_brn)->BRANCH_CODE; 

          $trainer = trim(htmlspecialchars($this->input->post('trainer')));

          if(trim(htmlspecialchars($this->input->post('registration_dt'))) != ''){          
            $open_date = date('Y-m-d',strtotime($this->input->post('registration_dt')));
           }else{
            $open_date=NULL;
           }
           if(trim(htmlspecialchars($this->input->post('payment_dt'))) != ''){          
            $payment_dt = date('Y-m-d',strtotime($this->input->post('payment_dt')));
           }else{
            $payment_dt=NULL;
           }
           $complimentry = $this->input->post('complimentry');
           if(isset($complimentry)){
            $is_compl = 'Y';
          }
          else{
            $is_compl = 'N';
          }
        
          $card_id = trim(htmlspecialchars($this->input->post('sel_card')));

          $where_card = array('CARD_ID'=>$card_id);
          $card_code = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where_card)->CARD_CODE;

       
          $subscription_amt = trim(htmlspecialchars($this->input->post('package_rate')));
       
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
          $hold_mno = $this->input->post('hold_mno');
          if(isset($hold_mno)){
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

        

          $where = array('CUS_ID'=>$cus_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);
          $total_amount =0;
          $member_acc_code=$memberdtl->member_acc_code;
          $phone=$memberdtl->CUS_PHONE;

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
           $valid_upto =  date('Y-m-d', strtotime($open_date. ' + '.$duration.' days'));             
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
            
           
           }
           else
           {
             $sundry_debtor = "Sundry Debtor";
             $rowGetSundDebAcc = $this->vouchermodel->getAccountIDBydesc($sundry_debtor,$comp);          
             $mem_account_id = $rowGetSundDebAcc->account_id; //Account ID Consider for Member           
             
           }

           $where_comp = array('comany_id'=>$comp);
           $is_gst = $this->commondatamodel->getSingleRowByWhereCls('company_master',$where_comp)->is_gst;

           if($branch_code!="TR" && $is_compl=="N"  && $payment_now>0)
           {
            $cust_ins_id = $this->insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_dt,$is_act,$dony_by,$is_compl,$corporate_comp_id);

            $payment_from = 'CHL';

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$subscription_amt,$disc_conv,$disc_offer,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cust_ins_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,0,$payment_from);

            $where_cus = array('CUS_ID'=>$cust_ins_id);
            $upd_customer = array('PAYMENT_ID'=>$payment_master_id);
            $this->commondatamodel->updateSingleTableData('customer_master',$upd_customer,$where_cus);
            //  insert voucher master
            $narration = 'Child';
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
              if($is_gst == 'Y'){
              $this->insertvoucherdetails($voucher_master_id,'Cr',$card_acc_id,$payment_now,1);
              $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
              $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
              $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$total_amount,4,$member_acc_code,$mno);
              }else{
                $this->insertvoucherdetails($voucher_master_id,'Cr',$card_acc_id,$payment_now,1);
                $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$total_amount,2,$member_acc_code,$mno);
              }
            }

              // voucher master insert data for voucher B
              $serial_char2 = 'B';
              $voucher_no2 = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char2);

              $voucher_master_id2 = $this->insertvouchermaster($voucher_srl,$voucher_no2,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$total_amount,$card_category,$card_id,$card_code,$card_desc,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch);
              // voucher details insert data  for voucher B
              if($voucher_master_id > 0 && $voucher_master_id2 > 0){
              $this->insertvoucherdetails($voucher_master_id2,'Cr',$mem_account_id,$total_amount,1,$member_acc_code,$mno);
              $this->insertvoucherdetails($voucher_master_id2,'Dr',$debit_acc_id,$total_amount,2);

              $where_voucher_srl = array('year_id'=>$year_id,'company_id'=>$comp);
              $voucher_arr = array('last_srl'=>$voucher_srl+1);
              $voucher_master = $this->commondatamodel->updateSingleTableData('voucher_srl_master',$voucher_arr,$where_voucher_srl);


              $where_payment = array('PAYMENT_ID'=>$payment_master_id);
              $upd_payment = array('voucher_master_id'=>$voucher_master_id,'second_voucher_mast_id'=>$voucher_master_id2);
              $upd_enq = $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment,$where_payment);
              }

             

            
           }else{
            if($branch_code == "TR"){
              $sub_amt = $subscription_amt;
            }else{
              $sub_amt =0;
            }

            $cust_ins_id = $this->insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_dt,$is_act,$dony_by,$is_compl,$corporate_comp_id);

            $payment_from = 'CHL';

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$sub_amt,$disc_conv,$disc_offer,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cust_ins_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,0,$payment_from);

            $where_cus = array('CUS_ID'=>$cust_ins_id);
            $upd_customer = array('PAYMENT_ID'=>$payment_master_id);
            $this->commondatamodel->updateSingleTableData('customer_master',$upd_customer,$where_cus);

             }
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
                    $from_where = 'CHL';

                    $this->insertduepayable($cust_ins_id,$mno,$date_installment,$due_amt,$installment_charge,$due_payable_amt,$branch_code,$card_code,$valid_string,$from_where,$payment_master_id,$pybl_cheque_no,$pybl_bank,$pybl_branch,$card_id);
                  }
            }                 

          } 

          //End due payable insert

          // start cash back insert data

          if(($is_compl=="N"  && $payment_now>0) && ($wallet_cashback != "") && ($is_promo == "Y" || $is_promo == "N")){

            $getPromoDetail = $this->commondatamodel->getSingleRowByWhereCls("promo_cashbck_assign_to_mem",["promo_cashbck_assign_to_mem.id"=>$promo_cashback_id]);

                $insert_promo = [];
                $insert_promo = [
                    "promo_cashback_id" => $getPromoDetail->transaction_id,
                    "mobile_no" => $phone,
                    "amount" => $cashback_amt,
                    "payment_id" => $payment_master_id,
                    "is_debit" => 'Y',
                    "tran_module" => 'CHL',
                    "tran_date" => date("Y-m-d H:i:s"),
                    "promo_cashback_assign_id" =>($is_promo == "Y") ? 0 : $promo_cashback_id,
                    "case_dtl_type" => "For Purchasing ".$card_code." Package",
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


          }else if(($is_compl=="N"  && $payment_now>0)){

            $this->cashbackaction($cust_ins_id,$mno,$valid_string,$valid_upto,$card_code,$branch_code);

          }
          // end cash back insert data
          

           $sent_msg = 'N';
           $isSms= $this->isSmsFacility($comp);
           $module = "Child Package";
           $controller = "childpackage/addedit_action";
           if($isSms=='Y'){

              $message = "Thank you for being part of Mantra family.Your Membership no. is ".$mno.". Please use the same for any further communication.";
              
              $sent_msg =  mantraSend($phone,$message,$module,$controller);
           }

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
private function insertcustomer($cus_id,$branch_id,$branch_code,$card_code,$card_id,$trainer,$mno,$open_date,$srl,$comp,$year_id,$user_id,$payment_date,$is_act,$dony_by,$is_compl,$corporate_comp_id)
 {

  $where = array('CUS_ID'=>$cus_id);
  $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 
  //pre($memberdtl);
  $mother_mem_no = $memberdtl->MEMBERSHIP_NO;  
  $member_acc_code = $memberdtl->member_acc_code;  
  $phone = $memberdtl->CUS_PHONE;
  $inert_arr = array(
                      'CUS_BRANCH'=>$branch_code,
                      'CUS_CARD'=>$card_code,
                      'MEMBERSHIP_NO'=>$mno,
                      'CUS_NAME'=>$memberdtl->CUS_NAME,
                      'CUS_NAME2'=>$memberdtl->CUS_NAME2,
                      'CUS_DOB'=>$memberdtl->CUS_DOB,
                      'CUS_SEX'=>$memberdtl->CUS_SEX,
                      'CUS_MS'=>$memberdtl->CUS_MS,
                      'CUS_BLOOD_GRP'=>$memberdtl->CUS_BLOOD_GRP,
                      'CUS_FATHER'=>$memberdtl->CUS_FATHER,
                      'CUS_ADRESS'=>$memberdtl->CUS_ADRESS,
                      'CUS_PIN'=>$memberdtl->CUS_PIN,
                      'CUS_PHONE'=>$phone,
                      'CUS_PHONE2'=>$memberdtl->CUS_PHONE2,
                      'CUS_EMAIL'=>$memberdtl->CUS_EMAIL,
                      'CUS_OCCUPATION'=>$memberdtl->CUS_OCCUPATION,
                      'IS_COMPLI'=>$is_compl,
                      'trainer_id'=>$trainer,
                      'done_by'=>$dony_by,
                      'is_converted'=>'N',
                      'IS_ACTIVE'=>$is_act,
                      'member_acc_code'=>$member_acc_code,
                      'entry_mode'=>'CP',
                      'company_id'=>$comp,
                      'corporate_comp_id'=>$corporate_comp_id,
                      'whatsup_number'=>$phone,
                      'REGISTRATION_DT'=>$open_date,
                      'PASS'=>$memberdtl->CUS_DOB,
                      'SRL_NO'=>$srl,
                      'USER_ID'=>$user_id,
                      'FIN_ID'=>$year_id,
                      'PAYMENT_DT'=>$payment_date,
                      'pack_type'=>'C',
                      'mother_mem_no'=>$mother_mem_no,
                      'mother_mem_id'=>$cus_id,
                      'branch_id'=>$branch_id,
                      'card_id'=>$card_id                                         
                    );
  
    
  $cust_id = $this->commondatamodel->insertSingleTableData('customer_master',$inert_arr);
  return $cust_id;
   
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
    $cashbck_pmnt_dtl_arr['tran_module']='CHL';
    $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']='0';
    $cashbck_pmnt_dtl_arr['case_dtl_type']='For Purchasing '.$card.' Package';
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
                $cashbck_pmnt_dtl_arr['case_dtl_type']='For Purchasing '.$card.' Package';						
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