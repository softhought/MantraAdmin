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

}
