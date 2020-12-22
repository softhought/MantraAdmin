<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Commancontroller extends MY_Controller{
	
    function __construct()
        {
            parent::__construct();
            $this->load->model('commondatamodel','commondatamodel',TRUE);
            $this->load->module('template');
        

            
    }

    public function check_existingdata(){

        if($this->session->userdata('mantra_user_detail'))
        {     
          $where = $this->input->post('where');
          $where_notequal = $this->input->post('where_notequal');
          $id = $this->input->post('id');
          //pre($where_not_in);exit;
         if($id == 0){
            $existing = $this->commondatamodel->checkExistanceData('company_master',$where);
         }else{
            $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('company_master',$where,$where_notequal);
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

    public function check_existingdata(){

        if($this->session->userdata('mantra_user_detail'))
        {     
        
            $usermasterlist = $this->commondatamodel->getAllDropdownData('user_master'); 

            foreach($usermasterlist as $usermasterlist){
            $insertarr = array(
                                'name'=>$usermasterlist->name_in_full,
                                'user_name'=>$usermasterlist->user_name,
                                'password'=>md5($usermasterlist->user_pwd),
                                'mobile_no'=>'',
                                'user_role_id'=>3,
                                'is_online'=>'N',
                                'is_active'=>'Y',
                                'branch_id'=>$usermasterlist->branch_id,
                                'company_id'=>$usermasterlist->company_id,
                                'created_by'=>1,
                                'created_at'=>date('Y-m-d'),
                                'updated_at'=>date('Y-m-d')
                                );
        $enq_master_id = $this->commondatamodel->insertSingleTableData('users',$insertarr);
            }
            exit;
     
        
        }else{
            redirect('admin','refresh');
      
        }
    
    }  

}
