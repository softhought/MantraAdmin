<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Duereminder extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		  $this->load->model('dueremindermodel','dueremindermodel',TRUE);		  
		  $this->load->model('renewalemindersmsmodel','renewalemindersmsmodel',TRUE);		  
		  $this->load->model('registrationmodel','registrationmodel',TRUE);		  
		  $this->load->model('vouchermodel','vouchermodel',TRUE);		  
		  $this->load->model('corporatecompanymodel','corporatecompanymodel',TRUE);		  
		  
          $this->load->module('template');		

    }
    
    public function index(){
    
        if($this->session->userdata('mantra_user_detail'))
        {   
            
            $data['packagecatlist'] = $this->commondatamodel->getAllRecordWhereByComIdOrderBy('product_category',[],'category_name');
            $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');          
           
           
              $data['view_file'] = 'dashboard/payment_received/due-reminder/due_reminder_list';      
            $this->template->admin_template($data);  	
    
        }else{
            redirect('admin','refresh');  
    
      }
    }

    public function getPackageList(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        {   
            $category =  $this->input->post('category');
            //$where = array('PROD_CATEGORY_ID'=>$category);
            
             $cardlist = $this->renewalemindersmsmodel->GetCardList($category); 
            //pre($locationlist);exit;
            $cardlistview = '';
            if(!empty($cardlist)){
              $cardlistview.='<option value="">Select</option>';
            foreach($cardlist as $cardlist){
              $cardlistview.='<option value="'.$cardlist->CARD_CODE.'">'.$cardlist->CARD_DESC."(". $cardlist->CARD_CODE.")".'</option>';
            }
          }else{
            $cardlistview.='<option value=""></option>';
          }
            $json_response = array('cardlistview'=>$cardlistview);
            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit; 
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }

    public function getAllduereminder(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        {  
         
          
          if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
            $from_dt = date('Y-m-d',strtotime($this->input->post('from_dt')));
           }else{
            $from_dt=NULL;
           }
           if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date')));
           }else{
            $to_date=NULL;
           }
          $branch_code = $this->input->post('branch');
           $category = $this->input->post('category');
          $card = $this->input->post('card');
         
      
          $data['duereminderlist']= $this->dueremindermodel->getAllduereminder($from_dt,$to_date,$branch_code,$card);
  
          
  
         // pre($data['duereminderlist']);exit;
          $page = 'dashboard/payment_received/due-reminder/due_reminder_partial_list'; 
          $this->load->view($page,$data);    
                
        
        }else{
            redirect('admin','refresh');
      
      }
      
      }

public function duerenewalpayment(){
   
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];
            
            if($this->uri->segment(4) != NULL){
      
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";  
                $data['btnTextLoader'] = "Saving...";           
                
                $data['tran_id'] = $this->uri->segment(4);

                $where = array('tran_id'=>$data['tran_id']);
                $data['duedtl']= $this->commondatamodel->getSingleRowByWhereCls('due_payable',$where); 
               
                $data['member_id'] = $data['duedtl']->member_id;
                $data['payment_id'] = $data['duedtl']->from_payment_id;
      
                $where_cus = array('CUS_ID'=>$data['member_id']);
                $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where_cus); 
      
                $data['cus_name'] = $memberdtl->CUS_NAME;
               
      
                $where_payment = array('PAYMENT_ID'=>$data['payment_id']);
                $paymentdtl= $this->commondatamodel->getSingleRowByWhereCls('payment_master',$where_payment);     
               
      
               $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
              
               $data['cgstlist'] = $this->registrationmodel->GetGSTRate('CGST',$company_id);
               $data['sgstlist'] = $this->registrationmodel->GetGSTRate('SGST',$company_id);
               $data['corporatecomlist'] = $this->registrationmodel->getAllCorporateCompanyList($company_id);
              
            }
             
               //pre($data['walletdtl']);exit;
      
           $data['view_file'] = 'dashboard/payment_received/due-reminder/add_duerenewal'; ;       
      
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
         
          $mode = trim(htmlspecialchars($this->input->post('mode')));
          $cus_id = trim(htmlspecialchars($this->input->post('cus_id')));
          $tran_id = trim(htmlspecialchars($this->input->post('tran_id')));    
          $due_amt = trim(htmlspecialchars($this->input->post('due_amt')));    
        
           if(trim(htmlspecialchars($this->input->post('payment_dt'))) != ''){          
            $payment_dt = date('Y-m-d',strtotime($this->input->post('payment_dt')));
           }else{
            $payment_dt=NULL;
           }
           $payment_now = trim(htmlspecialchars($this->input->post('payment_now')));

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
     
           $collection_branch_id = trim(htmlspecialchars($this->input->post('collection_branch')));
     
           $where_col_brn = array('BRANCH_ID'=>$collection_branch_id);
           $coll_branch_dtl= $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_col_brn);
           $coll_brn_code = $coll_branch_dtl->BRANCH_CODE;
     
           $corporate_comp_id = trim(htmlspecialchars($this->input->post('corporate_company')));

           $again_due_amt = trim(htmlspecialchars($this->input->post('again_due_amt')));

           if(trim(htmlspecialchars($this->input->post('next_due_date'))) != ''){          
            $next_due_date = date('Y-m-d',strtotime($this->input->post('next_due_date')));
           }else{
            $next_due_date=NULL;
           }

          ($again_due_amt>0) ?  $due_actual= $again_due_amt  :   $due_actual = 0;
           
          $where = array('CUS_ID'=>$cus_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $cus_name = $memberdtl->CUS_NAME;
          $phone=$memberdtl->CUS_PHONE;
          $mno = $memberdtl->MEMBERSHIP_NO;
          $card_code=$memberdtl->CUS_CARD;
          $branch_code=$memberdtl->CUS_BRANCH;
          $branch_id=$memberdtl->branch_id;
          $card_id=$memberdtl->card_id;
          $member_acc_code=$memberdtl->member_acc_code;

          $where_due = array('tran_id'=>$tran_id);
          $duedtl= $this->commondatamodel->getSingleRowByWhereCls('due_payable',$where_due); 
          $from_payment_id = $duedtl->from_payment_id;
          $valid_string = $duedtl->validity_string;
          

          $cgstTaxAmt = 0;
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

          $totalAmt = $payment_now + $cgstTaxAmt + $sgstTaxAmt; 
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

          $rowCard = $this->registrationmodel->getCardDtlByCode($card_code,$comp);
          $card_id = $rowCard->CARD_ID;
          $card_category = $rowCard->CARD_PREFIX;
          $card_desc = $rowCard->CARD_DESC;
          $card_acc_id = $rowCard->account_id;

          $rcpt_srl= $this->vouchermodel->gen_rcpt_serial_brn_fin($branch_code,$year_id,$comp);
          $narration = "Due Payment";
          if($branch_code!="LT" && $branch_code!="TR" && $payment_now>0)
          {

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$payment_dt,$due_amt,$payment_now,$due_actual,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$totalAmt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id);

            //  insert voucher master

            $voucherno_prefix = 'RG';
            $serial_char = 'A';
            $payment_from = "REG";
            $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoNew($year_id,$comp);
            $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char);
            $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentModeByBrnCode($branch_code,$payment_mode,$comp);
            
            // voucher master insert data for voucher A
             $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_dt,$branch_id,$payment_from,$narration,$from_payment_id,$totalAmt,$card_category,$card_id,$card_code,$card_desc);
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

              $voucher_master_id2 = $this->insertvouchermaster($voucher_srl,$voucher_no2,$payment_dt,$branch_id,$payment_from,$narration,$from_payment_id,$totalAmt,$card_category,$card_id,$card_code,$card_desc,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch);
              // voucher details insert data  for voucher B
              if($voucher_master_id > 0 && $voucher_master_id2 > 0){
              $this->insertvoucherdetails($voucher_master_id2,'Cr',$mem_account_id,$totalAmt,1,$member_acc_code,$membership_ref);
              $this->insertvoucherdetails($voucher_master_id2,'Dr',$debit_acc_id,$totalAmt,2);

              $where_voucher_srl = array('year_id'=>$year_id,'company_id'=>$comp);
              $voucher_arr = array('last_srl'=>$voucher_srl+1);
              $voucher_master = $this->commondatamodel->updateSingleTableData('voucher_srl_master',$voucher_arr,$where_voucher_srl);


              $where_payment = array('PAYMENT_ID'=>$payment_master_id);
              $upd_payment = array('voucher_master_id'=>$voucher_master_id,'second_voucher_mast_id'=>$voucher_master_id2);
              $upd_enq = $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment,$where_payment);
              }

              $where_duepayable = array('tran_id'=>$tran_id);
              $update_due_arr['payment_id']=$payment_master_id;
              $update_due_arr['payment_amount']=$payment_now;
              
              if ($due_actual>0)
                {
                  $update_due_arr['due_again']=$due_actual;
                  $update_due_arr['due_again_date']=$next_due_date;
                }
                
              $upd_enq = $this->commondatamodel->updateSingleTableData('due_payable',$update_due_arr,$where_duepayable);

              if ($due_actual>0)
              {
                $insert_due_arr['member_id']=$cus_id;
                $insert_due_arr['membershipno']=$mno;
                $insert_due_arr['due_pybl_date']=$next_due_date;
                $insert_due_arr['due_pybl_amt']=$due_actual;
                $insert_due_arr['BRANCH_CODE']=$branch_code;
                $insert_due_arr['CARD_CODE']=$card_code;
                $insert_due_arr['validity_string']=$valid_string;
                $insert_due_arr['from_where']="DUE";
                $insert_due_arr['from_payment_id']=$payment_master_id;
                $insert_due_arr['company_id']=$comp;
                $insert_due_arr['card_id']=$card_id;
                $this->commondatamodel->insertSingleTableData('due_payable',$insert_due_arr);
              }
              $sms = 'N';
              // $isSms= $this->commondatamodel->getSingleRowByWhereCls('company_master',array('comany_id'=>$comp))->sms_facility; ;
                 
              //  if($isSms=='Y'){    
              //     $message = "Welcome to Mantra";
                  
              //      $sms = mantraSend($phone,$message);
              //  }
          }


          if($payment_master_id){

            $json_response = array(
                "msg_status" => 1,
                "msg_data"=>'Saved Successfully',              
                "mode"=>$mode,
                "cust_ins_id"=>$cus_id, 
                "tran_id"=>$tran_id, 
                "is_sms"=>$sms, 
               
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
    }
    else{
    redirect('admin','refresh');

    }
} 

private function insertpaymentmaster($mno,$card_code,$payment_dt,$due_amt,$payment_now,$due_actual,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$totalAmt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id){
    $session = $this->session->userdata('mantra_user_detail');
    $payment_arr = array(
                          'MEMBERSHIP_NO'=>$mno,
                          'CARD_CODE'=>$card_code,
                          'FROM_DT'=>$payment_dt,
                          'VALID_UPTO'=>$payment_dt, 
                          'PRM_AMOUNT'=>$due_amt,
                          'AMOUNT'=>$payment_now,                          
                          'DUE_AMOUNT'=>$due_actual,                         
                          'CGST_RATE_ID'=>$cgstRateID,
                          'CGST_AMT'=>$cgstTaxAmt,
                          'SGST_RATE_ID'=>$sgstRateID,
                          'SGST_AMT'=>$sgstTaxAmt,
                          'TOTAL_AMOUNT'=>$totalAmt,
                          'PAYMENT_DT'=>$payment_dt,
                          'FRESH_RENEWAL'=>'D',
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
                          'payment_from'=>'DUE',
                          'collection_at'=>$coll_brn_code,
                          'voucher_master_id'=>0,
                          'second_voucher_mast_id'=>0,
                          'IS_GST'=>'Y',
                          'company_id'=>$session['companyid'],
                          'corporate_comp_id'=>$corporate_comp_id,
                          'covid_extention_days'=>0,                          
                          'card_id'=>$card_id,
                          'branch_id'=>$branch_id,
                          'collection_branch_id'=>$collection_branch_id,
                        );
                      
      $payment_master_id = $this->commondatamodel->insertSingleTableData('payment_master',$payment_arr);
        
      return $payment_master_id;                 
                      
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

  public function conformation(){

    $session = $this->session->userdata('mantra_user_detail');
     if($this->session->userdata('mantra_user_detail'))
      {  
         $customer_id=0;
         $payment_id=0;
         $data['is_sms']='N';
         if($this->uri->segment(4) != NULL){
           $customer_id = $this->uri->segment(4);   
         }
         if($this->uri->segment(5) != NULL){

             $tran_id = $this->uri->segment(5);   
            
         }
         if($this->uri->segment(6) != NULL){

          $data['is_sms'] = $this->uri->segment(6);   
         
      }

              $where = array('CUS_ID'=>$customer_id);      
              $data['customerData'] = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);   

             // pre( $data['customerData']);exit;

              $where_due = array('tran_id'=>$tran_id);      
              $data['duepayable'] = $this->commondatamodel->getSingleRowByWhereCls('due_payable',$where_due); 

         $data['view_file'] = 'dashboard/payment_received/due-reminder/conformation';    
         //  $data['view_file'] = 'dashboard/franchisee/createcompany_view';      
         $this->template->admin_template($data);  
      }else{
         redirect('admin','refresh');
      }


     }



}