<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Createbranch extends MY_Controller{
	
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
        $data['branchlist'] = $this->branchmodel->getbranchlistwithcompany();  
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/franchisee/branch_list';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function addeditbranch(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){


            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['branchId'] = 0;    
            $data['branchEditdata'] = [];  
    
    
           }else{      
    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['branchId'] = $this->uri->segment(4);     
               $where = array('BRANCH_ID'=>$data['branchId']);      
               $data['branchEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where);   
                        
           }
            
           $data['companylist'] = $this->commondatamodel->getAllRecordWhereOrderBy('company_master',[],'company_name');

       // pre($data['companylist']);exit;
        $data['view_file'] = 'dashboard/franchisee/createbranch_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function createbranch_action(){

    if($this->session->userdata('mantra_user_detail'))

    {
      $session = $this->session->userdata('mantra_user_detail');
        // $dataArry=[];
        // $json_response = array();
        // $formData = $this->input->post('formDatas');
        // parse_str($formData, $dataArry);

        $branchId = trim(htmlspecialchars($this->input->post('branchId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));

        $company_id = trim(htmlspecialchars($this->input->post('company_id')));
        $branch_name = trim(htmlspecialchars($this->input->post('branch_name')));       
        $branch_code = trim(htmlspecialchars($this->input->post('branch_code')));        
        $gst_no = trim(htmlspecialchars($this->input->post('gst_no')));        
        $company_contact = trim(htmlspecialchars($this->input->post('company_contact')));        
        $contact_person = trim(htmlspecialchars($this->input->post('contact_person')));        
        $branch_address = trim(htmlspecialchars($this->input->post('branch_address')));        
     
        
         
           if ($mode == "ADD" && $branchId == "0") {              
            
              $insert_arr = array(
                  'BRANCH_CODE'=>strtoupper($branch_code),
                  'BRANCH_NAME'=>strtoupper($branch_name),
                  'LAST_SRL'=>1,
                  'E_SRL'=>1,
                  'company_id'=>$company_id,
                  'branch_address'=>$branch_address,
                  'is_active'=>'Y',
                  'gst_no'=>$gst_no,
                  'company_contact'=>$company_contact,
                  'personal_contact'=>$personal_contact,
                  'created_dt'=>date('Y-m-d H:i:s'),
                  'created_by'=>$session['userid']
                    );
                   
                $upd_inser = $this->commondatamodel->insertSingleTableData('branch_master',$insert_arr);
                //pre($upd_inser);exit;
                 /** audit trail */ 
                  $module = 'Create Branch';           
                  $action = "Insert";
                  $method = 'Createbranch/createbranch_action';
                  $table="branch_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Branch Master',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);


            } else{

                      $update_arr = array(
                        'BRANCH_CODE'=>strtoupper($branch_code),
                        'BRANCH_NAME'=>strtoupper($branch_name),                      
                        'company_id'=>$company_id,
                        'branch_address'=>$branch_address,
                        'is_active'=>'Y',
                        'gst_no'=>$gst_no,
                        'company_contact'=>$company_contact,
                        'contact_person'=>$contact_person                                                
                        );

                $where = array('BRANCH_ID'=>$branchId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where);
                $upd_inser = $this->commondatamodel->updateSingleTableData('branch_master',$update_arr,$where);
                 /** audit trail */ 
                 $module = 'Create Branch';           
                  $action = "Update";
                  $method = 'Createbranch/createbranch_action';
                  $table="branch_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Update Branch Master',$module,$action,$method,$branchId,$table,$old_details,$new_details);

            }              
         
          if($upd_inser){
              $json_response = array(
                  "msg_status" => 1,
                  "mode"=>$mode,
                  "msg_data" => "Save Successfully"
                         
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

public function existingbarnchname(){
    if($this->session->userdata('mantra_user_detail'))
    {     
      $comapny_id = $this->input->post('comapny_id');
      $branch_name = $this->input->post('branch_name');
      $branchId = $this->input->post('branchId');
      //pre($where_not_in);exit;
      $where = array('company_id'=>$comapny_id,'BRANCH_NAME'=>$branch_name);
      $where_notequal = "BRANCH_ID !=".$branchId;
     if($branchId == 0){
        $existing = $this->commondatamodel->checkExistanceData('branch_master',$where);
     }else{
        $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('branch_master',$where,$where_notequal);
     }
     
     $json_response = array(
                      "msg_status" => $existing              
                    );

          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit; 
    
    }else{
        redirect('admin','refresh');
  
    }

}  
public function existingbarnchcode(){
    if($this->session->userdata('mantra_user_detail'))
    {     
      $comapny_id = $this->input->post('comapny_id');
      $branch_code = $this->input->post('branch_code');
      $branchId = $this->input->post('branchId');
      //pre($where_not_in);exit;
      $where = array('company_id'=>$comapny_id,'BRANCH_CODE'=>$branch_code);
      $where_notequal = "BRANCH_ID !=".$branchId;
     if($branchId == 0){
        $existing = $this->commondatamodel->checkExistanceData('branch_master',$where);
     }else{
        $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('branch_master',$where,$where_notequal);
     }
     
     $json_response = array(
                      "msg_status" => $existing              
                    );

          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit; 
    
    }else{
        redirect('admin','refresh');
  
    }

}

public function activebranch()
  {
      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {   
          $branch_id=$this->uri->segment(4); 
          $where = array('BRANCH_ID'=>$branch_id);
          $data = array('is_active'=>'Y');
          $this->commondatamodel->ActiveInactive('branch_master',$data,$where);
           /** audit trail */ 
           $module = 'Create Branch';           
           $action = "Active";
           $method = 'createbranch/activebranch';
           $table="branch_master";
           $this->commondatamodel->insertSingleActivityTableData('Active Branch',$module,$action,$method,$branch_id,$table);

          redirect(admin_except_base_url().'createbranch','refresh');



      }else{

          redirect('admin','refresh');

      }

  }

  public function inactivebranch()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   
        $branch_id=$this->uri->segment(4); 
        $where = array('BRANCH_ID'=>$branch_id);
        $data = array('is_active'=>'N');
        $this->commondatamodel->ActiveInactive('branch_master',$data,$where);
         /** audit trail */ 
         $module = 'Create Branch';           
         $action = "Inactive";
         $method = 'createbranch/activebranch';
         $table="branch_master";
         $this->commondatamodel->insertSingleActivityTableData('Inactive Branch',$module,$action,$method,$branch_id,$table);

        redirect(admin_except_base_url().'createbranch','refresh');


      }else{

          redirect('admin','refresh');

      }

  }
}