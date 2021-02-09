<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Productsale extends MY_Controller{

function __construct()
	{
		 parent::__construct();		
		  $this->load->model('renewalremidermodel','renewalremidermodel',TRUE);		  
		  $this->load->model('renewalemindersmsmodel','renewalemindersmsmodel',TRUE);		  
		  $this->load->model('walletmodel','walletmodel',TRUE);		  
		  $this->load->model('registrationmodel','registrationmodel',TRUE);		  
		  $this->load->model('vouchermodel','vouchermodel',TRUE);		  
		  $this->load->model('corporatecompanymodel','corporatecompanymodel',TRUE);		  
		  $this->load->model('productsalemodel','productsalemodel',TRUE);		  
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
            //  if($this->uri->segment(6) != NULL){
    
            //     $sent_msg = $this->uri->segment(6);   
               
            // }
            // if($sent_msg == 'Y'){
            //   $data['sms'] = 'Send Successfully';
            // }else{
            //  $data['sms'] = 'Not Send';
            // }
                  $where = array('CUS_ID'=>$customer_id);      
                  $data['customerData'] = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);   
    
                 // pre( $data['customerData']);exit;
    
                  $where_payment = array('PAYMENT_ID'=>$payment_id);      
                  $data['paymentData'] = $this->commondatamodel->getSingleRowByWhereCls('payment_master',$where_payment); 
                  $data['packageData'] = $this->commondatamodel->getSingleRowByWhereCls('package_sale',$where_payment); 
                  $data['guest'] =  $data['packageData']->GUEST_NAME;
                  $prod_id =  $data['packageData']->PRODUCT_ID;
                  $where_prod = array('PROD_ID'=>$prod_id);
                  $data['PROD_DESC'] = $this->commondatamodel->getSingleRowByWhereCls('product_master',$where_prod)->PROD_DESC;
    
             $data['view_file'] = 'dashboard/registration/product-sale/conformation';    
             //  $data['view_file'] = 'dashboard/franchisee/createcompany_view';      
             $this->template->admin_template($data);  
          }else{
             redirect('admin','refresh');
          }
    
    
         }


    public function addeditproduct(){
   
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];
            if($this->uri->segment(4) == NULL){
      
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";  
                $data['btnTextLoader'] = "Saving..."; 
                $data['product_id'] =$this->uri->segment(4);
                
      
               }
      
               $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
              
               $data['cardlist'] = $this->registrationmodel->getCardList($company_id); 
             
               $data['cgstlist'] = $this->registrationmodel->GetGSTRate('CGST',$company_id);
               $data['sgstlist'] = $this->registrationmodel->GetGSTRate('SGST',$company_id);
               $where = array('TAX_FEE >'=>0);
               $order_by = 'PROD_DESC';
               $data['productlist'] = $this->commondatamodel->getAllRecordWhereOrderBy('product_master',$where,$order_by);

               $data['saleaccountlist'] = $this->productsalemodel->getAllSaleAcoountlist($company_id);
              // pre($data['productlist']);exit;
              $data['memtype']=array("Self"=>"Self","Guest"=>"Guest");

             $data['view_file'] = 'dashboard/registration/product-sale/addedit_productsale';        
      
            $this->template->admin_template($data); 
      
        
        }else{
      
            redirect('admin','refresh');
      }
      
      }

   public function getmemberdtl(){
       
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];
            $branch =  $this->input->post('branch');
            $sel_card =  $this->input->post('sel_card');            
            
            $currentmemberlist = $this->productsalemodel->getCurrentMembersListByBranch($branch,$sel_card,$company_id);  
            //pre($currentmemberlist);exit;
            $memberlistview = '';
            $memberlistview.='<option value="">Select Member</option>';
            if(!empty($currentmemberlist)){
            foreach($currentmemberlist as $packagelist){
               // $member_acc_code = $packagelist->member_acc_code;
                $name = $packagelist->CUS_NAME." - ".$packagelist->MEMBERSHIP_NO;
              $memberlistview.='<option value="'.$packagelist->CUS_ID.'">'.$name.'</option>';
            }
          }
          $json_response = array('memberlistview'=>$memberlistview);
          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit; 
          
      }else{
          redirect('admin','refresh');
    
    }
  
  }

  public function getmemberwalletdtl(){
       
    if($this->session->userdata('mantra_user_detail'))
    {   
        $session = $this->session->userdata('mantra_user_detail');
       
        $cus_id =  $this->input->post('cus_id');
        $where = array('CUS_ID'=> $cus_id);
        $memberdtl = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);
        if(!empty($memberdtl)){
        $member_acc_code = $memberdtl->member_acc_code;
        
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

        
         if(!empty($walletdtl)){
            $walletdtlview.="<option value=''>Select</option>";
         foreach($walletdtl as $walletdtl){

          if($walletdtl->is_promo == 'Y'){
              $walletdtlview.="<option data-amount=".$walletdtl->amount." data-ispromo=".$walletdtl->is_promo." value=".$walletdtl->is_promo.'_'.$walletdtl->id.'_'.$walletdtl->amount.">".$walletdtl->title.' - '.$walletdtl->amount."</option>";

          }else{

              $walletdtlview.="<option data-amount=".$walletdtl->amount." data-ispromo=".$walletdtl->is_promo." value=".$walletdtl->is_promo.'_'.$walletdtl->id.'_'.$walletdtl->amount.">".'Cashback'.' - '.$walletdtl->amount."</option>";

         }
      }
    }

    }else{
        $walletdtlview = "";
    }
                             
      $json_response = array('walletdtlview'=>$walletdtlview);
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit; 
      
  }else{
      redirect('admin','refresh');

}

}

public function productprice(){
       
    if($this->session->userdata('mantra_user_detail'))
    {   
        $session = $this->session->userdata('mantra_user_detail');
        $company_id = $session['companyid'];
        $sel_product =  $this->input->post('sel_product');
        $basic_price=0;
        $where = array('PROD_ID'=> $sel_product);
        $productdtl = $this->commondatamodel->getSingleRowByWhereCls('product_master',$where);
        if(!empty($productdtl)){

             $basic_price = $productdtl->BASIC_FEE;
       
      }
      $json_response = array('basic_price'=>$basic_price);
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
     
      $mode = trim(htmlspecialchars($this->input->post('mode')));
      $product_id = trim(htmlspecialchars($this->input->post('product_id')));
     

      if(trim(htmlspecialchars($this->input->post('date_of_sale'))) != ''){          
        $payment_dt = date('Y-m-d',strtotime($this->input->post('date_of_sale')));
       }else{
        $payment_dt=NULL;
       }
       $branch_id = trim(htmlspecialchars($this->input->post('branch')));
       $where_brn = array('BRANCH_ID'=>$branch_id);
       $branch_code = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_brn)->BRANCH_CODE; 

       $card_id = trim(htmlspecialchars($this->input->post('sel_card')));
       if($card_id !=- ""){
        $where_card = array('CARD_ID'=>$card_id);
         $carddtl= $this->commondatamodel->getSingleRowByWhereCls('card_master',$where_card);
         $card_code = $carddtl->CARD_CODE;   
       }
      
       $cus_id = trim(htmlspecialchars($this->input->post('sel_name')));
       if($cus_id !=- ""){
          $where = array('CUS_ID'=>$cus_id);
          $memberdtl= $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 

          $mno = $memberdtl->MEMBERSHIP_NO;         
          $corporate_comp_id = $memberdtl->corporate_comp_id;
          $phone=$memberdtl->CUS_PHONE;         
          $member_acc_code=$memberdtl->member_acc_code;         
       }
       $paymentdtl= $this->productsalemodel->GetValidity($mno); 
       $valid_string=$paymentdtl->VALIDITY_STRING;
       $valid_upto=$paymentdtl->VALID_UPTO;

       $sel_product = trim(htmlspecialchars($this->input->post('sel_product')));
       $where_prod = array('PROD_ID'=>$sel_product);
        $PROD_DESC = $this->commondatamodel->getSingleRowByWhereCls('product_master',$where_prod)->PROD_DESC;
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
     
      $cgstRateID = trim(htmlspecialchars($this->input->post('cgstrate')));
      $sgstRateID = trim(htmlspecialchars($this->input->post('sgstrate')));
      $payable_amt = trim(htmlspecialchars($this->input->post('payable_amt')));
      $sel_self_guest = trim(htmlspecialchars($this->input->post('sel_self_guest')));
      $guest_name = trim(htmlspecialchars($this->input->post('guest_name')));
      $guest_mobile = trim(htmlspecialchars($this->input->post('guest_mobile')));
      $guest_address = trim(htmlspecialchars($this->input->post('guest_address')));
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
      $rcpt_srl= $this->vouchermodel->gen_rcpt_serial_brn_fin($branch_code,$year_id,$comp);

       $sale_account = trim(htmlspecialchars($this->input->post('sale_account')));
       $WSTaccID = $sale_account;
      // $WSTaccDesc = "Sale WST";      
      // $WSTacc = $this->vouchermodel->getAccountIDBydesc($WSTaccDesc,$comp);
      // $WSTaccID = $WSTacc->account_id;

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

      $where_comp = array('comany_id'=>$comp);
      $is_gst = $this->commondatamodel->getSingleRowByWhereCls('company_master',$where_comp)->is_gst;

      if($branch_code!="TR" && $payment_now>0)
          {

            $pack_ins_id = $this->insertpackagesale($payment_dt,$sel_self_guest,$cus_id,$mno,$guest_name,$guest_mobile,$guest_address,$payment_now,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$branch_code,$valid_string,$sel_product);

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$cashback_amt,$premium_amt,$payment_now,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$pack_ins_id);

            $where_papckage_sale = array('PACK_SALE_ID'=>$pack_ins_id);
            $upd_papckage_sale = array('PAYMENT_ID'=>$payment_master_id);
            $this->commondatamodel->updateSingleTableData('package_sale',$upd_papckage_sale,$where_papckage_sale);

            //  insert voucher master
          
            $narration = "Product (ST)";
            $voucherno_prefix = 'RG';
            $serial_char = 'A';
            $payment_from = "WST";
            $voucher_srl = $this->vouchermodel->getLatestVoucherSerialNoNew($year_id,$comp);
            $voucher_no = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char);
            $debit_acc_id = $this->vouchermodel->getAccountIdByPaymentModeByBrnCode($branch_code,$payment_mode,$comp);
            
            // voucher master insert data for voucher A
             $voucher_master_id = $this->insertvouchermaster($voucher_srl,$voucher_no,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$total_amount);
             // voucher details insert data  for voucher A
             if($voucher_master_id > 0){

              $this->insertvoucherdetails($voucher_master_id,'Cr',$WSTaccID,$payment_now,1);
              if($is_gst == 'Y'){
              $this->insertvoucherdetails($voucher_master_id,'Cr',$cgstAccID,$cgstTaxAmt,2);
              $this->insertvoucherdetails($voucher_master_id,'Cr',$sgstAccID,$sgstTaxAmt,3);
               }
              $this->insertvoucherdetails($voucher_master_id,'Dr',$mem_account_id,$total_amount,4,$member_acc_code,$membership_ref);
              }

              // voucher master insert data for voucher B
              
              $serial_char2 = 'B';
              $voucher_no2 = $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id,$serial_char2);

              $voucher_master_id2 = $this->insertvouchermaster($voucher_srl,$voucher_no2,$payment_dt,$branch_id,$payment_from,$narration,$payment_master_id,$total_amount,'','','','',$cheque_no,$cheque_date,$cheque_bank,$cheque_branch);
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

           
          }else{

            $pack_ins_id = $this->insertpackagesale($payment_dt,$sel_self_guest,$cus_id,$mno,$guest_name,$guest_mobile,$guest_address,$payment_now,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$branch_code,$valid_string,$sel_product);

            $payment_master_id = $this->insertpaymentmaster($mno,$card_code,$cashback_amt,$premium_amt,$payment_now,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$pack_ins_id);

            $where_papckage_sale = array('PACK_SALE_ID'=>$pack_ins_id);
            $upd_papckage_sale = array('PAYMENT_ID'=>$payment_master_id);
            $this->commondatamodel->updateSingleTableData('package_sale',$upd_papckage_sale,$where_papckage_sale);

          }

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
                  "tran_module" => 'PRODSALE',
                  "tran_date" => date("Y-m-d H:i:s"),
                  "promo_cashback_assign_id" =>($is_promo == "Y") ? 0 : $promo_cashback_id,
                  "case_dtl_type" => "For Purchasing ".$PROD_DESC." Product",
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

        }else {

          

        }
        // end cash back insert data




       
       if($payment_master_id){

        $json_response = array(
            "msg_status" => 1,
            "msg_data"=>'Saved Successfully',              
            "mode"=>$mode,
            "cust_ins_id"=>$cus_id, 
            "pmt_ins_id"=>$payment_master_id 
           
           
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

private function insertvouchermaster($voucher_srl,$voucher_no,$payment_date,$branch_id,$tran_type,$narration,$paymentid,$total_amount=0,$card_category=NULL,$card_id=NULL,$card=NULL,$card_desc=NULL,$cheque_no=NULL,$cheque_date=NULL,$cheque_bank=NULL,$cheque_branch=NULL){
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
        "total_dr_amt" => $total_amount,
        "total_cr_amt" => $total_amount,
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


private function insertpackagesale($payment_dt,$sel_self_guest,$cus_id,$mno,$guest_name,$guest_mobile,$guest_address,$payment_now,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$branch_code,$valid_string,$sel_product){
    $session = $this->session->userdata('mantra_user_detail');
    $package_arr = array(
                          'PACK_CODE'=>NULL,
                          'DATE_OF_SALE'=>$payment_dt,
                          'MEM_GUEST'=>$sel_self_guest,
                          'MEMBERSHIP_ID'=>$cus_id,
                          'MEMBERSHIP_NO'=>$mno,
                          'GUEST_NAME'=>$guest_name,
                          'GUEST_ADDRESS'=>$guest_address,
                          'GUEST_CONTACT'=>$guest_mobile,
                          'BASIC_FEE'=>$payment_now,
                          'TAX_FEE'=>NULL,
                          'CGST_RATE_ID'=>$cgstRateID,
                          'CGST_AMT'=>$cgstTaxAmt,
                          'SGST_RATE_ID'=>$sgstRateID,
                          'SGST_AMT'=>$sgstTaxAmt,
                          'TOT_AMT'=>$total_amount,
                          'BRANCH_CODE'=>$branch_code,
                          'USER_ID'=>$session['userid'],
                          'FIN_ID'=>$session['yearid'],
                          'VALIDITY_STRING'=>$valid_string,
                          'PRODUCT_ID'=>$sel_product,
                          'IS_GST'=>'Y'
                        );
    $pack_ins_id = $this->commondatamodel->insertSingleTableData('package_sale',$package_arr);
        
    return $pack_ins_id;   
}


private function insertpaymentmaster($mno,$card_code,$cashback_amt,$premium_amt,$payment_now,$cgstTaxAmt,$cgstRateID,$sgstTaxAmt,$sgstRateID,$total_amount,$payment_dt,$branch_code,$rcpt_srl,$payment_mode,$cheque_no,$cheque_date,$cheque_bank,$cheque_branch,$cus_id,$valid_string,$coll_brn_code,$corporate_comp_id,$collection_branch_id,$branch_id,$card_id,$pack_ins_id){
    $session = $this->session->userdata('mantra_user_detail');
    $payment_arr = array(
                          'MEMBERSHIP_NO'=>$mno,
                          'CARD_CODE'=>$card_code,
                          'FROM_DT'=>$payment_dt,
                          'VALID_UPTO'=>$payment_dt,
                          'EXPIRY_DT'=>NULL,
                          'ADMISSION'=>0,
                          'SUBSCRIPTION'=>$premium_amt,
                          'DISCOUNT_CONV'=>0,
                          'DISCOUNT_OFFER'=>0,
                          'DISCOUNT_NEGO'=>NULL,
                          'NEGO_REMARK'=>NULL,
                          'CASHBACK_AMT'=>0,
                          'WALLET_AMT'=>$cashback_amt,
                          'PRM_AMOUNT'=>NULL,
                          'AMOUNT'=>$payment_now,
                          'MNTN_CHG'=>0,
                          'DUE_AMOUNT'=>0,
                          'SERVICE_TAX'=>NULL,
                          'CGST_RATE_ID'=>$cgstRateID,
                          'CGST_AMT'=>$cgstTaxAmt,
                          'SGST_RATE_ID'=>$sgstRateID,
                          'SGST_AMT'=>$sgstTaxAmt,
                          'TOTAL_AMOUNT'=>$total_amount,
                          'PAYMENT_DT'=>$payment_dt,
                          'FRESH_RENEWAL'=>'P',
                          'BRANCH_CODE'=>$branch_code,
                          'PROD_SALE_ID'=>$pack_ins_id,
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
                          'payment_from'=>'PRODSALE',
                          'collection_at'=>$coll_brn_code,
                          'voucher_master_id'=>0,
                          'second_voucher_mast_id'=>0,
                          'IS_GST'=>'Y',
                          'company_id'=>$session['companyid'],
                          'corporate_comp_id'=>$corporate_comp_id,
                          'covid_extention_days'=>0,
                          'user_given_extention'=>0,
                          'card_id'=>$card_id,
                          'branch_id'=>$branch_id,
                          'collection_branch_id'=>$collection_branch_id,
                        );
      $payment_master_id = $this->commondatamodel->insertSingleTableData('payment_master',$payment_arr);
        
      return $payment_master_id;                 
                      
  }

  

}