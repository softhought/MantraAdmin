<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Enquiry extends MY_Controller{
	
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
     
     
      // $data['winglist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('enquiry_wings'); 
      $where_active = array('is_active'=>'Y');
      $data['wingcatlist'] = $this->commondatamodel->getAllRecordWhere('wings_category_master',$where_active); 
      $data['pinlist'] = $this->commondatamodel->getAllDropdownData('pin_master');
      // $data['wingcatlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('wings_category_master');  
      // $data['pinlist'] = $this->commondatamodel->getAllDropdownDataByComId('pin_master');  
      $data['userlist'] = $this->enquirymodel->getuserslist();
      $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');  
       //pre($data['userlist']);exit;
      $data['view_file'] = 'dashboard/front_office/calling/calling_list';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function getenquirylist(){

  
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
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

public function addeditenquiry(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['enquiryId'] = 0; 
            $data['mayhelp_id']=0;
            $data['frguestpId'] = 0;   
            $data['enquiryEditdata'] = [];      
            $data['mayihelpudata'] = [];
            $data['freeguestpassdata'] = [];      
    
           }else if(decode($this->uri->segment(4)) == 'WEB ENQUIRY'){ 
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";    
                $data['btnTextLoader'] = "Saving...";  
                $data['enquiryId'] = 0;   
                $data['frguestpId'] = 0;  
                $data['mayhelp_id'] =$this->uri->segment(5); 
                $data['freeguestpassdata'] = [];  
                $data['enquiryEditdata'] = [];         
                $data['branch_id'] = $this->uri->segment(6);  
                $data['wing'] = decode($this->uri->segment(4));

                $where = array('id'=>$data['mayhelp_id']);
                $data['mayihelpudata'] = $this->commondatamodel->getSingleRowByWhereCls('may_i_help_you',$where);

                $where_wingcat = array('wing_name'=>$data['wing']);
                $data['wingdtl'] = $this->commondatamodel->getSingleRowByWhereClsByComId('enquiry_wings',$where_wingcat);

                $where_loc = array('pin_code'=>$data['mayihelpudata']->pincode);        
                $data['locationlist'] = $this->commondatamodel->getAllRecordWhere('pin_master',$where_loc); 

            }else if(decode($this->uri->segment(4)) == 'ONE DAY FREE GUEST PASS'){ 
              $data['mode'] = "ADD";    
              $data['btnText'] = "Save";    
              $data['btnTextLoader'] = "Saving...";  
              $data['enquiryId'] = 0;   
              $data['frguestpId'] =$this->uri->segment(5); 
              $data['mayhelp_id'] = 0;          
              $data['branch_code'] = $this->uri->segment(6);  
              $data['wing'] = decode($this->uri->segment(4));

              $where = array('id'=>$data['frguestpId']);
              $data['freeguestpassdata'] = $this->commondatamodel->getSingleRowByWhereCls('free_guest_pass',$where);

              $where_wingcat = array('wing_name'=>$data['wing']);
              $data['wingdtl'] = $this->commondatamodel->getSingleRowByWhereClsByComId('enquiry_wings',$where_wingcat);

              $where_loc = array('pin_code'=>$data['freeguestpassdata']->pincode);        
              $data['locationlist'] = $this->commondatamodel->getAllRecordWhere('pin_master',$where_loc); 

          }else{

    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";   
              $data['mayhelp_id']=0;
              $data['frguestpId'] = 0; 
              $data['freeguestpassdata'] = []; 
              $data['mayihelpudata'] = [];  
              $data['enquiryId'] = $this->uri->segment(4); 
              $where = array('ID'=>$data['enquiryId']);      
              $data['enquiryEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where);  
            
              
              $where = array('id'=>$data['enquiryEditdata']->PIN);        
              $data['locationlist'] = $this->commondatamodel->getAllRecordWhere('pin_master',$where);    
                 //pre($where);exit;      
           }
           $where_active = array('is_active'=>'Y');
          //  $data['wingcatlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('wings_category_master'); 
          //  $data['winglist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('enquiry_wings');  
          //  $data['pinlist'] = $this->commondatamodel->getAllDropdownDataByComId('pin_master');  
          $data['wingcatlist'] = $this->commondatamodel->getAllRecordWhere('wings_category_master',$where_active); 
          $data['winglist'] = $this->commondatamodel->getAllRecordWhere('enquiry_wings',$where_active);  
          $data['pinlist'] = $this->commondatamodel->getAllDropdownData('pin_master');
           $data['userlist'] = $this->enquirymodel->getuserslist();
           $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
         
          
       //pre($data['winglist']);exit;
         $data['view_file'] = 'dashboard/front_office/enquiry/add_edit_enquiry'; ;       
         $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

public function getlocation(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $pin =  $this->input->post('pin');
        $where = array('pin_code'=>$pin);
        
        $locationlist = $this->commondatamodel->getAllRecordWhere('pin_master',$where);  
        //pre($locationlist);exit;
        $locations = '';
        if(!empty($locationlist)){
        foreach($locationlist as $locationlist){
          $locations.='<option value="'.$locationlist->location.'">'.$locationlist->location.'</option>';
        }
      }else{
        $locations.='<option value=""></option>';
      }
        $json_response = array('locationlist'=>$locations);
        header('Content-Type: application/json');
        echo json_encode( $json_response );
        exit; 
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function getallwings(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {   
      $cat_id =  $this->input->post('cat_id');
      $where = array('wing_category_id'=>$cat_id);
      
      $wingslist = $this->commondatamodel->getAllRecordWhere('enquiry_wings',$where);  
      //pre($locationlist);exit;
      $wingsview = '';
      if(!empty($wingslist)){
      foreach($wingslist as $wingslist){
        $wingsview.='<option value="'.$wingslist->wing_id.'">'.$wingslist->wing_name.'</option>';
      }
    }else{
      $wingsview.='<option value=""></option>';
    }
      $json_response = array('wingsview'=>$wingsview);
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit; 
  
  }else{
      redirect('admin','refresh');

}

}



public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {
      $session = $this->session->userdata('mantra_user_detail');
        $dataArry=[];
        $json_response = array();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $dataArry);

        $enquiryId = trim(htmlspecialchars($this->input->post('enquiryId')));
        $mayhelp_id = trim(htmlspecialchars($this->input->post('mayhelp_id')));
        $frguestpId = trim(htmlspecialchars($this->input->post('frguestpId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));
        if(trim(htmlspecialchars($this->input->post('enquiry_dt'))) != ''){          
           $enquiry_date = date('Y-m-d',strtotime($this->input->post('enquiry_dt')));
          }else{
           $enquiry_date=NULL;
          }
          if(trim(htmlspecialchars($this->input->post('followup_date'))) != ''){            
           $followup_date = date('Y-m-d',strtotime($this->input->post('followup_date')));
          }else{
           $followup_date=NULL;
          }
          if(trim(htmlspecialchars($this->input->post('dob'))) != ''){            
            $dob = date('Y-m-d',strtotime($this->input->post('dob')));
           }else{
            $dob=NULL;
           }
       //pre($enquiry_date);exit;
       $first_name = trim(htmlspecialchars($this->input->post('first_name')));
       $last_name = trim(htmlspecialchars($this->input->post('last_name')));
       $age = trim(htmlspecialchars($this->input->post('age')));
       $gender = trim(htmlspecialchars($this->input->post('gender')));
       $wing_cat_id = trim(htmlspecialchars($this->input->post('wing_category')));
       $wing_id = trim(htmlspecialchars($this->input->post('wings')));
       $branch_id = trim(htmlspecialchars($this->input->post('branch_id')));
       $email = trim(htmlspecialchars($this->input->post('email')));
       $pin = trim(htmlspecialchars($this->input->post('pin')));
       $location = trim(htmlspecialchars($this->input->post('location')));
       $mobile_no = trim(htmlspecialchars($this->input->post('mobile_no')));
       $whatsapp_no = trim(htmlspecialchars($this->input->post('whatsapp_no')));
       $address = trim(htmlspecialchars($this->input->post('address')));
       $remarks = trim(htmlspecialchars($this->input->post('remarks')));
       $done_by = trim(htmlspecialchars($this->input->post('done_by')));
       $where_brn = array('BRANCH_ID'=>$branch_id);
       $branch_code = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_brn)->BRANCH_CODE;
       $where_enqwing = array('wing_id'=>$wing_id);
       $wing_name = $this->commondatamodel->getSingleRowByWhereCls('enquiry_wings',$where_enqwing)->wing_name;
       $upd_inser = 0;

       $insert_arr = array(
        'DATE_OF_ENQ'=>$enquiry_date,
        'FIRST_NAME'=>strtoupper($first_name),                 
        'LAST_NAME'=>strtoupper($last_name),
        'ADDRESS'=>$address,
        'LOCATION'=>$location,
        'PIN'=>$pin,
        'REMARKS'=>$remarks,
        'MOBILE1'=>$mobile_no,
        'MOBILE2'=>$whatsapp_no,
        'EMAIL'=>$email,
        'FOLLOWUP_DATE'=>$followup_date,
        'IS_OPEN'=>'Y',
        'BRANCH_CODE'=>$branch_code,                  
        'user_id'=>$done_by,
        'for_the_wing'=>$wing_name,
        'enq_from'=>'',
        'dob'=>$dob,
        'age'=>$age,
        'wing_cat_id'=>$wing_cat_id,
        'wing_id'=>$wing_id,
        'gender'=>$gender,
        'branch_id'=>$branch_id,
        'company_id'=>$session['companyid']                 
          );
         // pre($insert_arr);exit;
           if ($mode == "ADD" && $enquiryId == "0") { 

                   $enq_master_id = $this->commondatamodel->insertSingleTableData('enquiry_master',$insert_arr);
                   if($enq_master_id){
                   $enq_no=$this->prepareEnqNo(substr($first_name,0,1),substr($last_name,0,1),$mobile_no,$enq_master_id);
                   $where_enq = array('ID'=>$enq_master_id);
                   $update_enqno = array('ENQ_NO'=>$enq_no);
                   $upd_enq = $this->commondatamodel->updateSingleTableData('enquiry_master',$update_enqno,$where_enq);
                   $enquiry_dtl = array(
                                        'enq_id'=>$enq_master_id,
                                        'enq_date'=>$enquiry_date,
                                        'enq_remarks'=>$remarks,
                                        'followup_date'=>$followup_date,
                                        'branch_code'=>$branch_code,
                                        'user_id'=>$done_by,
                                        'for_the_wing'=>$wing_name,
                                        'member_id'=>'',
                                        'validity_string'=>'',
                                        'card_code'=>'',
                                        'payment_id'=>'',                                       
                                        'wing_id'=>$wing_id,
                                        'branch_id'=>$branch_id,
                                        'company_id'=>$session['companyid']
                                       );
                                       //pre($enquiry_dtl);exit;
                  $upd_inser = $this->commondatamodel->insertSingleTableData('enquiry_detail',$enquiry_dtl);
                    
                      // For SMS  
                      if ($wing_name=="RENEWAL")
                      {
                          $sms_stat="N";
                      }
                      else
                      {
                          $sms_stat=$this->send_my_sms($mobile_no,$enq_no,$wing_name,$branch_code);
                      }
                      $update_enqno = array('sms_stat'=>$sms_stat);
                      $upd_enq = $this->commondatamodel->updateSingleTableData('enquiry_master',$update_enqno,$where_enq);
                      if ($mayhelp_id != 0 || $mayhelp_id != "")
                      {
                        $where_help = array('id'=>$mayhelp_id);
                        $update_mayihelp = array('is_called'=>'Y');

                        $upd_enq = $this->commondatamodel->updateSingleTableData('may_i_help_you',$update_mayihelp,$where_help);
                      }
                      if ($frguestpId != 0 || $frguestpId != "")
                      {
                        $where_guest = array('id'=>$frguestpId);
                        $update_freeguest = array('is_called'=>'Y');

                        $upd_enq = $this->commondatamodel->updateSingleTableData('free_guest_pass',$update_freeguest,$where_guest);
                      }



                 } 
                 /** audit trail */ 
                 $module = 'Enquiry';           
                 $action = "Insert";
                 $method = 'enquiry/addedit_action';
                 $table="enquiry_master";
                 $old_details="";
                 $new_details = json_encode($insert_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Add Enquiry',$module,$action,$method,$enq_master_id,$table,$old_details,$new_details);


            } else{

                   $where_enqmst = array('ID'=>$enquiryId);
                   $old_dtl = $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where_enqmst);
                   $upd_inser = $this->commondatamodel->updateSingleTableData('enquiry_master',$insert_arr,$where_enqmst);                 
                  /** audit trail */ 
                  $module = 'Enquiry';           
                  $action = "Update";
                  $method = 'enquiry/addedit_action';
                  $table="enquiry_master";
                  $old_details=json_encode($old_dtl);
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Enquiry',$module,$action,$method,$enquiryId,$table,$old_details,$new_details);

            }              
         
          if($upd_inser){
              $json_response = array(
                  "msg_status" => 1,
                  "mayhelp_id" => $mayhelp_id,
                  "frguestpId" => $frguestpId,
                  "mode"=>$mode,
                  "msg_data"=>'Save Successfully'                 
                         
              );
             } else{
              $json_response = array(
                  "msg_status" => 0,
                  "msg_data" => "There is some problem while updating ...Please try again."
      
              );
          }                   


        header('Content-Type: application/json');
        echo json_encode( $json_response );
        exit; 
      
    }  else{
      redirect('admin','refresh');

}

}

public function getenqmasterforfeedback(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {   

      $enq_id =  $this->input->post('enq_id');
      $where = array('ID'=>$enq_id);
      $enquirymstdata= $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where); 
      $row_remaks= $this->commondatamodel->getAllDropdownData('reason_master');
      $userlist = $this->commondatamodel->getAllDropdownData('users'); 
      $where = array('id'=>$enquirymstdata->PIN);        
      $locationlist = $this->commondatamodel->getSingleRowByWhereCls('pin_master',$where); 
      // pre($where);
      // pre($locationlist);exit;
      if(!empty($locationlist)){
        $pincode = $locationlist->pin_code;
      }else{
        $pincode = "";
      }
      $remarkslist= '';
      $userlistview = '';
      $remarkslist.= '<option value="">Select</option>';
      foreach($row_remaks as $row_remaks){
        $remarkslist.='<option value="'.$row_remaks->reason_id.'">'.$row_remaks->reason_title.'</option>';
      }
      $userlistview.= '<option value=""Select</option>';
      foreach($userlist as $userlist){
        $userlistview.='<option value="'.$userlist->id.'">'.$userlist->name.'</option>';
      }
      
      // pre($row_remaks);
      // pre($enquirymstdata);
      // exit;
      $json_response = array('enquirymstdata'=>$enquirymstdata,'remarkslist'=>$remarkslist,'userlistview'=>$userlistview,'pincode'=>$pincode);
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit;
  
  }else{
      redirect('admin','refresh');

}

}

public function feedback_action(){

  
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
      $enq_id =  $this->input->post('enq_id');
      $sel_remarks =  $this->input->post('sel_remarks');
      $remarks =  $this->input->post('remarks');
      if(trim(htmlspecialchars($this->input->post('followup_date'))) != ''){            
        $followup_date = date('Y-m-d',strtotime($this->input->post('followup_date')));
       }else{
        $followup_date=NULL;
       }
      $done_by =  $this->input->post('done_by');
      $m_branch_feed_code =  $this->input->post('m_branch_feed_code');
      $where = array('ID'=>$enq_id);
      $enquirymstdata= $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where);
      
      
      $enquiry_dtl = array(
                        'enq_id'=>$enq_id,
                        'enq_date'=>date('Y-m-d'),
                        'remarks_id'=>$sel_remarks,
                        'enq_remarks'=>$remarks,
                        'followup_date'=>$followup_date,
                        'branch_code'=>$enquirymstdata->BRANCH_CODE,
                        'user_id'=>$done_by,
                        'for_the_wing'=>$enquirymstdata->for_the_wing,
                        'wing_id'=>$enquirymstdata->wing_id,
                        'branch_id'=>$enquirymstdata->branch_id,
                        'company_id'=>$session['companyid']                        
                         );
                         
        $insert_id = $this->commondatamodel->insertSingleTableData('enquiry_detail',$enquiry_dtl);
            /** audit trail */ 
            $module = 'Calling';           
            $action = "Insert";
            $method = 'enquiry/feedback_action';
            $table="enquiry_detail";
            $old_details="";
            $new_details = json_encode($enquiry_dtl);
            $this->commondatamodel->insertSingleActivityTableData('Add Feedback',$module,$action,$method,$insert_id,$table,$old_details,$new_details);
                 
            if($insert_id){
              $json_response = array('msg_status'=>1);
            }else{
              $json_response = array('msg_status'=>0);
            }
      // pre($row_remaks);
      // pre($enquirymstdata);
      // exit;
     
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit;
  
  }else{
      redirect('admin','refresh');

}

}

public function getfeedbacklist(){  
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
      $enq_id =  $this->input->post('enq_id');
      
      $where = array('ID'=>$enq_id);
      $data['enquirymstdata']= $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where);

     
      $data['enquirydel']= $this->enquirymodel->getallenquirydtl($enq_id);
      //pre($data['enquirydel']);exit;
      $page = 'dashboard/front_office/calling/feedback_list_modal';      
      $this->load->view($page,$data);
  
  }else{
      redirect('admin','refresh');

}

}


public function enquiryclose(){
  if($this->session->userdata('mantra_user_detail'))

  {
    $session = $this->session->userdata('mantra_user_detail');
    $enq_id =  $this->input->post('enq_id');
      
    $where = array('ID'=>$enq_id);
    $update_arr = array('IS_OPEN'=>'N');
    $update= $this->commondatamodel->updateSingleTableData('enquiry_master',$update_arr,$where);
    if($update){
      $json_response  = array('msg_status'=>1);
    }else{
      $json_response  = array('msg_status'=>1);
    }
   
    header('Content-Type: application/json');
    echo json_encode( $json_response );
    exit;
  
  }else{
    redirect('admin','refresh');

  }

}


function prepareEnqNo($f,$l,$mob,$id)
{
	$enq=$f.$l."-".$mob."-".$id;
	return $enq;
}

function send_my_sms($phone,$enq_no,$wing,$branch)
{
    $mantra_url = "http://myvaluefirst.com/smpp/sendsms?";
    $feed = 'N';
	if ($wing=="GYM")
	{
		 if($branch=="CM")
		{
	         $message = "Thank you for showing interest on Mantra Health Club.Your Enquiry No. is ".$enq_no.". We look forward to serving you better, please contact +919007763533 / +919051026612 for any further queries";
		}

		 if($branch=="SN")
		{
	         $message = "Thank you for showing interest on Mantra Health Club.Your Enquiry No. is ".$enq_no.". We look forward to serving you better, please contact +919007605628 for any further queries";
		}

		 if($branch=="BP")
		{
	         $message = "Thank you for showing interest on Mantra Health Club.Your Enquiry No. is ".$enq_no.". We look forward to serving you better, please contact +919748488321 / +919836959859 for any further queries";
		}

		 if($branch=="LT")
		{
	         $message = "Thank you for showing interest on Mantra Health Club.Your Enquiry No. is ".$enq_no.". We look forward to serving you better, please contact +919051195830 / +919051195830 for any further queries";
		}

		 if($branch=="TR")
		{
	         $message = "Thank you for showing interest on Mantra Health Club.Your Enquiry No. is ".$enq_no.". We look forward to serving you better, please contact +919748488321 / +919836959859 for any further queries";
		}
    $feed=mantraSend($phone,$message);
	}
	if ($wing=="INSTITUTE")
	{
         $message = "Earn a Diploma in Fitness Management-Interactive & career counseling session on Saturday, 7th of Jun,14 from 12:00 pm to 2 pm at MANTRA HEALTH CLUB, 29F B.T. Road, Kol-2.Chiriyamore (Dumdum)";
         $feed=mantraSend($phone,$message);
	}
	if ($wing=="OLD MEMBER")
	{
		 if($branch=="CM")
		{
	         $message = "We Miss You You! We would be delighted to have you back on Mantra. Why not call us at +919007763533 / +919051026612.";
		}
		 if($branch=="SN")
		{
	         $message = "We Miss You You! We would be delighted to have you back on Mantra. Why not call us at +919007605628.";
		}
		 if($branch=="BP")
		{
	         $message = "We Miss You You! We would be delighted to have you back on Mantra. Why not call us at +919748488321 / +919836959859.";
		}
		 if($branch=="LT")
		{
	         $message = "We Miss You You! We would be delighted to have you back on Mantra. Why not call us at +919051195830 / +919051195830.";
    }
    $feed=mantraSend($phone,$message);

	}

    
	 return $feed;

}

//Start Quick Enquiry
public function quickenquiry(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
    $data['view_file'] = 'dashboard/front_office/quick-enquiry/quick_enquiry_list';      
    $this->template->admin_template($data);
  
  
  }else{
      redirect('admin','refresh');

}

}

public function getAllMayIHelpYou(){

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
    $branch_cd = $this->input->post('branch');
   

    $data['quickenquirylist'] = $this->enquirymodel->getAllattendance($from_dt,$to_date,$branch_cd);
    //pre($data['quickenquirylist']);exit;
    $page = 'dashboard/front_office/quick-enquiry/quick_enquiry_partial_list'; 
    $this->load->view($page,$data);    
    
  
  
  }else{
      redirect('admin','refresh');

}

}
//End  Quick Enquiry

//Start Onedayfreeguestpass
public function onedayfreeguestpass (){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
    $data['view_file'] = 'dashboard/front_office/one-day-free-pass/onedayfreeguestpass_list';      
    $this->template->admin_template($data);
  
  
  }else{
      redirect('admin','refresh');

}

}

public function getAllFreeGuestpass(){

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
    $branch_code = $this->input->post('branch');
   

    $data['freeguestpasslist'] = $this->enquirymodel->getAllFreeGuestpass($from_dt,$to_date,$branch_code);
    //pre($data['quickenquirylist']);exit;
    $page = 'dashboard/front_office/one-day-free-pass/onedayfreeguestpass_partial_list'; 
    $this->load->view($page,$data);    
    
  
  
  }else{
      redirect('admin','refresh');

}

}
//End  Quick Enquiry
//Start Enquiry Analysis
public function enquiryanalysis(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $where_active = array('is_active'=>'Y');
    $data['winglist'] = $this->commondatamodel->getAllRecordWhere('enquiry_wings',$where_active); 
    // $data['winglist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('enquiry_wings');  
    $data['pinlist'] = $this->commondatamodel->getAllDropdownDataByComId('pin_master');  
    $data['userlist'] = $this->enquirymodel->getuserslist();
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');  
     //pre($data['userlist']);exit;
    $data['view_file'] = 'dashboard/front_office/enquiry-analysis/equiry_analysis_list';      
      $this->template->admin_template($data);  
  
  }else{
      redirect('admin','refresh');

}

}
public function getenquiryanalysis(){

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
      // $mobile_no =  $this->input->post('mobile_no');
      $data['enquirylist'] = $this->enquirymodel->list_of_enquiry($search_by,$from_dt,$to_date,$branch,$wing,$caller);
      //pre($data['enquirylist']);exit;
     $data['search_by'] =  $search_by;
     $page = 'dashboard/front_office/enquiry-analysis/equiry_analysis_partial_list';      
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}


//End Enquiry Enalysis

//Start Special Enquiry
public function specialenquiry(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
    $where = array('wing_category_id'=>2,'is_active'=>'Y');

    $data['winglist'] = $this->commondatamodel->getAllRecordWhere('enquiry_wings',$where);  
    
    $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');  
     //pre($data['userlist']);exit;
    $data['view_file'] = 'dashboard/front_office/special-enquiry/special_enquiry_list';      
      $this->template->admin_template($data);  
  
  }else{
      redirect('admin','refresh');
}

}
public function getspecialenquiry(){

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
    
      $branch =  $this->input->post('branch');
      $wing =  $this->input->post('wing');
     
      $data['specialenquirylist'] = $this->enquirymodel->getAllEnquiredMember($from_dt,$to_date,$branch,$wing);
      //pre($data['enquirylist']);exit;
     
     $page = 'dashboard/front_office/special-enquiry/special_enquiry_partial_list';      
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}


//End Special Enquiry

}




