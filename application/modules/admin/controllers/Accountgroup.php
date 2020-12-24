<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Accountgroup extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
		 $this->load->model('branchmodel','branchmodel',TRUE);
         $this->load->module('template');
		
	}

public function index(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
        $orderby='group_description';
        $data['accountgrouplist'] = $this->commondatamodel->getAllRecordWhereOrderBy('group_master',[],$orderby);
        
        $data['view_file'] = 'dashboard/account/account_group/account_group_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function addAccountgroup(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  

       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['groupId'] = 0;
        $data['accountgroupEditdata'] = [];

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['groupId'] = $this->uri->segment(4);
          $where = array('group_id'=>$data['groupId']);
          $data['accountgroupEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('group_master',$where);

       }

     

      // exit;

        $data['view_file'] = 'dashboard/account/account_group/addedit_accountgroup_view';  
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

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
				"group_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('group_master',$update_array,$where);
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


  public  function  getSecondCategory(){

       $cat=$_POST['cat1'];
       if ($cat=="B")
        { 
        ?>

            <select name="sel_grp_cat2" id="sel_grp_cat2" class="form-control select2" style="width: 150px;">
            <option value="0">Select</option>
            <option value="A">Asset</option>
            <option value="L">Liability</option>
            </select>
        <?php
        }
        if ($cat=="P" or $cat=="T")
        {
        ?>
            <select name="sel_grp_cat2" id="sel_grp_cat2" class="form-control select2" style="width: 150px;">
            <option value="0">Select</option>
            <option value="I">Income</option>
            <option value="E">Expenditure</option>
            </select>
        <?php
        }
        if ($cat!="B" and $cat!="P" and $cat!="T")
        {
        ?>
            <select name="sel_grp_cat2" id="sel_grp_cat2" class="form-control select2" style="width: 150px;">
            <option value="0">Select</option>
            </select>

        <?php
        }


  } 


  public function accountgroup_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
        $mode = $this->input->post('mode');
        $groupId = $this->input->post('groupId');
        $groupname = trim($this->input->post('groupname'));
        $sel_grp_cat1 = $this->input->post('sel_grp_cat1');
        $sel_grp_cat2 = $this->input->post('sel_grp_cat2');
        $company_id=$session['companyid'];

        if ($mode == "ADD" && $groupId == "0") {

            $insert_arr = array(
                                'group_description' => $groupname,
                                'b_p_t' => $sel_grp_cat1,
                                'a_l_i_e' => $sel_grp_cat2,
                                'is_active' => 'Y',
                                'company_id' => $company_id
                           );
             $insertData = $this->commondatamodel->insertSingleTableData('group_master',$insert_arr);
                /** audit trail */ 
                  $module = 'Account group';           
                  $action = "Insert";
                  $method = 'accountgroup/accountgroup_action';
                  $table="group_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Branch Master',$module,$action,$method,$insertData,$table,$old_details,$new_details);


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
                                'group_description' => $groupname,
                                'b_p_t' => $sel_grp_cat1,
                                'a_l_i_e' => $sel_grp_cat2,
                                'is_active' => 'Y',
                                
                           );
                $where = array('group_id'=>$groupId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('group_master',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('group_master',$update_arr,$where);

                  /** audit trail */ 
                 $module = 'Account Group';           
                 $action = "Update";
                 $method = 'accountgroup/accountgroup_action';
                 $table="group_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Account Group',$module,$action,$method,$groupId,$table,$old_details,$new_details);


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


  	public function checkGroupName(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$groupname = trim($this->input->post('groupname'));
            $mode = trim($this->input->post('mode'));
            $groupId = trim($this->input->post('groupId'));
            $company_id=$session['companyid'];
            $flag=0;
            
            if($mode=='ADD'){
                $where = array('group_description' => $groupname,'company_id' => $company_id);
                $checkData=$this->commondatamodel->duplicateValueCheck('group_master',$where);
                if($checkData){$flag=1;}
            }else{
                $where_notequal = "group_id !=".$groupId;
                $where = array('group_description' => $groupname,'company_id' => $company_id);
                $checkData=$this->commondatamodel->checkExistanceDataWhereNotIn('group_master',$where,$where_notequal);
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
					"msg_data" => "Group name all ready exist!"
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