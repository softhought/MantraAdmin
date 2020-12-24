<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Trialbalance extends MY_Controller{
	
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
     
     
      
       //pre($data['userlist']);exit;
      $data['view_file'] = 'dashboard/front_office/calling/calling_list';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function getenquirylist(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {   

      $search_by =  $this->input->post('search_by');
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
    
      $branch =  $this->input->post('branch');
      $wing =  $this->input->post('wing');
      $caller =  $this->input->post('caller');
      $mobile_no =  $this->input->post('mobile_no');
      $data['enquirylist'] = $this->enquirymodel->getenquirylist($search_by,$from_dt,$to_date,$branch,$wing,$caller,$mobile_no);
      //pre($data['enquirylist']);exit;
     
     $page = 'dashboard/front_office/calling/calling_partial_list';      
      $this->load->view($page,$data);
  
  }else{
      redirect('admin','refresh');

}

}

|