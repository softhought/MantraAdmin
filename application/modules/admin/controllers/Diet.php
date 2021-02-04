<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Diet extends MY_Controller{

function __construct(){
    parent::__construct();
	$this->load->model('commondatamodel','commondatamodel',TRUE);	
	$this->load->model('dietmodel','_dietmodel',TRUE);	
    $this->load->module('template');		
}

public function index(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        echo "Mantra Diet List will show";    
    }else{
        redirect('admin','refresh');  
  }
}


public function preparediet(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
       $data['view_file'] = 'dashboard/diet/prepare/prepare_diet_view.php';
       $this->template->admin_template($data);  	

    }else{ 
        redirect('admin','refresh');  
    } 
}

}