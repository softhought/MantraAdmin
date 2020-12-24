<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Accountmapping extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
         $this->load->model('accountmappingmodel','accountmappingmodel',TRUE);
         $this->load->model('registrationmodel','reg_model',TRUE);
         $this->load->module('template');
		
	}

public function index(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
        $where = array('company_id' => $company_id);
        $data['accountmappingList'] = $this->accountmappingmodel->getAllAccountMappingList($company_id);
        
        $data['view_file'] = 'dashboard/account/account_mapping/account_mapping_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  
  public function addCompany(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['accountmappingId'] = 0;
        $data['branchmappingEditdata'] = [];
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['accountmappingId'] = $this->uri->segment(4);
          $where = array('id'=>$data['accountmappingId']);
          $data['branchmappingEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('corporate_company',$where);


       }

        $data['rowBranch'] = $this->reg_model->getAllBranch($company_id); 
        $data['pmt_mode']=array("Cash","ONP","Cheque","Card","Fund Transfer");
        $orderby='account_description';
        $data['accountList'] = $this->commondatamodel->getAllRecordWhereOrderBy('account_master',[],$orderby);

      // exit;

        $data['view_file'] = 'dashboard/account/account_mapping/addedit_account_mapping';  
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function mapping_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
         
        $mode = $this->input->post('mode');
        $accountmappingId = $this->input->post('accountmappingId');
        $sel_payment_mode = trim($this->input->post('sel_payment_mode'));
        $sel_account = trim($this->input->post('sel_account'));
        $sel_branch = $this->input->post('sel_branch');
       
      

        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
        $branch_code =  $this->getBranchCodeByCompany($sel_branch,$company_id);

        if ($mode == "ADD" && $accountmappingId == "0") {

            $insert_arr = array(                             
                                'branch' => $branch_code,
                                'payment_mode' => $sel_payment_mode,                     
                                'account_id' => $sel_account,                     
                                'branch_id' => $sel_branch,                     
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );

             $insertData = $this->commondatamodel->insertSingleTableData('branch_acc_payment',$insert_arr);



                /** audit trail */ 
                  $module = 'Branch Mapping ';           
                  $action = "Insert";
                  $method = 'accpuntmapping/mapping_action';
                  $table="branch_acc_payment";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Branch Mapping',$module,$action,$method,$insertData,$table,$old_details,$new_details);


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
  

               if(1)
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
				"id" => $updID
				);

			$update = $this->commondatamodel->updateSingleTableData('branch_acc_payment',$update_array,$where);
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



  	public function checkAccountMapping(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$sel_branch = trim($this->input->post('sel_branch'));
			$sel_payment_mode = trim($this->input->post('sel_payment_mode'));
            $mode = trim($this->input->post('mode'));
            $accountmappingId = trim($this->input->post('accountmappingId'));
            $company_id=$session['companyid'];
            $flag=0;
            
            if($mode=='ADD'){
                $where = array('branch_id' => $sel_branch,'payment_mode' => $sel_payment_mode,'company_id' => $company_id);
                $checkData=$this->commondatamodel->duplicateValueCheck('branch_acc_payment',$where);
                if($checkData){$flag=1;}
            }else{
                $where_notequal = "id !=".$accountmappingId;
                $where = array('branch_id' => $sel_branch,'payment_mode' => $sel_payment_mode,'company_id' => $company_id);
                $checkData=$this->commondatamodel->checkExistanceDataWhereNotIn('branch_acc_payment',$where,$where_notequal);
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
					"msg_data" => "this account all ready mapped!"
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


   public function getBranchCodeByCompany($branch_id,$company_id){

    return $branch_code = $this->commondatamodel->getSingleRowByWhereCls('branch_master',array('BRANCH_ID'=>$branch_id,
                                                   'company_id'=>$company_id))->BRANCH_CODE; 

   }





}/* end of class  */