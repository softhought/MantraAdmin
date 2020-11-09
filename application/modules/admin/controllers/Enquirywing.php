<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Enquirywing extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
         $this->load->module('template');

		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
        $data['wingslist'] = $this->commondatamodel->getAllDropdownData('enquiry_wings');  
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/front_office/masters/enquiry_wings_list';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

  public function addeditwings(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){


            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['wingId'] = 0;    
            $data['wingEditdata'] = [];  
    
    
           }else{      
    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['wingId'] = $this->uri->segment(4);     
               $where = array('wing_id'=>$data['wingId']);      
               $data['wingEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('enquiry_wings',$where);   
                        
           }
            
          
       // pre($data['companylist']);exit;
       $data['view_file'] = 'dashboard/front_office/masters/addedit_wings'; ;       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }



}  