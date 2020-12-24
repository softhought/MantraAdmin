<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Zone extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		//  $this->load->model('packagemodel','packagemodel',TRUE);		
         $this->load->module('template');
   

		
    }
    public function index(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        { 
            //$where = array('is_active_web_menu'=>'Y'); 
         
          $data['zonelist'] = $this->commondatamodel->getAllDropdownData('zone_master');  
        // pre($_SERVER);exit;
          $data['view_file'] = 'dashboard/franchisee/zone_list';      
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }

    public function addeditzone(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        {   
    
            if($this->uri->segment(4) == NULL){
    
    
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";    
                $data['btnTextLoader'] = "Saving...";    
                $data['zoneId'] = 0;    
                $data['zoneEditdata'] = [];  
        
        
               }else{      
        
                  $data['mode'] = "EDIT";    
                  $data['btnText'] = "Update";    
                  $data['btnTextLoader'] = "Updating...";    
                  $data['zoneId'] = $this->uri->segment(4);     
                   $where = array('zone_id'=>$data['zoneId']);      
                   $data['zoneEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('zone_master',$where);   
                
                
               }
    
            //pre($session);exit;
            $data['view_file'] = 'dashboard/franchisee/addedit_zone';       
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
      }
  

      public function addedit_action(){
        if($this->session->userdata('mantra_user_detail'))
    
        {
          $session = $this->session->userdata('mantra_user_detail');       
    
            $zoneId = trim(htmlspecialchars($this->input->post('zoneId')));
            $mode = trim(htmlspecialchars($this->input->post('mode')));       
           $zone_name = trim(htmlspecialchars($this->input->post('zone_name')));
              
               if ($mode == "ADD" && $zoneId == "0") { 
    
                       $insert_arr = array(
                                            'zone_name'=>strtoupper($zone_name),
                                            'is_active'=>'Y',
                                            'created_at'=>date('d-m-Y')
                                           );
    
                      $upd_inser = $this->commondatamodel->insertSingleTableData('zone_master',$insert_arr);                                       
    
                     /** audit trail */ 
                     $module = 'Zone Master';           
                     $action = "Insert";
                     $method = 'zone/addedit_action';
                     $table="zone_master";
                     $old_details="";
                     $new_details = json_encode($insert_arr);
                     $this->commondatamodel->insertSingleActivityTableData('Add Zone',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);
    
    
                } else{
    
                       $where = array('zone_id'=>$zoneId);
                       $old_dtl = $this->commondatamodel->getSingleRowByWhereCls('zone_master',$where);
                       $updtearr = array(
                                           'zone_name'=>strtoupper($zone_name),
                                           'is_active'=>'Y'
                                          );
                       $upd_inser = $this->commondatamodel->updateSingleTableData('zone_master',$updtearr,$where);                 
                      /** audit trail */ 
                      $module = 'Zone Master';           
                      $action = "Update";
                      $method = 'zone/addedit_action';
                      $table="zone_master";
                      $old_details=json_encode($old_dtl);
                      $new_details = json_encode($updtearr);
                      $this->commondatamodel->insertSingleActivityTableData('Add Zone',$module,$action,$method,$zoneId,$table,$old_details,$new_details);
    
                }              
             
              if($upd_inser){
                  $json_response = array(
                      "msg_status" => 1,
                      "mode"=>$mode,
                      "msg_data"=>'Save Successfully'                 
                             
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
    public function existingzone(){
        if($this->session->userdata('mantra_user_detail'))
        {     
        
          $zone_name = $this->input->post('zone_name'); 
          $zoneId = $this->input->post('zoneId');   
          $where = array('zone_name'=>$zone_name);  
          $where_notequal = "zone_id !=".$zoneId;
          if($zoneId == 0){
            $existing = $this->commondatamodel->checkExistanceData('zone_master',$where);    
         }else{
            $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('zone_master',$where,$where_notequal);
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
    public function active()
      {
          $session = $this->session->userdata('mantra_user_detail');
          if($this->session->userdata('mantra_user_detail'))
          {   
              $zoneid=$this->uri->segment(4); 
    
              $where = array('zone_id'=>$zoneid);
              $data = array('is_active'=>'Y');
              $this->commondatamodel->ActiveInactive('zone_master',$data,$where);
               /** audit trail */ 
               $module = 'Zone Master';           
               $action = "Active";
               $method = 'zone/active';
               $table="zone_master";
               $this->commondatamodel->insertSingleActivityTableData('Active Zone',$module,$action,$method,$zoneid,$table);
    
              redirect(admin_except_base_url().'zone','refresh');
    
    
    
          }else{
    
              redirect('admin','refresh');
    
          }
    
      }
    
      public function inactive()
    
      {
    
          $session = $this->session->userdata('mantra_user_detail');
    
          if($this->session->userdata('mantra_user_detail'))
    
          {   
            $zoneid=$this->uri->segment(4); 
            $where = array('zone_id'=>$zoneid);
            $data = array('is_active'=>'N');
            $this->commondatamodel->ActiveInactive('zone_master',$data,$where);
             /** audit trail */ 
             $module = 'Zone Master';           
             $action = "Inactive";
             $method = 'zone/inactive';
             $table="zone_master";
             $this->commondatamodel->insertSingleActivityTableData('Inactive Zone',$module,$action,$method,$zoneid,$table);
    
            redirect(admin_except_base_url().'zone','refresh');
    
    
          }else{
    
              redirect('admin','refresh');
    
          }
    
      }

}