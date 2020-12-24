<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Createcompany extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
		 $this->load->model('companyodel','companyodel',TRUE);
         $this->load->module('template');
	

		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
        $data['companylist'] = $this->companyodel->getcompanyList(); 

        $data['view_file'] = 'dashboard/franchisee/company_list';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function addeditcompany(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){


            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['companyId'] = 0;    
            $data['comapnyEditdata'] = [];  
    
    
           }else{      
    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['companyId'] = $this->uri->segment(4);     
               $where = array('comany_id'=>$data['companyId']);      
               $data['comapnyEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('company_master',$where);   
            
            
           }

           $where = array('is_active'=>'Y');
           $data['zonelist'] = $this->commondatamodel->getAllRecordWhere('zone_master',$where);   
           
        //pre($session);exit;
        //pre($dt);exit;
        $data['view_file'] = 'dashboard/franchisee/createcompany_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function createcompany_action(){

      if($this->session->userdata('mantra_user_detail'))

      {
        $session = $this->session->userdata('mantra_user_detail');
       

          $companyId = trim(htmlspecialchars($this->input->post('companyId')));
          $mode = trim(htmlspecialchars($this->input->post('mode')));
          $company_name = trim(htmlspecialchars($this->input->post('company_name')));
          $short_name = trim(htmlspecialchars($this->input->post('short_name')));
          $email = trim(htmlspecialchars($this->input->post('email')));
          $mobile_no = trim(htmlspecialchars($this->input->post('mobile_no')));
          $zone = trim(htmlspecialchars($this->input->post('zone')));
          $docFile =  $_FILES;
          $company_logo = trim(htmlspecialchars($this->input->post('company_logo')));        
          $isImage = trim(htmlspecialchars($this->input->post('isImage'))); 
          if($this->input->post('sms_facility') == 'on'){
            $sms_facility = 'Y';
         }else{
            $sms_facility = 'N';
         } 
         if($this->input->post('email_facility') == 'on'){
            $email_facility = 'Y';
         }else{
            $email_facility = 'N';
         } 
         if($this->input->post('accounts') == 'on'){
            $accounts = 'Y';
         }else{
            $accounts = 'N';
         }        
       
          $imageData = array(				
            'docFile' => $docFile, 
           
           );
           if($isImage == 'Y'){
               $dir = $_SERVER['DOCUMENT_ROOT'].'/MantraAdmin/assets/img/company-logo';
               $filename = "imagefile";                  
               $company_logo = $this->commondatamodel->GetUploadImage($imageData,$filename,$dir,$short_name);
             }else{
                $company_logo = $company_logo;
             }
           
             $i = 1;
             $reg_no = "";
             if ($mode == "ADD" && $companyId == "0") {

                while($i == 1){                   
                    $reg_no = rand(10000,99999);  
                    $where_reg = array('registration_no'=>$reg_no);
                    $i = $this->commondatamodel->checkExistanceData('company_master',$where_reg);
                                     
                }
              
                $insert_arr = array(
                    'company_name'=>$company_name,
                    'registration_no'=>$reg_no,
                    'short_name'=>strtoupper($short_name),
                    'company_phone'=>$mobile_no,
                    'company_email'=>$email,
                    'logo_name'=>$company_logo,
                    'is_parrent'=>'N',
                    'is_active'=>'Y',
                    'sms_facility'=>$sms_facility,
                    'accounts'=>$accounts,
                    'email_facility'=>$email_facility,
                    'created_date'=>date('Y-m-d H:i:s'),
                    'created_by'=>$session['userid'],
                    'zone_id'=>$zone,
                    'admin_new'=>'Y'
                      );

                  $upd_inser = $this->commondatamodel->insertSingleTableData('company_master',$insert_arr);

                  $voucher_sl_master = array(
                                            'last_srl'=>1,
                                            'year_id'=>$session['yearid'],
                                            'company_id'=>$upd_inser
                                        );
                 $vaoucher_srl_inser = $this->commondatamodel->insertSingleTableData('voucher_srl_master',$voucher_sl_master);
                 $sl_table = array(
                    'latest_srl'=>1,                   
                    'company_id'=>$upd_inser
                );
               $vaoucher_srl_inser = $this->commondatamodel->insertSingleTableData('serial_table',$sl_table);
                //  $yeartag = date('Y').'-'. date('y', strtotime("+12 months ".date('Y')));
                //  $srl_master = array(
                //     'serialno'=>1,
                //     'moduleTag'=>'NUM',
                //     'noofpaddingdigit'=>2,
                //     'module'=>'SALE',
                //     'company_id'=>$upd_inser,
                //     'year_id'=>$session['yearid'],                    
                //     'yeartag'=>$yeartag
                // );
                // $srl_inser = $this->commondatamodel->insertSingleTableData('serialmaster',$srl_master);
                   /** audit trail */ 
                    $module = 'Create Company';           
                    $action = "Insert";
                    $method = 'Createcompany/createcompany_action';
                    $table="company_master";
                    $old_details="";
                    $new_details = json_encode($insert_arr);
                    $this->commondatamodel->insertSingleActivityTableData('Add Company Master',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);


              } else{

                        $update_arr = array(
                            'company_name'=>$company_name,
                            'short_name'=>strtoupper($short_name),
                            'company_phone'=>$mobile_no,
                            'company_email'=>$email,
                            'logo_name'=>$company_logo,
                            'is_parrent'=>'N',
                            'is_active'=>'Y',
                            'sms_facility'=>$sms_facility,
                            'accounts'=>$accounts,
                            'email_facility'=>$email_facility,
                            'zone_id'=>$zone,                        
                            );

                  $where = array('comany_id'=>$companyId);
                  $olddtl = $this->commondatamodel->getSingleRowByWhereCls('company_master',$where);
                  $upd_inser = $this->commondatamodel->updateSingleTableData('company_master',$update_arr,$where);
                   /** audit trail */ 
                   $module = 'Create Company';           
                   $action = "Update";
                   $method = 'Createcompany/createcompany_action';
                   $table="company_master";
                   $old_details = json_encode($olddtl);
                   $new_details = json_encode($update_arr);
                   $this->commondatamodel->insertSingleActivityTableData('Update Company Master',$module,$action,$method,$companyId,$table,$old_details,$new_details);

              }              
           
            if($upd_inser){
                $json_response = array(
                    "msg_status" => 1,
                    "mode"=>$mode,
                    "registration_no"=>$reg_no
                           
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

  public function activecompany()
  {
      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {   
          $company_id=$this->uri->segment(4); 
          $where = array('comany_id'=>$company_id);
          $data = array('is_active'=>'Y');
          $this->commondatamodel->ActiveInactive('company_master',$data,$where);
           /** audit trail */ 
           $module = 'Create Company';           
           $action = "Active";
           $method = 'createcompany/activecompany';
           $table="company_master";
           $this->commondatamodel->insertSingleActivityTableData('Active Company Name',$module,$action,$method,$company_id,$table);

          redirect(admin_except_base_url().'createcompany','refresh');



      }else{

          redirect('admin','refresh');

      }

  }

  public function inactivecompany()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   
        $company_id=$this->uri->segment(4); 
        $where = array('comany_id'=>$company_id);
        $data = array('is_active'=>'N');
        $this->commondatamodel->ActiveInactive('company_master',$data,$where);
         /** audit trail */ 
         $module = 'Create Company';           
         $action = "Inactive";
         $method = 'createcompany/activecompany';
         $table="company_master";
         $this->commondatamodel->insertSingleActivityTableData('Inactive Company Name',$module,$action,$method,$company_id,$table);

        redirect(admin_except_base_url().'createcompany','refresh');


      }else{

          redirect('admin','refresh');

      }

  }


}