<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Emailmatter extends MY_Controller{
	
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
       
        $orderby='tran_id desc';
        $where = array('company_id' => $company_id );
        $data['emailmatterlist'] = $this->commondatamodel->getAllRecordWhereOrderBy('email_matter',$where ,$orderby);

        $data['view_file'] = 'dashboard/front_office/masters/email_matter/emailmatter_view';   
        
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  
  public function addEmailmatter(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['emailmatterId'] = 0;
        $data['emailmatterEditdata'] = [];
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['emailmatterId'] = $this->uri->segment(4);
          $where = array('tran_id'=>$data['emailmatterId']);
          $data['emailmatterEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('email_matter',$where);
       

       }


      // exit;

        $data['view_file'] = 'dashboard/front_office/masters/email_matter/addedit_emailmatter';   
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function emailmatter_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
         
        $mode = $this->input->post('mode');
        $email_title = $this->input->post('email_title');
        $email_matter = trim($this->input->post('email_matter'));
        $emailmatterId = trim($this->input->post('emailmatterId'));
  


        $company_id=$session['companyid'];
        $year_id=$session['yearid'];

        if ($mode == "ADD" && $emailmatterId == "0") {

            $insert_arr = array(
                                'email_title' => $email_title,
                                'email_matter' => $email_matter,                                                 
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );
             $insertData = $this->commondatamodel->insertSingleTableData('email_matter',$insert_arr);

        


                /** audit trail */ 
                     $module = 'Email Matter ';           
                  $action = "Insert";
                  $method = 'emailmatter/emailmatter_action';
                 $table="email_matter";
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
                                'email_title' => $email_title,
                                'email_matter' => $email_matter,                                                
                           );
                $where = array('tran_id'=>$emailmatterId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('email_matter',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('email_matter',$update_arr,$where);


                  /** audit trail */ 
                 $module = 'Email Matter ';           
                  $action = "Update";
                  $method = 'emailmatter/emailmatter_action';
                 $table="email_matter";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Sms ',$module,$action,$method,$emailmatterId,$table,$old_details,$new_details);


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
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('email_matter',$update_array,$where);
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