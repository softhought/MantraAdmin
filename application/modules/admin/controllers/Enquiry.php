<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Enquiry extends MY_Controller{
	
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

public function addeditenquiry(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['enquiryId'] = 0;    
            $data['enquiryEditdata'] = [];      
    
           }else{      
    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['enquiryId'] = $this->uri->segment(4);     
               $where = array('ID'=>$data['enquiryId']);      
              $data['enquiryEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where);  
               
              $where = array('pin_code'=>$data['enquiryEditdata']->PIN);        
              $data['locationlist'] = $this->commondatamodel->getAllRecordWhere('pin_master',$where);    
                        
           }
           $data['winglist'] = $this->commondatamodel->getAllDropdownData('enquiry_wings');  
           $data['pinlist'] = $this->commondatamodel->getAllDropdownData('pin_master');  
           $data['userlist'] = $this->commondatamodel->getAllDropdownData('user_master');
           $data['branchlist'] = $this->commondatamodel->getAllDropdownDataByComId('branch_master'); 
         
          
       // pre($data['winglist']);exit;
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

public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {
      $session = $this->session->userdata('mantra_user_detail');
        $dataArry=[];
        $json_response = array();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $dataArry);

        $enquiryId = trim(htmlspecialchars($this->input->post('enquiryId')));
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
       //pre($enquiry_date);exit;
       $first_name = trim(htmlspecialchars($this->input->post('first_name')));
       $last_name = trim(htmlspecialchars($this->input->post('last_name')));
       $wings = trim(htmlspecialchars($this->input->post('wings')));
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
       $upd_inser = 0;
          
           if ($mode == "ADD" && $enquiryId == "0") {             
            
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
                  'for_the_wing'=>$wings,
                  'enq_from'=>'',
                  'BRANCH_ID'=>$branch_id,
                  'company_id'=>$session['companyid']                 
                    );

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
                                        'for_the_wing'=>$wings,
                                        'member_id'=>'',
                                        'validity_string'=>'',
                                        'card_code'=>'',
                                        'payment_id'=>''
                                       );
                  $upd_inser = $this->commondatamodel->insertSingleTableData('enquiry_detail',$enquiry_dtl);
                   
                      // For SMS  
                      if ($wings=="RENEWAL")
                      {
                          $sms_stat="N";
                      }
                      else
                      {
                          $sms_stat=$this->send_my_sms($mobile_no,$enq_no,$wings,$branch_code);
                      }
                      $update_enqno = array('sms_stat'=>$sms_stat);
                      $upd_enq = $this->commondatamodel->updateSingleTableData('enquiry_master',$update_enqno,$where_enq);

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

                     

            }              
         
          if($upd_inser){
              $json_response = array(
                  "msg_status" => 1,
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

function prepareEnqNo($f,$l,$mob,$id)
{
	$enq=$f.$l."-".$mob."-".$id;
	return $enq;
}

function send_my_sms($phone,$enq_no,$wing,$branch)
{
    $mantra_url = "http://myvaluefirst.com/smpp/sendsms?";
    
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

	}
	if ($wing=="INSTITUTE")
	{
         $message = "Earn a Diploma in Fitness Management-Interactive & career counseling session on Saturday, 7th of Jun,14 from 12:00 pm to 2 pm at MANTRA HEALTH CLUB, 29F B.T. Road, Kol-2.Chiriyamore (Dumdum)";

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

	}

    $feed=mantraSend($phone,$message);
	 return $feed;

}

}