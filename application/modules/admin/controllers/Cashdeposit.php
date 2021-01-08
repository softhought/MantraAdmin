<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Cashdeposit extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		  $this->load->model('cashdepositmodel','cashdepositmodel',TRUE);
		  $this->load->model('vouchermodel','vouchermodel',TRUE);
          $this->load->module('template');		

	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
       
        $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/account/cash_deposit/cashdeposit_list';
        $this->template->admin_template($data);  		

    }else{
        redirect('admin','refresh');  

  }
}

public function getAllCashDepostit(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
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
           $branch =  $this->input->post('branch');

         $data['cashdepositlist'] = $this->cashdepositmodel->getAllCashDepostit($from_dt,$to_date,$branch,$comp);  
        // pre($data['branchlist']);exit;
        $page = 'dashboard/account/cash_deposit/cashdeposit_partial_list';
        $this->load->view($page,$data);
        		

    }else{
        redirect('admin','refresh');  

  }
}
  public function addeditcashdeposit(){
   
    if($this->session->userdata('mantra_user_detail'))
    {   
        $session = $this->session->userdata('mantra_user_detail');
        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";  
            $data['btnTextLoader'] = "Saving...";   
            $data['tranId'] = 0;
            $data['voucherId'] = 0;
            $data['cashdepositEditdata'] = [];  

           }else{      
              $data['mode'] = "EDIT";   
              $data['btnText'] = "Update";
              $data['btnTextLoader'] = "Updating..."; 
              $data['tranId'] = $this->uri->segment(4);    
               $where = array('tran_id'=>$data['tranId']);  
               $data['cashdepositEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('cash_deposit',$where); 
               if($data['cashdepositEditdata']->voucher_id != 0){  
                   $data['voucherId'] = $data['cashdepositEditdata']->voucher_id; 
                   $where_voucher = array('id'=>$data['voucherId']);
                   $data['voucherEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where_voucher);
                   $where_voucher_dtl = array('master_id'=>$data['voucherId'],'tran_tag'=>'Cr');
                   $data['Creditaccountdtl'] = $this->commondatamodel->getSingleRowByWhereCls('voucher_detail',$where_voucher_dtl); 
                   $where_voucher_dtl2 = array('master_id'=>$data['voucherId'],'tran_tag'=>'Dr');
                   $data['debitaccdtl'] = $this->commondatamodel->getSingleRowByWhereCls('voucher_detail',$where_voucher_dtl2);
                   //pre($data['Creditaccountdtl']);exit;
               }else{
                $data['voucherId'] = 0;
               }  
           }

           $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
           $subgroupids = array('4','5');
          $comp = $session['companyid']; 
           $data['CreditDebitAccountList'] = $this->cashdepositmodel->getCreditDebitAccountList($comp,$subgroupids); 
        //pre($data['CreditDebitAccountList']);exit;

       $data['view_file'] = 'dashboard/account/cash_deposit/addedit_cashdeposit'; ;       

        $this->template->admin_template($data);  

		

    }else{

        redirect('admin','refresh');

  

  }

  }
  public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {

      $session = $this->session->userdata('mantra_user_detail');
       

        $tranId = trim(htmlspecialchars($this->input->post('tranId')));
        $voucherId = trim(htmlspecialchars($this->input->post('voucherId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));
      
        if(trim(htmlspecialchars($this->input->post('date_of_deposit'))) != ''){          
            $date_of_deposit = date('Y-m-d',strtotime($this->input->post('date_of_deposit')));
           }else{
            $date_of_deposit=NULL;
           }
           $branch_id = trim(htmlspecialchars($this->input->post('branch')));
           $debit_acc_id = trim(htmlspecialchars($this->input->post('debit_acc_id')));
           $credit_acc_id = trim(htmlspecialchars($this->input->post('credit_acc_id')));
           $deposit_amt = trim(htmlspecialchars($this->input->post('deposit_amt')));

          $year_id =  $session['yearid'];    
          $comp =  $session['companyid'];   
          $user_id =  $session['userid'];   

           if ($mode == "ADD" && $tranId == "0") {          

               $voucher_srl =  $this->vouchermodel->getLatestVoucherSerialNoNew($year_id,$comp); 
               $voucherno_prefix = 'CD';              
               $voucher_no =  $this->vouchermodel->GenerateVoucherNoNew($voucherno_prefix,$voucher_srl,$year_id); 

               //update voucher_srl_master last srl  
               $where_voucher_srl = array('year_id'=>$year_id,'company_id'=>$comp);
               $voucher_arr = array('last_srl'=>$voucher_srl+1);
               $voucher_master = $this->commondatamodel->updateSingleTableData('voucher_srl_master',$voucher_arr,$where_voucher_srl);


               $narration="Cash Deposit";

              $voucher_master = array(
                                        "srl_no" => $voucher_srl,
                                        "voucher_no" => $voucher_no,
                                        "voucher_no_old" => $voucher_no,
                                        "voucher_date" => $date_of_deposit,
                                        "branch_id" => $branch_id,
                                        "tran_type" => 'CASH',
                                        "tran_sub_type" => '',
                                        "pkg_cat" => '',
                                        "pkg_id" => 0,
                                        "pkg_code" =>'',
                                        "pkg_desc" => '',
                                        "narration" => $narration,
                                        // "cheque_no" => $cheque_no,
                                        // "cheque_date" =>$cheque_date,
                                        // "bank_name" =>$bank,
                                        // "bank_branch" =>$bank_branch,
                                        "total_dr_amt" => $deposit_amt,
                                        "total_cr_amt" => $deposit_amt,
                                        "user_id" => $user_id,
                                        "year_id" => $year_id,
                                        "is_daily_collection" => 'Y',
                                        "company_id" => $comp
                          );


                $voucher_master_id = $this->commondatamodel->insertSingleTableData('voucher_master',$voucher_master);

               $this->insertvouchertl($voucher_master_id,'Dr',$debit_acc_id,$deposit_amt,1);
               $this->insertvouchertl($voucher_master_id,'Cr',$credit_acc_id,$deposit_amt,2);

               $cash_depositarray = array(
                                            'branch_id'=>$branch_id,
                                            'date_of_deposit'=>$date_of_deposit,
                                            'deposit_amt'=>$deposit_amt,
                                            'voucher_id'=>$voucher_master_id,
                                            'fin_id'=>$year_id,
                                            'entry_date'=>date('Y-m-d'),
                                            'company_id'=>$comp,
                                            );
            $upd_inser = $this->commondatamodel->insertSingleTableData('cash_deposit',$cash_depositarray);

                 /** audit trail */ 
                  $module = 'Cash Deposit'; 
                  $action = "Insert";
                  $method = 'cashdeposit/addedit_action';
                  $table="cash_deposit";
                  $old_details="";
                  $new_details = json_encode($cash_depositarray);
                  $this->commondatamodel->insertSingleActivityTableData('Add Cash Deposit',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);


            } else{

                if($voucherId != 0){
                    $voucher_no = "";
                    $where_voucher_mst = array('id'=>$voucherId);

                    $voucher_master_update = array(      
                        "voucher_date" => $date_of_deposit,
                        "branch_id" => $branch_id,      
                        // "cheque_no" => $cheque_no,
                        // "cheque_date" =>$cheque_date,
                        // "bank_name" =>$bank,
                        // "bank_branch" =>$bank_branch,
                        "total_dr_amt" => $deposit_amt,
                        "total_cr_amt" => $deposit_amt
                      );
                    $voucher_master = $this->commondatamodel->updateSingleTableData('voucher_master',$voucher_master_update,$where_voucher_mst);
                    $where_voucher_dtl = array('master_id'=>$voucherId);
                    $delete_voucherdtl = $this->commondatamodel->deleteTableData('voucher_detail',$where_voucher_dtl);

                    $this->insertvouchertl($voucherId,'Dr',$debit_acc_id,$deposit_amt,1);
                    $this->insertvouchertl($voucherId,'Cr',$credit_acc_id,$deposit_amt,2);

                    $update_cash_deposit = array(
                        'branch_id'=>$branch_id,
                        'date_of_deposit'=>$date_of_deposit,
                        'deposit_amt'=>$deposit_amt,                       
                        
                        );

                    $where_trn = array('tran_id'=>$tranId);
                    $olddtl = $this->commondatamodel->getSingleRowByWhereCls('cash_deposit',$where_trn);    
                    $upd_inser = $this->commondatamodel->updateSingleTableData('cash_deposit',$update_cash_deposit,$where_trn);

                      /** audit trail */ 

                 $module = 'Cash Deposit';
                 $action = "Update";
                 $method = 'cashdeposit/addedit_action';
                 $table="cash_deposit";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_cash_deposit);

                 $this->commondatamodel->insertSingleActivityTableData('Update Cash Deposit',$module,$action,$method,$tranId,$table,$old_details,$new_details);


                }                    

            }  

          if($upd_inser){

              $json_response = array(
                  "msg_status" => 1,
                  "msg_data"=>'Saved Successfully',              
                  "mode"=>$mode,
                  "voucherno"=>$voucher_no
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

private function insertvouchertl($voucher_master_id,$tran_tag,$acc_id,$deposit_amt,$srl){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $voucherDtlArry = array(
            "master_id" => $voucher_master_id,
            "srl_no" => $srl,
            "tran_tag" => $tran_tag,
            "acc_id" =>  $acc_id, 
            "pay_to_id" => '',
            "pay_month" => '',
            "amount" => $deposit_amt,
            "accountcode" => NULL,
            "membership_no" => NULL
          );
        		
         $this->commondatamodel->insertSingleTableData('voucher_detail',$voucherDtlArry);
    }else{
        redirect('admin','refresh');  

  }
}

public function deletecashdeposit(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];

        $tran_id = $this->input->post('tran_id');
        $voucher_id = $this->input->post('voucher_id');

       
        
        if($tran_id > 0 && $voucher_id > 0){
           
            $where_detail = array('master_id'=>$voucher_id);
            $where_cash = array('tran_id'=>$tran_id);
            $where_voucher = array('id'=>$voucher_id);

            $voucher_mst = $this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where_voucher);
            $voucher_dtl = $this->commondatamodel->getAllRecordWhere('voucher_detail',$where_detail);
            $cash_dtl = $this->commondatamodel->getSingleRowByWhereCls('cash_deposit',$where_cash);

            $module = 'Cash Deposit';
            $action = "Delete";
            $method = 'cashdeposit/deletecashdeposit';
            $table="cash_deposit";
            $new_details = "";
            $old_details = "Cash Deposit : ".json_encode($cash_dtl)."Voucher_master : ".json_encode($voucher_mst).'voucher_dtl : '.json_encode($voucher_dtl);
            $this->commondatamodel->insertSingleActivityTableData('Delete Cash Deposit',$module,$action,$method,$tran_id,$table,$old_details,$new_details);
    

            $dtl_delete = $this->commondatamodel->deleteTableData('voucher_detail',$where_detail); 
            $voucher_mst = $this->commondatamodel->deleteTableData('voucher_master',$where_voucher);
            $cash = $this->commondatamodel->deleteTableData('cash_deposit',$where_cash);
                    
       }
        
      
        $json_response = array(
            "msg_status" => 1,
            "msg_data" => "Delete Succssfully"     

        );
      
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit;      
        		

    }else{
        redirect('admin','refresh');  

  }
}


}  