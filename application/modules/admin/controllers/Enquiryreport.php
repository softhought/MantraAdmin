<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Enquiryreport extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('enquirymodel','enquirymodel',TRUE);		
          $this->load->module('template');
   

		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
      $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');     
             //pre($data['userlist']);exit;
      $data['view_file'] = 'dashboard/front_office/enquiry_report/equiry_report_list';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function getenquiryreportlist(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $gender =  $this->input->post('gender');
      if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
        $from_dt = date('Y-m-d',strtotime($this->input->post('from_dt')));
       }else{
        $from_dt=NULL;
       }
       if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
        $to_date = date('Y-m-d',strtotime($this->input->post('to_date')));
       }else{
        $to_date=NULL;
       }
               
        $from_dob = trim(htmlspecialchars($this->input->post('from_dob')));     
            
        $to_dob = trim(htmlspecialchars($this->input->post('to_dob')));
       
    
       $branch =  $this->input->post('branch');
     
     
      $data['enquirylist'] = $this->enquirymodel->getenquiryreportlist($branch,$gender,$from_dt,$to_date,$from_dob,$to_dob);
      //pre($data['enquirylist']);exit;
    
     $page = 'dashboard/front_office/enquiry_report/equiry_report_partial_list';      
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}


}