<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Memberinfo extends MY_Controller {
    public $CI = NULL;
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('registrationmodel','reg_model',TRUE);
        //$this->load->model('menumodel','menumodel',TRUE);
        $this->load->module('template');
        $this->CI = & get_instance();
    }



public function index()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $data['companyID']=$session['companyid'];
      
      
        $data['rowBranch'] = $this->reg_model->getAllBranch($data['companyID']); 
        $data['view_file'] = 'dashboard/registration/member_info_view';         
        $this->template->admin_template($data);
     
    }else{
        redirect('admin','refresh');
    }


 }


public function getMemberListEdit()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $mobileno = $_POST['mobileno'];
        $frmDt = date('Y-m-d',strtotime($_POST['frmDt']));
        $toDt = date('Y-m-d',strtotime($_POST['toDt']));
        $branch = $_POST['branch'];
        $result=[];
        if($mobileno!="")
        {
            $result['rowMemberInfo'] = $this->reg_model->GetMemberByMobileNo($mobileno,$company_id);
        }
        else
        {
            $result['rowMemberInfo'] = $this->reg_model->getMemberInfoByDateAndBrnch($frmDt,$toDt,$branch,$company_id);

        }

      //  pre($rowMemberInfo);


          $page = 'dashboard/registration/member_info_partial_view';    
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        

        
     
    }else{
        redirect('admin','refresh');
    }


 }


 public function getMemberDetailsModel()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $result['company_id']=$session['companyid'];
        	$cid = $_POST['cid'];
            $pid = $_POST['pid'];
            $mno = $_POST['mem'];
            $result['cid']=$cid;
            $result['pid']=$pid;
            $result['mno']=$mno;

           // $rowBranch=$obj_reg_inc->GetBranchList($_SESSION['COMPANY']);
            $result['rowBranch'] = $this->reg_model->getAllBranch($company_id); 
          //  $rowCard=$obj_reg_inc->GetCardList();
            $result['rowCard'] = $this->reg_model->getCardList($company_id); 
           // $rowServices=$obj_reg_inc->GetServiceList();
            $result['rowServices'] = $this->reg_model->getInterestedServiceList(); 
           // $rowUser=$obj_reg_inc->getUsers();
            $result['rowUser'] = $this->reg_model->getUsers($company_id); 
           // $rowTrainer=$obj_reg_inc->GetTrainerListAll();
            $result['rowTrainer'] = $this->reg_model->GetTrainerListAll($company_id); 
           // $rowCategory=$obj_reg_inc->getCategoryList();
            $result['rowCategory'] = $this->reg_model->getCategoryList($company_id); 
           // $rowBloodGroup = $obj_reg_inc->getBloodGroupList();
            $result['rowBloodGroup'] = $this->commondatamodel->getAllDropdownData('blood_group');

          //  $rowGetCGSTRate = $obj_reg_inc->GetGSTRate('CGST',$_SESSION['COMPANY']);
            $result['rowGetCGSTRate'] = $this->reg_model->GetGSTRate('CGST',$company_id); 
          //  $rowGetSGSTRate = $obj_reg_inc->GetGSTRate('SGST',$_SESSION['COMPANY']);           
            $result['rowGetSGSTRate'] = $this->reg_model->GetGSTRate('SGST',$company_id); 


            //$rowMemberInfo = $obj_reg_inc->getMemberDetailsByCode($mno);
            $result['rowMemberInfo'] = $this->reg_model->getMemberDetailsByCode($mno,$company_id);
           // $rowMemberPayment = $obj_reg_inc->GetPaymentData($pid);
            $result['rowMemberPayment'] = $this->reg_model->GetPaymentData($pid);
           // $rowDueData =  $disp_mem_cls->GetDueDetailData($pid);
            $result['rowDueData'] =  $this->reg_model->GetDueDetailData($pid);

            $result['rowinstallment'] = $this->commondatamodel->getAllDropdownData('installment_phase');

              $result['appetite']=array("Select","Good","Poor");
              $result['digestion']=array("Select","Normal","Acidity","Wind","Constipation","Ulcer","Abdominal Pain");
              $result['heart']=array("Select","Normal","Pinn in Chest","Palpitation","Ankle Swelling","Beathless-ness","Blood Pressure");
              $result['urine']=array("Select","Normal","Burning","Difficulty","Blood","Stone");
              $result['nerves']=array("Select","Normal","Headache","Fainting","Stone");
              $result['ent']=array("Select","Normal","Specific Problem");
              $result['ortho']=array("Select","Normal","Arthritis","Cervical","Lumber","Knee","Others");
              $result['psyche']=array("Select","Healthy","Anxiety","Childhood Experience","Problem at Home","Depression","Others");
              $result['disorder']=array("Select","Regular","Irregular","Painful","Not Applicable");
              $result['diet']=array("Select","Non-Veg","Veg");
              $result['pmt_mode']=array("Select","Cash","ONP","Cheque","Card","Fund Transfer");
              $result['heard_about']=array("Hoarding","Road Side Ad","Word of mouth","FM Radio","TV Ad","Conversion","From Member","Re Admission","Doctor Referral");
              $result['service']=array("Yes Always","No","If Required");
      


        $page = 'dashboard/registration/member_detail_modal_data';              
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        

        
     
    }else{
        redirect('admin','refresh');
    }


 }



 public function updateMemberData()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];

        $mode = $_POST['mode'];
        $cid = $_POST['cid'];
     //   pre($_POST);exit;
        
        
        if($mode=="PERSONAL"){
        $this->memberPersonalInfoUpadate($mode,$cid,$_POST);

        }else if($mode=="PAYMENTGST"){

        $this->memberPaymentInfoGSTUpadate($mode,$cid,$_POST,$company_id);

        }else if($mode=="GENMEDASS"){
            $this->memberGenerakMedicalInfoUpadate($mode,$cid,$_POST);

        }else if($mode=="MEDIINFO"){
            $this->memberMedicalInfoUpadate($mode,$cid,$_POST);

        }
        else{
            echo "1";
        }
       
           
           
          //pre($_POST);

       

        
     
    }else{
        redirect('admin','refresh');
    }


 }


 function memberPersonalInfoUpadate($mode,$cid,$postdata){

        $rowGetMember=$this->reg_model->getRegistrationData($cid);

 
        $prv_dob = $rowGetMember->CUS_DOB;
        $pass = $rowGetMember->PASS;

        $first_name = $postdata['first_name'];
        $last_name = $postdata['last_name'];
        $name = $postdata['name'];
        $dob = date("Y-m-d",strtotime($postdata['dob']));
        $gender = $postdata['gender'];
        $marital = $postdata['marital'];
        $father = $postdata['father'];
        $email = $postdata['email'];
        $occp = $postdata['occp'];
        $bldgrp = $postdata['bldgrp'];
        $trainer = $postdata['trainer'];
        $pin = $postdata['pin'];
        $address = $postdata['address'];
        $whatsupNum = $postdata['whatsupNum'];

        $cus_master_upd = array(
			"CUS_FNAME" => $first_name,
			"CUS_LNAME" => $last_name,
			"CUS_NAME" => $name,
			"CUS_SEX" => $gender,
			"CUS_MS" => $marital,
			"CUS_BLOOD_GRP" => $bldgrp,
			"CUS_FATHER" => $father,
			"CUS_ADRESS" => $address,
			"CUS_PIN" => $pin,
			"CUS_EMAIL" => $email,
			"CUS_OCCUPATION" => $occp,
			"trainer_id" => $trainer,
			"whatsup_number" => $whatsupNum
        );

         $where = array('CUS_ID' => $cid);
         $this->commondatamodel->updateSingleTableData('customer_master',$cus_master_upd,$where);
        

        if($prv_dob==$pass)
		{
			$upd_cus_dob = array(
			"CUS_DOB" => $dob,
			"PASS" => $dob
			);
		}
		else
		{
			$upd_cus_dob = array(
			"CUS_DOB" => $dob
			);
		}
		$this->commondatamodel->updateSingleTableData('customer_master',$upd_cus_dob,$where);
		
		
      

       echo "1";

 }

 function chekFromData($postdata,$val){
   $blank=null;
   if(isset($postdata[$val])){return $postdata[$val];}else{return $blank;}
}

public function memberMedicalInfoUpadate($mode,$cid,$postdata){

     $cus_master_upd['CUS_COMPLAINT']=$this->chekFromData($postdata,'txt_comp');
     $cus_master_upd['CUS_HISTORY']=$this->chekFromData($postdata,'CUS_HISTORY');
     $cus_master_upd['CUS_APPETITE']=$this->chekFromData($postdata,'sel_app');
     $cus_master_upd['CUS_DIGESTION']=$this->chekFromData($postdata,'sel_dig');
     $cus_master_upd['CUS_HEART']=$this->chekFromData($postdata,'sel_hrt');
     $cus_master_upd['CUS_URINE']=$this->chekFromData($postdata,'sel_urn');
     $cus_master_upd['CUS_NERVES']=$this->chekFromData($postdata,'sel_nrv');
     $cus_master_upd['CUS_ENT']=$this->chekFromData($postdata,'sel_ent');
     $cus_master_upd['CUS_ORTHO']=$this->chekFromData($postdata,'sel_ort');
     $cus_master_upd['CUS_PSYCHE']=$this->chekFromData($postdata,'sel_psy');
     $cus_master_upd['CUS_FD']=$this->chekFromData($postdata,'sel_fem');
     $cus_master_upd['CUS_DIET']=$this->chekFromData($postdata,'sel_dit');
     

            $where = array('CUS_ID' => $cid);
               $this->commondatamodel->updateSingleTableData('customer_master',$cus_master_upd,$where);



    echo "1";



}


 public function memberGenerakMedicalInfoUpadate($mode,$cid,$postdata){

               $cus_master_upd['is_high_bp']=$this->chekFromData($postdata,'is_high_bp');
               $cus_master_upd['high_bp_medicines']=$this->chekFromData($postdata,'high_bp_medicines');
               $cus_master_upd['diabetes_type']=$this->chekFromData($postdata,'diabetes_radio');
               $cus_master_upd['diabetics_medicines']=$this->chekFromData($postdata,'diabetics_medicines');
               $cus_master_upd['is_heart_disease']=$this->chekFromData($postdata,'is_heart_disease');
               $cus_master_upd['heart_disease_medicines']=$this->chekFromData($postdata,'heart_disease_medicines');
               $cus_master_upd['is_pcod']=$this->chekFromData($postdata,'is_pcod');
               $cus_master_upd['pcod_medicines']=$this->chekFromData($postdata,'pcod_medicines');
               $cus_master_upd['is_chronic_kidney_disease']=$this->chekFromData($postdata,'is_chronic_kidney_disease');
               $cus_master_upd['chronic_kidney_disease_medicines']=$this->chekFromData($postdata,'chronic_kidney_disease_medicines');
               $cus_master_upd['psyche']=$this->chekFromData($postdata,'sel_psyche');
               $cus_master_upd['regular_med_history']=$this->chekFromData($postdata,'regular_med_history');

            $where = array('CUS_ID' => $cid);
               $this->commondatamodel->updateSingleTableData('customer_master',$cus_master_upd,$where);



    echo "1";
 }

   /***********************************************************/
	 /*************PAYMENT FROM GST UPDATE HERE******************/
	/***********************************************************/


 public function memberPaymentInfoGSTUpadate($mode,$cid,$postdata,$company){

    if($mode=="PAYMENTGST")
	{
		$pid = $postdata['pid'];
		$voucher_master_id = $postdata['vmid'];
		$isEditable = $postdata['isedt'];

		//Payment Edit Data---
		$pmtDt = $postdata['pmtDt'];
		$clbrn = $postdata['clbrn'];
		$rmksnego = $postdata['rmksnego'];
		$paynw = $postdata['paynw'];
		$due = $postdata['due'];
		$cgstRate = $postdata['cgstRate'];
		$cgstAmt = $postdata['cgstAmt'];
		$sgstRate = $postdata['sgstRate'];
		$sgstAmt = $postdata['sgstAmt'];
		$payble = $postdata['payble'];
		$finsdt = $postdata['finsdt'];
		$finsamt = $postdata['finsamt'];
		$finschqn = $postdata['finschqn'];
		$finsbnk = $postdata['finsbnk'];
        $finbrn = $postdata['finbrn'];
        




		$secinsdt = $postdata['secinsdt'];
		$secinsamt = $postdata['secinsamt'];
		$secinschq = $postdata['secinschq'];
		$secinsbnk = $postdata['secinsbnk'];
        $secinsbrn = $postdata['secinsbrn'];

        $thirdinsdt = $postdata['thirdinsdt'];
		$thirdinsamt = $postdata['thirdinsamt'];
		$thirdinschq = $postdata['thirdinschq'];
		$thirdinsbnk = $postdata['thirdinsbnk'];
        $thirdinsbrn = $postdata['thirdinsbrn'];

        $fourinsdt = $postdata['fourinsdt'];
		$fourinsamt = $postdata['fourinsamt'];
		$fourinschq = $postdata['fourinschq'];
		$fourinsbnk = $postdata['fourinsbnk'];
        $fourinsbrn = $postdata['fourinsbrn'];

        
      

        $fifthinsdt = $postdata['fifthinsdt'];
		$fifthinsamt = $postdata['fifthinsamt'];
		$fifthinschq = $postdata['fifthinschq'];
		$fifthinsbnk = $postdata['fifthinsbnk'];
        $fifthinsbrn = $postdata['fifthinsbrn'];


        $sixthinsdt = $postdata['sixthinsdt'];
		$sixthinsamt = $postdata['sixthinsamt'];
		$sixthinschq = $postdata['sixthinschq'];
		$sixthinsbnk = $postdata['sixthinsbnk'];
        $sixthinsbrn = $postdata['sixthinsbrn'];

        
       
        



		$pmode = $postdata['pmode'];
		$chqno = $postdata['chqno'];
		$chqdt = $postdata['chqdt'];
		$bnkname = $postdata['bnkname'];
		$bnkbrn = $postdata['bnkbrn'];
		$doneby = $postdata['doneby'];
		
       // $rowPaymentData = $obj_reg_inc->GetPaymentData($pid);
        $rowPaymentData = $this->reg_model->GetPaymentData($pid);
		$prm = 0;
		
		
		
			$membershp = $rowPaymentData->MEMBERSHIP_NO;
			$validity_str = $rowPaymentData->VALIDITY_STRING;
			$branch = $rowPaymentData->BRANCH_CODE;
			$card = $rowPaymentData->CARD_CODE;
			$paymentfrom = $rowPaymentData->payment_from;
			$prm = $rowPaymentData->PRM_AMOUNT;
			$voucher_master_id_2 = $rowPaymentData->second_voucher_mast_id; //added on 23.07.2019
			
		
	
		
		
		$upd_payment_arr=array();
		$insert_due_arr=array();
		$upd_cust_due_dtl = array();
		$upd_cus = array();
		
		$upd_payment_arr = array(
			"NEGO_REMARK" => $rmksnego,
			"AMOUNT" => $paynw,
			"DUE_AMOUNT" => $due,
			"CGST_RATE_ID"=> $cgstRate,
			"CGST_AMT"=> $cgstAmt,
			"SGST_RATE_ID"=> $sgstRate,
			"SGST_AMT"=> $sgstAmt,
			"TOTAL_AMOUNT" => $payble,
			"PAYMENT_DT" => date('Y-m-d',strtotime($pmtDt)),
			"PAYMENT_MODE" => $pmode,
			"CHQ_NO" => $chqno,
			"CHQ_DT" => ($chqdt == "" ? NULL : date("Y-m-d", strtotime($chqdt))),
			"BANK_NAME" => $bnkname,
			"BRANCH_NAME" => $bnkbrn,
			"collection_at" => $clbrn
		);
		
      //  $upd = $disp_mem_cls->updatePaymentInfo($upd_payment_arr,$pid);
        $where_pid = array('payment_master.PAYMENT_ID' => $pid );
        $this->commondatamodel->updateSingleTableData('payment_master',$upd_payment_arr,$where_pid);
		
		$upd_cus = array(
			"done_by" => $doneby
		);
       // $updt = $disp_mem_cls->UpdateMemPersonalInfo($upd_cus,$cid);
        
        $where_cid = array('customer_master.CUS_ID' => $cid );
        $this->commondatamodel->updateSingleTableData('customer_master',$upd_cus,$where_cid);
		
		
		$isEditable="";
       // $checkduePayable = $disp_mem_cls->isDuePaid($membershp,$validity_str,$pid);
        $checkduePayable = $this->reg_model->isDuePaid($membershp,$validity_str,$pid);
		if($checkduePayable>0)
		{
			$isEditable="N";
		}
		else
		{
			$isEditable="Y";
		}
		
		if($due>0 AND $isEditable=="Y")
		{
			//$deleterec = $disp_mem_cls->DeleteDuePayable($membershp,$validity_str,$pid);
			$deleterec = $this->DeleteDuePayable($membershp,$validity_str,$pid);
			if($finsamt>0)
			{
			$insert_due_arr['member_id']=$cid;
			$insert_due_arr['membershipno']=$membershp;
			$insert_due_arr['due_pybl_date']=date('Y-m-d',strtotime($finsdt));
			$insert_due_arr['due_pybl_amt']=$finsamt;

			$insert_due_arr['BRANCH_CODE']=$branch;
			$insert_due_arr['CARD_CODE']=$card;
			$insert_due_arr['validity_string']=$validity_str;
			$insert_due_arr['from_where']=$paymentfrom;
			$insert_due_arr['from_payment_id']=$pid;

			$insert_due_arr['pybl_cheque_no']=$finschqn;
			$insert_due_arr['pybl_bank']=$finsbnk;
			$insert_due_arr['pybl_branch']=$finbrn;
			$insert_due_arr['company_id']=$company;
           // $insrt_due=$obj_reg_inc->InsertIntoDuePybl($insert_due_arr);
            $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
		   }
		
		  if($secinsamt>0)
		  {
			$insert_due_arr['member_id']=$cid;
			$insert_due_arr['membershipno']=$membershp;
			$insert_due_arr['due_pybl_date']=date('Y-m-d',strtotime($secinsdt));
			$insert_due_arr['due_pybl_amt']=$secinsamt;
			
			$insert_due_arr['BRANCH_CODE']=$branch;
			$insert_due_arr['CARD_CODE']=$card;
			$insert_due_arr['validity_string']=$validity_str;
			$insert_due_arr['from_where']=$paymentfrom;
			$insert_due_arr['from_payment_id']=$pid;

			$insert_due_arr['pybl_cheque_no']=$secinschq;
			$insert_due_arr['pybl_bank']=$secinsbnk;
			$insert_due_arr['pybl_branch']=$secinsbrn;
			$insert_due_arr['company_id']=$company;
					
           // $insrt_due=$obj_reg_inc->InsertIntoDuePybl($insert_due_arr);
            $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
           }
           

         if($thirdinsamt>0)
		  {
			$insert_due_arr['member_id']=$cid;
			$insert_due_arr['membershipno']=$membershp;
			$insert_due_arr['due_pybl_date']=date('Y-m-d',strtotime($thirdinsdt));
			$insert_due_arr['due_pybl_amt']=$thirdinsamt;
			
			$insert_due_arr['BRANCH_CODE']=$branch;
			$insert_due_arr['CARD_CODE']=$card;
			$insert_due_arr['validity_string']=$validity_str;
			$insert_due_arr['from_where']=$paymentfrom;
			$insert_due_arr['from_payment_id']=$pid;

			$insert_due_arr['pybl_cheque_no']=$thirdinschq;
			$insert_due_arr['pybl_bank']=$thirdinsbnk;
			$insert_due_arr['pybl_branch']=$thirdinsbrn;
			$insert_due_arr['company_id']=$company;
					
           // $insrt_due=$obj_reg_inc->InsertIntoDuePybl($insert_due_arr);
            $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
           }
           
           
        if($fourinsamt>0)
		  {
			$insert_due_arr['member_id']=$cid;
			$insert_due_arr['membershipno']=$membershp;
			$insert_due_arr['due_pybl_date']=date('Y-m-d',strtotime($fourinsdt));
			$insert_due_arr['due_pybl_amt']=$fourinsamt;
			
			$insert_due_arr['BRANCH_CODE']=$branch;
			$insert_due_arr['CARD_CODE']=$card;
			$insert_due_arr['validity_string']=$validity_str;
			$insert_due_arr['from_where']=$paymentfrom;
			$insert_due_arr['from_payment_id']=$pid;

			$insert_due_arr['pybl_cheque_no']=$fourinschq;
			$insert_due_arr['pybl_bank']=$fourinsbnk;
			$insert_due_arr['pybl_branch']=$fourinsbrn;
			$insert_due_arr['company_id']=$company;
					
           // $insrt_due=$obj_reg_inc->InsertIntoDuePybl($insert_due_arr);
            $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
		   }

         if($fifthinsamt>0)
		  {
			$insert_due_arr['member_id']=$cid;
			$insert_due_arr['membershipno']=$membershp;
			$insert_due_arr['due_pybl_date']=date('Y-m-d',strtotime($fifthinsdt));
			$insert_due_arr['due_pybl_amt']=$fifthinsamt;
			
			$insert_due_arr['BRANCH_CODE']=$branch;
			$insert_due_arr['CARD_CODE']=$card;
			$insert_due_arr['validity_string']=$validity_str;
			$insert_due_arr['from_where']=$paymentfrom;
			$insert_due_arr['from_payment_id']=$pid;

			$insert_due_arr['pybl_cheque_no']=$fifthinschq;
			$insert_due_arr['pybl_bank']=$fifthinsbnk;
			$insert_due_arr['pybl_branch']=$fifthinsbrn;
			$insert_due_arr['company_id']=$company;
					
           // $insrt_due=$obj_reg_inc->InsertIntoDuePybl($insert_due_arr);
            $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
           }
           

        if($sixthinsamt>0)
		  {
			$insert_due_arr['member_id']=$cid;
			$insert_due_arr['membershipno']=$membershp;
			$insert_due_arr['due_pybl_date']=date('Y-m-d',strtotime($sixthinsdt));
			$insert_due_arr['due_pybl_amt']=$sixthinsamt;
			
			$insert_due_arr['BRANCH_CODE']=$branch;
			$insert_due_arr['CARD_CODE']=$card;
			$insert_due_arr['validity_string']=$validity_str;
			$insert_due_arr['from_where']=$paymentfrom;
			$insert_due_arr['from_payment_id']=$pid;

			$insert_due_arr['pybl_cheque_no']=$sixthinschq;
			$insert_due_arr['pybl_bank']=$sixthinsbnk;
			$insert_due_arr['pybl_branch']=$sixthinsbrn;
			$insert_due_arr['company_id']=$company;
					
           // $insrt_due=$obj_reg_inc->InsertIntoDuePybl($insert_due_arr);
            $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
		   }
		   
		   if($paymentfrom!="REN")
		   {
		   // Updating Customer Master For Due Detail
		     $upd_cust_due_dtl = array(
			 "first_due_date" => date('Y-m-d',strtotime($finsdt)),
			 "first_due_amount" => $finsamt,
			 "second_due_date" => date('Y-m-d',strtotime($secinsdt)), 
			 "second_due_amount" => $secinsamt
			); 
			
            // $update = $disp_mem_cls->UpdateMemPersonalInfo($upd_cust_due_dtl,$cid);
             
             $where_cid = array('customer_master.CUS_ID' => $cid );
             $this->commondatamodel->updateSingleTableData('customer_master',$upd_cust_due_dtl,$where_cid);
		   }
		}
		
		$voucher_master = array();
		$voucher_detail = array();
		$voucherCustomer = array();
		$voucherSale = array();
		$vocherServicetax1 = array(); // CGST Array
		$vocherServicetax2 = array(); // SGST Array
		
		$debit_voucherArry = array();
		$credit_voucherArry = array();
		
		
            IF($voucher_master_id>0)
            {
                            IF($branch!="LT" && $branch!="TR" && $paynw>0)
                            {
                                
                                // getting member accountcode
                                $account_code = "";
                                $rowgetAccounCode = $this->getMemberAccountCode($membershp,$cid);
                                if($rowgetAccounCode){
                                    $account_code = $rowgetAccounCode->accountcode;
                                }
                                
                              //  $rowdebitAccountId = $obj_voucher_cls->getAccountIdByPaymentMode($branch,$pmode,$_SESSION['COMPANY']);
                                 $rowdebitAccountId = $this->reg_model->getAccountIdByPaymentMode($branch,$pmode,$company);
                                 $debit_acc_id = $rowdebitAccountId->account_id;
                              
                                    
                               // $rowCard = $obj_voucher_cls->GetCardDtlByCode($card);
                                $rowCard=$this->reg_model->getCardDtlByCode($card,$company);
                                $card_acc_id=0;
                                if($rowCard)
                                {
                                    $card_acc_id = $rowCard->account_id;
                                }
                                $sundry_debtor = "Sundry Debtor";
                               // $rowGetSundDebAcc = $obj_voucher_cls->getAccountIDBydesc($sundry_debtor,$_SESSION['COMPANY']);
                                $rowGetSundDebAcc = $this->reg_model->getAccountIDBydesc($sundry_debtor,$company);
                                if($rowGetSundDebAcc)
                                {
                                    $mem_account_id = $rowGetSundDebAcc->account_id; //Account ID Consider for Member
                                }
                                
                                /*
                                $serv_tax_desc = "SERVICE TAX PAID";
                                $rowGetServiceTaxAcc = $obj_voucher_cls->getAccountIDBydesc($serv_tax_desc);
                                foreach($rowGetServiceTaxAcc as $service_tax_acc)
                                {
                                    $serv_tax_acc_id = $service_tax_acc['account_id'];
                                }
                                */
                                /******GET CGST AND SGST Account ID*******/
                                
                                /********---CGST------**********/
                                    if($cgstRate>0)
                                    {	
                                       // $rowCGSTData =  $obj_reg_inc->GetGSTRateByID('CGST',$cgstRate);
                                        $rowCGSTData =  $this->reg_model->GetGSTRateByID('CGST',$cgstRate);
                                        if($rowCGSTData)
                                        {
                                            $cgstrate= $rowCGSTData->rate;
                                            $cgstAccID = $rowCGSTData->accountId;
                                        }
                                    }

                                    
                                    
                                    /*------********----SGST--------*/
                                    
                                    if($sgstRate>0)
                                    {
                                       // $rowSGSTData =  $obj_reg_inc->GetGSTRateByID('SGST',$sgstRate);
                                        $rowSGSTData =  $this->reg_model->GetGSTRateByID('SGST',$sgstRate);
                                        if($rowSGSTData)
                                        {
                                            $sgstrate= $rowSGSTData->rate;
                                            $sgstAccID = $rowSGSTData->accountId;
                                        }
                                    }
                                    
                                

                                
                                
                                    // NEW ENTRY FROM 01.07.2017 implemented on 26.02.2018
                                        
                                        $voucher_dtl_array = array();
                                        $voucherDtlArry1 = array(); // Sale  -- Cr  1
                                        $voucherDtlArry2 = array(); // CGST  -- Cr  2
                                        $voucherDtlArry3 = array(); // SGST  -- Cr  3
                                        $voucherDtlArry4 = array(); // Party -- Dr  4
                                        $voucherDtlArry5 = array(); // Party -- Cr  5
                                        $voucherDtlArry6 = array(); // Cash/bank -- Dr  6
                                        
                                        
                                        // Sales A/C Credit ---- 1
                                        $voucherDtlArry1 = array(
                                            "master_id" => $voucher_master_id,
                                            "srl_no" => 1,
                                            "tran_tag" => 'Cr',
                                            "acc_id" => $card_acc_id, // Sale A/C ID
                                            "pay_to_id" => '',
                                            "pay_month" => '',
                                            "amount" => $paynw,
                                            "accountcode" => NULL,
                                            "membership_no" => NULL
                                        );
                                        
                                        // CGST A/C Credit ----- 2
                                        $voucherDtlArry2 = array(
                                            "master_id" => $voucher_master_id,
                                            "srl_no" => 2,
                                            "tran_tag" => 'Cr',
                                            "acc_id" => $cgstAccID,
                                            "pay_to_id" => '',
                                            "pay_month" => '',
                                            "amount" => $cgstAmt,
                                            "accountcode" => NULL,
                                            "membership_no" => NULL
                                        );
                                        
                                        // SGST A/C Credit ----- 3
                                        $voucherDtlArry3 = array(
                                            "master_id" => $voucher_master_id,
                                            "srl_no" => 3,
                                            "tran_tag" => 'Cr',
                                            "acc_id" => $sgstAccID,
                                            "pay_to_id" => '',
                                            "pay_month" => '',
                                            "amount" => $sgstAmt,
                                            "accountcode" => NULL,
                                            "membership_no" => NULL
                                        );
                                        
                                        // Sundry Debtor A/C Debit ----- 4
                                        $voucherDtlArry4 = array(
                                            "master_id" => $voucher_master_id,
                                            "srl_no" => 4,
                                            "tran_tag" => 'Dr',
                                            "acc_id" => $mem_account_id,
                                            "pay_to_id" => '',
                                            "pay_month" => '',
                                            "amount" => $paynw+$cgstAmt+$sgstAmt,
                                            "accountcode" => $account_code,
                                            "membership_no" => $membershp
                                        );


                                        // delete old voucher detail
                                        //$delete = $obj_voucher_cls->deleteFromVoucherDetail($voucher_master_id);

                                      //  $voucher_dtl_array = array($voucherDtlArry1,$voucherDtlArry2,$voucherDtlArry3,$voucherDtlArry4);
                                      //  insertIntoVoucherDetailData($obj_voucher_cls,$voucher_dtl_array);

                                        // Updating total debit and total credit to voucher master
                                      //  $totalDebit = getTotalDebitAmt($obj_voucher_cls,$voucher_master_id);
                                      //  $totalCredit = getTotalCreditAmt($obj_voucher_cls,$voucher_master_id);
                                        //$update = updateVoucherMasterAmount($obj_voucher_cls,$voucher_master_id,$totalDebit,$totalCredit);


                                         $voucher_dtl_array = array($voucherDtlArry1,$voucherDtlArry2,$voucherDtlArry3,$voucherDtlArry4);
                                         $this->insertIntoVoucherDetailData($voucher_master_id,$voucher_dtl_array);

                                        
                                        /*----- For Second Voucher Prepare Master Data-----*/

                                        // Sundry Debtor A/C Credit ----- 5
                                        $voucherDtlArry5 = array(
                                            "master_id" => $voucher_master_id_2,
                                            "srl_no" => 1,
                                            "tran_tag" => 'Cr',
                                            "acc_id" => $mem_account_id,
                                            "pay_to_id" => '',
                                            "pay_month" => '',
                                            "amount" => $paynw+$cgstAmt+$sgstAmt,
                                            "accountcode" => $account_code,
                                            "membership_no" => $membershp
                                        );
                                        
                                        // Cash/Bank Debit ----- 6
                                        $voucherDtlArry6 = array(
                                            "master_id" => $voucher_master_id_2,
                                            "srl_no" => 2,
                                            "tran_tag" => 'Dr',
                                            "acc_id" => $debit_acc_id,
                                            "pay_to_id" => '',
                                            "pay_month" => '',
                                            "amount" => $paynw+$cgstAmt+$sgstAmt,
                                            "accountcode" => NULL,
                                            "membership_no" => NULL
                                        );




                                        // delete old voucher detail
                                       // $delete = $obj_voucher_cls->deleteFromVoucherDetail($voucher_master_id_2);

                                      //  $voucher_dtl_array2 = array($voucherDtlArry5,$voucherDtlArry6);
                                      //  insertIntoVoucherDetailData($obj_voucher_cls,$voucher_dtl_array2);

                                        // Updating total debit and total credit to voucher master
                                      //  $totalDebit = getTotalDebitAmt($obj_voucher_cls,$voucher_master_id_2);
                                     //   $totalCredit = getTotalCreditAmt($obj_voucher_cls,$voucher_master_id_2);
                                      //  $update = updateVoucherMasterAmount($obj_voucher_cls,$voucher_master_id_2,$totalDebit,$totalCredit);

                                        
                                        $voucher_dtl_array_2 = array($voucherDtlArry5,$voucherDtlArry6);
                                        $this->insertIntoVoucherDetailData($voucher_master_id_2,$voucher_dtl_array_2);
                                        
                                       
                                        
                                    $voucher_master = array(
                                    "voucher_date" => date('Y-m-d',strtotime($pmtDt)),
                                    "is_sent" => 'U'
                                    );
                                
                                    $upd_vucher = $this->UpdateVoucherMaster($voucher_master,$voucher_master_id);
                                    $upd_vucher2 = $this->UpdateVoucherMaster($voucher_master,$voucher_master_id_2);
                                
                                

                                
                            
                                
                            }
            }
	    echo "1";
	
      	/************************* END VOUCHER ENTRY*****************/
	}

 }


 public function DeleteDuePayable($mem,$validty,$pid){

      $where = array(
                        'membershipno' => $mem,
                        'validity_string' => $validty,
                        'from_payment_id' => $pid,
                    );
      $this->commondatamodel->deleteTableData('due_payable',$where);
 }

 public function InsertIntoDuePybl($insert_array){
   
   return  $this->commondatamodel->insertSingleTableData('due_payable',$insert_array); 
}

public function getMemberAccountCode($membershp,$customer_id){

 $where = array('MEMBERSHIP_NO'=>$membershp,'CUS_ID'=>$customer_id);      
 return $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where); 
}



   public function insertIntoVoucherDetailData($voucher_master_id,$voucherDtlArry){

      /* ----------------- delete voucher details ------------------------*/
      $where_voucher_master = array('master_id' => $voucher_master_id);
      $this->commondatamodel->deleteTableData('voucher_detail',$where_voucher_master);
      foreach ($voucherDtlArry as $value) {
      $this->commondatamodel->insertSingleTableData('voucher_detail',$value); 
      } 
      /* Updating total debit and total credit to voucher master */
      $totalDebit = $this->reg_model->getVoucherDetailsTotalAmount($voucher_master_id,'Dr');
      $totalCredit = $this->reg_model->getVoucherDetailsTotalAmount($voucher_master_id,'Cr');
      /* update voucher master amount */
      $update_array = array('total_dr_amt' => $totalDebit,'total_cr_amt' => $totalCredit );
      $where = array('id' => $voucher_master_id);
      $upd_insert = $this->commondatamodel->updateSingleTableData('voucher_master',$update_array,$where);

    }


   public function UpdateVoucherMaster($updArry,$vouchermastID){
             $where = array('voucher_master.id' => $vouchermastID );
             $this->commondatamodel->updateSingleTableData('voucher_master',$updArry,$where);

    }






}/*  end of class */