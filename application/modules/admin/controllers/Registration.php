<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Registration extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
	   $this->load->model('registrationmodel','reg_model',TRUE);
	   $this->load->model('walletmodel','wallet_model',TRUE);
     $this->load->module('template');
	

		
    }

   public function conformation(){

    $session = $this->session->userdata('mantra_user_detail');
     if($this->session->userdata('mantra_user_detail'))
      {  
         $customer_id=0;
         $payment_id=0;
         $sent_msg  = 'N';
         if($this->uri->segment(4) != NULL){
           $customer_id = $this->uri->segment(4);   
         }
         if($this->uri->segment(5) != NULL){

             $payment_id = $this->uri->segment(5);   
            
         }
         if($this->uri->segment(6) != NULL){

            $sent_msg = $this->uri->segment(6);   
           
        }
        if($sent_msg == 'Y'){
          $data['sms'] = 'Send Successfully';
        }else{
         $data['sms'] = 'Not Send';
        }
              $where = array('CUS_ID'=>$customer_id);      
              $data['customerData'] = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);   

             // pre( $data['customerData']);exit;

              $where_payment = array('PAYMENT_ID'=>$payment_id);      
              $data['paymentData'] = $this->commondatamodel->getSingleRowByWhereCls('payment_master',$where_payment); 

         $data['view_file'] = 'dashboard/registration/conformation';    
         //  $data['view_file'] = 'dashboard/franchisee/createcompany_view';      
         $this->template->admin_template($data);  
      }else{
         redirect('admin','refresh');
      }


     }

  public function addnew(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {     

        if($this->uri->segment(4) == NULL){


              $data['mode'] = "Add";    
              $data['btnText'] = "Save";    
              $data['btnTextLoader'] = "Saving...";    
              $data['regId'] = 0;    
              $data['regEditdata'] = [];  
    
    
           }else{      
    
              $data['mode'] = "Edit";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['regId'] = $this->uri->segment(4);     
              $where = array('CUS_ID'=>$data['regId']);      
              $data['regEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);   
            
            
           }
           
              // $session['companyid']=5;
               if($session['companyid']==1 || $session['companyid']==2 || $session['companyid']==3 || $session['companyid']==4){
                  $data['agreement_sign_needed']='Y';
               }else{
                  $data['agreement_sign_needed']='N';
               }

              $data['enq_no']='';
              $data['brn_cd']='';
              $data['reg_dt']=date('d/m/Y');
              $data['payment_dt']=date('d/m/Y');
              $data['companyID']=$session['companyid'];
              $data['yearID']=$session['yearid'];
              $data['accYear'] = $this->commondatamodel->getSingleRowByWhereCls('year_master',array('year_id' =>$data['yearID']));  
              $data['rowBranch'] = $this->reg_model->getAllBranch($data['companyID']); 
              $data['rowBranchCol']=$data['rowBranch'];
              $data['rowinstallment'] = $this->commondatamodel->getAllDropdownData('installment_phase');
              $data['occupationList'] = $this->commondatamodel->getAllDropdownData('occupation_master');
              $data['rowPin'] = $this->commondatamodel->getAllDropdownData('pin_master');
              $data['rowCard'] = $this->reg_model->getCardList($data['companyID']); 
              $data['rowServices'] = $this->reg_model->getInterestedServiceList(); 
              $data['rowUser'] = $this->reg_model->getUsers($data['companyID']); 
              $data['rowTrainer'] = $this->reg_model->GetTrainerListAll($data['companyID']); 
              $data['rowCorporateCompny'] = $this->reg_model->getAllCorporateCompanyList($data['companyID']);
              $data['rowCategory'] = $this->reg_model->getCategoryList($data['companyID']); 
              $data['rowBloodGroup'] = $this->commondatamodel->getAllDropdownData('blood_group');
              $data['rowRefDoctor'] = $this->commondatamodel->getAllRecordWhere('referral_doctor',array('company_id' =>$data['companyID'],'is_active' => 'Y'));
              $data['rowGetCGSTRate'] = $this->reg_model->GetGSTRate('CGST',$data['companyID']); 
              $data['rowGetSGSTRate'] = $this->reg_model->GetGSTRate('SGST',$data['companyID']); 

             
              $data['gender'] = array('M' => "Male",'F' => "Female",'O' => "Other" );
              $data['status']=array("Married","Single");
              $data['status_val']=array("M","S");
              $data['appetite']=array("Select","Good","Poor");
              $data['digestion']=array("Select","Normal","Acidity","Wind","Constipation","Ulcer","Abdominal Pain");
              $data['heart']=array("Select","Normal","Pinn in Chest","Palpitation","Ankle Swelling","Beathless-ness","Blood Pressure");
              $data['urine']=array("Select","Normal","Burning","Difficulty","Blood","Stone");
              $data['nerves']=array("Select","Normal","Headache","Fainting","Stone");
              $data['ent']=array("Select","Normal","Specific Problem");
              $data['ortho']=array("Select","Normal","Arthritis","Cervical","Lumber","Knee","Others");
              $data['psyche']=array("Select","Healthy","Anxiety","Childhood Experience","Problem at Home","Depression","Others");
              $data['disorder']=array("Select","Regular","Irregular","Painful","Not Applicable");
              $data['diet']=array("Select","Non-Veg","Veg");
              $data['pmt_mode']=array("Select","Cash","ONP","Cheque","Card","Fund Transfer");
              $data['heard_about']=array("Hoarding","Road Side Ad","Word of mouth","FM Radio","TV Ad","Conversion","From Member","Re Admission","Doctor Referral");
              $data['service']=array("Yes Always","No","If Required");
              $data['fitnessHistory'] = array(
                                             'Beginners' => 'Beginners (No experience in physical Exercise or did not perform any exercise for last six month )',
                                             'Intermediate' => 'Intermediate (Practicing physical exercise regularly  for  more than six month',
                                             'Advance' => 'Advance : Practicing physical exercise regularly for more than a year ) ',
                                          );



   

       // pre($data['rowGetCGSTRate']);exit;
        $data['view_file'] = 'dashboard/registration/new_reg_mother';    
        //  $data['view_file'] = 'dashboard/franchisee/createcompany_view';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public  function getCardBrnRate() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
               
                $company_id = $this->input->post('comapny_id');
                $sel_branch = $this->input->post('sel_branch');
                $sel_card = $this->input->post('sel_card');
                $rate='0';
                $rowRate = $this->reg_model->getRateDetailByCompany($sel_branch,$sel_card,$company_id);            
                foreach($rowRate as $row_rate)
                  {
                     $rate=$row_rate->package_rate;
                  }
               echo($rate);

         }else{
            redirect('admin','refresh');
      }

   }

    public  function getRegistrationInfo() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
                $cashbckamt=0;
                $membershipno = $this->input->post('code');
                $company_id = $session['companyid'];
                $row_mem = $this->reg_model->getMemberDetailsByCode($membershipno,$company_id);
                $rowCashBackAmt = $this->reg_model->getCashbackAmtConversion($membershipno);
                if($rowCashBackAmt){
                  $cashbckamt = $rowCashBackAmt->cash_bck_amt;
                }

                if($row_mem) {
                   echo($row_mem->CUS_ID."*".$row_mem->CUS_NAME."*".$row_mem->CUS_DOB."*".$row_mem->CUS_SEX."*".$row_mem->CUS_MS."*".$row_mem->CUS_FATHER."*".$row_mem->CUS_ADRESS."*".$row_mem->CUS_PIN."*".$row_mem->CUS_PHONE."*".$row_mem->CUS_PHONE2."*".$row_mem->CUS_EMAIL."*".$row_mem->CUS_OCCUPATION."*".$row_mem->CUS_COMPLAINT."*".$row_mem->CUS_HISTORY."*".$row_mem->CUS_APPETITE."*".$row_mem->CUS_DIGESTION."*".$row_mem->CUS_HEART."*".$row_mem->CUS_URINE."*".$row_mem->CUS_NERVES."*".$row_mem->CUS_ENT."*".$row_mem->CUS_ORTHO."*".$row_mem->CUS_PSYCHE."*".$row_mem->CUS_FD."*".$row_mem->CUS_DIET."*".$cashbckamt."*".$row_mem->CUS_BLOOD_GRP);
                }else{
                   $bln="";
                   echo(""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*".""."*"."*"."");
                }
                
             

                exit;

         }else{
            redirect('admin','refresh');
      }

   }

   
    public  function addReferDoctor() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
                $cashbckamt=0;
                $doct_name = $this->input->post('doct_name');
                $degree = $this->input->post('degree');
                $company_id = $session['companyid'];

                $insert_array = array(
                              'doctor_name' => $doct_name, 
                              'degree' => $degree, 
                              'is_active' => 'Y',                            
                              'company_id' => $company_id, 
                              
                            );

             $refid=$this->commondatamodel->insertSingleTableData('referral_doctor',$insert_array); 

             $where = array('is_active' => 'Y','company_id' => $company_id);
             $rowDoctorRef= $this->commondatamodel->getAllRecordWhere('referral_doctor',$where);

             ?>
               <select class="form_input_text form-control forminputs select2" id="ref_doct" name="ref_doct" style="width:254px;">
               <option value="0">Select</option>
               <?php foreach($rowDoctorRef as $ref_doc){ ?>
                  <option value="<?php echo $ref_doc->id;?>" <?php if($refid==$ref_doc->id){echo "selected";}?>><?php echo $ref_doc->doctor_name;?></option>
               <?php }?>
            </select> 
           <?php  
        

                exit;

         }else{
            redirect('admin','refresh');
      }

   }

   
       public  function getEnquiryDetails() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
                $cashbckamt=0;
                $enq_no = $this->input->post('enq_no');
                $company_id = $session['companyid'];
                $rowMember = $this->reg_model->getEnquiryDetail($enq_no,$company_id);

                ?>
               <select name="sel_name_enq" id="sel_name_enq" class="form_input_text forminputs select2" style="width: 306px;" onChange="getEnqNo(this.value)" >
               <option value="0">Select Name</option>

                <?php

                 foreach ($rowMember as $row_mm)
                  {
                     $name=$row_mm->FIRST_NAME." ".$row_mm->LAST_NAME;
                     echo("<option value=\"".$row_mm->ID."\">");
                     echo($name);
                     echo("</option>");

                  }

                exit;

         }else{
            redirect('admin','refresh');
      }

   }

    public  function getEnquiryNoData() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
                $cashbckamt=0;
                $enqid = $this->input->post('enqid');
                $company_id = $session['companyid'];
                $where = array('ID'=>$enqid);      
                $row_mem = $this->commondatamodel->getSingleRowByWhereCls('enquiry_master',$where);   
                $pin='';$loc='';

               
                  if ($row_mem)
                     {
                       
                           $pin_where=array('id'=>$row_mem->PIN);
                           $rowPin=$this->commondatamodel->getSingleRowByWhereCls('pin_master',$pin_where);   
                           if($rowPin)
                           {
                              $pin=$rowPin->pin_code;
                              $loc=$rowPin->location;
                           }
                           echo($row_mem->ENQ_NO."*".$row_mem->FIRST_NAME."*".$row_mem->LAST_NAME."*".$row_mem->ADDRESS."*".$row_mem->MOBILE1."*".$row_mem->MOBILE2."*".$pin."*".$loc);

                        
                     }
                     else
                     {
                           echo(""."*".""."*".""."*".""."*".""."*".""."*".""."*"."");
                     }

                

         }else{
            redirect('admin','refresh');
      }

   }

       public  function getMemberNameByMobile() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
                $cashbckamt=0;
                $txt_mem_mob = $this->input->post('txt_mem_mob');
                $company_id = $session['companyid'];
                $where = array('CUS_PHONE'=>$txt_mem_mob);      
                $row_mem = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);   

             //   pre($row_mem);
              
                if($row_mem){
                  echo $row_mem->CUS_NAME;
                }

                exit;
                

         }else{
            redirect('admin','refresh');
      }

   }






     public  function getTrainerByBranch() { 
        
         $session = $this->session->userdata('mantra_user_detail');
         if($this->session->userdata('mantra_user_detail'))
         {  
                $branch = $this->input->post('brn');
                $company_id = $session['companyid'];
                $rowTrainer = $this->reg_model->getTrainerByBrn($branch,$company_id); 
              ?>
               <select name="sel_trainer" id="sel_trainer" class="form_input_text form-control forminputs select2" >
               <option value="0">All Trainer</option>
              <?php
              foreach ($rowTrainer as $rowtrainer) { ?>
                <option value="<?php echo $rowtrainer->empl_id;?>"><?php echo $rowtrainer->empl_name."[".$rowtrainer->branch_cd."]";?></option>
             <?php }

         }else{
            redirect('admin','refresh');
      }

   }


   public  function getDiscountRateBranchPackage() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
               
                $company_id = $session['companyid'];
                $sel_branch = $this->input->post('branch');
                $sel_card = $this->input->post('card_code');
                $rate='0';
                $rowRate = $this->reg_model->getRateDetailByCompany($sel_branch,$sel_card,$company_id); 
                if (sizeof($rowRate)>0) {
		
                     foreach($rowRate as $row_rate)
                     {
                        $rate=$row_rate->package_rate;
                        $discount_rate=$row_rate->discount_rate;
                     }
               
                     if ($discount_rate>0) {
                           $discount_rate;
                           $discount=($rate*$discount_rate)/100;
                           $premium= $rate-$discount;
                           $payment_now=$premium;
                           $off=$discount_rate." % OFF ";
                              $json_response = array(
                                          "status" => 1,
                                          "discount_rate" => $off,
                                          "discount" => $discount,
                                          "premium" => $premium,
                                          "payment_now" => $payment_now,                                         
                                       );
                        
                     }else{
                     
                           $discount_rate="";
                           $discount="";
                           $premium=$rate;
                           $payment_now=$rate;
                              $json_response = array(
                                          "status" => 0,
                                          "discount_rate" => $discount_rate,
                                          "discount" => $discount,
                                          "premium" => $premium,
                                          "payment_now" => $payment_now,                                       
                                       );

                        }

            }else{
                     
                              $json_response = array(
                                          "status" => 0,
                                          "discount_rate" =>"",
                                          "discount" => "",
                                          "premium" => "",
                                          "payment_now" => "",	 
                                       );

            }

					echo json_encode( $json_response );
						exit;

         }else{
            redirect('admin','refresh');
      }

   }


   
   public  function getPromoWithMobile() { 
        
         $session = $this->session->userdata('mantra_user_detail');
         if($this->session->userdata('mantra_user_detail'))
         {  
                $mobile = $this->input->post('mobile');               
                $company_id = $session['companyid'];
                $alldata=[];
               
               $memberData = $this->wallet_model-> getMemberAccCodebymobile($mobile,$company_id);
               if($memberData){
                  $memberacc = $memberData->member_acc_code;

                  $promoList = $this->wallet_model->GetPromoCaseWithMemberAccCode($memberacc);
                  $cashbackList = $this->wallet_model->GetCashbackWithMemberAccCode($memberacc);
                  if(empty($promoList)){
                     $alldata = $cashbackList ;
                  }else if(empty($cashbackList)){
                     $alldata = $promoList;
                  }else{
                     $alldata = array_merge($promoList, $cashbackList);
                  }
                  
               }
            

               echo json_encode($alldata);
		         exit();


         }else{
            redirect('admin','refresh');
      }

   }


      public  function getMemberaccCodeWithMobile() { 
        
         $session = $this->session->userdata('mantra_user_detail');
         if($this->session->userdata('mantra_user_detail'))
         {  
                $mobile = $this->input->post('mobile');               
                $company_id = $session['companyid'];
                $alldata=[];
               
               $memberData = $this->wallet_model-> getMemberAccCodebymobile($mobile,$company_id);
              
            if($memberData){
               echo $memberacc = $memberData->member_acc_code;
            }

               
		         exit();


         }else{
            redirect('admin','refresh');
      }

   }


    public  function getCardList() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {                
                $company_id = $session['companyid'];
                $cat = $this->input->post('cat');              
                $where = array('id'=>$cat,'company_id'=>$company_id);      
                $productCategory = $this->commondatamodel->getSingleRowByWhereCls('product_category',$where); 
                $rowPackage=[];
                if ($productCategory) {
                   $start=$productCategory->start_letter;
                   $rowPackage = $this->reg_model->GetCardByCategoryByCompny($start,$company_id);
                }?>
            <select name="sel_card" id="sel_card" class="form_input_text form-control select2"  onchange="getRate();" onclick="return getRate();">
            <option value="ALL">Select</option>
            <?php if ($rowPackage) {
            foreach ($rowPackage as $row_pack) { ?>

               <option value="<?php echo $row_pack->CARD_CODE;?>"><?php echo $row_pack->CARD_DESC."[".$row_pack->CARD_CODE."]";?></option>
                
            <?php  } }?>
            </select>
            <?php



         }else{
            redirect('admin','refresh');
      }

   }


     public function registration_action(){
      if($this->session->userdata('mantra_user_detail'))
      {
         $session = $this->session->userdata('mantra_user_detail');
         $company_id = $session['companyid'];
         $year_id = $session['yearid'];
         $user_id = $session['userid'];


         
         //pre($_FILES);
        // pre($_POST);exit;
         $mode = $this->input->post('mode',true);   
         $entry_mode = $this->input->post('entry_mode',true);   
         $regID = $this->input->post('regId',true);  


         if(isset($_POST['chkIsact']) && $_POST['chkIsact']=='on'){ $is_act="H"; }else{ $is_act="Y"; }
         if(isset($_POST['chkIscompl']) && $_POST['chkIscompl']=='on'){ $is_compl="Y"; }else{ $is_compl="N";}

         $curr_date = date('Y-m-d');
         //   $from_where="F";
         $is_active="Y";
         $fresh_renewal = "F";
         // Customer master

         $enq_no=$_POST['txt_enq_no'];
         $enq_id=$_POST['sel_name_enq'];

         $reg_dt=$_POST['txt_reg_dt'];
         $branch=$_POST['sel_branch'];
         $collection_at=$_POST['sel_col_branch'];
         $card=$_POST['sel_card'];
         $txt_first_name=$_POST['txt_first_name'];
         $txt_last_name=$_POST['txt_last_name'];
         $name=$_POST['txt_name'];
         $name2=$_POST['txt_name_2'];
         $ext_mem_no=$_POST['txt_ext_mno'];
         $ext_mem_id=$_POST['hd_mno'];
         $is_converted = $_POST['hd_isconverted'];
         $reg_mode = $_POST['entry_mode'];


         if($reg_mode=="NEW REG"){
            $entry_mode = "NR";
            $payment_from = "REG";
         }
         if($reg_mode=="ENQ REG"){
            $entry_mode = "ER";
            $payment_from = "REG";
         }
         if($reg_mode=="CON REG"){
            $entry_mode = "WC";
            $payment_from = "CON";  // CON tag used for Conversion
         }

         $dob=date("Y-m-d",strtotime($_POST['txt_birth']));
         if($_POST['txt_anniversary']!=''){
            $txt_anniversary=date("Y-m-d",strtotime($_POST['txt_anniversary']));
         }else{
            $txt_anniversary=NULL;
         }

         $gender=$_POST['sel_gender'];
         $mar_stat=$_POST['sel_marital'];
         $blood_group = $_POST['sel_blood_grp'];
         $father=$_POST['txt_father'];
         $add=$_POST['txt_add'];
         $pin=$_POST['txt_pin'];
         $phone=$_POST['txt_phone'];
         $phone2=$_POST['txt_phone2'];
         $whatsup_number=$_POST['whatsup_number'];
         $mail=$_POST['txt_mail'];
         $occu=$_POST['txt_occu'];
         $compl=$_POST['txt_comp'];
         $history=$_POST['txt_his'];

         $trainer=$_POST['sel_trainer'];

         $app=$_POST['sel_app'];
         $dig=$_POST['sel_dig'];
         $hrt=$_POST['sel_hrt'];
         $urn=$_POST['sel_urn'];
         $nrv=$_POST['sel_nrv'];
         $ent=$_POST['sel_ent'];
         $ort=$_POST['sel_ort'];
         $psy=$_POST['sel_psy'];
         $fem=$_POST['sel_fem'];
         $dit=$_POST['sel_dit'];

         $heard=$_POST['sel_heard'];
         $ref_mem_mob='';$ref_mem_id='';$ref_doct_id='';
         if ($heard=="From Member")
         {
            $ref_mem_mob=$_POST['txt_mem_mob'];
            $ref_mem_id=$_POST['txtmid'];
         }
         if($heard=="Doctor Referral"){
            $ref_doct_id = $_POST['ref_doct'];
         }

         $service=$_POST['sel_service'];
        
         
         $sel_fitness_history=$this->chekFromData($_POST,'sel_fitness_history');
     /*---------------- Medical assestemnt ----------------- */
         $waist=$this->chekFromData($_POST,'txt_waist');
         $weight=$this->chekFromData($_POST,'txt_weight');
         $height=$this->chekFromData($_POST,'txt_height');
         $hip=$this->chekFromData($_POST,'txt_hip');
         $chest=$this->chekFromData($_POST,'txt_chest');
         $hand=$this->chekFromData($_POST,'txt_hand');

         $bp=$this->chekFromData($_POST,'txt_bp');
         $fat=$this->chekFromData($_POST,'txt_fat');
         $bp_d=$this->chekFromData($_POST,'txt_bp_d');

         $heart_rate=$this->chekFromData($_POST,'txt_heart_rate');
         $oxy_level=$this->chekFromData($_POST,'txt_oxy_level');
         $ecg=$this->chekFromData($_POST,'txt_ecg');
         $chest_xray=$this->chekFromData($_POST,'txt_chest_xray');
         $vo2_max=$this->chekFromData($_POST,'txt_vo2');
        //  $urea=$_POST['txt_urea']; /* comment for undefined  */
        // $creatine=$_POST['txt_creatine']; /* comment for undefined  */
        // $uric_acid=$_POST['txt_uric_acid'];  /* comment for undefined  */
         //$glucose_pp=$_POST['txt_glucose_pp'];  /* comment for undefined  */
        // $glucose_f=$_POST['txt_glucose_f']; /* comment for undefined  */

        // $glucose_r=$_POST['txt_glucose_r'];  /* comment for undefined  */

       //  $calcium=$_POST['txt_calcium'];  /* comment for undefined  */
       //  $heim=$_POST['txt_heim'];  /* comment for undefined  */

       //  $triglycerids=$_POST['txt_triglycerids'];  /* comment for undefined  */
        // $cholesteral_hdl=$_POST['txt_cholesteral_hdl']; /* comment for undefined  */

      //   $cholesteral_ldl=$_POST['txt_cholesteral_ldl']; /* comment for undefined  */
       //  $cholesteral_tot=$_POST['txt_cholesteral_tot'];  /* comment for undefined  */
       //  $hba=$_POST['txt_hba']; /* comment for undefined  */

       //  $thyroid=$_POST['txt_thyroid'];  /* comment for undefined  */
       //  $urinary=$_POST['txt_urinary'];  /* comment for undefined  */









         $service_id=$_POST['sel_service_int'];
         $done_by=$_POST['sel_user'];

         $f_inst_dt=null;
         if (isset($_POST['txt_inst1_dt']) && strlen($_POST['txt_inst1_dt'])!=0)
         {
                  $f_inst_dt=date("Y-m-d",strtotime($_POST['txt_inst1_dt']));
         }

         $f_inst_amt=$_POST['txt_inst1_amt'];
         $f_inst_cheque=$_POST['txt_inst1_cheque'];
         $f_inst_bank=$_POST['txt_inst1_bank'];
         $f_inst_branch=$_POST['txt_inst1_branch'];
         $f_installment_chrgs=$_POST['due_installment1_charges'];


         if (isset($_POST['txt_inst2_dt']) && strlen($_POST['txt_inst2_dt'])!=0)
         {
               $s_inst_dt=date("Y-m-d",strtotime($_POST['txt_inst2_dt']));
         }

         $s_inst_amt=$_POST['txt_inst2_amt'];
         $s_inst_cheque=$_POST['txt_inst2_cheque'];
         $s_inst_bank=$_POST['txt_inst2_bank'];
         $s_inst_branch=$_POST['txt_inst2_branch'];
         $s_installment_chrgs=$_POST['due_installment2_charges'];


         if (isset($_POST['txt_inst3_dt']) && strlen($_POST['txt_inst3_dt'])!=0)
         {
               $t_inst_dt=date("Y-m-d",strtotime($_POST['txt_inst3_dt']));
         }

         $t_inst_amt=$_POST['txt_inst3_amt'];
         $t_inst_cheque=$_POST['txt_inst3_cheque'];
         $t_inst_bank=$_POST['txt_inst3_bank'];
         $t_inst_branch=$_POST['txt_inst3_branch'];
         $t_installment_chrgs=$_POST['due_installment3_charges'];

         if (isset($_POST['txt_inst4_dt']) &&  strlen($_POST['txt_inst4_dt'])!=0)
         {
               $fo_inst_dt=date("Y-m-d",strtotime($_POST['txt_inst4_dt']));
         }

         $fo_inst_amt=$_POST['txt_inst4_amt'];
         $fo_inst_cheque=$_POST['txt_inst4_cheque'];
         $fo_inst_bank=$_POST['txt_inst4_bank'];
         $fo_inst_branch=$_POST['txt_inst4_branch'];
         $fo_installment_chrgs=$_POST['due_installment4_charges'];

         if (isset($_POST['txt_inst5_dt']) && strlen($_POST['txt_inst5_dt'])!=0)
         {
               $fi_inst_dt=date("Y-m-d",strtotime($_POST['txt_inst5_dt']));
         }

         $fi_inst_amt=$_POST['txt_inst5_amt'];
         $fi_inst_cheque=$_POST['txt_inst5_cheque'];
         $fi_inst_bank=$_POST['txt_inst5_bank'];
         $fi_inst_branch=$_POST['txt_inst5_branch'];
         $fi_installment_chrgs=$_POST['due_installment5_charges'];

         if (isset($_POST['txt_inst6_dt']) && strlen($_POST['txt_inst6_dt'])!=0)
         {
               $si_inst_dt=date("Y-m-d",strtotime($_POST['txt_inst6_dt']));
         }

         $si_inst_amt=$_POST['txt_inst6_amt'];
         $si_inst_cheque=$_POST['txt_inst6_cheque'];
         $si_inst_bank=$_POST['txt_inst6_bank'];
         $si_inst_branch=$_POST['txt_inst6_branch'];
         $si_installment_chrgs=$_POST['due_installment6_charges'];


         









         /* ---------------------- Files Upload ----------------------- */
          $file_dir1=$_SERVER['DOCUMENT_ROOT']."/images/member_p/";
         $file_dir2=$_SERVER['DOCUMENT_ROOT']."/admin/form/";

         if(is_uploaded_file($_FILES['imgInp']['tmp_name']))
         {
            move_uploaded_file($_FILES['imgInp']['tmp_name'],$file_dir1.$_FILES['imgInp']['name'])
            or die("Unable to Move Image");

            $imagename=$_FILES['imgInp']['name'];
         }
         else
         {
            $imagename="";
         }
         
         if(is_uploaded_file($_FILES['doc1']['tmp_name']))
         {
            move_uploaded_file($_FILES['doc1']['tmp_name'],$file_dir2.$_FILES['doc1']['name'])
            or die("Unable to Move Pdf");

            $pdf1=$_FILES['doc1']['name'];
         }
         else
         {
            $pdf1="";
         }

         if(is_uploaded_file($_FILES['doc2']['tmp_name']))
         {
            move_uploaded_file($_FILES['doc2']['tmp_name'],$file_dir2.$_FILES['doc2']['name'])
            or die("Unable to Move Pdf");

            $pdf2=$_FILES['doc2']['name'];
         }
         else
         {
            $pdf2="";
         }


         if(is_uploaded_file($_FILES['doc3']['tmp_name']))
         {
            move_uploaded_file($_FILES['doc3']['tmp_name'],$file_dir2.$_FILES['doc3']['name'])
            or die("Unable to Move Pdf");

            $pdf3=$_FILES['doc3']['name'];
         }
         else
         {
            $pdf3="";
         }


         if(is_uploaded_file($_FILES['doc4']['tmp_name']))
         {
            move_uploaded_file($_FILES['doc4']['tmp_name'],$file_dir2.$_FILES['doc4']['name'])
            or die("Unable to Move Pdf");

            $pdf4=$_FILES['doc4']['name'];
         }
         else
         {
            $pdf4="";
         }


         if(is_uploaded_file($_FILES['doc5']['tmp_name']))
         {
            move_uploaded_file($_FILES['doc5']['tmp_name'],$file_dir2.$_FILES['doc5']['name'])
            or die("Unable to Move Pdf");

            $pdf5=$_FILES['doc5']['name'];
         }
         else
         {
            $pdf5="";
         }


         if(is_uploaded_file($_FILES['doc6']['tmp_name']))
         {
            move_uploaded_file($_FILES['doc6']['tmp_name'],$file_dir1.$_FILES['doc6']['name'])
            or die("Unable to Move Pdf");

            $doctor_prescription=$_FILES['doc6']['name'];
         }
         else
         {
            $doctor_prescription="";
         }


         $doctor_prescription="";
         if ($is_compl=="N")
         {           
            $rcpt_srl=$this->reg_model->getReceiptNoPaymentMaster($branch,$year_id,$company_id);
         }
         else
         {
            $rcpt_srl=0;
         }

         $branch_id = $this->commondatamodel->getSingleRowByWhereCls('branch_master',array('BRANCH_CODE'=>$branch,
                                                   'company_id'=>$company_id))->BRANCH_ID; 
        
         $rowCard=$this->reg_model->getCardDtlByCode($card,$company_id);
         if($rowCard){
         $card_id = $rowCard->CARD_ID;
         $card_category = $rowCard->CARD_PREFIX;
         $card_desc = $rowCard->CARD_DESC;
         $card_acc_id = $rowCard->account_id;
         }else{$card_id='';$card_category='';$card_desc='';$card_acc_id='';}
         $servicetaxAmt=0;

         if (isset($_POST['txt_chq_dt']) && strlen($_POST['txt_chq_dt'])!=0)
         {          
		      $chqDate = date("Y-m-d",strtotime($_POST['txt_chq_dt']));
         }else{
             $chqDate = NULL;
         }

         if (isset($_POST['txt_payment_dt']) && strlen($_POST['txt_payment_dt'])!=0)
         {          
		       $payment_date=date("Y-m-d",strtotime($_POST['txt_payment_dt']));
         }else{
             $payment_date = NULL;
         }
        
         // Payment master
   
         $payment_mode=$_POST['sel_mode'];
         $chq_no=$_POST['txt_chq_no'];
         $bank_name=$this->chekFromData($_POST,'txt_bank');
         $branch_name=$this->chekFromData($_POST,'txt_branch');
	
		
         

         $adm=0;
         $subs=$_POST['txt_subscription'];
         $disc1=$_POST['txt_disc_conv'];
         $disc2=$_POST['txt_disc_offer'];
         $disc3=$_POST['txt_disc_nego'];
         $nego_disc_rem=$_POST['txt_rem_nego'];
         $cashbackamt = $_POST['txt_cashbck'];

         $prm=$this->chekFromData($_POST,'txt_premium');
         if($prm==''){$prm=0;}

         
         $payment_now=$_POST['txt_payment_now'];
         if ($payment_now=='') {
           $payment_now=0;
         }
         $due=$_POST['txt_due'];

   	   $insert_fields_arr=[];
         $insert_payment_arr=[];
         $insert_due_arr=[];
         $insert_mem_comp_arr=[];
         $insert_account_master = [];
         $voucherCustomer = [];
         $voucherSale = [];

	      $account_code = "";
        
         $agreement_sign_id=$_POST['agreement_sign_id'];
        



         if($mode == 'Add' && $regID == 0){

               $srl=$this->gen_serial_brn($branch,$card,$company_id);
               
               $mno=$this->gen_mem_no_pad($branch,$card,$srl,$company_id);

               

               $generateValidity = $this->generateValidityString($entry_mode,$is_converted,$ext_mem_no,$reg_dt,$card,$phone,$company_id); 
                // pre($generateValidity);exit;
               $valid_string = $generateValidity['valid_string'];
               $open_date = $generateValidity['open_date'];
               $covideextensiondays = $generateValidity['covideextensiondays'];
               $valid_upto1 = $generateValidity['valid_upto1'];

               if($ext_mem_no!="" && $ext_mem_id!=0 && $entry_mode=='WC'){
                     $narration = "Conversion";
               }else{
                     $narration = "Registration";
               }

               /* -------------------------- Account Code ---------------------------- */    
              $account_code=$this->getMemberAccountCode($phone,$company_id);
              /*--------- get mem_account_id ,mem_acc_code,membership_ref*/
              $accountData=$this->getMemberAccountsDetails($_POST,$ext_mem_no,$ext_mem_id,$entry_mode,$account_code,$mno,$company_id);

              $cgstTaxAmt = 0;
              $sgstTaxAmt = 0;
              $cgstRateID = $this->chekFromData($_POST,'cgstrate');
              $cgstAmount = $_POST['cgstAmount'];
              $sgstRateID =$this->chekFromData($_POST,'sgstrate');
              $sgstAmount = $_POST['sgstAmount'];
              $isGST = "N";

              	if($cgstAmount>0 && $sgstAmount>0)
               {
                  $isGST = "Y";
               }
               if($cgstAmount>0)
               {
                  $rowCGSTData =  $this->reg_model->GetGSTRateByID('CGST',$cgstRateID);
                  if($rowCGSTData)
                  {
                     $cgstrate= $rowCGSTData->rate;
                     $cgstAccID = $rowCGSTData->accountId;
                  }

                  $cgstTaxAmt = (($cgstrate/100) * $payment_now);
               }

               if($sgstAmount>0)
               {
                  $rowSGSTData =  $this->reg_model->GetGSTRateByID('SGST',$sgstRateID);
                  if($rowSGSTData)
                  {
                     $sgstrate= $rowSGSTData->rate;
                     $sgstAccID = $rowSGSTData->accountId;
                  }

                  $sgstTaxAmt = (($sgstrate/100) * $payment_now);
               }

             
               $total_amount = $payment_now + $cgstTaxAmt + $sgstTaxAmt;



             //  echo "insert";exit;
              	$insert_fields_arr['CUS_BRANCH']=$branch;
               $insert_fields_arr['CUS_CARD']=$card;
               $insert_fields_arr['branch_id']=$this->getBranchIDByCompany($branch,$company_id);
               $insert_fields_arr['card_id']=$this->getCardIDByCompany($card,$company_id);
               $insert_fields_arr['MEMBERSHIP_NO']=$mno;
               $insert_fields_arr['CUS_FNAME']=$txt_first_name;
               $insert_fields_arr['CUS_LNAME']=$txt_last_name;
               $insert_fields_arr['CUS_NAME']=$name;
               $insert_fields_arr['CUS_NAME2']=$name2;
               $insert_fields_arr['CUS_DOB']=$dob;
               $insert_fields_arr['ANNIVERSARY_DT']=$txt_anniversary;
               $insert_fields_arr['CUS_SEX']=$gender;
               $insert_fields_arr['CUS_MS']=$mar_stat;
               $insert_fields_arr['CUS_BLOOD_GRP']=$blood_group; // Mithilesh on 21.10.2016
               $insert_fields_arr['CUS_FATHER']=$father;
               $insert_fields_arr['CUS_ADRESS']=$add;
               $insert_fields_arr['CUS_PIN']=$pin;
               $insert_fields_arr['CUS_PHONE']=$phone;
               $insert_fields_arr['CUS_PHONE2']=$phone2;
               $insert_fields_arr['CUS_EMAIL']=$mail;
               $insert_fields_arr['CUS_OCCUPATION']=$occu;
               $insert_fields_arr['CUS_COMPLAINT']=$compl;
               $insert_fields_arr['CUS_HISTORY']=$history;

               $insert_fields_arr['CUS_APPETITE']=$app;
               $insert_fields_arr['CUS_DIGESTION']=$dig;
               $insert_fields_arr['CUS_HEART']=$hrt;
               $insert_fields_arr['CUS_URINE']=$urn;
               $insert_fields_arr['CUS_NERVES']=$nrv;
               $insert_fields_arr['CUS_ENT']=$ent;
               $insert_fields_arr['CUS_ORTHO']=$ort;
               $insert_fields_arr['CUS_PSYCHE']=$psy;
               $insert_fields_arr['CUS_FD']=$fem;
               $insert_fields_arr['CUS_DIET']=$dit;
               $insert_fields_arr['IS_ACTIVE']=$is_act;
               //"Y"
               $insert_fields_arr['REGISTRATION_DT']=$open_date;
               $insert_fields_arr['PASS']=$dob;
               $insert_fields_arr['SRL_NO']=$srl;
               $insert_fields_arr['USER_ID']=$user_id ;
               $insert_fields_arr['FIN_ID']=$year_id;
               $insert_fields_arr['EXT_MEMBERSHIP_NO']=$ext_mem_no;
               $insert_fields_arr['EXT_MEMBERSHIP_ID']=$ext_mem_id;

               $insert_fields_arr['ENQ_NO']=$enq_no;
               $insert_fields_arr['ENQ_ID']=$enq_id;
               $insert_fields_arr['PAYMENT_DT']=$payment_date;

               $insert_fields_arr['IS_COMPLI']=$is_compl;
               $insert_fields_arr['FROM_WHERE']=$heard;
               $insert_fields_arr['REF_MEM_MOBILE']=$ref_mem_mob;
               $insert_fields_arr['REF_MEMBER_ID']=$ref_mem_id;
               $insert_fields_arr['REF_DOCT_ID']=$ref_doct_id;
               $insert_fields_arr['FREE_SERVICE']=$service;

               $insert_fields_arr['trainer_id']=$trainer;

               $insert_fields_arr['WAIST']=$waist;
               $insert_fields_arr['WEIGHT']=$weight;
               $insert_fields_arr['HEIGHT']=$height;
               $insert_fields_arr['HIP']=$hip;
               $insert_fields_arr['CHEST']=$chest;
               $insert_fields_arr['HAND']=$hand;

               $insert_fields_arr['BP']=$bp;
               $insert_fields_arr['FAT']=$fat;
               $insert_fields_arr['service_id']=$service_id;
              // $insert_fields_arr['member_diet']=$this->chekFromData($_POST,'sel_diet');
               $insert_fields_arr['website']=$this->chekFromData($_POST,'txt_website');
               $insert_fields_arr['houseno']=$this->chekFromData($_POST,'txt_houseno');
               $insert_fields_arr['buildingno']= $this->chekFromData($_POST,'txt_buildingno');
               $insert_fields_arr['apartmentno']=$this->chekFromData($_POST,'txt_apartno'); 
               $insert_fields_arr['fitness_history']=$this->chekFromData($_POST,'sel_fitness_history');

               $insert_fields_arr['image_name']=$imagename;
               $insert_fields_arr['form_page1']=$pdf1;
               $insert_fields_arr['form_page2']=$pdf2;
               $insert_fields_arr['form_page3']=$pdf3;
               $insert_fields_arr['form_page4']=$pdf4;
               $insert_fields_arr['form_page5']=$pdf5;
               $insert_fields_arr['doctor_prescription']=$doctor_prescription;

              
               $insert_fields_arr['is_high_bp']=$this->chekFromData($_POST,'is_high_bp');
               $insert_fields_arr['high_bp_medicines']=$this->chekFromData($_POST,'high_bp_medicines');
               $insert_fields_arr['diabetes_type']=$this->chekFromData($_POST,'diabetes_radio');
               $insert_fields_arr['diabetics_medicines']=$this->chekFromData($_POST,'diabetics_medicines');
               $insert_fields_arr['is_heart_disease']=$this->chekFromData($_POST,'is_heart_disease');
               $insert_fields_arr['heart_disease_medicines']=$this->chekFromData($_POST,'heart_disease_medicines');
               $insert_fields_arr['is_pcod']=$this->chekFromData($_POST,'is_pcod');
               $insert_fields_arr['pcod_medicines']=$this->chekFromData($_POST,'pcod_medicines');
               $insert_fields_arr['is_chronic_kidney_disease']=$this->chekFromData($_POST,'is_chronic_kidney_disease');
               $insert_fields_arr['chronic_kidney_disease_medicines']=$this->chekFromData($_POST,'chronic_kidney_disease_medicines');
              // $insert_fields_arr['psyche']=$this->chekFromData($_POST,'sel_psyche');
               $insert_fields_arr['regular_med_history']=$this->chekFromData($_POST,'regular_med_history');

               if (isset($_POST['txt_inst1_dt']) && strlen($_POST['txt_inst1_dt'])!=0)
               {
                  $insert_fields_arr['first_due_date']=$f_inst_dt;
                  $insert_fields_arr['first_due_amount']=$f_inst_amt;
               }

               if (isset($_POST['txt_inst2_dt']) && strlen($_POST['txt_inst2_dt'])!=0)
               {
                  $insert_fields_arr['second_due_date']=$s_inst_dt;
                  $insert_fields_arr['second_due_amount']=$s_inst_amt;
               }

               //added by anil on 09-04-2020
               if (isset($_POST['txt_inst3_dt']) && strlen($_POST['txt_inst3_dt'])!=0)
               {
                  $insert_fields_arr['third_due_date']=$t_inst_dt;
                  $insert_fields_arr['third_due_amount']=$t_inst_amt;
               }

               if (isset($_POST['txt_inst4_dt']) && strlen($_POST['txt_inst4_dt'])!=0)
               {
                  $insert_fields_arr['fourth_due_date']=$fo_inst_dt;
                  $insert_fields_arr['fourth_due_amount']=$fo_inst_amt;
               }

               if (isset($_POST['txt_inst5_dt']) && strlen($_POST['txt_inst5_dt'])!=0)
               {
                  $insert_fields_arr['fifth_due_date']=$fi_inst_dt;
                  $insert_fields_arr['fifth_due_amount']=$fi_inst_amt;
               }

               if (isset($_POST['txt_inst6_dt']) && strlen($_POST['txt_inst6_dt'])!=0)
               {
                  $insert_fields_arr['sixth_due_date']=$si_inst_dt;
                  $insert_fields_arr['sixth_due_amount']=$si_inst_amt;
               }
               //ended by anil on 09-04-2020

               $insert_fields_arr['BP_D']=$bp_d;
               $insert_fields_arr['HEART_RATE']=$heart_rate;
               $insert_fields_arr['OXY_SAT_LEVEL']=$oxy_level;
               $insert_fields_arr['ECG']=$ecg;
               $insert_fields_arr['CHEST_XRAY']=$chest_xray;
               $insert_fields_arr['VO2_MAX']=$vo2_max;



              // $insert_fields_arr['urea']=$urea;
              // $insert_fields_arr['creatine']=$creatine;
              // $insert_fields_arr['uric_acid']=$uric_acid;
              // $insert_fields_arr['glucose_pp']=$glucose_pp;
              // $insert_fields_arr['glucose_f']=$glucose_f;
              // $insert_fields_arr['glucose_r']=$glucose_r;
              // $insert_fields_arr['calcium']=$calcium;
             //  $insert_fields_arr['heimoglobin']=$heim;
             //  $insert_fields_arr['triglycerids']=$triglycerids;
             //  $insert_fields_arr['cholesteral_hdl']=$cholesteral_hdl;
              // $insert_fields_arr['cholesteral_ldl']=$cholesteral_ldl;
             //  $insert_fields_arr['cholesteral_tot']=$cholesteral_tot;
              // $insert_fields_arr['HbA1c']=$hba;
             //  $insert_fields_arr['thyroid_profile']=$thyroid;
             //  $insert_fields_arr['urinary_micro_albumin']=$urinary;
               $insert_fields_arr['pack_type']="M";
               $insert_fields_arr['done_by']=$done_by;
               $insert_fields_arr['is_converted']=$is_converted;
               $insert_fields_arr['entry_mode']=$entry_mode;
               $insert_fields_arr['member_acc_code']=$account_code;
               $insert_fields_arr['corporate_comp_id']=$_POST['sel_corp_comny'];
               $insert_fields_arr['company_id'] = $company_id;
               $insert_fields_arr['whatsup_number'] = $whatsup_number;
               $insert_fields_arr['is_new_soft'] = 'Y';


               // echo "<pre>";
               // print_r($insert_fields_arr);
               // echo "</pre>";exit;
               // echo "Account Code";
               // echo "<br>";
               // echo $account_code;
               // exit;


                 $cust_ins_id = $this->commondatamodel->insertSingleTableData('customer_master',$insert_fields_arr);

                 

             /*------------------------------- voucher entry start -------------------- */
             $voucher_master_id = 0; $voucher_master_id_2 = 0;

             if($branch!="LT" && $branch!="TR" && $is_compl=="N" && $payment_now>0)
               {
                  $voucherno_prefix = 'RG';
                  $voucher_srl = $this->reg_model->getLatestVoucherSerialNoNew($year_id,$company_id);
                  /*----- For First Voucher Prepare Master Data-----*/
                  $voucher_serial_A =  $voucher_srl."A";
                  
                  $voucher_no = $this->GenerateVoucherNoNew($voucherno_prefix,$voucher_serial_A,$year_id);

                  $voucher_master = array(
                                          "srl_no" => $voucher_srl,
                                          "voucher_no" => $voucher_no,
                                          "voucher_date" => date('Y-m-d',strtotime($payment_date)),
                                          "branch_id" => $branch_id,
                                          "tran_type" => 'REG',
                                          "tran_sub_type" => '',
                                          "pkg_cat" => $card_category ,
                                          "pkg_id" => $card_id,
                                          "pkg_code" =>$card,
                                          "pkg_desc" => $card_desc,
                                          "narration" => $narration,
                                          "cheque_no" => '',
                                          "cheque_date" => '',
                                          "bank_name" => '',
                                          "bank_branch" => '',
                                          "total_dr_amt" => 0,
                                          "total_cr_amt" => 0,
                                          "user_id" => $user_id,
                                          "year_id" => $year_id,
                                          "is_daily_collection" => 'Y',
                                          "company_id" => $company_id
                                       );

                 $voucher_master_id =  $this->commondatamodel->insertSingleTableData('voucher_master',$voucher_master);     
             
                  // gettin account id by branch and payment mode
                  $rowdebitAccountId = $this->reg_model->getAccountIdByPaymentMode($branch,$payment_mode,$company_id);
            
                  $debit_acc_id = $rowdebitAccountId->account_id;
               	$voucher_dtl_array = [];
                  $voucher_dtl_array2 = [];
                  $voucherDtlArry1 = []; // Sale  -- Cr  1
                  $voucherDtlArry2 = []; // CGST  -- Cr  2
                  $voucherDtlArry3 = []; // SGST  -- Cr  3
                  $voucherDtlArry4 = []; // Party -- Dr  4
                  $voucherDtlArry5 = []; // Party -- Cr  5
                  $voucherDtlArry6 = []; // Cash/bank -- Dr  6

                  // Sales A/C Credit ---- 1
                  $voucherDtlArry1 = array(
                     "master_id" => $voucher_master_id,
                     "srl_no" => 1,
                     "tran_tag" => 'Cr',
                     "acc_id" => $card_acc_id, // Sale A/C ID
                     "pay_to_id" => '',
                     "pay_month" => '',
                     "amount_old" => '0.00',
                     "amount" => $payment_now,
                     "accountcode" => NULL,
                     "membership_no" => NULL
                  );

                  // CGST A/C Credit ----- 2
                  $voucherDtlArry2 = array(
                     "master_id" => $voucher_master_id,
                     "srl_no" => 2,
                     "tran_tag" => 'Cr',
                     "acc_id" => $cgstAccID,
                     "pay_to_id" => '',
                     "pay_month" => '',
                     "amount_old" => '0.00',
                     "amount" => $cgstTaxAmt,
                     "accountcode" => NULL,
                     "membership_no" => NULL
                  );

                  // SGST A/C Credit ----- 3
                  $voucherDtlArry3 = array(
                     "master_id" => $voucher_master_id,
                     "srl_no" => 3,
                     "tran_tag" => 'Cr',
                     "acc_id" => $sgstAccID,
                     "pay_to_id" => '',
                     "pay_month" => '',
                     "amount_old" => '0.00',
                     "amount" => $sgstTaxAmt,
                     "accountcode" => NULL,
                     "membership_no" => NULL
                  );

                  // Sundry Debtor A/C Debit ----- 4
                  $voucherDtlArry4 = array(
                     "master_id" => $voucher_master_id,
                     "srl_no" => 4,
                     "tran_tag" => 'Dr',
                     "acc_id" => $accountData['mem_account_id'],
                     "pay_to_id" => '',
                     "pay_month" => '',
                     "amount_old" => '0.00',
                     "amount" => $payment_now+$cgstTaxAmt+$sgstTaxAmt,
                     "accountcode" => $accountData['mem_acc_code'],
                     "membership_no" => $accountData['membership_ref']
                  );

                  $voucher_dtl_array = array($voucherDtlArry1,$voucherDtlArry2,$voucherDtlArry3,$voucherDtlArry4);
                  $this->insertIntoVoucherDetailData($voucher_master_id,$voucher_dtl_array);
                  
                  /*----- For Second Voucher Prepare Master Data-----*/
			      	$voucher_serial_B =  $voucher_srl."B";
                  $voucher_no2 = $this->GenerateVoucherNoNew($voucherno_prefix,$voucher_serial_B,$year_id);
                  
                  $voucher_master2 = array(
                                          "srl_no" => $voucher_srl,
                                          "voucher_no" => $voucher_no2,
                                          "voucher_date" => date('Y-m-d',strtotime($payment_date)),
                                          "branch_id" => $branch_id,
                                          "tran_type" => 'REG',
                                          "tran_sub_type" => '',
                                          "pkg_cat" => $card_category ,
                                          "pkg_id" => $card_id,
                                          "pkg_code" =>$card,
                                          "pkg_desc" => $card_desc,
                                          "narration" => $narration,
                                          "cheque_no" => trim($chq_no),
                                          "cheque_date" => $chqDate,
                                          "bank_name" => $bank_name,
                                          "bank_branch" => $branch_name,
                                          "total_dr_amt" => 0,
                                          "total_cr_amt" => 0,
                                          "user_id" => $user_id,
                                          "year_id" => $year_id,
                                          "is_daily_collection" => 'Y',
                                          "company_id" => $company_id
                                       );
            
                  $voucher_master_id_2 =  $this->commondatamodel->insertSingleTableData('voucher_master',$voucher_master2);    

                  	// Sundry Debtor A/C Credit ----- 5
                     $voucherDtlArry5 = array(
                        "master_id" => $voucher_master_id_2,
                        "srl_no" => 1,
                        "tran_tag" => 'Cr',
                        "acc_id" => $accountData['mem_account_id'],
                        "pay_to_id" => '',
                        "pay_month" => '',
                        "amount_old" => '0.00',
                        "amount" => $payment_now+$cgstTaxAmt+$sgstTaxAmt,
                        "accountcode" => $accountData['mem_acc_code'],
                        "membership_no" => $accountData['membership_ref']
                     );

                     // Cash/Bank Debit ----- 6
                     $voucherDtlArry6 = array(
                        "master_id" => $voucher_master_id_2,
                        "srl_no" => 2,
                        "tran_tag" => 'Dr',
                        "acc_id" => $debit_acc_id,
                        "pay_to_id" => '',
                        "pay_month" => '',
                        "amount_old" => '0.00',
                        "amount" => $payment_now+$cgstTaxAmt+$sgstTaxAmt,
                        "accountcode" => NULL,
                        "membership_no" => NULL
                     );

                     $voucher_dtl_array_2 = array($voucherDtlArry5,$voucherDtlArry6);
                    $this->insertIntoVoucherDetailData($voucher_master_id_2,$voucher_dtl_array_2);



               } /* End of Branch Check && Payment Amount greater than 0 */

                /*-------------------------------end of voucher entry  -------------------- */


               /*---------------------get promo amount------------------- */
                       $amt_Deduct=$this->getPromoAmount($_POST,$company_id);
               /* -------------------- payment master data ---------------------- */

                        $insert_payment_arr['MEMBERSHIP_NO']=$mno;
                        $insert_payment_arr['CARD_CODE']=$card;
                        $insert_payment_arr['FROM_DT']=$open_date;
                        $insert_payment_arr['VALID_UPTO']=$valid_upto1;
                        $insert_payment_arr['EXPIRY_DT']=$valid_upto1;

                        $insert_payment_arr['ADMISSION']=$adm;
                        $insert_payment_arr['SUBSCRIPTION']=$subs;

                        $insert_payment_arr['DISCOUNT_CONV']=$disc1;
                        $insert_payment_arr['DISCOUNT_OFFER']=$disc2;
                        $insert_payment_arr['DISCOUNT_NEGO']=$disc3;
                        $insert_payment_arr['NEGO_REMARK']=$nego_disc_rem;
                        $insert_payment_arr['CASHBACK_AMT']=$cashbackamt;


                        $insert_payment_arr['WALLET_AMT']=$amt_Deduct; // added by sandipan on 12.09.2019

                        $insert_payment_arr['PRM_AMOUNT']=$prm;
                        $insert_payment_arr['AMOUNT']=$payment_now;
                        $insert_payment_arr['MNTN_CHG']=0;
                        $insert_payment_arr['DUE_AMOUNT']=$due;
                        $insert_payment_arr['SERVICE_TAX']=NULL;
                        $insert_payment_arr['CGST_RATE_ID']= $cgstRateID;
                        $insert_payment_arr['CGST_AMT']= $cgstTaxAmt;
                        $insert_payment_arr['SGST_RATE_ID']=$sgstRateID;
                        $insert_payment_arr['SGST_AMT']=$sgstTaxAmt;

                        $insert_payment_arr['TOTAL_AMOUNT']=$total_amount;
                        $insert_payment_arr['PAYMENT_DT']=$payment_date;
                        $insert_payment_arr['FRESH_RENEWAL']='F';
                        $insert_payment_arr['BRANCH_CODE']=$branch;
                        $insert_payment_arr['USER_ID']=$user_id;
                        $insert_payment_arr['FIN_ID']=$year_id;
                        $insert_payment_arr['RCPT_NO']=$rcpt_srl;

                        $insert_payment_arr['PAYMENT_MODE']=$payment_mode;
                        $insert_payment_arr['CHQ_NO']=$chq_no;
                        $insert_payment_arr['CHQ_DT']=$chqDate;
                        $insert_payment_arr['BANK_NAME']=$bank_name;
                        $insert_payment_arr['BRANCH_NAME']=$branch_name;
                        $insert_payment_arr['CUST_ID']=$cust_ins_id;
                        $insert_payment_arr['VALIDITY_STRING']=$valid_string;

                     //	$insert_payment_arr['payment_from']='REG';
                        $insert_payment_arr['payment_from'] = $payment_from;
                        $insert_payment_arr['collection_at'] = $collection_at;
                        $insert_payment_arr['collection_branch_id'] = $this->getBranchIDByCompany($collection_at,$company_id);
                        $insert_payment_arr['voucher_master_id'] = $voucher_master_id;
                        $insert_payment_arr['second_voucher_mast_id'] = $voucher_master_id_2;
                        $insert_payment_arr['IS_GST']= $isGST;
                        $insert_payment_arr['company_id'] = $company_id;
                        $insert_payment_arr['corporate_comp_id'] = $_POST['sel_corp_comny'];
                        $insert_payment_arr['branch_id']=$this->getBranchIDByCompany($branch,$company_id);
                        $insert_payment_arr['card_id']=$this->getCardIDByCompany($card,$company_id);
                        if($entry_mode=='WC' && $is_converted=="Y")
                        {
                           $insert_payment_arr['covid_extention_days']=$covideextensiondays;
                        }

                        $pmt_ins_id =$this->commondatamodel->insertSingleTableData('payment_master',$insert_payment_arr); 
                        if($entry_mode=='WC' && $is_converted=="Y" && $covideextensiondays > 0)
                        {
                        $covid_deatils = array( 
                           'mobile_no'=>$phone,
                           'membership_no'=>$mno,
                           'validity_string'=>$valid_string,
                           'entry_date'=>date('Y-m-d'),
                           'payment_id'=>$pmt_ins_id,
                           'covid_days'=>$covideextensiondays
                        );
                        
                        $covid = $this->commondatamodel->insertSingleTableData('covid_extension_details',$covid_deatils); 
                        }   
                        
                       $extMemberId=$_POST['old_mem'];;
                       $upd_cashbck_admn['is_redeemed']='Y';
                       /*-------------------------- update CashBckAdminConversion -------------------------------- */
                       $where = array('member_id' => $extMemberId,'is_redeemed' => 'N');
                       $upd_cash_bck_admin = $this->commondatamodel->updateSingleTableData('cash_back_admin',$upd_cashbck_admn,$where);
                       
                       $where_cus = array('CUS_ID'=>$cust_ins_id);
                       $upd_customer = array('PAYMENT_ID'=>$pmt_ins_id);
                       $this->commondatamodel->updateSingleTableData('customer_master',$upd_customer,$where_cus);
                       
                       /*-------------------------- update voucher master -------------------------------- */
                       $this-> updateVoucherMasterPaymentId($pmt_ins_id,$voucher_master_id);
                       $this-> updateVoucherMasterPaymentId($pmt_ins_id,$voucher_master_id_2);

                       $this->calmemberAmountDistribution($mno,$branch,$card,$open_date,$valid_upto1,$valid_string,$prm,$pmt_ins_id,$company_id);

                       $this->insertCashBack($_POST,$mno,$valid_string,$valid_upto1,$is_compl,$pmt_ins_id,$company_id);

                       $this->insertIntoInstallment($_POST,$cust_ins_id,$pmt_ins_id,$mno,$valid_string,$branch,$card,$company_id);

                       $this->insertIntoMemberCompliment($cust_ins_id,$mno,$valid_string,$branch,$card,$company_id);

                       $isSms= $this->isSmsFacility($company_id);
                       $sent_msg = 'N';
                        if($isSms=='Y'){

                           $message = "Thank you for being part of Mantra family.Your Membership no. is ".$mno.". Please use the same for any further communication.";
                           $sent_msg = mantraSend($phone,$message);
                        }

                         if($cust_ins_id){
                           $json_response = array(
                                 "msg_status" => 1,
                                 "mode"=>$mode, 
                                 "cust_ins_id"=>$cust_ins_id, 
                                 "pmt_ins_id"=>$pmt_ins_id, 
                                 "msg_data" => "Save Successfully",
                                 'sent_msg'=>$sent_msg
                                       
                           );
                           } else{
                           $json_response = array(
                                 "msg_status" => 0,
                                 "msg_data" => "There is some problem while updating ...Please try again."
                     
                           );
                        } 



         }else{

         }






         
           header('Content-Type: application/json');
           echo json_encode( $json_response );
           exit; 

      }else{
            redirect('admin','refresh');
      }


   }



   public function gen_serial_brn($branch,$card,$company){
      $srl=1;       
      
      $result = $this->reg_model->getSerialBranch($branch,$card,$company);  
      
      if($result){
		   $srl=$result->SRL_NO+1;
      }
      return $srl;
   }


 public function gen_mem_no_pad($branch,$card,$srl,$company)
{

     $zero=''; 

      $short_name = $this->commondatamodel->getSingleRowByWhereCls('company_master',array('comany_id'=>$company))->short_name; 
      $srl_len=strlen($srl);
      $rem_len=8-$srl_len;
      for ($i=1; $i<=$rem_len; $i++)
      {
         $zero=$zero."0";
      }
      $mSrl_no_txt=$short_name.$branch.$card.$zero.$srl;

      return $mSrl_no_txt;
}




function chekFromData($postdata,$val){
   $blank=null;
   if(isset($postdata[$val])){return $postdata[$val];}else{return $blank;}
}


/* Generating validity period */
public function generateValidityString($entry_mode,$is_converted,$ext_mem_no,$reg_dt,$card,$phone,$company_id){

   
	$duration=$this->reg_model->get_duration($card,$company_id);
	$covideextensiondays = 0;
   
	if($entry_mode=='WC' && $is_converted=="Y")
	{
         $row_validity = $this->reg_model->getValidityForConversion($ext_mem_no);
         $from_dt = $row_validity->FROM_DT;
			$valid_upto = $row_validity->VALID_UPTO;
			$validity_str = $row_validity->VALIDITY_STRING;

         $grantDys = 0;
         $plusDays = 1;
         $curr_date = date('Y-m-d');
         $rowGrantDays = $this->reg_model->getMemberExtension($ext_mem_no,$validity_str);
         if ($rowGrantDays) {
            $grantDys = $rowGrantDays->grant_days;
         }


         $actualExpiryDt =  date('Y-m-d', strtotime($valid_upto. ' + '.$grantDys.' days'));

         if($actualExpiryDt>$curr_date)
         {
            $StartDate = date('Y-m-d', strtotime($actualExpiryDt. ' + '.$plusDays.' days'));
         }
         else
         {
            //$StartDate = $_POST['txt_reg_dt'];
            $StartDate = $reg_dt;
         }

         
         $notextendforcovid = $this->reg_model->Notextendcoviddays($card,$company_id);
         $getcovidDetail = $this->reg_model->getexistingcovidDetail($phone);
         $pre_from_date = $from_dt;
         $pre_to_date = $actualExpiryDt;

               if($pre_to_date > '2020-03-20'){
               if($getcovidDetail == 0){
               if($notextendforcovid == 1){
                  $covideextensiondays = 0;
               }else{
                  $covideextensiondays = $this->reg_model->getlossDaysInCovid($pre_from_date,$pre_to_date);
               }

            }else{
               $covideextensiondays = 0;
            }
               }else{
                  $covideextensiondays = 0;
               }
	}
	else
	{
		//$StartDate = $_POST['txt_reg_dt'];
	   $StartDate = $reg_dt;
		$covideextensiondays = 0;
   }
   
   $open_date=date("Y-m-d",strtotime($StartDate));

	$opening_date = explode("-",$open_date);
	$valid_upto1 = date('Y-m-d',strtotime('+'.$duration+$covideextensiondays.' day',mktime(0,0,0,$opening_date[1],$opening_date[2],$opening_date[0])));

   $valid_string = $open_date." - ".$valid_upto1;

   return $result = array(
                     'open_date' => $open_date,
                     'valid_string' => $valid_string,
                     'covideextensiondays' => $covideextensiondays,
                     'valid_upto1' => $valid_upto1,
                   );

                 


   // echo "<br>";
	// echo "covid ".$covideextensiondays;
	// echo "<br>";
	// echo "Start Date ".$StartDate;
	// echo "<br>";
	// echo "Valid Upto ".$valid_upto1;
	// echo "<br>";
	// echo "Validity Period ".$valid_string;
	// echo "<br>";
	// exit;

}

public function getMemberAccountCode($mobile,$company){


$memberData = $this->commondatamodel->getSingleRowByWhereCls('customer_master',array('CUS_PHONE'=>$mobile));

   if($memberData){
      $account_code = $memberData->member_acc_code;
      if ($account_code=='') {
        $account_code = $this->getAccountNewCode($company);
      }
   }else{
        $account_code = $this->getAccountNewCode($company);
   }

   return $account_code;
}

public function getAccountNewCode($company){
   $padding = "";
   $membercode = "";
   
      $rowSerialData = $this->reg_model->getLastSerialNoForMemCode($company);  
      $max_srl_no = $rowSerialData->latest_srl;
		$srl_tbl_id = $rowSerialData->id;
      $startLetter = $rowSerialData->short_name;
      
      $new_serial = $max_srl_no+1;
      $length = ceil(log10(abs($max_srl_no) + 1));

      if($length==1){ $padding="00000"; }
      if($length==2){ $padding="0000"; }
      if($length==3){ $padding="000"; }
      if($length==4){ $padding="00"; }
      if($length==5){ $padding="0"; }
      if($length==6){ $padding=""; }

      $membercode = $startLetter.$padding.$new_serial;
      $update_arr = array(
		"latest_srl" => $new_serial
	   );
      $where = array('serial_table.id' => $srl_tbl_id );
      $upd_inser = $this->commondatamodel->updateSingleTableData('serial_table',$update_arr,$where);
   
      return $membercode;
}

function getMemberAccountsDetails($postdata,$ext_mem_no,$ext_mem_id,$entry_mode,$account_code,$mno,$company_id){

      $mem_account_id = NULL;
      $mem_acc_code = NULL;
      $membership_ref = NULL;

   	if($ext_mem_no!="" && $ext_mem_id!=0 && $entry_mode=='WC')
      {
         $rowRegData = $this->reg_model->getRegistrationData($ext_mem_id);
         if ($rowRegData) {
           $corporate_comp_id = $rowRegData->corporate_comp_id;
         }

         if($corporate_comp_id > 0)
         {
            $rowCorporateComp = $this->reg_model->getCorporateCompanyData($corporate_comp_id);
               if ($rowCorporateComp) {
                  $mem_account_id = $rowCorporateComp->account_id;
                  $mem_acc_code = NULL;
                  $membership_ref = NULL;
               }
         }
         else
         {
               $sundry_debtor = "Sundry Debtor";
               $rowGetSundDebAcc = $this->reg_model->getAccountIDBydesc($sundry_debtor,$company_id);
               if($rowGetSundDebAcc)
               {
                  $mem_account_id = $rowGetSundDebAcc->account_id; //Account ID Consider for Member
                  $mem_acc_code = $account_code;
                  $membership_ref = $mno;
               }
         }
      }

      else
         {

            if(isset($postdata['sel_corp_comny']) && $postdata['sel_corp_comny']>0)
            {
               $rowCorporateComp = $this->reg_model->getCorporateCompanyData($postdata['sel_corp_comny']);
               if($rowCorporateComp)
               {
                  $mem_account_id = $rowCorporateComp->account_id;
                  $mem_acc_code = NULL;
                  $membership_ref = NULL;
               }
            }
            else
            {
                $sundry_debtor = "Sundry Debtor";              
                $rowGetSundDebAcc = $this->reg_model->getAccountIDBydesc($sundry_debtor,$company_id);
               if($rowGetSundDebAcc)
               {
                  $mem_account_id = $rowGetSundDebAcc->account_id; //Account ID Consider for Member
                  $mem_acc_code = $account_code;
                  $membership_ref = $mno;
               }
            }
         }

         return array('mem_account_id' => $mem_account_id,
                        'mem_acc_code' => $mem_acc_code,
                        'membership_ref' => $membership_ref,
                         );

}



public function GenerateVoucherNoNew($from,$serial,$yrID){

	   $rowYear = $this->commondatamodel->getSingleRowByWhereCls('year_master',array('year_id'=>$yrID));
      $startingYear=date("y", strtotime($rowYear->starting_date));
      $endingYear=date("y", strtotime($rowYear->ending_date));
		$year = $startingYear."-".$endingYear;
      $vocherno = $from."/".$serial."/".$year;
      return $vocherno;

}


   
   public  function getOnSaleCashBack() { 
        
         $session = $this->session->userdata('mantra_user_detail');
         if($this->session->userdata('mantra_user_detail'))
         {     
                $branch = $this->input->post('branch');               
                $card_code = $this->input->post('card_code');               
                $company_id = $session['companyid'];
                $amount=0;

                $rowGetCashbackOnSale = $this->reg_model->getCashBackOnSaleAmt($branch,$card_code,$company_id);

                if($rowGetCashbackOnSale){
                  $amount = $rowGetCashbackOnSale->cashback_amt;
                }
            
		         echo $amount;


         }else{
            redirect('admin','refresh');
      }

   }


   public function insertIntoVoucherDetailData($voucher_master_id,$voucherDtlArry){

      /* ----------------- delete voucher details ------------------------*/
      $where_voucher_master = array('master_id' => $voucher_master_id);
      $this->commondatamodel->deleteTableData('voucher_detail',$where_voucher_master);
      foreach ($voucherDtlArry as $value) {
      $this->commondatamodel->insertSingleTableData('voucher_detail',$value); 
      } 
      /* Updating total debit and total credit to voucher master */
      $totalDebit = $this->reg_model->getVoucherDetailsTotalAmount($voucher_master_id,'Dr');
      $totalCredit = $this->reg_model->getVoucherDetailsTotalAmount($voucher_master_id,'Cr');
      /* update voucher master amount */
      $update_array = array('total_dr_amt' => $totalDebit,'total_cr_amt' => $totalCredit );
      $where = array('id' => $voucher_master_id);
      $upd_insert = $this->commondatamodel->updateSingleTableData('voucher_master',$update_array,$where);

   }

   public function getPromoAmount($postdata,$company_id){
      $promoAmt=0;
      $subs=$postdata['txt_subscription'];
         if(isset($postdata['promo']) && $postdata['promo']!='0')
         {
            $promoarray = explode('_',$postdata['promo']);
            $is_promo = $promoarray[0];
            $promo_id = $promoarray[1];
            if($is_promo == 'Y'){

               $promoData=$this->commondatamodel->getSingleRowByWhereCls('promo_master',array('id'=>$promo_id,'company_id'=>$company_id));
               if($promoData){$promoAmt =$promoAmt->amount;}

            } else{
               $promoAmt=$postdata['reducecase'];
            }

            if($promoAmt>$subs) // if promo balance is greater then packge/product price
            {
               $Deduct=$subs;
            }else{
               $Deduct=$promoAmt;
            }
            $amt_Deduct=$Deduct;
         }else{
            $amt_Deduct=0;
         }


         return $amt_Deduct;

   }


   public function updateVoucherMasterPaymentId($pmt_ins_id,$voucher_master_id){
      	$upd_voucher_master = array("parent_payment_id" => $pmt_ins_id);
         $where = array('id' => $voucher_master_id);
         $this->commondatamodel->updateSingleTableData('voucher_master',$upd_voucher_master,$where);
   }

public function calmemberAmountDistribution($mem,$branch,$card,$fdate,$tdate,$valdstr,$packgamount,$payment_id,$compid)
   {

      $from_dt = $fdate; 
      $to_date = $tdate; 
      

      $arr_months = array();   //2020-04-01 to 2020-10-31
      $date1 = new DateTime($from_dt);
      $date2 = new DateTime($to_date);
      $month1 = new DateTime($date1->format('Y-m')); //The first day of the month of date 1



      while ($month1 < $date2) { 
         $arr_months[$month1->format('Y-m-t')] = cal_days_in_month(CAL_GREGORIAN, $month1->format('m'), $month1->format('Y')); //Add it to the array
         $month1->modify('+1 month'); 
         }
  

        // pre($month1);
        // pre($arr_months);

         $days_no = 0;
         $distAmount = 0;
         $insert_array = array();
         $fdate = array_keys($arr_months);
         $fdate = reset($fdate);

         $last_date = array_keys($arr_months);
         $last_date = end($last_date);


        $fisrt_dy_last_month = date('Y-m-01',strtotime($last_date));

      

         $total_package_dy = $this->getNoOfDays(date('Y-m-d',strtotime($from_dt)),date('Y-m-d',strtotime($to_date)));
         //pre($arr_months);
         foreach ($arr_months as $key => $value) 
         {
            if($key==$fdate)
            {
               $days_no = $this->getNoOfDays(date('Y-m-d',strtotime($fdate)),date('Y-m-d',strtotime($from_dt)));
               
            }
            elseif($key==$last_date)
            {
               $days_no =  $this->getNoOfDays(date('Y-m-d',strtotime($to_date)),date('Y-m-d',strtotime($fisrt_dy_last_month)))+1;
            }
            else
            {
               $days_no = $value;
            }
            

            $distAmount = $this->getDistributedAmtForMonths($total_package_dy,$days_no,$packgamount);
            $insert_array = array(
                           "membership_no" => $mem,
                           "valid_from" => date('Y-m-d',strtotime($fdate)),
                           "valid_to" => date('Y-m-d',strtotime($tdate)),
                           "branch" => $branch,
                           "card_code" =>$card,
                           "no_of_days" => $days_no,
                           "for_month" =>  date('M',strtotime($key)),
                           "for_year" => date('Y',strtotime($key)),
                           "date_for_month" => $key,
                           "process_on" => date('Y-m-d'),
                           "amount" => $distAmount,
                           "total_package_amt" => $packgamount,
                           "validity_string" => $valdstr,
                           "payment_id" => $payment_id,
                           "company_id" => $compid
            );
            
            /*echo "<pre>";
            print_r($insert_array);
            echo "<pre>";*/

            
              $covid = $this->commondatamodel->insertSingleTableData('member_per_month_service_detail',$insert_array); 
         }


   }

public function getNoOfDays($fdate,$tdate)
{
	$days = 0;
	$date1 = new DateTime($fdate);
	$date2 = new DateTime($tdate);
	$days = $date2->diff($date1)->format("%a");
	return $days;
	
}

public function getDistributedAmtForMonths($total_package_dy,$daysno,$ttlamt)
{

   $dist_Amount = 0;
   

	$dist_Amount = ($ttlamt*$daysno)/$total_package_dy;
	//$dist_Amount = number_format($dist_Amount,2);
 	return $dist_Amount;
}


public function insertCashBack($postdata,$mno,$valid_string,$valid_upto1,$is_compl,$pmt_ins_id,$company){
             $branch=$postdata['sel_branch'];
             $card=$postdata['sel_card'];
             $phone=$postdata['txt_phone'];
             $subs=$postdata['txt_subscription'];

               $caseback_assign_to_mem_arr = array();
               $cashbck_pmnt_dtl_arr = array();

             
               $on_sale_cash_bckmaster = $this->wallet_model->getOnSaleCashBackAmtandId($branch,$card,$company);
             //  pre($on_sale_cash_bckmaster);
               if(!empty($on_sale_cash_bckmaster)){

                  $cardcaseback = $on_sale_cash_bckmaster->cashback_amt;
                  $cardcasebackId = $on_sale_cash_bckmaster->id;
                  $cardbranch = $on_sale_cash_bckmaster->branch;

               }else{ 
                  $cardcaseback = "";
                  $cardcasebackId ="";
                  $cardbranch ="";
               }


                  //caseback assign for member
                  $is_promo = 'N';
                  $caseback_assign_to_mem_arr['mobile_no'] = $phone;
                  $caseback_assign_to_mem_arr['branch_code'] = $cardbranch;

                  $caseback_assign_to_mem_arr['transaction_id']=$cardcasebackId;
                  $caseback_assign_to_mem_arr['is_promo']= $is_promo;
                  $caseback_assign_to_mem_arr['is_expired']='N';
                  $caseback_assign_to_mem_arr['member_acc_code']=$postdata['memberAccCode'];
                  $caseback_assign_to_mem_arr['membership_no']=$mno;
                  $caseback_assign_to_mem_arr['validity_string']=$valid_string;
                  $caseback_assign_to_mem_arr['expire_dt']=$valid_upto1;

                  //caseback in dtl table
                  $cashbck_pmnt_dtl_arr['promo_cashback_id']= $cardcasebackId;
                  $cashbck_pmnt_dtl_arr['mobile_no']= $phone;
                  $cashbck_pmnt_dtl_arr['amount']=$cardcaseback;
                  $cashbck_pmnt_dtl_arr['payment_id']=NULL ;
                  $cashbck_pmnt_dtl_arr['is_debit']='N' ;
                  $cashbck_pmnt_dtl_arr['tran_module']='REG';
                  $cashbck_pmnt_dtl_arr['case_dtl_type']='For Purchasing '.$card.' Package';
                  $cashbck_pmnt_dtl_arr['member_acc_code']=$postdata['memberAccCode'];
                  $cashbck_pmnt_dtl_arr['membership_no']=$mno;
                  $cashbck_pmnt_dtl_arr['validity_string']=$valid_string;
                  $cashbck_pmnt_dtl_arr['expire_dt']=$valid_upto1;

   if($is_compl == 'N'){
        
         if($postdata['walletchenge'] == 'Y'){

               if($postdata['promo'] != '0')
               {

                        $promoarray = explode('_',$postdata['promo']);
                        $is_promo = $promoarray[0];
                        /* start I we are using Promo */
                        if($is_promo == 'Y'){
                                             $promo_id = $promoarray[1];
                                             $promo_cashbck_pmnt_dtl_arr=array();
                                             $promo_amt=$this->wallet_model->getPromodetailByIdnew($promo_id);
                                             if($promo_amt>$subs)
                                             {
                                                $amount_Deduct=$subs;
                                                $promo_crnt_amt=$promo_amt-$subs;
                                             }else{
                                                $amount_Deduct=$promo_amt;
                                                $promo_crnt_amt=0;
                                             }
                                             /* insert into promo_cashbck_pmnt_dtl */
                                             $promo_cashbck_pmnt_dtl_arr['promo_cashback_id']= $promo_id;
                                             $promo_cashbck_pmnt_dtl_arr['mobile_no']= $phone;
                                             $promo_cashbck_pmnt_dtl_arr['amount']=$amount_Deduct;
                                             $promo_cashbck_pmnt_dtl_arr['payment_id']=$pmt_ins_id ;
                                             $promo_cashbck_pmnt_dtl_arr['is_debit']='Y' ;
                                             $promo_cashbck_pmnt_dtl_arr['tran_module']='REG';
                                             $promo_cashbck_pmnt_dtl_arr['promo_cashback_assign_id']='0';
                                             $promo_cashbck_pmnt_dtl_arr['member_acc_code']=$postdata['memberAccCode'];//added by anil on 20-11-2019
                                             //$promo_cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$promo_id; //add by anil on 19-11-2019

                                             $promo_cashbck_pmnt_dtl_arr['membership_no']=$mno;
                                             $promo_cashbck_pmnt_dtl_arr['validity_string']=$valid_string;
                                             $promo_cashbck_pmnt_dtl_arr['expire_dt']=$valid_upto1;
                                             $promo_cashbck_pmnt_dtl_arr['company_id']=$company;

                                          // $obj_inc_wlt->InsertIntoPromoCashBckPaymntDtlTbl($promo_cashbck_pmnt_dtl_arr);
                                             $this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$promo_cashbck_pmnt_dtl_arr); 
                                             /*- insert into promo_cashbck_pmnt_dtl end -*/


                                             /* update promo_cashbck_assign_to_mem */
                                             $promo_cashbck_assign_to_mem_arr=array();
                                             $promo_cashbck_assign_to_mem_arr['amount']=$promo_crnt_amt;
                                             $promo_cashbck_assign_to_mem_arr['member_acc_code']=$postdata['memberAccCode'];//added by anil on 20-11-2019

                                             $this->UpdatePromoAmountForWallet($promo_cashbck_assign_to_mem_arr,$phone,$promo_id);

                                                /* Start Send SMS */

                                                   //  $message = "INR ".$amount_Deduct." credited to your Wallet on ".date('d-m-Y')." for purchasing ".$card." package";
                                                   // $sms_stat=send_caseback_sms('8910088950',$message);

                                             /* End Send SMS */

                                 /* Start If Cashback is available and using promo caseback */

                                 if($cardcaseback != ''){
                                       $member_acc_code = $postdata['memberAccCode'];
                                       $amount_Deduct = $cardcaseback;
                                      // $getwithoutexpirecash = $obj_inc_wlt->getwithoutexpirecaseback($member_acc_code);
                                       $getwithoutexpirecash = $this->wallet_model->getwithoutexpirecaseback($member_acc_code);
                                      // $getexistscaseback = $obj_inc_wlt->getexistscaseback($member_acc_code);
                                       $getexistscaseback = $this->wallet_model->getexistscaseback($member_acc_code);

                                             if(!empty($getwithoutexpirecash)){

                                                      $pre_caseback_amt = $getwithoutexpirecash->amount;
                                                      $caseback_assign_id = $getwithoutexpirecash->id;
                                                      $amount_Deduct = $pre_caseback_amt +  $cardcaseback;
                                                      $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;

                                                      $update_caseback = $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$member_acc_code);

                                                      $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;
                                                     // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                                                      $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 

                                             }else{

                                                   $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;

                                                   if(!empty($getexistscaseback)){

                                                      $pre_caseback_amt = $getexistscaseback->amount;
                                                      $caseback_assign_id = $getexistscaseback->id;

                                                      $update_caseback = $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$member_acc_code);

                                                      //for expire amount
                                                      $cashbck_pmnt_dtl_arr['amount']=$pre_caseback_amt;
                                                      $cashbck_pmnt_dtl_arr['case_dtl_type']='CashBack Expire';
                                                      $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;
                                                      $cashbck_pmnt_dtl_arr['is_debit']='Y' ;
                                                      $cashbck_pmnt_dtl_arr['membership_no']=$getexistscaseback->membership_no;
                                                      $cashbck_pmnt_dtl_arr['validity_string']=$getexistscaseback->validity_string;
                                                      $cashbck_pmnt_dtl_arr['expire_dt']=$getexistscaseback->expire_dt;
                                                     // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                                                      $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 

                                                      //for new cashback
                                                      $cashbck_pmnt_dtl_arr['amount']=$cardcaseback;
                                                      $cashbck_pmnt_dtl_arr['case_dtl_type']='For Purchasing '.$card.' Package';
                                                      $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;
                                                      $cashbck_pmnt_dtl_arr['membership_no']=$mno;
                                                      $cashbck_pmnt_dtl_arr['validity_string']=$valid_string;
                                                      $cashbck_pmnt_dtl_arr['expire_dt']=$valid_upto1;
                                                    //  $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                                                      $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 


                                                      }else{

                                                       //  $insertcaseassign = $obj_inc_wlt->InsertIntoCashBckPaymt($caseback_assign_to_mem_arr);
                                                         $insertcaseassign = $this->commondatamodel->insertSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr); 

                                                         $caseback_assign_id = $insertcaseassign;
                                                         $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;
                                                        // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                                                         $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 

                                                         
                                                      }


                                          }

                                       /* Start Send SMS */

                                          // $message = "INR ".$cardcaseback." credited to your Wallet on ".date('d-m-Y')." for purchasing ".$card." package";
                                          // $sms_stat=send_caseback_sms('8910088950',$message);

                                       /* End Send SMS */

                                    }else{

                                    $member_acc_code = $postdata['memberAccCode'];
                                   // $getwithoutexpirecash = $obj_inc_wlt->getwithoutexpirecaseback($member_acc_code);
                                    $getwithoutexpirecash = $this->wallet_model->getwithoutexpirecaseback($member_acc_code);
                                   // $getexistscaseback = $obj_inc_wlt->getexistscaseback($member_acc_code);
                                    $getexistscaseback = $this->wallet_model->getexistscaseback($member_acc_code);

                                                if(!empty($getwithoutexpirecash)){
                                                   $caseback_assign_to_mem_arr['branch_code'] = $getwithoutexpirecash->branch_code;
                                                   $caseback_assign_to_mem_arr['transaction_id']=$getwithoutexpirecash->transaction_id;
                                                   $update_caseback = $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$member_acc_code);

                                                }else{

                                                $caseback_assign_to_mem_arr['amount'] = 0;

                                                if(!empty($getexistscaseback)){

                                                   $caseback_assign_to_mem_arr['branch_code'] = $getexistscaseback->branch_code;
                                                   $caseback_assign_to_mem_arr['transaction_id']=$getexistscaseback->transaction_id;
                                                 
                                                   $cur_caseback_amt = $getexistscaseback->amount;
                                                   $caseback_assign_id = $getexistscaseback->id;
                                                   $update_caseback = $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$member_acc_code);

                                                   //for expire amount
                                                   $cashbck_pmnt_dtl_arr['amount']=$cur_caseback_amt;
                                                   $cashbck_pmnt_dtl_arr['case_dtl_type']='CashBack Expire';
                                                   $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$getexistscaseback->transaction_id;
                                                   $cashbck_pmnt_dtl_arr['is_debit']='Y';
                                                   $cashbck_pmnt_dtl_arr['membership_no']=$getexistscaseback->membership_no;
                                                   $cashbck_pmnt_dtl_arr['validity_string']=$getexistscaseback->validity_string;
                                                   $cashbck_pmnt_dtl_arr['expire_dt']=$getexistscaseback->expire_dt;
                                                  // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);

                                                   $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 


                                                }


                                             }

                                    }

                              $this->addReferralcase($postdata,$branch,$card,$mno,$company);

                           /* End If Cashback is available and using promo caseback */



                        }/* End If we are using Promo */
                        /* Start Using Caseback */
                        else{

                              $is_promo = 'N';
                              $caseback_id = $promoarray[1];
                              //$caseback_amt = $obj_inc_wlt->getCashbackdetailById($caseback_id);
                              $caseback_amt = $this->wallet_model->getCashbackdetailById($caseback_id);
                              

                              $getexistscaseback = $this->wallet_model->getexistscasebackfromassign($caseback_id);

                             
                              if(!empty($getexistscaseback)){
                                    $transaction_id = $getexistscaseback->transaction_id;
                                    $barnch_cd =  $getexistscaseback->branch_code;
                              }

                              //caseback assign table

                              $caseback_assign_to_mem_arr['mobile_no'] = $phone;
                              $caseback_assign_to_mem_arr['branch_code'] = $cardbranch;

                              $caseback_assign_to_mem_arr['transaction_id']=$cardcasebackId;
                              $caseback_assign_to_mem_arr['is_promo']= $is_promo;
                              $caseback_assign_to_mem_arr['is_expired']='N';
                              $caseback_assign_to_mem_arr['member_acc_code']=$postdata['memberAccCode'];
                              $caseback_assign_to_mem_arr['membership_no']=$mno;
                              $caseback_assign_to_mem_arr['validity_string']=$valid_string;
                              $caseback_assign_to_mem_arr['expire_dt']=$valid_upto1;

                           //caseback detail table

                              $cashbck_pmnt_dtl_arr['promo_cashback_id']= $cardcasebackId;
                              $cashbck_pmnt_dtl_arr['mobile_no']= $phone;

                              $cashbck_pmnt_dtl_arr['payment_id']=$pmt_ins_id;
                              $cashbck_pmnt_dtl_arr['is_debit']='Y' ;
                              $cashbck_pmnt_dtl_arr['tran_module']='REG';
                              $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_id;
                              $cashbck_pmnt_dtl_arr['case_dtl_type']='For Purchasing '.$card.' Package';
                              $cashbck_pmnt_dtl_arr['member_acc_code']=$postdata['memberAccCode'];
                              //added by anil on 22-04-2020
                              $cashbck_pmnt_dtl_arr['membership_no']=$mno;
                              $cashbck_pmnt_dtl_arr['validity_string']=$valid_string;
                              $cashbck_pmnt_dtl_arr['expire_dt']=$valid_upto1;

                           if($cardcaseback != ''){

                              $reduceinput = $postdata['reducecase'];
                              $totalcaseback = 	$caseback_amt;
                              $remaincase = $totalcaseback -  $reduceinput;
                              $amount_Deduct =  $remaincase +  $cardcaseback;
                              $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;
                              $cashbck_pmnt_dtl_arr['amount']=$reduceinput;

                              //added by anil on 22-04-2020
                              $cashbck_pmnt_dtl_arr['membership_no']=$getexistscaseback->membership_no;
                              $cashbck_pmnt_dtl_arr['validity_string']=$getexistscaseback->validity_string;
                              $cashbck_pmnt_dtl_arr['expire_dt']=$getexistscaseback->expire_dt;

                              $update_caseback = $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$postdata['memberAccCode']);

                              // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                              $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 

                              /* Start Send SMS */

                                 // $message = "INR ".$reduceinput." debited to your Wallet on ".date('d-m-Y')." for purchasing ".$card." package";
                                 // $sms_stat=send_caseback_sms('8910088950',$message);

                              /* End Send SMS */


                              $cashbck_pmnt_dtl_arr['amount']=$cardcaseback;
                              $cashbck_pmnt_dtl_arr['payment_id']=NULL;
                              $cashbck_pmnt_dtl_arr['is_debit']='N' ;
                              //added by anil on 22-04-2020
                              $cashbck_pmnt_dtl_arr['membership_no']=$mno;
                              $cashbck_pmnt_dtl_arr['validity_string']=$valid_string;
                              $cashbck_pmnt_dtl_arr['expire_dt']=$valid_upto1;
                             // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);

                              $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);
                              

                              /* Start Send SMS */

                                 // $message = "INR ".$cardcaseback." credited to your Wallet on ".date('d-m-Y')." for purchasing ".$card." package";
                                 // $sms_stat=send_caseback_sms('8910088950',$message);

                              /* End Send SMS */

                           }else{
                              $caseback_id = $promoarray[1];
                             // $caseback_amt = $obj_inc_wlt->getCashbackdetailById($caseback_id);
                              $caseback_amt = $this->wallet_model->getCashbackdetailById($caseback_id);
                              $totalcaseback = 	$caseback_amt;
                              $reduceinput = $postdata['reducecase'];
                              $amount_Deduct = $totalcaseback -  $reduceinput;

                              $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;
                              $caseback_assign_to_mem_arr['branch_code'] = $barnch_cd;

                              $caseback_assign_to_mem_arr['transaction_id']=$transaction_id;
                              $cashbck_pmnt_dtl_arr['promo_cashback_id']= $transaction_id;
                              $cashbck_pmnt_dtl_arr['amount']=$reduceinput;
                              //added by anil on 22-04-2020
                              $cashbck_pmnt_dtl_arr['membership_no']=$getexistscaseback->membership_no;
                              $cashbck_pmnt_dtl_arr['validity_string']=$getexistscaseback->validity_string;
                              $cashbck_pmnt_dtl_arr['expire_dt']=$getexistscaseback->expire_dt;

                             // $update_caseback = $obj_inc_wlt->UpdateCaseBackamtWallet($caseback_assign_to_mem_arr,$caseback_id);
                             
                              $update_caseback =$this->commondatamodel->updateSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr,array('id' => $caseback_id ));

                                // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                              $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);

                              /* Start Send SMS */
                                 // $message = "INR ".$reduceinput." debited to your Wallet on ".date('d-m-Y')." for purchasing ".$card." package";
                                 // $sms_stat=send_caseback_sms('8910088950',$message);
                              /* End Send SMS */

                           }



                           $this->addReferralcase($postdata,$branch,$card,$mno,$company);

                        }



                  }
         }   /* End Using Caseback */

            /* start using No promo and no case back*/
         else{


            if($cardcaseback != ''){
                  $member_acc_code = $postdata['memberAccCode'];
                  $amount_Deduct = $cardcaseback;
                  $is_promo = 'N';
                 // $getexistscaseback = $obj_inc_wlt->getexistscaseback($account_code);
                  $getexistscaseback = $this->wallet_model->getexistscaseback($member_acc_code);
                  $getexistscasebackgreterzero = $this->wallet_model->getexistscasebackgreterzero($member_acc_code);

                  //caseback assign for member
                  $caseback_assign_to_mem_arr['mobile_no'] = $phone;
                  $caseback_assign_to_mem_arr['branch_code'] = $cardbranch;

                  $caseback_assign_to_mem_arr['transaction_id']=$cardcasebackId;
                  $caseback_assign_to_mem_arr['is_promo']= $is_promo;
                  $caseback_assign_to_mem_arr['is_expired']='N';
                  $caseback_assign_to_mem_arr['member_acc_code']=$member_acc_code;
               //added by anil on 22-04-2020
                  $caseback_assign_to_mem_arr['membership_no']=$mno;
                  $caseback_assign_to_mem_arr['validity_string']=$valid_string;
                  $caseback_assign_to_mem_arr['expire_dt']=$valid_upto1;

                  if(!empty($getexistscaseback)){


                     $pre_caseback_amt = $getexistscaseback->amount;
                     $caseback_assign_id = $getexistscaseback->id;


                     $amount_Deduct =$cardcaseback;


                     $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;


                     $update_caseback = $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$member_acc_code);


                  }else{


                     $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;                
                     $caseback_assign_id = $this->commondatamodel->insertSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr); 
                     // $insertcaseassign = $obj_inc_wlt->InsertIntoCashBckPaymt($caseback_assign_to_mem_arr);
                     // $caseback_assign_id = mysqli_insert_id();


                  }

                  if(!empty($getexistscasebackgreterzero)){

                        //caseback in dtl table
                     $cashbck_pmnt_dtl_arr['promo_cashback_id']= $getexistscasebackgreterzero->transaction_id;
                     $cashbck_pmnt_dtl_arr['mobile_no']= $phone;
                     $cashbck_pmnt_dtl_arr['amount']=$getexistscasebackgreterzero->amount;
                     $cashbck_pmnt_dtl_arr['payment_id']=NULL ;
                     $cashbck_pmnt_dtl_arr['is_debit']='Y';
                     $cashbck_pmnt_dtl_arr['tran_module']='REG';
                     $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$getexistscasebackgreterzero->id;
                     $cashbck_pmnt_dtl_arr['case_dtl_type']='Cash Back Expire';
                     $cashbck_pmnt_dtl_arr['member_acc_code']=$member_acc_code;
                     $cashbck_pmnt_dtl_arr['membership_no']=$getexistscasebackgreterzero->membership_no;
                     $cashbck_pmnt_dtl_arr['validity_string']=$getexistscasebackgreterzero->validity_string;
                     $cashbck_pmnt_dtl_arr['expire_dt']=$getexistscasebackgreterzero->expire_dt;

                    // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                     $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);
                  }

                  //caseback in dtl table
                  $cashbck_pmnt_dtl_arr['promo_cashback_id']= $cardcasebackId;
                  $cashbck_pmnt_dtl_arr['mobile_no']= $phone;
                  $cashbck_pmnt_dtl_arr['amount']=$cardcaseback;
                  $cashbck_pmnt_dtl_arr['payment_id']=NULL ;
                  $cashbck_pmnt_dtl_arr['is_debit']='N';
                  $cashbck_pmnt_dtl_arr['tran_module']='REG';
                  $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;
                  $cashbck_pmnt_dtl_arr['case_dtl_type']='For Purchasing '.$card.' Package';
                  $cashbck_pmnt_dtl_arr['member_acc_code']=$member_acc_code;
                  //added by anil on 22-04-2020
                  $cashbck_pmnt_dtl_arr['membership_no']=$mno;
                  $cashbck_pmnt_dtl_arr['validity_string']=$valid_string;
                  $cashbck_pmnt_dtl_arr['expire_dt']=$valid_upto1;

                    // pre($cashbck_pmnt_dtl_arr);exit;

                //  $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                  $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr);



               }

              $this->addReferralcase($postdata,$branch,$card,$mno,$company);
         }

   }

    /* End using No promo and no case back*/







}


public function UpdatePromoAmountForWallet($promo_cashbck_assign_to_mem_arr,$phone,$promo_id){
         $where = array(
                           'mobile_no' => $phone,
                           'transaction_id' => $promo_id,
                           'is_promo' => 'Y',
                        );
         $this->commondatamodel->updateSingleTableData('promo_cashbck_assign_to_mem',$promo_cashbck_assign_to_mem_arr,$where);
}


public function UpdateCaseBackAmtForWallet($post_fields,$member_acc_code){
     $where = array(
                           'member_acc_code' => $member_acc_code,
                           'is_promo' => 'N'
                   );
     $this->commondatamodel->updateSingleTableData('promo_cashbck_assign_to_mem',$post_fields,$where);
}



public function addReferralcase($postdata,$branch,$card,$mno,$company_id){


			 if($postdata['txt_mem_mob'] != ''){

              $mobile = $postdata['txt_mem_mob'];
             // $memberAcccode = $obj_inc_wlt->getMemberAccCodebymobile($mobile);
              $memberAcccode =  $this->wallet_model->getMemberAccCodebymobile($mobile,$company_id);
              
              $mem_acc_code =  $memberAcccode->member_acc_code;
			 	 //caseback assign for member
	           $is_promo = 'N';
       	  	  $caseback_assign_to_mem_arr['mobile_no'] = $mobile;
              $caseback_assign_to_mem_arr['branch_code'] = $branch;
              $caseback_assign_to_mem_arr['is_promo']= $is_promo;
              $caseback_assign_to_mem_arr['is_expired']='N';
			     $caseback_assign_to_mem_arr['member_acc_code']=$mem_acc_code;

               //added by anil on 22-04-2020
               $caseback_assign_to_mem_arr['membership_no']=$memberAcccode->MEMBERSHIP_NO;
               $caseback_assign_to_mem_arr['validity_string']=$memberAcccode->VALIDITY_STRING;
               $caseback_assign_to_mem_arr['expire_dt']=$memberAcccode->EXPIRY_DT;


               //caseback in dtl table
               $cashbck_pmnt_dtl_arr['mobile_no']= $mobile;
               $cashbck_pmnt_dtl_arr['payment_id']=NULL ;
               $cashbck_pmnt_dtl_arr['is_debit']='N' ;
               $cashbck_pmnt_dtl_arr['tran_module']='REG';
               $cashbck_pmnt_dtl_arr['case_dtl_type']='Refer To '.$mno;
               $cashbck_pmnt_dtl_arr['member_acc_code']=$mem_acc_code;

               $cashbck_pmnt_dtl_arr['membership_no']=$memberAcccode->MEMBERSHIP_NO;
               $cashbck_pmnt_dtl_arr['validity_string']=$memberAcccode->VALIDITY_STRING;
               $cashbck_pmnt_dtl_arr['expire_dt']=$memberAcccode->EXPIRY_DT;


               // $referralCase = $obj_inc_wlt->getReferralCaseback($branch,$card);
                $referralCase = $this->wallet_model->getReferralCaseback($brn,$card,$company_id);

                $tran_id = $referralCase->id;
                $caseback_assign_to_mem_arr['transaction_id'] = $tran_id;
		          $cashbck_pmnt_dtl_arr['promo_cashback_id'] = $tran_id;

		                if(!empty($referralCase)){


                        $referralcaseAmt = $referralCase->ref_case_amt;
                        //$getexistscaseback = $obj_inc_wlt->getexistscaseback($mem_acc_code);
                        $getexistscaseback = $this->wallet_model->getexistscaseback($member_acc_code);


					          if(!empty($getexistscaseback)){

                                       $pre_caseback_amt = $getexistscaseback->amount;
              	                        $caseback_assign_id = $getexistscaseback->id;
              	 	                     $amount_Deduct = $pre_caseback_amt +  $referralcaseAmt;
              	                        $caseback_assign_to_mem_arr['amount'] = $amount_Deduct;
                                       // $update_caseback = $obj_inc_wlt->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$mem_acc_code);
                                       $update_caseback =   $this->UpdateCaseBackAmtForWallet($caseback_assign_to_mem_arr,$member_acc_code);
					          } else{
                                      $caseback_assign_to_mem_arr['amount'] = $referralcaseAmt;
                                    //  $insertcaseassign = $obj_inc_wlt->InsertIntoCashBckPaymt($caseback_assign_to_mem_arr);
                                      $insertcaseassign =  $this->commondatamodel->insertSingleTableData('promo_cashbck_assign_to_mem',$caseback_assign_to_mem_arr); 
                                    
                                    	$caseback_assign_id = $insertcaseassign;

					                }

                                       $cashbck_pmnt_dtl_arr['mobile_no']= $mobile;
                                       $cashbck_pmnt_dtl_arr['amount']=$referralcaseAmt;
                                       $cashbck_pmnt_dtl_arr['promo_cashback_assign_id']=$caseback_assign_id;



                         // $insertcasebackdtl = $obj_inc_wlt->InsertIntoCashBckPaymtdtl($cashbck_pmnt_dtl_arr);
                          $insertcasebackdtl=$this->commondatamodel->insertSingleTableData('promo_cashbck_pmnt_dtl',$cashbck_pmnt_dtl_arr); 

                          /* Start Send SMS */

                           // $message = "INR ".$referralcaseAmt." credited to your Wallet on ".date('d-m-Y')." for refer to member";
                           // $sms_stat=send_caseback_sms('8910088950',$message);

                         /* End Send SMS */


		                }else{

		                }

				}else{

				}



	}


public function insertIntoInstallment($postdata,$cust_ins_id,$pmt_ins_id,$mno,$valid_string,$branch,$card,$company_id){

               $due=$postdata['txt_due'];
               $f_inst_dt=null;
               if (isset($postdata['txt_inst1_dt']) && strlen($postdata['txt_inst1_dt'])!=0)
               {
                        $f_inst_dt=date("Y-m-d",strtotime($postdata['txt_inst1_dt']));
               }

               $f_inst_amt=$postdata['txt_inst1_amt'];
               $f_inst_cheque=$postdata['txt_inst1_cheque'];
               $f_inst_bank=$postdata['txt_inst1_bank'];
               $f_inst_branch=$postdata['txt_inst1_branch'];
               $f_installment_chrgs=$postdata['due_installment1_charges'];

               $s_inst_dt=NULL;
               if (isset($postdata['txt_inst2_dt']) && strlen($postdata['txt_inst2_dt'])!=0)
               {
                     $s_inst_dt=date("Y-m-d",strtotime($postdata['txt_inst2_dt']));
               }

               $s_inst_amt=$postdata['txt_inst2_amt'];
               $s_inst_cheque=$postdata['txt_inst2_cheque'];
               $s_inst_bank=$postdata['txt_inst2_bank'];
               $s_inst_branch=$postdata['txt_inst2_branch'];
               $s_installment_chrgs=$postdata['due_installment2_charges'];

               $t_inst_dt=NULL;
               if (isset($postdata['txt_inst3_dt']) && strlen($postdata['txt_inst3_dt'])!=0)
               {
                     $t_inst_dt=date("Y-m-d",strtotime($postdata['txt_inst3_dt']));
               }

               $t_inst_amt=$postdata['txt_inst3_amt'];
               $t_inst_cheque=$postdata['txt_inst3_cheque'];
               $t_inst_bank=$postdata['txt_inst3_bank'];
               $t_inst_branch=$postdata['txt_inst3_branch'];
               $t_installment_chrgs=$postdata['due_installment3_charges'];
               $fo_inst_dt = NULL;
               if (isset($postdata['txt_inst4_dt']) &&  strlen($postdata['txt_inst4_dt'])!=0)
               {
                     $fo_inst_dt=date("Y-m-d",strtotime($postdata['txt_inst4_dt']));
               }

               $fo_inst_amt=$postdata['txt_inst4_amt'];
               $fo_inst_cheque=$postdata['txt_inst4_cheque'];
               $fo_inst_bank=$postdata['txt_inst4_bank'];
               $fo_inst_branch=$postdata['txt_inst4_branch'];
               $fo_installment_chrgs=$postdata['due_installment4_charges'];
               $fi_inst_dt=NULL;
               if (isset($postdata['txt_inst5_dt']) && strlen($postdata['txt_inst5_dt'])!=0)
               {
                     $fi_inst_dt=date("Y-m-d",strtotime($postdata['txt_inst5_dt']));
               }

               $fi_inst_amt=$postdata['txt_inst5_amt'];
               $fi_inst_cheque=$postdata['txt_inst5_cheque'];
               $fi_inst_bank=$postdata['txt_inst5_bank'];
               $fi_inst_branch=$postdata['txt_inst5_branch'];
               $fi_installment_chrgs=$postdata['due_installment5_charges'];
               $si_inst_dt=NULL;
               if (isset($postdata['txt_inst6_dt']) && strlen($postdata['txt_inst6_dt'])!=0)
               {
                     $si_inst_dt=date("Y-m-d",strtotime($postdata['txt_inst6_dt']));
               }

               $si_inst_amt=$postdata['txt_inst6_amt'];
               $si_inst_cheque=$postdata['txt_inst6_cheque'];
               $si_inst_bank=$postdata['txt_inst6_bank'];
               $si_inst_branch=$postdata['txt_inst6_branch'];
               $si_installment_chrgs=$postdata['due_installment6_charges'];


   if ($due>0)
	{
            if (isset($postdata['txt_inst1_dt']) && strlen($postdata['txt_inst1_dt'])!=0 && $f_inst_amt>0)
            {
               $insert_due_arr['member_id']=$cust_ins_id;
               $insert_due_arr['membershipno']=$mno;
               $insert_due_arr['due_pybl_date']=$f_inst_dt;
               //added by anil on 20-04-2020
               $insert_due_arr['due_amt']=$f_inst_amt - $f_installment_chrgs;
               $insert_due_arr['due_installment_chrgs']=$f_installment_chrgs;
               $insert_due_arr['due_pybl_amt']=$f_inst_amt;
               $insert_due_arr['BRANCH_CODE']=$branch;
               $insert_due_arr['CARD_CODE']=$card;
               $insert_due_arr['validity_string']=$valid_string;
               $insert_due_arr['from_where']="REG";
               $insert_due_arr['from_payment_id']=$pmt_ins_id;
               $insert_due_arr['company_id']= $company_id;
               $insert_due_arr['pybl_cheque_no']=$f_inst_cheque;
               $insert_due_arr['pybl_bank']=$f_inst_bank;
               $insert_due_arr['pybl_branch']=$f_inst_branch;
               $insert_due_arr['card_id']=$this->getCardIDByCompany($card,$company_id);


               $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);
            }

         if (isset($postdata['txt_inst2_dt']) && strlen($postdata['txt_inst2_dt'])!=0 && $s_inst_amt>0)
                  {
               $insert_due_arr['member_id']=$cust_ins_id;
               $insert_due_arr['membershipno']=$mno;
               $insert_due_arr['due_pybl_date']=$s_inst_dt;
                  //added by anil on 20-04-2020
               $insert_due_arr['due_amt']=$s_inst_amt - $s_installment_chrgs;
               $insert_due_arr['due_installment_chrgs']=$s_installment_chrgs;
               $insert_due_arr['due_pybl_amt']=$s_inst_amt;
               $insert_due_arr['BRANCH_CODE']=$branch;
               $insert_due_arr['CARD_CODE']=$card;
               $insert_due_arr['validity_string']=$valid_string;
               $insert_due_arr['from_where']="REG";
               $insert_due_arr['from_payment_id']=$pmt_ins_id;
               $insert_due_arr['company_id']= $company_id;
               $insert_due_arr['pybl_cheque_no']=$s_inst_cheque;
               $insert_due_arr['pybl_bank']=$s_inst_bank;
               $insert_due_arr['pybl_branch']=$s_inst_branch;
               $insert_due_arr['card_id']=$this->getCardIDByCompany($card,$company_id);

               $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);

               }

               /** */
               /* added by anil on 09-04-2020 */

               if (isset($postdata['txt_inst3_dt']) && strlen($postdata['txt_inst3_dt'])!=0 && $t_inst_amt>0)
                  {
               $insert_due_arr['member_id']=$cust_ins_id;
               $insert_due_arr['membershipno']=$mno;
               $insert_due_arr['due_pybl_date']=$t_inst_dt;
               //added by anil on 20-04-2020
               $insert_due_arr['due_amt']=$t_inst_amt - $t_installment_chrgs;
               $insert_due_arr['due_installment_chrgs']=$t_installment_chrgs;
               $insert_due_arr['due_pybl_amt']=$t_inst_amt;
               $insert_due_arr['BRANCH_CODE']=$branch;
               $insert_due_arr['CARD_CODE']=$card;
               $insert_due_arr['validity_string']=$valid_string;
               $insert_due_arr['from_where']="REG";
               $insert_due_arr['from_payment_id']=$pmt_ins_id;
               $insert_due_arr['company_id']= $company_id;
               $insert_due_arr['pybl_cheque_no']=$t_inst_cheque;
               $insert_due_arr['pybl_bank']=$t_inst_bank;
               $insert_due_arr['pybl_branch']=$t_inst_branch;
               $insert_due_arr['card_id']=$this->getCardIDByCompany($card,$company_id);

               $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);

               }

               if (isset($postdata['txt_inst4_dt']) && strlen($postdata['txt_inst4_dt'])!=0 && $fo_inst_amt>0)
                  {
               $insert_due_arr['member_id']=$cust_ins_id;
               $insert_due_arr['membershipno']=$mno;
               $insert_due_arr['due_pybl_date']=$fo_inst_dt;
               //added by anil on 20-04-2020
               $insert_due_arr['due_amt']=$fo_inst_amt - $fo_installment_chrgs;
               $insert_due_arr['due_installment_chrgs']=$fo_installment_chrgs;
               $insert_due_arr['due_pybl_amt']=$fo_inst_amt;
               $insert_due_arr['BRANCH_CODE']=$branch;
               $insert_due_arr['CARD_CODE']=$card;
               $insert_due_arr['validity_string']=$valid_string;
               $insert_due_arr['from_where']="REG";
               $insert_due_arr['from_payment_id']=$pmt_ins_id;
               $insert_due_arr['company_id']= $company_id;
               $insert_due_arr['pybl_cheque_no']=$fo_inst_cheque;
               $insert_due_arr['pybl_bank']=$fo_inst_bank;
               $insert_due_arr['pybl_branch']=$fo_inst_branch;
               $insert_due_arr['card_id']=$this->getCardIDByCompany($card,$company_id);

               $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);

               }

               if (isset($postdata['txt_inst5_dt']) &&  strlen($postdata['txt_inst5_dt'])!=0 && $fi_inst_amt>0)
               {
               $insert_due_arr['member_id']=$cust_ins_id;
               $insert_due_arr['membershipno']=$mno;
               $insert_due_arr['due_pybl_date']=$fi_inst_dt;
               //added by anil on 20-04-2020
               $insert_due_arr['due_amt']=$fi_inst_amt - $fi_installment_chrgs;
               $insert_due_arr['due_installment_chrgs']=$fi_installment_chrgs;
               $insert_due_arr['due_pybl_amt']=$fi_inst_amt;
               $insert_due_arr['BRANCH_CODE']=$branch;
               $insert_due_arr['CARD_CODE']=$card;
               $insert_due_arr['validity_string']=$valid_string;
               $insert_due_arr['from_where']="REG";
               $insert_due_arr['from_payment_id']=$pmt_ins_id;
               $insert_due_arr['company_id']= $company_id;
               $insert_due_arr['pybl_cheque_no']=$fi_inst_cheque;
               $insert_due_arr['pybl_bank']=$fi_inst_bank;
               $insert_due_arr['pybl_branch']=$fi_inst_branch;
               $insert_due_arr['card_id']=$this->getCardIDByCompany($card,$company_id);

               $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);

               }

               if (isset($postdata['txt_inst6_dt']) && strlen($postdata['txt_inst6_dt'])!=0 && $si_inst_amt>0)
                  {
               $insert_due_arr['member_id']=$cust_ins_id;
               $insert_due_arr['membershipno']=$mno;
               $insert_due_arr['due_pybl_date']=$si_inst_dt;
               //added by anil on 20-04-2020
               $insert_due_arr['due_amt']=$si_inst_amt - $si_installment_chrgs;
               $insert_due_arr['due_installment_chrgs']=$si_installment_chrgs;
               $insert_due_arr['due_pybl_amt']=$si_inst_amt;
               $insert_due_arr['BRANCH_CODE']=$branch;
               $insert_due_arr['CARD_CODE']=$card;
               $insert_due_arr['validity_string']=$valid_string;
               $insert_due_arr['from_where']="REG";
               $insert_due_arr['from_payment_id']=$pmt_ins_id;
               $insert_due_arr['company_id']=$company_id;
               $insert_due_arr['pybl_cheque_no']=$si_inst_cheque;
               $insert_due_arr['pybl_bank']=$si_inst_bank;
               $insert_due_arr['pybl_branch']=$si_inst_branch;
               $insert_due_arr['card_id']=$this->getCardIDByCompany($card,$company_id);

               $insrt_due=$this->InsertIntoDuePybl($insert_due_arr);

               }

               /* ended by anil on 09-04-2020 */

	}

}

public function InsertIntoDuePybl($insert_array){
   
   return  $this->commondatamodel->insertSingleTableData('due_payable',$insert_array); 
}


public function insertIntoMemberCompliment($cust_ins_id,$mno,$valid_string,$branch,$card,$company){

   
     // $del_msg=$obj_reg_inc->DeleteFromMemberCompliment($cust_ins_id,$valid_string);
      $where_compliment = array('validity_string' => $valid_string,'member_id' => $cust_ins_id);
      $del_msg= $this->commondatamodel->deleteTableData('member_compliment',$where_compliment);


      $rowCardDetail=$this->reg_model->getCardDetail($branch,$card,$company);
      foreach($rowCardDetail as $row_detail)
      {
         $coupon_id=$row_detail->coupon_id;
         $qty=$row_detail->qty;
         $desc=$row_detail->detail_description;

         $insert_mem_comp_arr['member_id']=$cust_ins_id;
         $insert_mem_comp_arr['membership_no']=$mno;
         $insert_mem_comp_arr['coupon_id']=$coupon_id;
         $insert_mem_comp_arr['pack_compl']=$desc;
         $insert_mem_comp_arr['qty']=$qty;
         $insert_mem_comp_arr['card_code']=$card;
         $insert_mem_comp_arr['branch_code']=$branch;
         $insert_mem_comp_arr['validity_string']=$valid_string;

         //$insrt_compl=$obj_reg_inc->InsertIntoMemberCompliment($insert_mem_comp_arr);
         $insrt_compl=$this->commondatamodel->insertSingleTableData('member_compliment',$insert_mem_comp_arr); 

      }



}



  public  function getTermconSendVerificationCode() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
              $mobile = $this->input->post('mobile');
              $company_id = $session['companyid']; 
              $user_id = $session['userid']; 

              $verifed_code=rand(10000,999999);


             $insert_array = array(
                              'verifed_code' => $verifed_code, 
                              'send_time' => date('Y-m-d H:i:s'), 
                              'company_id' => $company_id, 
                              'user_id' => $user_id, 
                            );


             $sign_id= $this->commondatamodel->insertSingleTableData('term_and_condition_sign',$insert_array); 

            $link="https://www.mantrahealthclub.com/mantra/termofuse/agreement/".$sign_id;
            $message = "Please read the agreement to get verification code ".$link;
            mantraSend($mobile,$message);

            
             $json_response = array("sign_id" => $sign_id,
              "verifed_code" => $verifed_code,"link" => $link);

					echo json_encode( $json_response );
						exit;




                

         }else{
            redirect('admin','refresh');
      }

   }

    public  function checkVerificationCode() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
              $code = $this->input->post('code');
              $sign_id = $this->input->post('sign_id');
              $company_id = $session['companyid']; 
          

             $where_check = array(
                              'sign_id' => $sign_id, 
                              'verifed_code' => $code, 
                             
                            );


            $check= $this->commondatamodel->checkExistanceData('term_and_condition_sign',$where_check); 


            if ($check) {
               $json_response = array( "is_verified" => 'Y','verification_time' => date('Y-m-d H:i:s'));
               $where = array('sign_id' => $sign_id);
               $upd_cash_bck_admin = $this->commondatamodel->updateSingleTableData('term_and_condition_sign',$json_response,$where);
            }else{
               $json_response = array("is_verified" => 'N');
               $where = array('sign_id' => $sign_id);
               $upd_cash_bck_admin = $this->commondatamodel->updateSingleTableData('term_and_condition_sign',$json_response,$where);
            }

					echo json_encode( $json_response );
						exit;




                

         }else{
            redirect('admin','refresh');
      }

   }

   
    public  function checkPaymentModeWithBranch() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
              $sel_mode = $this->input->post('sel_mode');
              $sel_branch = $this->input->post('sel_branch');
              $company_id = $session['companyid']; 
          

             $where_check = array(
                              'branch' => $sel_branch, 
                              'payment_mode' => $sel_mode, 
                              'company_id' => $company_id, 
                              'is_active' => 'Y'
                             
                            );


            $check= $this->commondatamodel->checkExistanceData('branch_acc_payment',$where_check); 


            if ($check) {
               $json_response = array( "is_mapped" => 'Y');
               
            }else{
               $json_response = array("is_mapped" => 'N');
              
            }

					echo json_encode( $json_response );
						exit;




                

         }else{
            redirect('admin','refresh');
      }

   }


   public function updateAgreementTable($sign_id,$account_code,$customer_id){

      if($sign_id!=0){
               $upd_data = array('member_ac_code' => $sign_id,'customer_id' => $customer_id);
               $where = array('sign_id' => $sign_id);
               $upd_cash_bck_admin = $this->commondatamodel->updateSingleTableData('term_and_condition_sign',$upd_data,$where);
      }
   }



   public  function updateGeneralMedicalAssestment() { 
      
         $session = $this->session->userdata('mantra_user_detail');
      
         if($this->session->userdata('mantra_user_detail'))
         {  
               
                $company_id = $session['companyid'];
                $sel_branch = $this->input->post('branch');
               
             
                    
                    
                     
                              $json_response = array(
                                          "status" => 0,
                                          "discount_rate" =>"",
                                          "discount" => "",
                                          "premium" => "",
                                          "payment_now" => "",	 
                                       );

            

					echo json_encode( $json_response );
						exit;

         }else{
            redirect('admin','refresh');
      }

   }




 public function getBranchIDByCompany($branch_code,$company_id){

    return $branch_id = $this->commondatamodel->getSingleRowByWhereCls('branch_master',array('BRANCH_CODE'=>$branch_code,
                                                   'company_id'=>$company_id))->BRANCH_ID; 

   }
   

   
 public function getCardIDByCompany($card_code,$company_id){

    return $card_id = $this->commondatamodel->getSingleRowByWhereCls('card_master',array('CARD_CODE'=>$card_code,
                                                   'company_id'=>$company_id))->CARD_ID; 

   }

public function isSmsFacility($company_id){

    return $sms_facility = $this->commondatamodel->getSingleRowByWhereCls('company_master',array('comany_id'=>$company_id))->sms_facility; 

   }






    

} /* end of class */ 