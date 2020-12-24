<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Account extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
		 $this->load->model('accountmodel','accountmodel',TRUE);
         $this->load->module('template');
		
	}

public function index(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
        $data['accountList'] = $this->accountmodel->getAllAccountList($company_id,$year_id);
        
        $data['view_file'] = 'dashboard/account/account/account_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  
  public function addAccount(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['accountId'] = 0;
        $data['accountEditdata'] = [];
        $data['openingBalance']=0;

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['accountId'] = $this->uri->segment(4);
          $where = array('account_id'=>$data['accountId']);
          $data['accountEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('account_master',$where);
          $data['openingBalance']=$this->accountmodel->getAccountOpeningBalance($company_id,$year_id,$data['accountId']);

       }

        $orderby='sub_group_desc';
        $data['subGroupList'] = $this->commondatamodel->getAllRecordWhereOrderBy('sub_group_master',[],$orderby);
        $orderbystate='state';
        $data['stateList'] = $this->commondatamodel->getAllRecordWhereOrderBy('state_master',[],$orderbystate);

      // exit;

        $data['view_file'] = 'dashboard/account/account/addedit_account';  
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function account_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
         
        $mode = $this->input->post('mode');
        $accountId = $this->input->post('accountId');
        $account_name = trim($this->input->post('account_name'));
        $select_sub_group = trim($this->input->post('select_sub_group'));
        $opening_balance = $this->input->post('opening_balance');
        $account_addr = $this->input->post('account_addr');
        $select_state = $this->input->post('select_state');
        $gst_in = $this->input->post('gst_in');
        $pan_no = $this->input->post('pan_no');


        $company_id=$session['companyid'];
        $year_id=$session['yearid'];

        if ($mode == "ADD" && $accountId == "0") {

            $insert_arr = array(
                                'account_description' => $account_name,
                                'sub_group_id' => $select_sub_group,
                                'open_bal' => $opening_balance,
                                'fin_id' => $year_id,
                                'address' => $account_addr,
                                'state_id' => $select_state,
                                'gstin' => $gst_in,
                                'panno' => $pan_no,                        
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );
             $insertData = $this->commondatamodel->insertSingleTableData('account_master',$insert_arr);

             $account_oening_array = array(
                                        'AccountId' =>$insertData , 
                                        'OpeningBalance' => $opening_balance, 
                                        'AccountingYearId' => $year_id, 
                                        'branch_code' => NULL, 
                                        'branchId' => NULL, 
                                        'companyId' => $company_id, 
                                      );
             $insertOpeningData = $this->commondatamodel->insertSingleTableData('account_opening_master',$account_oening_array);


                /** audit trail */ 
                  $module = 'Account ';           
                  $action = "Insert";
                  $method = 'account/account_action';
                  $table="account_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Account Master',$module,$action,$method,$insertData,$table,$old_details,$new_details);


               if($insertData)
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "Saved successfully",
                            "mode" => "ADD",
                        );

                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "There is some problem.Try again"
                        );

                    }



        }else{

              $update_arr = array(
                                'account_description' => $account_name,
                                'sub_group_id' => $select_sub_group,
                                'open_bal' => $opening_balance,
                                'address' => $account_addr,
                                'state_id' => $select_state,
                                'gstin' => $gst_in,
                                'panno' => $pan_no                                                 
                           );
                $where = array('account_id'=>$accountId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('account_master',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('account_master',$update_arr,$where);

                $this->deleteAccountOpeningBalance($year_id,$company_id,$accountId);

                 $account_oening_array = array(
                                        'AccountId' =>$accountId , 
                                        'OpeningBalance' => $opening_balance, 
                                        'AccountingYearId' => $year_id, 
                                        'branch_code' => NULL, 
                                        'branchId' => NULL, 
                                        'companyId' => $company_id, 
                                      );
             $insertOpeningData = $this->commondatamodel->insertSingleTableData('account_opening_master',$account_oening_array);

                  /** audit trail */ 
                 $module = 'Account ';           
                 $action = "Update";
                 $method = 'account/account_action';
                 $table="account_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Account ',$module,$action,$method,$accountId,$table,$old_details,$new_details);


               if($upd_insert)
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "Saved successfully",
                            "mode" => "ADD",
                        );

                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "There is some problem.Try again"
                        );

                    }



            

        }


            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;

   }else
		{
			redirect('login','refresh');
        }
        
  }


  
	public function setStatus(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"account_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('account_master',$update_array,$where);
			if($update)
			{
				$json_response = array(
					"msg_status" => 1,
					"msg_data" => "Status updated"
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "Failed to update"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }



  	public function checkAccountName(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$account_name = trim($this->input->post('account_name'));
            $mode = trim($this->input->post('mode'));
            $accountId = trim($this->input->post('accountId'));
            $company_id=$session['companyid'];
            $flag=0;
            
            if($mode=='ADD'){
                $where = array('account_description' => $account_name,'company_id' => $company_id);
                $checkData=$this->commondatamodel->duplicateValueCheck('account_master',$where);
                if($checkData){$flag=1;}
            }else{
                $where_notequal = "account_id !=".$accountId;
                $where = array('account_description' => $account_name,'company_id' => $company_id);
                $checkData=$this->commondatamodel->checkExistanceDataWhereNotIn('account_master',$where,$where_notequal);
                if($checkData){$flag=1;}
            }

     
			if(!$flag)
			{
				$json_response = array(
					"msg_status" => 1,
					"msg_data" => "You can proceed"
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "Account name all ready exist!"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }




    public function deleteAccountOpeningBalance($year_id,$company_id,$accountId){
         $where = array(
                        'AccountingYearId' => $year_id,
                        'companyId' => $company_id,
                        'AccountId' => $accountId,
                    );
      $this->commondatamodel->deleteTableData('account_opening_master',$where);
    }


}/* end of class  */