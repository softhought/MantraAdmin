<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Voucher extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		 $this->load->model('vouchermodel','vouchermodel',TRUE);	
		//  $this->load->model('enquirymodel','enquirymodel',TRUE);
          $this->load->module('template');		

  }
  
  public function index(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
       
        $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');
        
        $data['view_file'] = 'dashboard/account/vouher/voucher_list';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function getvoucherdata(){ 

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
      $session = $this->session->userdata('mantra_user_detail');
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

       $branch = trim(htmlspecialchars($this->input->post('branch')));
       $tranction_type = trim(htmlspecialchars($this->input->post('tranction_type')));
       $collection_type = trim(htmlspecialchars($this->input->post('collection_type')));
        $comp = $session['companyid'];
       $data['voucherlist'] = $this->vouchermodel->getallvoucherlist($from_dt,$to_date,$branch,$tranction_type,$collection_type,$comp);
       //pre($data['voucherlist']);exit;
         $page = 'dashboard/account/vouher/voucher_partial_list';       
         $this->load->view($page,$data);
		
    }else{
        redirect('admin','refresh');
  
  }

  }


  public function addeditvoucher(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";  
            $data['btnTextLoader'] = "Saving...";   
            $data['vouchermstId'] = 0;
            $data['voucherEditdata'] = [];  

           }else{      
              $data['mode'] = "EDIT";   
              $data['btnText'] = "Update";
              $data['btnTextLoader'] = "Updating..."; 
              $data['vouchermstId'] = $this->uri->segment(4);    
               $where = array('id'=>$data['vouchermstId']);  
               $data['voucherEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where);  
             
               $data['voucherdtldata'] = $this->vouchermodel->getvoucherdtl($data['vouchermstId']);
               $tranction_type = $data['voucherEditdata']->tran_type;
               if($tranction_type == 'CASH' || $tranction_type == 'BANK'){  
                 $data['subtranlist'] = json_decode(SUB_TRASANCTION_TYPE);
               }else{
                $data['subtranlist'] = array();
               }

               $data['cardlist'] = $this->vouchermodel->GetCardList($data['voucherEditdata']->pkg_cat); 
                //pre(json_decode(SUB_TRASANCTION_TYPE));
                //pre($data['voucherdtldata']);
              // exit; 
           }

           $data['Allbranchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
          $data['packagecatlist'] = $this->commondatamodel->getAllRecordWhereByComIdOrderBy('product_category',[],'category_name'); 
          $data['employeelist'] = $this->vouchermodel->GetEmployeeList(); 
           
       // pre($data['branchlist']);exit;

         $data['view_file'] = 'dashboard/account/vouher/addedit_voucher'; ;       

        $this->template->admin_template($data);  

		

    }else{
        redirect('admin','refresh');

  }

  }

  public function getsubtransactiontype(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $tranction_type =  $this->input->post('tranction_type');
       $subtranctionview ="";
        if($tranction_type == 'CASH' || $tranction_type == 'BANK'){
            $subtranctionview.='<option value="">Select</option>';
            foreach(json_decode(SUB_TRASANCTION_TYPE) as $key => $value){

                $subtranctionview.='<option value="'.$key.'">'.$value.'</option>';
            }
          

        }else{
            $subtranctionview.='<option value="">&nbsp;</option>';
            
        }
        
       
      
        $json_response = array('subtranctionview'=>$subtranctionview);
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
        
         $cardlist = $this->vouchermodel->GetCardList($category); 
        //pre($locationlist);exit;
        $cardlistview = '';
        if(!empty($cardlist)){
          $cardlistview.='<option value="">Select</option>';
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


public function getAccountList(){

 
  if($this->session->userdata('mantra_user_detail'))
  {   
    $session = $this->session->userdata('mantra_user_detail');
      $trn =  $this->input->post('trn');
      $tag =  $this->input->post('tag');
      $pkg =  $this->input->post('pkg');
      $comp = $session['companyid'];

      $accountlist = $this->vouchermodel->GetAccountList($trn,$tag,$pkg,$comp); 

      //pre($accountlist);exit;
    
      $accountlistview = '';
      if(!empty($accountlist)){
        if($tag != "type"){
          $accountlistview.='<option value="">Select</option>';
        }
      foreach($accountlist as $accountlist){
        $accountlistview.='<option value="'.$accountlist->account_id.'">'.$accountlist->account_description.'</option>';
      }
    }else{
      $accountlistview.='<option value="">Select</option>';
    }
      $json_response = array('accountlistview'=>$accountlistview);
      header('Content-Type: application/json');
      echo json_encode( $json_response );
      exit; 
  
  }else{
      redirect('admin','refresh');

}

}

public function getvoucherdetails()

      {  
          if($this->session->userdata('mantra_user_detail'))  
          {  
              $session = $this->session->userdata('mantra_user_detail');

              $data['rowno'] = $this->input->post('rowno');  
              $data['dr_cr_tag'] = $this->input->post('dr_cr_tag');  
              $data['account_id'] = $this->input->post('account_id');  
              $data['account_name'] = $this->input->post('account_name');  
              $data['pay_to_id'] = $this->input->post('pay_to_id');  
              $data['pay_to_name'] = $this->input->post('pay_to_name');  
              $data['pay_month'] = $this->input->post('pay_month');  
              $data['amount'] = $this->input->post('amount'); 

                  
              $page = 'dashboard/account/vouher/add_voucher_detail_partial';
  
              $viewTemp = $this->load->view($page,$data,TRUE);  
              echo $viewTemp;
  
          }else{
  
            redirect('admin','refresh');
  
      }
   
  
  }


  public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {

      $session = $this->session->userdata('mantra_user_detail');
       

        $vouchermstId = trim(htmlspecialchars($this->input->post('vouchermstId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));

        if($this->input->post('daily_collection') == 'on'){
          $daily_collection = 'Y';
        }
        else{
          $daily_collection = 'N';
        }
        if($this->input->post('is_original') == 'on'){
          $is_original = 'Y';
        }
        else{
          $is_original = 'N';
        }

        if(trim(htmlspecialchars($this->input->post('voucher_dt'))) != ''){            
          $voucher_dt = date('Y-m-d',strtotime($this->input->post('voucher_dt')));
         }else{
          $voucher_dt=NULL;
         }
         $branch = trim(htmlspecialchars($this->input->post('branch')));
         $tranction_type = trim(htmlspecialchars($this->input->post('tranction_type')));

         if($tranction_type == 'JOURNAL' || $tranction_type == 'CONTRA'){
          $sub_tranction_type = "";
         }else{
          $sub_tranction_type = trim(htmlspecialchars($this->input->post('sub_tranction_type')));
         }
         
         $category = trim(htmlspecialchars($this->input->post('category')));
         $card_id = trim(htmlspecialchars($this->input->post('card')));

         $total_dr = trim(htmlspecialchars($this->input->post('total_dr')));
         $total_cr = trim(htmlspecialchars($this->input->post('total_cr')));
         $narration = trim(htmlspecialchars($this->input->post('narration')));
         $cheque_no = trim(htmlspecialchars($this->input->post('cheque_no')));

         if(trim(htmlspecialchars($this->input->post('cheque_date'))) != ''){            
          $cheque_date = date('Y-m-d',strtotime($this->input->post('cheque_date')));
         }else{
          $cheque_date=NULL;
         }
         $bank_name = trim(htmlspecialchars($this->input->post('bank_name')));
         $branch_name = trim(htmlspecialchars($this->input->post('branch_name')));

         if($card_id != ""){

         $where = array('CARD_ID'=>$card_id);  
         $carddtl = $this->commondatamodel->getSingleRowByWhereCls('card_master',$where); 
         $card_code = $carddtl->CARD_CODE;
         $card_desc = $carddtl->CARD_DESC;
         }else{
          $card_code = "";
          $card_desc = "";
         }
         $is_voucher_dtl = trim(htmlspecialchars($this->input->post('is_voucher_dtl')));
         if($this->input->post('dr_cr_tag_dtl') != ''){

          $dr_cr_tag_dtl = $this->input->post('dr_cr_tag_dtl');
          $account_id_dtl = $this->input->post('account_id_dtl');
          $pay_to_id_dtl = $this->input->post('pay_to_id_dtl');
          $pay_month_dtl = $this->input->post('pay_month_dtl'); 
          $amountdtl = $this->input->post('amountdtl'); 
         

      } 
      $year_id = $session['yearid'];
      $company_id = $session['companyid'];
    

           if ($mode == "ADD" && $vouchermstId == "0") {          

            
            $srl_no = $this->vouchermodel->GetMaxsrl($year_id,$company_id);
            $voucher_no = $this->getvoucherno($year_id,$company_id,$tranction_type,$sub_tranction_type);
            

            $insert_arr = array(
              'srl_no'=>$srl_no,                   
              'voucher_no'=>$voucher_no,
              'voucher_date'=>$voucher_dt,
              'branch_id'=>$branch,
              'tran_type'=>$tranction_type,
              'tran_sub_type'=>$sub_tranction_type,
              'pkg_cat'=>$category,
              'pkg_id'=>$card_id,
              'pkg_code'=>$card_code,
              'pkg_desc'=>$card_desc,
              'narration'=>$narration,
              'cheque_no'=>$cheque_no,
              'cheque_date'=>$cheque_date,
              'bank_name'=>$bank_name,
              'bank_branch'=>$branch_name,
              'total_dr_amt'=>$total_dr,
              'total_cr_amt'=>$total_cr,
              'user_id'=>$session['userid'],
              'year_id'=>$year_id,
              'is_daily_collection'=>$daily_collection,
              'is_sent'=>'N',
              'company_id'=> $session['companyid'],
              'is_original'=> $is_original                  
                );

                   

                $upd_inser = $this->commondatamodel->insertSingleTableData('voucher_master',$insert_arr);
                $this->voucherdetails($upd_inser,$dr_cr_tag_dtl,$account_id_dtl,$pay_to_id_dtl,$pay_month_dtl,$amountdtl);

                
                 /** audit trail */ 
                  $module = 'Voucher'; 
                  $action = "Insert";
                  $method = 'voucher/addedit_action';
                  $table="voucher_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Voucher',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);





            } else{

              $voucher_no = trim(htmlspecialchars($this->input->post('voucher_no')));

              $update_arr = array(               
                'voucher_date'=>$voucher_dt,
                'branch_id'=>$branch,
                'tran_type'=>$tranction_type,
                'tran_sub_type'=>$sub_tranction_type,
                'pkg_cat'=>$category,
                'pkg_id'=>$card_id,
                'pkg_code'=>$card_code,
                'pkg_desc'=>$card_desc,
                'narration'=>$narration,
                'cheque_no'=>$cheque_no,
                'cheque_date'=>$cheque_date,
                'bank_name'=>$bank_name,
                'bank_branch'=>$branch_name,
                'total_dr_amt'=>$total_dr,
                'total_cr_amt'=>$total_cr,
                'user_id'=>$session['userid'],
                'year_id'=>$year_id,
                'is_daily_collection'=>$daily_collection,
                'is_sent'=>'N',
                'company_id'=> $session['companyid'],
                'is_original'=> $is_original                  
                  );

                $where = array('id'=>$vouchermstId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where);
                $upd_inser = $this->commondatamodel->updateSingleTableData('voucher_master',$update_arr,$where);
                $where_dtl = array('master_id'=>$vouchermstId);
                $deletedtl = $this->commondatamodel->deleteTableData('voucher_detail',$where_dtl);

                $this->voucherdetails($vouchermstId,$dr_cr_tag_dtl,$account_id_dtl,$pay_to_id_dtl,$pay_month_dtl,$amountdtl);
               
                 /** audit trail */ 

                 $module = 'Voucher';
                 $action = "Update";
                 $method = 'voucher/addedit_action';
                 $table="voucher_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Update Voucher',$module,$action,$method,$vouchermstId,$table,$old_details,$new_details);



            }            

          if($upd_inser){
              $json_response = array(
                  "msg_status" => 1,
                  "mode"=>$mode,
                  "voucherno"=>$voucher_no,
                  "msg_data"=>'Saved Successfully'           

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

private function voucherdetails($master_id,$dr_cr_tag_dtl,$account_id_dtl,$pay_to_id_dtl,$pay_month_dtl,$amountdtl){
  $session = $this->session->userdata('mantra_user_detail');
  for($i=0;$i<count($dr_cr_tag_dtl);$i++)
{
       $srl_no=$i+1;
       
      $insert_arr = array(
                          'master_id'=>$master_id,
                          'srl_no'=>$srl_no,
                          'tran_tag'=>$dr_cr_tag_dtl[$i],
                          'acc_id'=>$account_id_dtl[$i],
                          'pay_to_id'=>$pay_to_id_dtl[$i],
                          'pay_month'=>$pay_month_dtl[$i],
                          'amount'=>$amountdtl[$i]
                          
                          );
         $insert_id = $this->commondatamodel->insertSingleTableData('voucher_detail',$insert_arr);
  }

}


private function getvoucherno($year_id,$company_id,$tranction_type,$sub_tranction_type){

       $srl_no = $this->vouchermodel->GetMaxsrl($year_id,$company_id);

       $srl_pad=str_repeat("0",(6-strlen($srl_no))).$srl_no;

       $yr_pad = $this->vouchermodel->Getyearpad($year_id);

       $tran_pad=substr($tranction_type,0,1).substr($sub_tranction_type,0,1);

       return $voucher_no=$tran_pad."/".$srl_pad."/".$yr_pad;

     


}


public function voucherdelete()

      {  
          if($this->session->userdata('mantra_user_detail'))  
          {  
              $session = $this->session->userdata('mantra_user_detail');

              $voucherId = $this->uri->segment(4); 

              $where_mst = array('id'=>$voucherId);
              $voucher_mst = $this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where_mst);
              $this->commondatamodel->deleteTableData('voucher_master',$where_mst); 

              $where = array('master_id'=>$voucherId);
              $voucher_dtl = $this->commondatamodel->getAllRecordWhere('voucher_detail',$where);
              $this->commondatamodel->deleteTableData('voucher_detail',$where);
             
               /** audit trail */ 

           $module = 'Voucher Register';
           $action = "Delete";
           $method = 'voucher/voucherdelete';
           $table="voucher_master";
           $new_details = "";
           $old_details = "Voucher_master : ".json_encode($voucher_mst).'voucher_dtl : '.json_encode($voucher_dtl);
           $this->commondatamodel->insertSingleActivityTableData('Delete Voucher',$module,$action,$method,$voucherId,$table,$old_details,$new_details);

          redirect(admin_except_base_url().'voucher','refresh');

  
          }else{
  
            redirect('admin','refresh');
  
      }
   
  
  }

}  