<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Accountsubgroup extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
		 $this->load->model('Accountsubgroupmodel','Accountsubgroupmodel',TRUE);
         $this->load->module('template');
		
	}

public function index(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
        $data['accountSubGroupList'] = $this->Accountsubgroupmodel->getAcountSubGroupList($company_id);
        
        $data['view_file'] = 'dashboard/account/account_sub_group/account_sub_group_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

    public function addAccountsubgroup(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['subgroupId'] = 0;
        $data['subgroupEditdata'] = [];
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['subgroupId'] = $this->uri->segment(4);
          $where = array('sub_group_id'=>$data['subgroupId']);
          $data['subgroupEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('sub_group_master',$where);
        

       }

        $orderby='group_description';
        $data['groupList'] = $this->commondatamodel->getAllRecordWhereOrderBy('group_master',[],$orderby);
    
      // exit;

        $data['view_file'] = 'dashboard/account/account_sub_group/addedit_account_sub_group';  
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function accountsubgroup_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
        $mode = $this->input->post('mode');
        $subgroupId = $this->input->post('subgroupId');
        $subgroupname = trim($this->input->post('subgroupname'));
        $sel_group = $this->input->post('sel_group');

        $company_id=$session['companyid'];

        if ($mode == "ADD" && $subgroupId == "0") {

            $insert_arr = array(
                                'sub_group_desc' => $subgroupname,
                                'group_id' => $sel_group,
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );
             $insertData = $this->commondatamodel->insertSingleTableData('sub_group_master',$insert_arr);
                /** audit trail */ 
                  $module = 'Account Sub Group';           
                  $action = "Insert";
                  $method = 'accountsubgroup/accountsubgroup_action';
                  $table="sub_group_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Sub Group Master',$module,$action,$method,$insertData,$table,$old_details,$new_details);


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
                                 'sub_group_desc' => $subgroupname,
                                 'group_id' => $sel_group,
                                 'is_active' => 'Y',
                                
                           );
                $where = array('sub_group_id'=>$subgroupId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('sub_group_master',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('sub_group_master',$update_arr,$where);

                  /** audit trail */ 
                 $module = 'Account Sub Group';           
                 $action = "Update";
                 $method = 'accountsubgroup/accountsubgroup_action';
                 $table="sub_group_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Account Sub Group Master',$module,$action,$method,$subgroupId,$table,$old_details,$new_details);


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
				"sub_group_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('sub_group_master',$update_array,$where);
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


     	public function checkSubGroupName(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$subgroupname = trim($this->input->post('subgroupname'));
            $mode = trim($this->input->post('mode'));
            $subgroupId = trim($this->input->post('subgroupId'));
            $company_id=$session['companyid'];
            $flag=0;
            
            if($mode=='ADD'){
                $where = array('sub_group_desc' => $subgroupname,'company_id' => $company_id);
                $checkData=$this->commondatamodel->duplicateValueCheck('sub_group_master',$where);
                if($checkData){$flag=1;}
            }else{
                $where_notequal = "sub_group_id !=".$subgroupId;
                $where = array('sub_group_desc' => $subgroupname,'company_id' => $company_id);
                $checkData=$this->commondatamodel->checkExistanceDataWhereNotIn('sub_group_master',$where,$where_notequal);
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
					"msg_data" => "Sub Group name all ready exist!"
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


}/* end of class */