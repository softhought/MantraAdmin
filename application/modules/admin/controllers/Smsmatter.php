<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Smsmatter extends MY_Controller{
	
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

       $orderby='tran_id desc';
       $where = array('company_id' => $company_id );
        $data['smasmatterlist'] = $this->commondatamodel->getAllRecordWhereOrderBy('sms_matter',$where,$orderby);

       // pre($data['smasmatterlist']); exit;
       
        
        $data['view_file'] = 'dashboard/front_office/masters/sms_matter/smsmatter_view';   
        
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  
  public function addSmsmatter(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['smsmatterId'] = 0;
        $data['smsmatterEditdata'] = [];
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['smsmatterId'] = $this->uri->segment(4);
          $where = array('tran_id'=>$data['smsmatterId']);
          $data['smsmatterEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('sms_matter',$where);
       

       }


      // exit;

        $data['view_file'] = 'dashboard/front_office/masters/sms_matter/addedit_smsmatter';   
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function smsmatter_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
         
        $mode = $this->input->post('mode');
        $sms_title = $this->input->post('sms_title');
        $sms_matter = trim($this->input->post('sms_matter'));
        $smsmatterId = trim($this->input->post('smsmatterId'));
  


        $company_id=$session['companyid'];
        $year_id=$session['yearid'];

        if ($mode == "ADD" && $smsmatterId == "0") {

            $insert_arr = array(
                                'sms_title' => $sms_title,
                                'sms_matter' => $sms_matter,                                                 
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );
             $insertData = $this->commondatamodel->insertSingleTableData('sms_matter',$insert_arr);

        


                /** audit trail */ 
                  $module = 'Sms Matter ';           
                  $action = "Insert";
                  $method = 'smsmatter/smsmatter_action';
                  $table="sms_matter";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Sms Matter',$module,$action,$method,$insertData,$table,$old_details,$new_details);


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
                                'sms_title' => $sms_title,
                                'sms_matter' => $sms_matter,                                                
                           );
                $where = array('tran_id'=>$smsmatterId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('sms_matter',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('sms_matter',$update_arr,$where);


                  /** audit trail */ 
                 $module = 'Sms Matter ';           
                  $action = "Update";
                  $method = 'smsmatter/smsmatter_action';
                 $table="sms_matter";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Sms ',$module,$action,$method,$smsmatterId,$table,$old_details,$new_details);


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
				"tran_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('sms_matter',$update_array,$where);
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