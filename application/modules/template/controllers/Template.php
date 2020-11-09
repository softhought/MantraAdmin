<?php

class Template extends MX_Controller
{
	public function __construct()
	{
		parent ::__construct();
        date_default_timezone_set('Asia/Kolkata'); 
		$this->load->model('Template_model','_templates',TRUE);
	}
	public function admin_template($data = NULL)
	{
		$session = $this->session->userdata('mantra_user_detail');	
	
		$user_id = $session['userid'];	
		//pre($session);exit;
		$menus = $this->_templates->getadminmenulist('admin_menu_master',$user_id);
		$data['menu'] = $menus;
		$data['username'] = $session['username'];
		$data['acc_period'] = $session['acc_period'];
		$data['companyname'] = $session['companyname'];
		//pre($data['menu']);exit;
		
		$this->load->view('template/admin_template', $data);
	}
}