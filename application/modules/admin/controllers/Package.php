<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Package extends MY_Controller{
	
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
         
          $data['productlist'] = $this->commondatamodel->getAllDropdownDataByComId('product_category');  
        // pre($_SERVER);exit;
          $data['view_file'] = 'dashboard/registration/master/main-package/main_package_list';      
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }


    public function addeditmainpackage(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        {   
    
            if($this->uri->segment(4) == NULL){
    
    
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";    
                $data['btnTextLoader'] = "Saving...";    
                $data['productId'] = 0;    
                $data['productEditdata'] = [];  
        
        
               }else{      
        
                  $data['mode'] = "EDIT";    
                  $data['btnText'] = "Update";    
                  $data['btnTextLoader'] = "Updating...";    
                  $data['productId'] = $this->uri->segment(4);     
                   $where = array('id'=>$data['productId']);      
                   $data['productEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('product_category',$where);   
                
                
               }
    
            //pre($session);exit;
            $data['view_file'] = 'dashboard/registration/master/main-package/addedit_mainpackage';       
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
      }
  public function checkduplicate(){
        if($this->session->userdata('mantra_user_detail'))
        {     
          $session = $this->session->userdata('mantra_user_detail');
          $txtcode = $this->input->post('txtcode');
          $productId = $this->input->post('productId');
          $company_id = $session['companyid'];
          //pre($where_not_in);exit;
          $where = array('company_id'=>$company_id,'start_letter'=>$txtcode,'is_active_web_menu'=>'Y');
          // pre($where);exit;
          $where_notequal = "id !=".$productId;
         if($productId == 0){
            $existing = $this->commondatamodel->checkExistanceData('product_category',$where);
         }else{
            $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('product_category',$where,$where_notequal);
         }
         
         $json_response = array(
                          "msg_status" => $existing              
                        );
    
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
          

          $productId = trim(htmlspecialchars($this->input->post('productId')));
          $mode = trim(htmlspecialchars($this->input->post('mode')));
          $txtcode = trim(htmlspecialchars($this->input->post('txtcode')));
          $package_name = trim(htmlspecialchars($this->input->post('package_name')));
          $design_text = trim(htmlspecialchars($this->input->post('design_text')));
         
          $docFile =  $_FILES;
          $banner_img = trim(htmlspecialchars($this->input->post('banner_img')));        
          $isImage = trim(htmlspecialchars($this->input->post('isImage')));        
       
          $imageData = array(				
            'docFile' => $docFile, 
           
           );
           //pre($imageData);exit;
           if($isImage == 'Y'){
              //  $dir = $_SERVER['DOCUMENT_ROOT'].'/MantraAdmin/assets/img/company-logo';
               $dir = $_SERVER['DOCUMENT_ROOT'].'/images/products';
               $filename = "imagefile";                  
               $banner_img = $this->commondatamodel->GetUploadImage($imageData,$filename,$dir);
             }else{
                $banner_img = $banner_img;
             }
          
            
             if ($mode == "ADD" && $productId == "0") {

               
              
                $insert_arr = array(
                    'category_name'=>strtoupper($package_name),                    
                    'start_letter'=>strtoupper($txtcode),
                    'banner_img'=>$banner_img,
                    'page_design'=>$design_text,
                    'is_active_web_menu'=>'Y',
                    'company_id'=>$session['companyid']
                      );

                  $upd_inser = $this->commondatamodel->insertSingleTableData('product_category',$insert_arr);

                   /** audit trail */ 
                    $module = 'Main Package';           
                    $action = "Insert";
                    $method = 'package/addedit_action';
                    $table="product_category";
                    $old_details="";
                    $new_details = json_encode($insert_arr);
                    $this->commondatamodel->insertSingleActivityTableData('Add Main Package',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);


              } else{

                        $update_arr = array(
                          'category_name'=>strtoupper($package_name),                    
                          'start_letter'=>strtoupper($txtcode),
                          'banner_img'=>$banner_img,
                          'page_design'=>$design_text,
                          'is_active_web_menu'=>'Y',                          
                            );

                  $where = array('id'=>$productId);
                  $olddtl = $this->commondatamodel->getSingleRowByWhereCls('product_category',$where);
                  $upd_inser = $this->commondatamodel->updateSingleTableData('product_category',$update_arr,$where);
                   /** audit trail */ 
                   $module = 'Main Package';           
                   $action = "Update";
                   $method = 'package/addedit_action';
                   $table="product_category";
                   $old_details = json_encode($olddtl);
                   $new_details = json_encode($update_arr);
                   $this->commondatamodel->insertSingleActivityTableData('Update Main Package',$module,$action,$method,$productId,$table,$old_details,$new_details);

              }              
           
            if($upd_inser){
                $json_response = array(
                    "msg_status" => 1,
                    "mode"=>$mode
                    
                           
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

  public function activemainpackage()
  {
      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {   
          $product_id=$this->uri->segment(4); 
          $where = array('id'=>$product_id);
          $data = array('is_active_web_menu'=>'Y');
          $this->commondatamodel->ActiveInactive('product_category',$data,$where);
           /** audit trail */ 
           $module = 'Main Package';           
           $action = "Active";
           $method = 'package/activemainpackage';
           $table="product_category";
           $this->commondatamodel->insertSingleActivityTableData('Active Main Package',$module,$action,$method,$product_id,$table);

          redirect(admin_except_base_url().'package','refresh');



      }else{

          redirect('admin','refresh');

      }

  }

  public function inactivemainpackage()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   
        $product_id=$this->uri->segment(4); 
          $where = array('id'=>$product_id);
          $data = array('is_active_web_menu'=>'N');
          $this->commondatamodel->ActiveInactive('product_category',$data,$where);
           /** audit trail */ 
           $module = 'Main Package';           
           $action = "Inactive";
           $method = 'package/activemainpackage';
           $table="product_category";
           $this->commondatamodel->insertSingleActivityTableData('Inactive Main Package',$module,$action,$method,$product_id,$table);

          redirect(admin_except_base_url().'package','refresh');


      }else{

          redirect('admin','refresh');

      }

  }

  //Start Package Facilities

  public function facilities(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    { 
        //$where = array('is_active_web_menu'=>'Y'); 
     
      $data['couponlist'] = $this->commondatamodel->getAllDropdownData('coupon_master');  
    // pre($_SERVER);exit;
      $data['view_file'] = 'dashboard/registration/master/facilities/facilities_list';      
        $this->template->admin_template($data);  
        
    }else{
        redirect('admin','refresh');
  
  }

}

public function addeditfacilities(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {   

      if($this->uri->segment(4) == NULL){


          $data['mode'] = "ADD";    
          $data['btnText'] = "Save";    
          $data['btnTextLoader'] = "Saving...";    
          $data['couponId'] = 0;    
          $data['couponEditdata'] = [];  
  
  
         }else{      
  
            $data['mode'] = "EDIT";    
            $data['btnText'] = "Update";    
            $data['btnTextLoader'] = "Updating...";    
            $data['couponId'] = $this->uri->segment(4);     
             $where = array('coupon_id'=>$data['couponId']);      
             $data['couponEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('coupon_master',$where);   
          
          
         }

      //pre($session);exit;
      $data['view_file'] = 'dashboard/registration/master/facilities/addedit_facilities';       
      $this->template->admin_template($data);  
      
  }else{
      redirect('admin','refresh');

}

}

public function facilities_addedit_action(){

  if($this->session->userdata('mantra_user_detail'))

  {
    $session = $this->session->userdata('mantra_user_detail');
      

      $couponId = trim(htmlspecialchars($this->input->post('couponId')));
      $mode = trim(htmlspecialchars($this->input->post('mode')));
      $coupon_title = trim(htmlspecialchars($this->input->post('coupon_title')));
      $rate_type = trim(htmlspecialchars($this->input->post('rate_type')));
      $actual_rate = trim(htmlspecialchars($this->input->post('actual_rate')));
      $price_off_rate = trim(htmlspecialchars($this->input->post('price_off_rate')));
      $maximum_booking = trim(htmlspecialchars($this->input->post('maximum_booking')));     
    
      $sms_title = trim(htmlspecialchars($this->input->post('sms_title'))); 
      $isgst = trim(htmlspecialchars($this->input->post('isgst_chargable')));

      if($isgst == "on"){
        $isgst_chargable = 'Y';
      } else{
        $isgst_chargable = 'N';
      }  
     
      //$isgst_chargable = trim(htmlspecialchars($this->input->post('isgst_chargable')));        
   
     
         if ($mode == "ADD" && $couponId == "0") {           
          
            $insert_arr = array(
                'coupon_title'=>$coupon_title,                    
                'package_type'=>"",
                'rate_type'=>$rate_type,
                'price_off_rate'=>$price_off_rate,
                'actual_rate'=>$actual_rate,
                'package_category'=>"",
                'is_gstchargble'=>$isgst_chargable,
                'maximum_booking'=>$maximum_booking,
                'zoom_link'=>"",
                'sms_title'=>$sms_title,
                'company_id'=>$session['companyid']
                  );

              $upd_inser = $this->commondatamodel->insertSingleTableData('coupon_master',$insert_arr);

               /** audit trail */ 
                $module = 'Facilities';           
                $action = "Insert";
                $method = 'package/facilities_addedit_action';
                $table="coupon_master";
                $old_details="";
                $new_details = json_encode($insert_arr);
                $this->commondatamodel->insertSingleActivityTableData('Add Package Facilities',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);


          } else{

                    $update_arr = array(
                        'coupon_title'=>$coupon_title,                    
                        'package_type'=>"",
                        'rate_type'=>$rate_type,
                        'price_off_rate'=>$price_off_rate,
                        'actual_rate'=>$actual_rate,
                        'package_category'=>"",
                        'is_gstchargble'=>$isgst_chargable,
                        'maximum_booking'=>$maximum_booking,
                        'zoom_link'=>"",
                        'sms_title'=>$sms_title,                          
                        );

              $where = array('coupon_id'=>$couponId);
              $olddtl = $this->commondatamodel->getSingleRowByWhereCls('coupon_master',$where);
              $upd_inser = $this->commondatamodel->updateSingleTableData('coupon_master',$update_arr,$where);
               /** audit trail */ 
               $module = 'Facilities';           
               $action = "Update";
               $method = 'package/facilities_addedit_action';
               $table="coupon_master";
               $old_details = json_encode($olddtl);
               $new_details = json_encode($update_arr);
               $this->commondatamodel->insertSingleActivityTableData('Update Package Facilities',$module,$action,$method,$couponId,$table,$old_details,$new_details);

          }              
       
        if($upd_inser){
            $json_response = array(
                "msg_status" => 1,
                "mode"=>$mode
                
                       
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

public function deletefacilities()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   
          $coupon_id=$this->input->post('coupon_id'); 
          $where = array('coupon_id'=>$coupon_id);
          $olddtl = $this->commondatamodel->getSingleRowByWhereCls('coupon_master',$where);
          $delete = $this->commondatamodel->deleteTableData('coupon_master',$where);
           /** audit trail */ 
           $module = 'Facilities';           
           $action = "Delete";
           $method = 'package/deletefacilities';
           $table="coupon_master";
           $old_details = json_encode($olddtl);
           $this->commondatamodel->insertSingleActivityTableData('Delete Package Facilities',$module,$action,$method,$coupon_id,$table,$old_details);

          
            $json_response = array(
                "msg_status" => 1,
            );
           
           header('Content-Type: application/json');
           echo json_encode( $json_response );
           exit; 


      }else{

          redirect('admin','refresh');

      }

  }

//End Package Facilities
}