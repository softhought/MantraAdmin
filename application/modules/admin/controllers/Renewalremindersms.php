<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Renewalremindersms extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('renewalemindersmsmodel','renewalemindersmsmodel',TRUE);		
         $this->load->module('template');
   

		
    }
    public function index(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        { 
           
            $data['packagecatlist'] = $this->commondatamodel->getAllRecordWhereByComIdOrderBy('product_category',[],'category_name');
            $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
          
            $data['trainerlist'] = $this->renewalemindersmsmodel->GetTrainerListAll(); 
           
              $data['view_file'] = 'dashboard/registration/renewal-reminder-sms/sms_reminder_list.php';      
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }

    public function getAllRenewalreminder(){

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
        $category = $this->input->post('category');
        $card = $this->input->post('card');
        $trainer = $this->input->post('trainer');
        $mobile_no = $this->input->post('mobile_no');
        $mem_no = $this->input->post('mem_no');
       
    
        $data['renewalsmslist']= $this->renewalemindersmsmodel->getAllRenewalremindersms($from_dt,$to_date,$branch_id,$card,$trainer,$mobile_no,$mem_no);

        $data['card'] = $card; 
        $data['branch_id'] = $branch_id; 
        // $i=1;$att_rate=0;$days=0; $years="";$months="";
        // foreach($data['renewalsmslist'] as $renewalsmslist){
            
        //   $from_dt=$renewalsmslist['FROM_DT'];
        //   $to_dt=$renewalsmslist['VALID_UPTO'];
            
        //   $date_diff=strtotime($to_dt) - strtotime($from_dt);

        //   $days = floor(($date_diff - $years* 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))+1;
        //   if ($days>0)
        //   {
        //       $att_rate=number_format($renewalsmslist['totAtt']*100/$days,2);
        //   } 

        //   if($renewalsmslist['prepaymentdtl'] != "") { $lastpayment =  date('d-m-Y',strtotime($renewalsmslist['prepaymentdtl'])); }else{ $lastpayment =  date('d-m-Y',strtotime($renewalsmslist['PAYMENT_DT'])); }

        //   // $data_arr[] =array($i,$renewalsmslist['MEMBERSHIP_NO'],$renewalsmslist['FROM_DT'].' - '.$renewalsmslist['VALID_UPTO'],$renewalsmslist['CUS_PHONE'],$renewalsmslist['CUS_NAME'],date('d-m-Y',strtotime($renewalsmslist['EXPIRY_DT'])),$lastpayment,date('d-m-Y',strtotime($renewalsmslist['PAYMENT_DT'])),$renewalsmslist['renewal_rate'],$renewalsmslist['PAYMENT_DT'],$renewalsmslist['totAtt'].'/'.$days.'/'.$att_rate, $renewalsmslist['totalsms']);

        //   $data_arr[] =array($i,$renewalsmslist['MEMBERSHIP_NO']);
        // }
      

       // pre($data_arr);exit;
        $page = 'dashboard/registration/renewal-reminder-sms/sms_reminder_partial_list.php'; 
        $this->load->view($page,$data);    
        // $json_response = array('data'=>$data_arr);
        // //pre($json_response);
        // header('Content-Type: application/json');
        // echo json_encode( $json_response );
        // exit;
      
      
      }else{
          redirect('admin','refresh');
    
    }
    
    }


    public function getMobileDetail(){

      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {   
          $mobile_no =  $this->input->post('mobile_no');
          $where = array('CUS_PHONE'=>$mobile_no);
          
          $custmoer_dtl = $this->renewalemindersmsmodel->getMobileDetail('customer_master',$where,'CUS_ID');  
          //pre($locationlist);exit;
           if(!empty($custmoer_dtl)){
            $json_response = array('mem_no'=>$custmoer_dtl->MEMBERSHIP_NO);
           }else{
            $json_response = array('mem_no'=>'');
           }
         
          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit; 
      
      }else{
          redirect('admin','refresh');
    
    }
  
  }


  public function getPackageList(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $category =  $this->input->post('category');
        //$where = array('PROD_CATEGORY_ID'=>$category);
        
         $cardlist = $this->renewalemindersmsmodel->GetCardList($category); 
        //pre($locationlist);exit;
        $cardlistview = '';
        if(!empty($cardlist)){
        foreach($cardlist as $cardlist){
          $cardlistview.='<option value="'.$cardlist->CARD_ID.'">'.$cardlist->CARD_DESC.'</option>';
        }
      }else{
        $cardlistview.='<option value=""></option>';
      }
        $json_response = array('cardlistview'=>$cardlistview);
        header('Content-Type: application/json');
        echo json_encode( $json_response );
        exit; 
		
    }else{
        redirect('admin','refresh');
  
  }

}


public function sendingSMS(){

  
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
      $card =  $this->input->post('card');
      $branch_id =  $this->input->post('branch_id');

      $member_id =  $this->input->post('mem_id');
      $validity_str =  $this->input->post('validity_str');
      $mem_no =  $this->input->post('mem_no');
      $expiry_dt =  $this->input->post('expiry_dt');
      $mobile_no =  $this->input->post('mobile_no');

      if($branch_id != ""){

        $where_brn = array('BRANCH_ID'=>$branch_id);
        $branchdtl = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where_brn);

        $branch_cd = $branchdtl->BRANCH_CODE;
        $branch_id = $branchdtl->BRANCH_ID;
      }else{
        $branch_cd = $session['branchcode'];
        $branch_id = $session['branchid'];
      }
    if($card != ""){

     $where_card = array('CARD_ID'=>$card);
     $cardtl = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where_card);

     $card_cd =  $cardtl->CARD_CODE;
     $card_id =  $cardtl->CARD_ID;
    }else{
      $card_cd = 'ALL';
      $card_id =  '0';
    }      

      $sms_other_master = array(
                                'sending_date'=>date('Y-m-d H:i:s'),
                                'from_where'=>'R',
                                'branch_cd'=>$branch_cd,
                                'card_cd'=>$card_cd,
                                'branch_id'=>$branch_id,
                                'card_id'=>$card_id,
                                'company_id'=>$session['companyid']
      );

      $master_insert_id = $this->commondatamodel->insertSingleTableData('sms_other_master',$sms_other_master);

  for ($i=0;$i<count($member_id);$i++)
  {
    $due_date = date('d-m-Y',strtotime($expiry_dt[$i]));
    $member_no = $mem_no[$i];
    $mem_id = $member_id[$i];
    
    $sms_text = "Your membership (".$member_no.") renewal date is ".$due_date." please renew with in due date to get cash back and other facilities.To renew click https://mantrahealthclub.com/memberpanel/memberdashboard/smsrenew/".$mem_id; 

    $err_stat = mantraSend($mobile_no[$i],$sms_text);

       if($err_stat=="Y")
        {
          $err_id=1;
        }
        else
        {
          $err_id=0;
        }

        $sms_other_detail = array(
                                  'sms_master_id'=>$master_insert_id,
                                  'member_id'=>$mem_id,
                                  'membership_no'=>$member_no,
                                  'sending_stat'=>$err_id,
                                  'validity_string'=>$validity_str[$i],
                                  'mobile_no'=>$mobile_no[$i],
                                  'sms_content'=>$sms_text
                                );
       
        $insert_id = $this->commondatamodel->insertSingleTableData('sms_other_detail',$sms_other_detail);
  }
       if($sms_other_master){
        $json_response = array('msg_status'=>1);
       }else{
        $json_response = array('msg_status'=>0);
       }
     
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit; 
  
  }else{
      redirect('admin','refresh');

}

}

public function getpaymenthistory(){  
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
      $member_id =  $this->input->post('member_id');
      
      //$where = array('CUST_ID'=>$member_id);
      $data['paymentdata']= $this->renewalemindersmsmodel->getpaymenthistory($member_id);

     
     
      //pre($data['enquirydel']);exit;
      $page = 'dashboard/registration/renewal-reminder-sms/payment_list_modal.php';      
      $this->load->view($page,$data);
  
  }else{
      redirect('admin','refresh');

}

}

}