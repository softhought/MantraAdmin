<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Packagecardcreation extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('packagemodel','packagemodel',TRUE);		
         $this->load->module('template');
   

		
    }
    public function index(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        { 
            //$where = array('is_active_web_menu'=>'Y'); 
         
            $data['cardlist'] = $this->commondatamodel->getAllDropdownDataByComId('card_master');  
            // pre($_SERVER);exit;
              $data['view_file'] = 'dashboard/registration/master/card-creation/card_list';      
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }

public function addeditcard(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        {   
      
            if($this->uri->segment(4) == NULL){
      
      
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";    
                $data['btnTextLoader'] = "Saving...";    
                $data['cardId'] = 0;    
                $data['cardEditdata'] = [];  
                $data['facilitydata'] = [];
        
               }else{      
        
                  $data['mode'] = "EDIT";    
                  $data['btnText'] = "Update";    
                  $data['btnTextLoader'] = "Updating...";    
                  $data['cardId'] = $this->uri->segment(4);     
                   $where = array('CARD_ID'=>$data['cardId']);      
                   $data['cardEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where); 
                   //$where_carddtl = array('card_id'=>$data['cardId']);  
                   //$order_by = ["branch_cd"=>'ASC'];                  
                   
                   $data['ratedetaildata'] = $this->packagemodel->getAllratedetails($data['cardId']); 
                   $data['facilitydata'] = $this->packagemodel->getAllfacilitydata($data['cardId']); 
                  
                //pre($data['cardEditdata']);exit;
                
               
                //exit;
                
               }
               $data['packagecatlist'] = $this->commondatamodel->getAllRecordWhereByComIdOrderBy('product_category',[],'category_name');
               $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
               $data['couponlist'] = $this->commondatamodel->getAllDropdownData('coupon_master');   
               $data['achivmentslist'] = $this->commondatamodel->getAllDropdownData('card_achievements_master');   
           // pre($data['packagecatlist']);exit;
            $data['view_file'] = 'dashboard/registration/master/card-creation/addedit_card';       
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
      
      }

public function getcardrate()

      {  
          if($this->session->userdata('mantra_user_detail'))  
          {  
              $session = $this->session->userdata('mantra_user_detail');

              $data['rowno'] = $this->input->post('rowno');  
              $data['branch'] = $this->input->post('branch');  
              $data['package_rate'] = $this->input->post('package_rate');  
              $data['renewal_rate'] = $this->input->post('renewal_rate');  
              $data['discount_rate'] = $this->input->post('disount_rate');  
              $where = array('BRANCH_ID'=>$data['branch']); 
              $data['branch_name'] = $this->commondatamodel->getSingleRowByWhereCls("branch_master",$where)->BRANCH_NAME; 
              $data['branch_code'] = $this->commondatamodel->getSingleRowByWhereCls("branch_master",$where)->BRANCH_CODE; 
    
              $page = 'dashboard/registration/master/card-creation/add_cardrate_partial_view';
  
              $viewTemp = $this->load->view($page,$data,TRUE);  
              echo $viewTemp;
  
          }else{
  
            redirect('admin','refresh');
  
      }
   
  
  }

  public function getpackagedtl()

  {  
      if($this->session->userdata('mantra_user_detail'))  
      {  
          $session = $this->session->userdata('mantra_user_detail');

          $data['newtrtb'] = $this->input->post('newtrtb');  
          $data['srlNo'] = $this->input->post('srlNo');  
          $data['rowno'] = $this->input->post('rowno');  
          $data['branch'] = $this->input->post('packdtl_branch');  
          $data['facility_id'] = $this->input->post('facility_id');  
          $data['facility_name'] = $this->input->post('facility_name');  
          $data['qty'] = $this->input->post('qty');  
          $data['type'] = $this->input->post('type');  
          $data['work_out'] = $this->input->post('work_out');  
          $data['sub_group'] = $this->input->post('sub_group'); 

          $where = array('BRANCH_ID'=>$data['branch']); 
          $data['branch_name'] = $this->commondatamodel->getSingleRowByWhereCls("branch_master",$where)->BRANCH_NAME; 
          $data['branch_code'] = $this->commondatamodel->getSingleRowByWhereCls("branch_master",$where)->BRANCH_CODE; 

          $page = 'dashboard/registration/master/card-creation/add_package_details';

          $viewTemp = $this->load->view($page,$data,TRUE);  
          echo $viewTemp;

      }else{

        redirect('admin','refresh');

  }



}  
       
public function checkcarcode()

      {  
          if($this->session->userdata('mantra_user_detail'))  
          {  
              $session = $this->session->userdata('mantra_user_detail');

              $card_prefix = $this->input->post('card_prefix');  
              $card_code = $this->input->post('card_code');  
              $cardcode = $card_prefix.strtoupper($card_code);
              $where = array('CARD_CODE'=>$cardcode,'company_id'=>$session['companyid']); 
              $existing = $this->commondatamodel->getSingleRowByWhereClsByComId("card_master",$where); 
             if(!empty($existing)){
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

public function CheckPrefixWithAppearance()

      {  
          if($this->session->userdata('mantra_user_detail'))  
          {  
              $session = $this->session->userdata('mantra_user_detail');
              $appearance_serial = $this->input->post('appearance_serial');  
              $card_prefix = $this->input->post('card_prefix');  
            //  pre(base_url());
            //   pre($_SERVER['DOCUMENT_ROOT']);exit;
              
              $where = array('appearance_serial'=>$appearance_serial,'CARD_PREFIX'=>$card_prefix); 
              $existing = $this->commondatamodel->getSingleRowByWhereClsByComId("card_master",$where); 
             if(!empty($existing)){
                $json_response = array('msg_status'=>1,'msg_data'=>'Already Used','base_url'=>base_url());
             }else{
                $json_response = array('msg_status'=>0,'msg_data'=>'Available','base_url'=>base_url());
             }
             
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
       
        $cardId = trim(htmlspecialchars($this->input->post('cardId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));

        $package_cat = trim(htmlspecialchars($this->input->post('package_cat')));
       // pre($package_cat);exit;
        $package_type = trim(htmlspecialchars($this->input->post('package_type')));       
        $card_prefix = trim(htmlspecialchars($this->input->post('card_prefix')));        
        $card_code = trim(htmlspecialchars($this->input->post('card_code')));        
        $package_desc = trim(htmlspecialchars($this->input->post('package_desc')));        
        $achivement_type = trim(htmlspecialchars($this->input->post('achivement_type')));        
        $active_days = trim(htmlspecialchars($this->input->post('active_days')));        
        $appearance_serial = trim(htmlspecialchars($this->input->post('appearance_serial')));        
        $session_alloted = trim(htmlspecialchars($this->input->post('session_alloted')));        
        $extension_days = trim(htmlspecialchars($this->input->post('extension_days')));        
        $from_time = trim(htmlspecialchars($this->input->post('from_time')));        
        $to_time = trim(htmlspecialchars($this->input->post('to_time')));        
        $point = trim(htmlspecialchars($this->input->post('point')));        
        $application_limit_days = trim(htmlspecialchars($this->input->post('application_limit_days')));        
        $covid_extension_days = trim(htmlspecialchars($this->input->post('covid_extension_days'))); 

         if($this->input->post('is_active') == 'on'){
            $is_active = 'Y';
         }else{
            $is_active = 'N';
         } 
         if($this->input->post('web_active') == 'on'){
            $web_active = 'Y';
         }else{
            $web_active = 'N';
         } 
         if($this->input->post('attendance_consider') == 'on'){
            $attendance_consider = 'Y';
         }else{
            $attendance_consider = 'N';
         } 
        
        //  card details data
        $is_card_detail_change = trim(htmlspecialchars($this->input->post('is_card_detail_change'))); 
        if($this->input->post('card_coupon_id') != ''){

            $card_coupon_id = $this->input->post('card_coupon_id');
            $card_branch_code = $this->input->post('card_branch_code');
            $card_branch_id = $this->input->post('card_branch_id');
            $carddtl_qty = $this->input->post('carddtl_qty'); 
            $detail_description = $this->input->post('detail_description'); 
            $sub_description = $this->input->post('sub_description'); 
            $grp_for_hf = $this->input->post('grp_for_hf'); 

        }   
        
         //  card rate details data
         $is_card_rate_change = trim(htmlspecialchars($this->input->post('is_card_rate_change'))); 
         if($this->input->post('rate_branch_code') != ''){

            $rate_branch_code = $this->input->post('rate_branch_code');
            $rate_branch_id = $this->input->post('rate_branch_id');
            $package_rate_dtl = $this->input->post('package_rate_dtl');
            $renewal_rate_dtl = $this->input->post('renewal_rate_dtl');
            $discount_rate_dtl = $this->input->post('discount_rate_dtl');

         }
          
           if ($mode == "ADD" && $cardId == "0") {  
            

            	/***------------Account------***/
	            $param = "SALES A/C";
                $sub_group_id = $this->packagemodel->getSubGroup($param);

               $insert_acc_master = array(
                                          'account_description'=>"Sales ".strtoupper($card_code),
                                          'sub_group_id'=>$sub_group_id,
                                          'open_bal'=>0,
                                          'member_acccode'=>NULL,
                                          'fin_id'=>$session['yearid'],
                                          'is_active'=>'Y',
                                          'company_id'=>$session['companyid'],
                                          'is_sent'=>'N'
                                        
                                          );        
            $account_id = $this->commondatamodel->insertSingleTableData('account_master',$insert_acc_master);

            $where = array('id'=>$package_cat);
           
            $start_letter = $this->commondatamodel->getSingleRowByWhereClsByComId("product_category",$where)->start_letter;
             $cardcode = $start_letter.strtoupper($card_code);
              $card_master_arr = array(
                  'CARD_DESC'=>strtoupper($package_desc),
                  'CARD_CODE'=>$cardcode,
                  'CARD_ACTIVE_DAYS'=>$active_days,
                  'BASIC_FEE'=>0,
                  'TAX_FEE'=>0,
                  'SERVICE_TYPE'=>NULL,
                  'IS_ACTIVE'=>$is_active,
                  'WEB_ACTIVE'=>$web_active,
                  'NO_OF_SESSION'=>$session_alloted,
                  'PROD_CATEGORY_ID'=>$package_cat,
                  'CARD_PREFIX'=>$start_letter,
                  'FROM_TIME'=>$from_time,
                  'TO_TIME'=>$to_time,
                  'EXTENSION_DAYS'=>$extension_days,
                  'point'=>$point,
                  'attendance_consider'=>$attendance_consider,
                  'application_limit_days'=>$application_limit_days,
                  'company_id'=>$session['companyid'],
                  'account_id'=>$account_id,
                  'package_card_type'=>$package_type,
                  'achievement_id'=>$achivement_type,
                  'appearance_serial'=>$appearance_serial,             
                  'covid_extension_days'=>$covid_extension_days
                
                    );
                   
                  $card_master_id = $this->commondatamodel->insertSingleTableData('card_master',$card_master_arr);
                //pre($upd_inser);exit;
                 /** audit trail */ 
                  $module = 'Package Card Creation';           
                  $action = "Insert";
                  $method = 'Packagecardcreation/addedit_action';
                  $table="card_master";
                  $old_details="";
                 $new_details = json_encode($card_master_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Card',$module,$action,$method,$card_master_id,$table,$old_details,$new_details);

                  if($card_master_id){

                  if($this->input->post('card_coupon_id') != ''){

                    $this->carddetails($card_master_id,$cardcode,$card_coupon_id,$card_branch_code,$card_branch_id,$carddtl_qty,$detail_description,$sub_description,$grp_for_hf);
                   
                  }
                  
           
                  if($this->input->post('rate_branch_code') != ''){
                    $this->cardratedetails($card_master_id,$cardcode,$rate_branch_code,$rate_branch_id,$package_rate_dtl,$renewal_rate_dtl,$discount_rate_dtl);
                  }

                }


            } else{

                    $card_master_arr = array(
                        'CARD_DESC'=>$package_desc,
                        'CARD_CODE'=>$card_code,
                        'CARD_ACTIVE_DAYS'=>$active_days,
                        'BASIC_FEE'=>0,
                        'TAX_FEE'=>0,
                        'SERVICE_TYPE'=>NULL,
                        'IS_ACTIVE'=>$is_active,
                        'WEB_ACTIVE'=>$web_active,
                        'NO_OF_SESSION'=>$session_alloted,
                        'PROD_CATEGORY_ID'=>$package_cat,
                        'CARD_PREFIX'=>$card_prefix,
                        'FROM_TIME'=>$from_time,
                        'TO_TIME'=>$to_time,
                        'EXTENSION_DAYS'=>$extension_days,
                        'point'=>$point,
                        'attendance_consider'=>$attendance_consider,
                        'application_limit_days'=>$application_limit_days,                       
                        'package_card_type'=>$package_type,
                        'achievement_id'=>$achivement_type,
                        'appearance_serial'=>$appearance_serial,             
                        'covid_extension_days'=>$covid_extension_days
                    
                        );

                $where = array('CARD_ID'=>$cardId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where);
                $card_master_id = $this->commondatamodel->updateSingleTableData('card_master',$card_master_arr,$where);
                 /** audit trail */ 
                 $module = 'Package Card Creation';           
                  $action = "Update";
                  $method = 'Packagecardcreation/addedit_action';
                  $table="card_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($card_master_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Update Card',$module,$action,$method,$cardId,$table,$old_details,$new_details);

                 if($card_master_id){
                    if($is_card_detail_change == 'Y'){

                        $where_carddtl_del = array('card_id'=>$cardId,'company_id'=>$session['companyid']);

                        $this->commondatamodel->deleteTableData('card_detail',$where_carddtl_del);

                        $this->carddetails($cardId,$card_code,$card_coupon_id,$card_branch_code,$card_branch_id,$carddtl_qty,$detail_description,$sub_description,$grp_for_hf);
                    
                    }
                    if($is_card_rate_change == 'Y'){

                        $where_cardrate_del = array('card_id'=>$cardId,'company_id'=>$session['companyid']);

                        $this->commondatamodel->deleteTableData('rate_detail',$where_cardrate_del);

                        $this->cardratedetails($cardId,$card_code,$rate_branch_code,$rate_branch_id,$package_rate_dtl,$renewal_rate_dtl,$discount_rate_dtl);
                    }

                }
            }              
         
          if($card_master_id){
              $json_response = array(
                  "msg_status" => 1,
                  "mode"=>$mode,
                  "msg_data" => "Save Successfully"
                         
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

private function carddetails($card_master_id,$cardcode,$card_coupon_id,$card_branch_code,$card_branch_id,$carddtl_qty,$detail_description,$sub_description,$grp_for_hf){
    $session = $this->session->userdata('mantra_user_detail');
    for($i=0;$i<count($card_coupon_id);$i++)
	{
         
        $insert_arr = array(
                            'card_id'=>$card_master_id,
                            'card_code'=>$cardcode,
                            'coupon_id'=>$card_coupon_id[$i],
                            'qty'=>$carddtl_qty[$i],
                            'detail_description'=>$detail_description[$i],
                            'sub_description'=>$sub_description[$i],
                            'grp_for_hf'=>$grp_for_hf[$i],
                            'branch_cd'=>$card_branch_code[$i],
                            'company_id'=>$session['companyid'],
                            'branch_id'=>$card_branch_id[$i]
                            );
           $insert_id = $this->commondatamodel->insertSingleTableData('card_detail',$insert_arr);
    }

}

private function cardratedetails($card_master_id,$cardcode,$rate_branch_code,$rate_branch_id,$package_rate_dtl,$renewal_rate_dtl,$discount_rate_dtl){
    $session = $this->session->userdata('mantra_user_detail');
    for($i=0;$i<count($rate_branch_code);$i++)
	{
         
        $insert_arr = array(
                            'card_id'=>$card_master_id,
                            'card_code'=>$cardcode,
                            'package_rate'=>$package_rate_dtl[$i],
                            'renewal_rate'=>$renewal_rate_dtl[$i],
                            'discount_rate'=>$discount_rate_dtl[$i],
                            'branch_code'=>$rate_branch_code[$i],
                            'company_id'=>$session['companyid'],                           
                            'branch_id'=>$rate_branch_id[$i]
                            );
           $insert_id = $this->commondatamodel->insertSingleTableData('rate_detail',$insert_arr);
    }

}

public function activecard()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $card_id=$this->uri->segment(4); 
        $active=$this->uri->segment(5); 
        $where = array('CARD_ID'=>$card_id);

        if($active == 'WEB'){
            $data = array('WEB_ACTIVE'=>'Y');
            $this->commondatamodel->ActiveInactive('card_master',$data,$where);
        }else if($active == 'ACT'){

            $data = array('IS_ACTIVE'=>'Y');
            $this->commondatamodel->ActiveInactive('card_master',$data,$where);
        }
       
        //  /** audit trail */ 
        //  $module = 'Create Company';           
        //  $action = "Active";
        //  $method = 'createcompany/activecompany';
        //  $table="company_master";
        //  $this->commondatamodel->insertSingleActivityTableData('Active Company Name',$module,$action,$method,$company_id,$table);

        redirect(admin_except_base_url().'packagecardcreation','refresh');



    }else{

        redirect('admin','refresh');

    }

}

public function inactivecard()

{

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))

    {   
        $card_id=$this->uri->segment(4); 
        $active=$this->uri->segment(5); 
        $where = array('CARD_ID'=>$card_id);

        if($active == 'WEB'){
            $data = array('WEB_ACTIVE'=>'N');
            $this->commondatamodel->ActiveInactive('card_master',$data,$where);
        }else if($active == 'ACT'){

            $data = array('IS_ACTIVE'=>'N');
            $this->commondatamodel->ActiveInactive('card_master',$data,$where);
        }

       /** audit trail */ 
    //    $module = 'Create Company';           
    //    $action = "Inactive";
    //    $method = 'createcompany/activecompany';
    //    $table="company_master";
    //    $this->commondatamodel->insertSingleActivityTableData('Inactive Company Name',$module,$action,$method,$company_id,$table);

      redirect(admin_except_base_url().'packagecardcreation','refresh');


    }else{

        redirect('admin','refresh');

    }

}


}