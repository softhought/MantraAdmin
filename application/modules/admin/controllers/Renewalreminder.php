<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Renewalreminder extends MY_Controller{

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
          $this->load->module('template');		

    }
    
    public function index(){
    
        if($this->session->userdata('mantra_user_detail'))
        {   
            
            $data['packagecatlist'] = $this->commondatamodel->getAllRecordWhereByComIdOrderBy('product_category',[],'category_name');
            $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
          
            $data['trainerlist'] = $this->renewalemindersmsmodel->GetTrainerListAll(); 
           
              $data['view_file'] = 'dashboard/payment_received/renewal-reminder/renewal_reminder_list';      
            $this->template->admin_template($data);  	
    
        }else{
            redirect('admin','refresh');  
    
      }
    }

    public function getAllRenewalreminder(){

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
        $branch_id = $this->input->post('branch');
        $category_id = $this->input->post('category');
        if($category_id != ""){
          $where_cat = array('id'=>$category_id);
          $categorydtl= $this->commondatamodel->getSingleRowByWhereCls('product_category',$where_cat); 
          $category = $categorydtl->start_letter;
        }else{
          $category = "";
        }
      
        $card = $this->input->post('card');
        $trainer = $this->input->post('trainer');
        $mobile_no = $this->input->post('mobile_no');
        $mem_no = $this->input->post('mem_no');
       
    
        $data['renewalreminderlist']= $this->renewalremidermodel->getAllRenewalreminder($from_dt,$to_date,$branch_id,$card,$category,$trainer,$mobile_no,$mem_no);

        $data['card'] = $card; 
        $data['branch_id'] = $branch_id; 
        

        //pre($data['renewalreminderlist']);exit;
        $page = 'dashboard/payment_received/renewal-reminder/renewal_reminder_partial_list'; 
        $this->load->view($page,$data);    
              
      
      }else{
          redirect('admin','refresh');
    
    }
    
    }

    public function getenqmasterforfeedback(){

      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {   
    
          $cusid =  $this->input->post('cusid');
          $pid =  $this->input->post('pid');
          $wing =  $this->input->post('wing');
          $where = array('CUS_ID'=>$cusid);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $name = explode(" ",$memberdtl->CUS_NAME);
          $fname = $name[0];
          $lname = end($name);
          $pin_code = $memberdtl->CUS_PIN;
          $add = $memberdtl->CUS_ADRESS;
          $mobile1 = $memberdtl->CUS_PHONE;
          $mobile2 = $memberdtl->CUS_PHONE2;
          $email = $memberdtl->CUS_EMAIL;
          $branch_code = $memberdtl->CUS_BRANCH;

          $prv_enq_id = 0;
          $prv_enq_dt = "";
          $prv_enq_no = "";
          $enquirycheck = $this->renewalremidermodel->getRenEnqDetail($cusid,$pid);
          if(!empty($enquirycheck)){
            $prv_enq_id = $enquirycheck->ID;
            $prv_enq_dt = $enquirycheck->DATE_OF_ENQ;
            $prv_enq_no = $enquirycheck->ENQ_NO;
          }
          
          $row_remaks= $this->commondatamodel->getAllDropdownData('reason_master');
          $userlist = $this->commondatamodel->getAllDropdownData('users'); 
          $where = array('pin_code'=>$pin_code);        
          $locationlist = $this->commondatamodel->getSingleRowByWhereCls('pin_master',$where); 
          // pre($where);
          // pre($locationlist);exit;
          if(!empty($locationlist)){
            $pincode = $locationlist->pin_code;
            $location= $locationlist->location;
          }else{
            $pincode = "";
          }
          $remarkslist= '';
          $userlistview = '';
          $remarkslist.= '<option value="">Select</option>';
          foreach($row_remaks as $row_remaks){
            $remarkslist.='<option value="'.$row_remaks->reason_id.'">'.$row_remaks->reason_title.'</option>';
          }
          $userlistview.= '<option value=""Select</option>';
          foreach($userlist as $userlist){
            $userlistview.='<option value="'.$userlist->id.'">'.$userlist->name.'</option>';
          }
          $enquirymstdata = array();
          $enquirymstdata = array(
                                  'FIRST_NAME'=>$fname,
                                  'LAST_NAME'=>$lname,
                                  'PIN'=>$pin_code,
                                  'LOCATION'=>$location,
                                  'ADDRESS'=>$add,
                                  'EMAIL'=>$email,
                                  'MOBILE1'=>$mobile1,
                                  'MOBILE2'=>$mobile2,
                                  'for_the_wing'=>$wing,
                                  'BRANCH_CODE'=>$branch_code,
                                  "customer_id" => $cusid,
                                  "prv_enq_id" => $prv_enq_id,
                                  "prv_enq_dt" => $prv_enq_dt,
                                  "prv_enq_no" => $prv_enq_no
                                  );
          
          //pre($enquirymstdata);
          // pre($enquirymstdata);
          //exit;
          $json_response = array('enquirymstdata'=>$enquirymstdata,'remarkslist'=>$remarkslist,'userlistview'=>$userlistview,'pincode'=>$pincode);
          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit;
      
      }else{
          redirect('admin','refresh');
    
    }
    
    }

    public function feedback_action(){

  
      if($this->session->userdata('mantra_user_detail'))
      {   
        $session = $this->session->userdata('mantra_user_detail');
          $enq_id =  $this->input->post('enq_id');
          $customer_id =  $this->input->post('customer_id');
          $payment_id =  $this->input->post('payment_id');
          $feedbackEnqMode =  $this->input->post('feedbackEnqMode');
          $wing =  $this->input->post('wing');
          $sel_remarks =  $this->input->post('sel_remarks');
          $remarks =  $this->input->post('remarks');
          if(trim(htmlspecialchars($this->input->post('followup_date'))) != ''){            
            $followup_date = date('Y-m-d',strtotime($this->input->post('followup_date')));
           }else{
            $followup_date=NULL;
           }
          $done_by =  $this->input->post('done_by');
          $m_branch_feed_code =  $this->input->post('m_branch_feed_code');

          $where = array('CUS_ID'=>$customer_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $name = explode(" ",$memberdtl->CUS_NAME);
          $first_name = $name[0];
          $last_name = end($name);
          $pin_code = $memberdtl->CUS_PIN;
          $add = $memberdtl->CUS_ADRESS;
          $mobile1 = $memberdtl->CUS_PHONE;
          $mobile2 = $memberdtl->CUS_PHONE2;
          $email = $memberdtl->CUS_EMAIL;
          $branch_code = $memberdtl->CUS_BRANCH;
          $mno = $memberdtl->MEMBERSHIP_NO;
          $card_code = $memberdtl->CUS_CARD;
          $gender = $memberdtl->CUS_SEX;
          $branch_id = $memberdtl->branch_id;
          $dob = $memberdtl->CUS_DOB;

          $paymentdtl= $this->renewalremidermodel->getMembershipPaymtdtl($mno);

          $validity_string = $paymentdtl->VALIDITY_STRING;
          $payment_id = $paymentdtl->PAYMENT_ID;
          $where = array('pin_code'=>$pin_code);        
          $locationlist = $this->commondatamodel->getSingleRowByWhereCls('pin_master',$where); 
          // pre($where);
          // pre($locationlist);exit;
          if(!empty($locationlist)){
            $pincode = $locationlist->pin_code;
            $location= $locationlist->location;
            $pin = $locationlist->id;
          }else{
            $pincode = "";
          }
          
          $where_wing = array('wing_name'=>$wing);
          $wingdtl = $this->commondatamodel->getSingleRowByWhereClsByComId('enquiry_wings',$where_wing);
        
          $wing_id = $wingdtl->wing_id;
          if($dob != ""){
            $now = time();          
            $difference = $now - $dob;
            $age = floor($difference / 31556926);
          }else{
            $age = "";
          }
          
          if($feedbackEnqMode == 'Enquiry'){            

            $insert_arr = array(
              'DATE_OF_ENQ'=>date("Y-m-d"),
              'FIRST_NAME'=>strtoupper($first_name),                 
              'LAST_NAME'=>strtoupper($last_name),
              'ADDRESS'=>$add,
              'LOCATION'=>$location,
              'PIN'=>$pin,
              'REMARKS'=>$remarks,
              'MOBILE1'=>$mobile1,
              'MOBILE2'=>$mobile2,
              'EMAIL'=>$email,
              'FOLLOWUP_DATE'=>$followup_date,
              'IS_OPEN'=>'Y',
              'BRANCH_CODE'=>$branch_code,                  
              'user_id'=>$done_by,
              'for_the_wing'=>$wing,
              'enq_from'=>'',
              'dob'=>$dob,
              'age'=>$age,
              'wing_cat_id'=>$wingdtl->wing_category_id,
              'wing_id'=>$wing_id,
              'gender'=>$gender,
              'branch_id'=>$branch_id,
              'company_id'=>$session['companyid']                 
                );  
               
                $enq_master_id = $this->commondatamodel->insertSingleTableData('enquiry_master',$insert_arr);
                
                if($enq_master_id){
                $enq_no=$this->prepareEnqNo(substr($first_name,0,1),substr($last_name,0,1),$mobile1,$enq_master_id);
                $where_enq = array('ID'=>$enq_master_id);
                $update_enqno = array('ENQ_NO'=>$enq_no);
                $upd_enq = $this->commondatamodel->updateSingleTableData('enquiry_master',$update_enqno,$where_enq);
                
                $insert_dtl_id = $this->insertenquirydtl($enq_master_id,$sel_remarks,$remarks,$followup_date,$branch_code,$done_by,$wing,$wing_id,$branch_id,$customer_id,$card_code,$validity_string,$payment_id,$session['companyid']);
              
              }
              $module = 'Renewal Remider';           
              $action = "Insert";
              $method = 'renewalreminder/feedback_action';
              $table="enquiry_master";
              $old_details="";
              $new_details = json_encode($insert_arr);
              $this->commondatamodel->insertSingleActivityTableData('Add Feedback',$module,$action,$method,$enq_master_id,$table,$old_details,$new_details);

          }

          if($feedbackEnqMode == 'Feedback'){

            $insert_dtl_id = $this->insertenquirydtl($enq_id,$sel_remarks,$remarks,$followup_date,$branch_code,$done_by,$wing,$wing_id,$branch_id,$customer_id,$card_code,$validity_string,$payment_id,$session['companyid']);

          }

          $tot_calling = $this->renewalremidermodel->getTotalRenewalEnqCall($customer_id,$payment_id,'RENEWAL');      
          if($tot_calling<10)
          {
            $tot_call = "0".$tot_calling;
          }
          else
          {
              $tot_call = $tot_calling;
          }
                /** audit trail */ 
               
                     
                if($insert_dtl_id){
                  $json_response = array('msg_status'=>1,'tot_calling'=>$tot_call);
                }else{
                  $json_response = array('msg_status'=>0);
                }
          // pre($row_remaks);
          // pre($enquirymstdata);
          // exit;
         
          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit;
      
      }else{
          redirect('admin','refresh');
    
    }
    
    }

private function insertenquirydtl($enq_master_id,$sel_remarks,$remarks,$followup_date,$branch_code,$done_by,$wing,$wing_id,$branch_id,$customer_id,$card_code,$validity_string,$payment_id,$comp)
{

  $enquiry_dtl = array(
    'enq_id'=>$enq_master_id,
    'enq_date'=>date('Y-m-d'),
    'remarks_id'=>$sel_remarks,
    'enq_remarks'=>$remarks,
    'followup_date'=>$followup_date,
    'branch_code'=>$branch_code,
    'user_id'=>$done_by,
    'for_the_wing'=>$wing,
    'wing_id'=>$wing_id,
    'member_id'=>$customer_id,
    'validity_string'=>$validity_string,
    'card_code'=>$card_code,
    'payment_id'=>$payment_id,
    'branch_id'=>$branch_id,
    'company_id'=>$comp                       
     );

     $insert_id = $this->commondatamodel->insertSingleTableData('enquiry_detail',$enquiry_dtl);

     return $insert_id;
	
}
    
function prepareEnqNo($f,$l,$mob,$id)
{
	$enq=$f.$l."-".$mob."-".$id;
	return $enq;
}

public function getfeedbacklist(){  
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
    $cusid =  $this->input->post('cusid');
    $pid =  $this->input->post('pid');
    $data['enquirymstdata'] = array();
    $data['enquirydel'] = array();
      // $where = array('ID'=>$enq_id);
      $where = array('CUS_ID'=>$cusid);
      $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

      $data['name'] = $memberdtl->CUS_NAME;
      $data['mno'] = $memberdtl->MEMBERSHIP_NO;
      $data['enquirydata'] = array();
      $enquirymstdata= $this->renewalremidermodel->getEnquiryRenewalRow($cusid,$pid);

      foreach($enquirymstdata as $enquirymstdata){
        $enq_id = $enquirymstdata->enqMastID;
        $enquirydtldata= $this->renewalremidermodel->getEnquiryDetailByEnqNo($enq_id);
        $data['enquirydata'][] = array(
                                    'enqMastID'=>$enq_id,
                                    'ENQ_NO'=>$enquirymstdata->ENQ_NO,
                                    'enquirydtldata'=>$enquirydtldata
        );
      }

      // if(!empty($data['enquirymstdata']) && $data['enquirymstdata']->enqMastID > 0){
      //   $enq_id = $data['enquirymstdata']->enqMastID;
      //   $data['enquirydel']= $this->enquirymodel->getallenquirydtl($enq_id);
      // }
     
     // pre($data['enquirydata']);exit;
      $page = 'dashboard/payment_received/renewal-reminder/feedback_list_modal';      
      $this->load->view($page,$data);
  
  }else{
      redirect('admin','refresh');

}

}

public function addeditrenewal(){
   
  if($this->session->userdata('mantra_user_detail'))
  {   
      $session = $this->session->userdata('mantra_user_detail');
      $company_id = $session['companyid'];
      if($this->uri->segment(4) != NULL && $this->uri->segment(5) != NULL){

          $data['mode'] = "ADD";    
          $data['btnText'] = "Save";  
          $data['btnTextLoader'] = "Saving...";           
          
          $customer_id =$this->uri->segment(4);
          $payment_id = $this->uri->segment(5);
          $data['cus_id'] = $customer_id;
          $data['payment_id'] = $payment_id;

          $where = array('CUS_ID'=>$customer_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $data['cus_name'] = $memberdtl->CUS_NAME;
         
          $branch_code = $memberdtl->CUS_BRANCH;
          $card_code = $memberdtl->CUS_CARD;
          
          $member_acc_code=$memberdtl->member_acc_code;
          $branch_id = $this->getBranchIDByCompany($branch_code,$company_id);
          $rowCard = $this->registrationmodel->getCardDtlByCode($card_code,$company_id);
          if(!empty($rowCard)){
            $card_id = $rowCard->CARD_ID;
          }else{
            $card_id = NULL;
          }
          

          $where_payment = array('PAYMENT_ID'=>$payment_id);
          $paymentdtl= $this->commondatamodel->getSingleRowByWhereCls('payment_master',$where_payment);

          $data['sub_amt'] = number_format($paymentdtl->SUBSCRIPTION,2);
          $data['membership_no'] = $paymentdtl->MEMBERSHIP_NO;
          $data['validity_string'] = date('Y-m-d',strtotime($paymentdtl->FROM_DT)).' - '.date('Y-m-d',strtotime($paymentdtl->EXPIRY_DT));
           
          $plusDays=1;
          $actualExpiryDt=date('Y-m-d',strtotime($paymentdtl->EXPIRY_DT)); 
          $nextStartDate = date('Y-m-d', strtotime($actualExpiryDt. ' + '.$plusDays.' days'));

          if($nextStartDate > date('Y-m-d')){
            $data['nextstartdt'] = $nextStartDate;
          }else{
            $data['nextstartdt'] = date('Y-m-d');
          }

          $data['cashback_on_sale']= $this->walletmodel->getCashBackOnSaleAmt($branch_code,$card_code,$company_id);
          $ratedtl= $this->renewalremidermodel->getRateDetailByCompany($branch_code,$card_code,$company_id);
          if(!empty($ratedtl)){
            $data['renewal_rate'] = $ratedtl->renewal_rate;
          }else{
            $data['renewal_rate'] = 0;
          }
        

         }

         $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
         //$data['dueinstallmentlist'] = $this->renewalremidermodel->getinstallmentperiod($company_id); 
         $data['dueinstallmentlist'] = $this->commondatamodel->getAllDropdownData('installment_phase'); 
         $data['cgstlist'] = $this->registrationmodel->GetGSTRate('CGST',$company_id);
         $data['sgstlist'] = $this->registrationmodel->GetGSTRate('SGST',$company_id);
         $data['corporatecomlist'] = $this->registrationmodel->getAllCorporateCompanyList($company_id);
         $promoList = $this->walletmodel->GetPromoWithMemberAccCode($member_acc_code);
        
          $cashbackList = $this->walletmodel->GetCashbackWithMemberAccCode($member_acc_code);
          $data['walletdtl'] = array();
          if(empty($promoList)){
            $data['walletdtl'] = $cashbackList ;
            }else if(empty($cashbackList)){
             $data['walletdtl'] = $promoList;
            }else{
              $data['walletdtl'] = array_merge($promoList, $cashbackList);
           }
       
         //pre($data['walletdtl']);exit;

     $data['view_file'] = 'dashboard/payment_received/renewal-reminder/addedit_renewal'; ;       

      $this->template->admin_template($data); 

  
  }else{

      redirect('admin','refresh');
}

}

public function getinstallmentview(){
   
  if($this->session->userdata('mantra_user_detail'))
  {  

    $period = $this->input->post('period');

    $data['period'] = $period;

    $page = 'dashboard/payment_received/renewal-reminder/due_installment_view';
    $this->load->view($page,$data);
    
    
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
      $pre_payment_id = trim(htmlspecialchars($this->input->post('payment_id')));

      if(trim(htmlspecialchars($this->input->post('start_dt'))) != ''){          
        $start_dt = date('Y-m-d',strtotime($this->input->post('start_dt')));
       }else{
        $start_dt=NULL;
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
      $disc_nego = trim(htmlspecialchars($this->input->post('disc_nego')));
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
      
    

      $subscription_amt = trim(htmlspecialchars($this->input->post('subscription_amt')));
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

      $collection_branch_id = trim(htmlspecialchars($this->input->post('collection_branch')));

      $where_col_brn = array('BRANCH_ID'=>$collection_branch_id);
      $coll_branch_dtl= $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_col_brn);
      $coll_brn_code = $coll_branch_dtl->BRANCH_CODE;

      $corporate_comp_id = trim(htmlspecialchars($this->input->post('corporate_company')));


          $where = array('CUS_ID'=>$cus_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $cus_name = $memberdtl->CUS_NAME;
          $member_acc_code=$memberdtl->member_acc_code;
          $phone=$memberdtl->CUS_PHONE;

          $where_payment = array('PAYMENT_ID'=>$pre_payment_id);
          $paymentdtl= $this->commondatamodel->getSingleRowByWhereCls('payment_master',$where_payment);
          
          $branch_code = $paymentdtl->BRANCH_CODE;
          $card_code = $paymentdtl->CARD_CODE;
          
          //$card_id = $paymentdtl->card_id;
          $mno = $paymentdtl->MEMBERSHIP_NO;
          $pre_from_date = $paymentdtl->FROM_DT;
          $pre_to_date = $paymentdtl->EXPIRY_DT;
          $branch_id =  $this->getBranchIDByCompany($branch_code,$comp);
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

          if($pre_to_date > date('Y-m-d') && $start_dt == $pre_to_date){

            $open_date=date("Y-m-d",strtotime('+1 day', strtotime($start_dt)));
            
          }
          else{
            $open_date=date("Y-m-d",strtotime($start_dt));
            
          }
          if($start_dt > date('Y-m-d') && $pre_to_date <= date("Y-m-d")){

               $startTimeStamp = strtotime(date('Y-m-d'));
                $endTimeStamp = strtotime($open_date);
                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                 $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                 // and you might want to convert to integer
                 $user_given_extentiondays = intval($numberDays);
            
          }else if($start_dt > $pre_to_date && $pre_to_date >date('Y-m-d')){
        
                $startTimeStamp = strtotime(date("Y-m-d",strtotime('+1 day', strtotime($pre_to_date))));
                $endTimeStamp = strtotime($open_date);
                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                 $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                 // and you might want to convert to integer
                 $user_given_extentiondays = intval($numberDays);
            
          }else{
                  $user_given_extentiondays = 0;
          }

          //create validity string
          $opening_date = explode("-",$open_date);
	        $valid_upto = date('Y-m-d',strtotime('+'.$duration.' day',mktime(0,0,0,$opening_date[1],$opening_date[2],$opening_date[0])));

          $valid_string=$open_date." - ".$valid_upto;
          
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
          $narration = "Renewal";

          $totalAmt = 0;
          $totalAmt = $payment_now+$cgstTaxAmt+$sgstTaxAmt;
          $where_comp = array('comany_id'=>$comp);
          $is_gst = $this->commondatamodel->getSingleRowByWhereCls('company_master',$where_comp)->is_gst;

          if($branch_code!="TR" && $is_compl=="N"  && $payment_now>0)
          {
           
            

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$subscription_amt,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$totalAmt,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$user_given_extentiondays);
            
            $renewal_insert = array(
                                    'payment_id'=>$payment_master_id,
                                    'customer_id'=>$cus_id,
                                    'renewal_date'=>$open_date,
                                    'BRANCH_CODE'=>$branch_code,
                                    'user_id'=>$session['userid'],
                                    'FIN_ID'=>$session['yearid'],
                                    'company_id'=>$session['companyid']
                                  );
           $renewal_id = $this->commondatamodel->insertSingleTableData('renewaltable',$renewal_insert);
           $where_payment_ren = array('PAYMENT_ID'=>$pre_payment_id);
           $upd_payment_ren = array('RENEW_ID'=>$renewal_id);
           $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment_ren,$where_payment_ren);
           
          //  insert voucher master

            $voucherno_prefix = 'RG';
            $serial_char = 'A';
            $payment_from = "REG";
            $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoNew($year_id,$comp);
            $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char);
            $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentModeByBrnCode($branch_code,$payment_mode,$comp);
            
            // voucher master insert data for voucher A
             $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$totalAmt,$card_category,$card_id,$card_code,$card_desc);
             // voucher details insert data  for voucher A
             if($voucher_master_id > 0){
              if($is_gst == 'Y'){
              $this->insertvoucherdetails($voucher_master_id,'Cr',$card_acc_id,$payment_now,1);
              $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
              $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
              $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$totalAmt,4,$member_acc_code,$membership_ref);

              }else{
                $this->insertvoucherdetails($voucher_master_id,'Cr',$card_acc_id,$payment_now,1);
                $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$totalAmt,2,$member_acc_code,$membership_ref);
              }
              
              }

              // voucher master insert data for voucher B
              $serial_char2 = 'B';
              $voucher_no2 = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char2);

              $voucher_master_id2 = $this->insertvouchermaster($voucher_srl,$voucher_no2,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$totalAmt,$card_category,$card_id,$card_code,$card_desc,$cheque_no,$cheque_date,$cheque_bank,   $cheque_branch);
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

           

             
          }else{
            if($branch_code == "TR"){
              $sub_amt = $subscription_amt;
            }else{
              $sub_amt =0;
            }
            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$sub_amt,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$totalAmt,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$user_given_extentiondays);
            $renewal_insert = array(
              'payment_id'=>$payment_master_id,
              'customer_id'=>$cus_id,
              'renewal_date'=>$open_date,
              'BRANCH_CODE'=>$branch_code,
              'user_id'=>$session['userid'],
              'FIN_ID'=>$session['yearid'],
              'company_id'=>$session['companyid']
            );
          $renewal_id = $this->commondatamodel->insertSingleTableData('renewaltable',$renewal_insert);
          $where_payment_ren = array('PAYMENT_ID'=>$pre_payment_id);
          $upd_payment_ren = array('RENEW_ID'=>$renewal_id);
          $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment_ren,$where_payment_ren);

          
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
                     $from_where = 'REN';

                     $this->insertduepayable($cus_id,$mno,$date_installment,$due_amt,$installment_charge,$due_payable_amt,$branch_code,$card_code,$valid_string,$from_where,$payment_master_id,$pybl_cheque_no,$pybl_bank,$pybl_branch,$card_id);
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
                  "tran_module" => 'REN',
                  "tran_date" => date("Y-m-d H:i:s"),
                  "promo_cashback_assign_id" =>($is_promo == "Y") ? 0 : $promo_cashback_id,
                  "case_dtl_type" => "For Renewal ".$card_code." Package",
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
              
          $this->cashbackaction($cus_id,$mno,$valid_string,$valid_upto,$card_code,$branch_code);


        }else if(($is_compl=="N"  && $payment_now>0)){

          $this->cashbackaction($cus_id,$mno,$valid_string,$valid_upto,$card_code,$branch_code);

        }
        // end cash back insert data

           // Amount Distribution Per Month
           $this->calmemberAmountDistribution($mno,$branch_code,$card_code,$open_date,$valid_upto,$valid_string,$premium_amt,$payment_master_id,$comp);

           

           //start insert member compaliment 
           $where_del = array('member_id'=>$cus_id,'validity_string'=>$valid_string);
           $this->commondatamodel->deleteTableData('member_compliment',$where_del);
           $rowCardDetail=$this->registrationmodel->getCardDetail($branch_code,$card_code,$comp);
          
           foreach($rowCardDetail as $row_detail)
           {
               $coupon_id=$row_detail->coupon_id;
               $qty=$row_detail->qty;
               $desc=$row_detail->detail_description;

               $insert_mem_comp_arr['member_id']=$cus_id;
               $insert_mem_comp_arr['membership_no']=$mno;
               $insert_mem_comp_arr['coupon_id']=$coupon_id;
               $insert_mem_comp_arr['pack_compl']=$desc;
               $insert_mem_comp_arr['qty']=$qty;
               $insert_mem_comp_arr['card_code']=$card_code;
               $insert_mem_comp_arr['branch_code']=$branch_code;
               $insert_mem_comp_arr['validity_string']=$valid_string;
               $insert_mem_comp_arr['renew_id']=$renewal_id;

               $this->commondatamodel->insertSingleTableData("member_compliment",$insert_mem_comp_arr);

           }
                        
           //end insert member compaliment 
           $sent_msg = 'N';
           $isSms= $this->isSmsFacility($comp);
           $module = "Renewal Reminder";
           $controller = "Renewalreminder/addedit_action"; 
           if($isSms=='Y'){

              $message = "Your Mantra membership no ".$mno." has been successfully renewed with payment of Rs. ".$totalAmt." Thank You for being part of Mantra family!";
              
              $sent_msg = mantraSend($phone,$message,$module,$controller);
           }
      

      if($payment_master_id){

        $json_response = array(
            "msg_status" => 1,
            "msg_data"=>'Saved Successfully',              
            "mode"=>$mode,
            "cust_ins_id"=>$cus_id, 
            "pmt_ins_id"=>$payment_master_id, 
            'sent_msg'=>$sent_msg
           
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

  }  else{
    redirect('admin','refresh');

   }

}
private function insertpaymentmaster($mno,$card_code,$open_date,$valid_upto,$subscription_amt,$disc_nego,$rem_nego,$cashback_amt,$premium_amt,$payment_now,$due_amt,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$totalAmt,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$user_given_extentiondays){
  $session = $this->session->userdata('mantra_user_detail');
  $payment_arr = array(
                        'MEMBERSHIP_NO'=>$mno,
                        'CARD_CODE'=>$card_code,
                        'FROM_DT'=>$open_date,
                        'VALID_UPTO'=>$valid_upto,
                        'EXPIRY_DT'=>$valid_upto,
                        'ADMISSION'=>0,
                        'SUBSCRIPTION'=>$subscription_amt,
                        'DISCOUNT_CONV'=>0,
                        'DISCOUNT_OFFER'=>0,
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
                        'FRESH_RENEWAL'=>'R',
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
                        'payment_from'=>'REN',
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
  $cashbck_pmnt_dtl_arr['tran_module']='REN';
  $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']='0';
  $cashbck_pmnt_dtl_arr['case_dtl_type']='For Renewal '.$card.' Package';
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
              $cashbck_pmnt_dtl_arr['case_dtl_type']='For Renewal '.$card.' Package';						
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

public function isSmsFacility($company_id){

  return $sms_facility = $this->commondatamodel->getSingleRowByWhereCls('company_master',array('comany_id'=>$company_id))->sms_facility; 

 }

 public function getBranchIDByCompany($branch_code,$company_id){

  return $branch_id = $this->commondatamodel->getSingleRowByWhereCls('branch_master',array('BRANCH_CODE'=>$branch_code,
                                                 'company_id'=>$company_id))->BRANCH_ID; 

 }


}