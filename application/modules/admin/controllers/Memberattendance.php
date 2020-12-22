<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Memberattendance extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('memberattendancemodel','memberattendancemodel',TRUE);		
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


public function addeditattendence(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['tranId'] = 0;    
            $data['attendenceEditdata'] = [];      
    
           }else{      
    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['tranId'] = $this->uri->segment(4);     
               $where = array('tran_id'=>$data['tranId']);      
              $data['attendenceEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('member_attendance',$where);  
               
               
                 //pre($where);exit;      
           }
          
         
          
       // pre($data['winglist']);exit;
         $data['view_file'] = 'dashboard/reports/attendance/mem_attendance/addedit_member_attendance'; ;       
         $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function getmembershipdtl(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
       $mobile = $this->input->post('mobile_no');

       $currentpackagelist = $this->memberattendancemodel->GetCurrentPackage($mobile);
       $listview='';
       $listview.='<option value="">Select</option>';
       if(!empty($currentpackagelist)){
       foreach($currentpackagelist as $currentpackagelist){
        $name = $currentpackagelist->CUS_CARD." - ".$currentpackagelist->CUS_NAME." - ".$currentpackagelist->MEMBERSHIP_NO;
        $listview.='<option value="'.$currentpackagelist->CUS_ID.'">'.$name.'</option>';          
       }
       $json_response = array('msg_status'=>1,'listview'=>$listview);
       }else{
        $json_response = array('msg_status'=>0,'listview'=>$listview);
       }

       
       header('Content-Type: application/json');
       echo json_encode( $json_response );
       exit;
     
    
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function getmemberdtl(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
     $cus_id = $this->input->post('cus_id');
     $where = array('CUS_ID'=>$cus_id);
     $memdtl = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);
     // pre($memdtl);exit;
     $json_response = array('msg_status'=>1,'memdtl'=>$memdtl);
     
     header('Content-Type: application/json');
     echo json_encode( $json_response );
     exit;
   
  
  
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
    $data['view_file'] = 'dashboard/front_office/reports/member/attendance_register';      
    $this->template->admin_template($data);
  
  
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
    $mobile_no = $this->input->post('mobile_no');
    $cus_id = $this->input->post('package');

    $data['attendancelist'] = $this->memberattendancemodel->getAllattendance($from_dt,$to_date,$branch_id,$mobile_no,$cus_id);
    //pre($data['attendancelist']);exit;
    $page = 'dashboard/front_office/reports/member/attendance_register_partial_list'; 
    $this->load->view($page,$data);    
    
  
  
  }else{
      redirect('admin','refresh');

}

}
//End Attendence Register

//Start Attendence Register With Time
public function attendenceregisterwithtime(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
    $data['view_file'] = 'dashboard/front_office/reports/member/attendance_register_with_time';      
    $this->template->admin_template($data);
  
  
  }else{
      redirect('admin','refresh');

}

}

public function getattendencetimelist(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {    
    
    if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
      $fdt = date('Y-m-d',strtotime($this->input->post('from_dt')));
     }else{
      $fdt=NULL;
     }
     if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
      $tdt = date('Y-m-d',strtotime($this->input->post('to_date')));
     }else{
      $tdt=NULL;
     }
    $branch_id = $this->input->post('branch');
    $aryRange = array();
    $data['ary0608'] = array();
    $data['ary0911'] = array();
    $data['ary1202'] = array();
    $data['ary0305']= array();
    $data['ary1820'] = array();
    $data['ary2123'] = array();
    $iDateFrom=mktime(1,0,0,substr($fdt,5,2),     substr($fdt,8,2),substr($fdt,0,4));
	  $iDateTo=mktime(1,0,0,substr($tdt,5,2),     substr($tdt,8,2),substr($tdt,0,4));

	if ($iDateTo>=$iDateFrom)
	{
    
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
    
		while ($iDateFrom<$iDateTo)
		{
			$iDateFrom+=86400; // add 24 hours
			array_push($aryRange,date('Y-m-d',$iDateFrom));
		}
	}
    for($i=0;$i<sizeof($aryRange);$i++)
	{
		$dt1=6;
		$dt2=8;
		array_push($data['ary0608'],$this->memberattendancemodel->getmemattendence($aryRange[$i],$branch_id,$dt1,$dt2));	
		$dt1=9;
		$dt2=11;
		array_push($data['ary0911'],$this->memberattendancemodel->getmemattendence($aryRange[$i],$branch_id,$dt1,$dt2));
		$dt1=12;
		$dt2=14;
		array_push($data['ary1202'],$this->memberattendancemodel->getmemattendence($aryRange[$i],$branch_id,$dt1,$dt2));
		$dt1=15;
		$dt2=17;
		array_push($data['ary0305'],$this->memberattendancemodel->getmemattendence($aryRange[$i],$branch_id,$dt1,$dt2));
		$dt1=18;
		$dt2=20;
		array_push($data['ary1820'],$this->memberattendancemodel->getmemattendence($aryRange[$i],$branch_id,$dt1,$dt2));	
		array_push($data['ary2123'],$this->memberattendancemodel->getmemattendence($aryRange[$i],$branch_id,$dt1,$dt2));

	}
  $data['aryRange'] = $aryRange;
  //pre($data['aryRange']);exit;
    
    
    $page = 'dashboard/front_office/reports/member/attendance_register_partial_with_time'; 
    $this->load->view($page,$data); 
  
  }else{
      redirect('admin','refresh');

}

}
//End Attendence Register With Time

//Start Attendence Ranking
public function attendenceranking(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
    $data['view_file'] = 'dashboard/front_office/reports/member/attendance_ranking';      
    $this->template->admin_template($data);
  
  
  }else{
      redirect('admin','refresh');

}

}

public function getattendencerankinglist(){

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
    $mobile_no = $this->input->post('mobile_no');
    $cus_id = $this->input->post('package');

    $data['attendancerankinglist'] = $this->memberattendancemodel->getMemberPressentDays($from_dt,$to_date,$branch_id,$mobile_no,$cus_id);

    $page = 'dashboard/front_office/reports/member/attendance_ranking_partial_list'; 
    $this->load->view($page,$data);
        
    
  
  
  }else{
      redirect('admin','refresh');

}

}
//End Attendence Ranking

//Start Zero Attendence Ranking
public function zeroattendence(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
    $data['view_file'] = 'dashboard/front_office/reports/member/zero_attendance_ranking';      
    $this->template->admin_template($data);
  
  
  }else{
      redirect('admin','refresh');

}

}

public function getzeroattendencelist(){

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
   
    $query = $this->db->query("CALL zeroAttendence('".$from_dt."','".$to_dt."','".$branch_id."')");    
 
   $data['zeroattendancelist'] =  $query->result();
pre($data['zeroattendancelist']);exit;
    $page = 'dashboard/front_office/reports/member/attendance_ranking_partial_list'; 
    $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}
//End Zero Attendence Ranking



}