<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MY_Controller{
	
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
        $data['view_file'] = 'dashboard/dashboard_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

}