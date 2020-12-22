<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Employeeattendance extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('employeeattendancemodel','employeeattendancemodel',TRUE);		
         $this->load->module('template');
   

		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
     
      $data['winglist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('enquiry_wings');  
      $data['pinlist'] = $this->commondatamodel->getAllDropdownDataByComId('pin_master');  
      $data['userlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('users');
      $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');  
       //pre($data['userlist']);exit;
      $data['view_file'] = 'dashboard/front_office/calling/calling_list';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

//Start Attendence Register
public function attendenceregister(){
       $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
      $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
      $data['view_file'] = 'dashboard/front_office/reports/employee/attendance_register';      
      $this->template->admin_template($data);
    
    
    }else{
        redirect('admin','refresh');
  
  }
  
  }


public function getTrainerByBranch(){
    $session = $this->session->userdata('mantra_user_detail');
 if($this->session->userdata('mantra_user_detail'))
 {  
  
    $branch_id = $this->input->post('branch');

    $trainerlist = $this->employeeattendancemodel->getTrainerByBrnAttReg($branch_id);
    $trainerlistview = "";
    $trainerlistview.="<option value=''>Select</option>";
    if(!empty($trainerlist)){
   foreach($trainerlist as $trainerlist){
    $trainerlistview.="<option value = '".$trainerlist->empl_id."'>".$trainerlist->empl_name."</option>";
   }
 }
    $json_response = array('trainerlistview'=>$trainerlistview);
      
       
       header('Content-Type: application/json');
       echo json_encode( $json_response );
       exit;
 
 
 }else{
     redirect('admin','refresh');

}

}

  
  public function getattendencelist(){
  
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
      
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
      $branch_id = $this->input->post('branch');
      $employee = $this->input->post('employee');
     
  
      $data['attendancelist'] = $this->employeeattendancemodel->getAllEmployeeAtts($from_dt,$to_date,$branch_id,$employee);
  
      $page = 'dashboard/front_office/reports/employee/attendance_register_partial_list'; 
      $this->load->view($page,$data);
          
      
    
    
    }else{
        redirect('admin','refresh');
  
  }
  
  }
  //End Attendence Register
  

}