<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Corporatecompany extends MY_Controller{
	
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
        $where = array('company_id' => $company_id);
        $orderby='company_name'; 
        $data['corporateCompanyList'] = $this->commondatamodel->getAllRecordWhereOrderBy('corporate_company',$where,$orderby);
        
        $data['view_file'] = 'dashboard/account/corporate_company/corporate_company_view';       
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
        $data['corporateCompanyId'] = 0;
        $data['corporateCompanyEditdata'] = [];
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['corporateCompanyId'] = $this->uri->segment(4);
          $where = array('id'=>$data['corporateCompanyId']);
          $data['corporateCompanyEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('corporate_company',$where);


       }



      // exit;

        $data['view_file'] = 'dashboard/account/corporate_company/addedit_corporate_company';  
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function company_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
         
        $mode = $this->input->post('mode');
        $corporateCompanyId = $this->input->post('corporateCompanyId');
        $company_name = trim($this->input->post('company_name'));
        $gistn_no = trim($this->input->post('gistn_no'));
        $address = $this->input->post('address');
       


        $company_id=$session['companyid'];
        $year_id=$session['yearid'];

        if ($mode == "ADD" && $corporateCompanyId == "0") {

            $insert_arr = array(                             
                                'company_name' => $company_name,
                                'gistn_no' => $gistn_no,                     
                                'address' => $address,                     
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );

             $insertData = $this->commondatamodel->insertSingleTableData('corporate_company',$insert_arr);



                /** audit trail */ 
                  $module = 'Corporate Company ';           
                  $action = "Insert";
                  $method = 'corporate_company/company_action';
                  $table="corporate_company";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Corporate company',$module,$action,$method,$insertData,$table,$old_details,$new_details);


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
                                'company_name' => $company_name,
                                'gistn_no' => $gistn_no,                     
                                'address' => $address,                     
                                'is_active' => 'Y',                                                   
                           );
                $where = array('id'=>$corporateCompanyId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('corporate_company',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('corporate_company',$update_arr,$where);



                  /** audit trail */ 
                 $module = 'Corporate Company';           
                 $action = "Update";
                 $method = 'corporate_company/company_action';
                 $table="corporate_company";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Add Corporate company ',$module,$action,$method,$corporateCompanyId,$table,$old_details,$new_details);


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
				"id" => $updID
				);

			$update = $this->commondatamodel->updateSingleTableData('corporate_company',$update_array,$where);
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
			$company_name = trim($this->input->post('company_name'));
            $mode = trim($this->input->post('mode'));
            $corporateCompanyId = trim($this->input->post('corporateCompanyId'));
            $company_id=$session['companyid'];
            $flag=0;
            
            if($mode=='ADD'){
                $where = array('company_name' => $company_name,'company_id' => $company_id);
                $checkData=$this->commondatamodel->duplicateValueCheck('corporate_company',$where);
                if($checkData){$flag=1;}
            }else{
                $where_notequal = "id !=".$corporateCompanyId;
                $where = array('company_name' => $company_name,'company_id' => $company_id);
                $checkData=$this->commondatamodel->checkExistanceDataWhereNotIn('corporate_company',$where,$where_notequal);
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
					"msg_data" => "Company name all ready exist!"
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





}/* end of class  */