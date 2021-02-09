<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enquirymodel extends CI_Model{

    public function getenquirylist($search_by,$from_dt,$to_date,$branch,$wing,$caller,$mobile_no)

    {
        $session = $this->session->userdata('mantra_user_detail');
        $where_comp = array('enquiry_detail.company_id'=>$session['companyid']);
       if($search_by == 'FOLLOW-UP DATE' && $from_dt != "" && $to_date != ""){
           $where = "enquiry_detail.followup_date between '$from_dt' and '$to_date'";
       }elseif($search_by == 'ENQUIRY DATE' && $from_dt != "" && $to_date != ""){
        $where = "enquiry_detail.enq_date between '$from_dt' and '$to_date'";
       }else{
        $where =array();
       }
       if($branch != ''){
           $where_brn = array("enquiry_detail.branch_id"=>$branch);
        }else{
           $where_brn = array();
       }
       if($wing != ''){
        $where_wing = array("enquiry_detail.wing_id"=>$wing);
        }else{
          $where_wing = array();
        }
        if($caller != ''){
            $where_caller = array("enquiry_detail.user_id"=>$caller);
            }else{
            $where_caller = array();
        }
        if($mobile_no != ''){
            $where_mob = array("enquiry_master.MOBILE1"=>$mobile_no);
            }else{
            $where_mob = array();
        }

        $data = array();    
        $query = $this->db->select("enquiry_detail.*,enquiry_master.*,pin_master.pin_code,pin_master.location as pin_location,branch_master.BRANCH_NAME,users.name as caller_name")
                          ->from('enquiry_detail')
                          ->join('enquiry_master','enquiry_detail.enq_id = enquiry_master.ID','INNER')   
                          ->join('pin_master','enquiry_master.PIN = pin_master.id','LEFT')   
                          ->join('branch_master','enquiry_detail.branch_id = branch_master.BRANCH_ID','INNER')   
                          ->join('users','enquiry_detail.user_id = users.id','LEFT')
                          ->where($where)   
                          ->where($where_brn)   
                          ->where($where_wing)   
                          ->where($where_caller)   
                          ->where($where_mob) 
                          ->where($where_comp) 
                          ->group_by('enquiry_detail.enq_id')                          
                          ->order_by('enquiry_master.FIRST_NAME','ASC');
                          
      
		$query = $this->db->get();
		 #echo $this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = array(
                              'enqdtl'=>$rows,
                              'rowcount'=>$this->getEnquiryDataFromReg($rows->enq_id)
                            );
            }
            return $data;            

        }
		else
		{
             return $data;
         }

    }


    
    public function getallenquirydtl($enq_id)
	{
        $data = array();
        $where = array('enq_id'=>$enq_id);
		$this->db->select("*")
                ->from('enquiry_detail')
                ->join('users','enquiry_detail.user_id = users.id','LEFT')
                ->join('reason_master','enquiry_detail.remarks_id = reason_master.reason_id','LEFT')
				->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
    
public function gatallwingslist()
	{
        $data = array();
        $session = $this->session->userdata('mantra_user_detail');
        $where = array('company_id'=>$session['companyid']);
		$this->db->select("enquiry_wings.*,wings_category_master.category_name,wings_category_master.cat_id")
                ->from('enquiry_wings')
                ->join('wings_category_master','enquiry_wings.wing_category_id = wings_category_master.cat_id','LEFT');               
				//->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
    
public function getuserslist()
	{
        $data = array();
        $session = $this->session->userdata('mantra_user_detail');
        $where = array('is_active'=>'Y','company_id'=>$session['companyid']);
		$this->db->select("*")
                ->from('users')               
				->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[] = array(
                                'id'=>$rows->id,
                                'name'=>$rows->name,
                                'mobile_no'=>$rows->mobile_no
                                );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

public function getAllattendance($from_dt,$to_date,$branch_cd)
	{
        $data = array();
    //    $session = $this->session->userdata('mantra_user_detail');
    //     $where = array('may_i_help_you.company_id'=>$session['companyid']);
        if($from_dt != "" && $to_date != ""){
            $where2 = 'may_i_help_you.date_of_entry BETWEEN "'.$from_dt.'" AND "'.$to_date.'"';
        }else{
            $where2 = array();
        }
        if($branch_cd != ""){
            $where3 = array('may_i_help_you.branch_cd'=>$branch_cd);
        }else{
            $where3 = array();
        }

		$this->db->select("may_i_help_you.*,branch_master.BRANCH_NAME")
                ->from('may_i_help_you') 
                ->join('branch_master','may_i_help_you.branch_cd = branch_master.BRANCH_CODE','LEFT')              
                //  ->where($where)                
				->where($where2)
                ->where($where3)
                ->group_by('may_i_help_you.id')
                ->order_by('may_i_help_you.date_of_entry','DESC');
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getAllFreeGuestpass($from_dt,$to_date,$branch_code)
	{
        $data = array();
       
        if($from_dt != "" && $to_date != ""){
            $where2 = 'free_guest_pass.date_of_entry BETWEEN "'.$from_dt.'" AND "'.$to_date.'"';
        }else{
            $where2 = array();
        }
        if($branch_code != ""){
            $where3 = array('free_guest_pass.gym_location'=>$branch_code);
        }else{
            $where3 = array();
        }

		$this->db->select("free_guest_pass.*,branch_master.BRANCH_NAME")
                ->from('free_guest_pass') 
                ->join('branch_master','free_guest_pass.gym_location = branch_master.BRANCH_CODE','LEFT') 
				->where($where2)
                ->where($where3)
                ->group_by('free_guest_pass.id')
                ->order_by('free_guest_pass.date_of_entry','DESC');
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
public function list_of_enquiry($search_by,$from_dt,$to_date,$branch,$wing,$caller,$category)

    {
        $session = $this->session->userdata('mantra_user_detail');
        $where_comp = array('enquiry_detail.company_id'=>$session['companyid']);

       if($search_by == 'FOLLOW-UP'){
           if($from_dt != "" && $to_date != ""){
              $where = "enquiry_detail.followup_date between '$from_dt' and '$to_date'";
           }else{
               $where = array();
           }
          
           $where_group = "enquiry_detail.tran_id";
           $where_order = "enquiry_master.FIRST_NAME";
           $by = "ASC";
       }else{
        if($from_dt != "" && $to_date != ""){
           $where = "enquiry_master.DATE_OF_ENQ between '$from_dt' and '$to_date'";
        }else{
            $where = array();
        }
           $where_group = "enquiry_master.ID";
           $where_order = "enquiry_detail.tran_id";
           $by = "DESC";
       }
       if($branch != '' && $search_by == 'FOLLOW-UP'){

           $where_brn = array("enquiry_detail.branch_id"=>$branch);

        }else if($branch != '' && $search_by == 'FRESH'){

            $where_brn = array("enquiry_master.branch_id"=>$branch);
         
       }else{
            $where_brn = array();
       }
       if($wing != '' && $search_by == 'FOLLOW-UP'){
        $where_wing = array("enquiry_detail.wing_id"=>$wing);
        }else if($wing != '' && $search_by == 'FRESH'){

            $where_wing = array("enquiry_master.wing_id"=>$wing);
         
       }else{
          $where_wing = array();
        }
        if($caller != '' && $search_by == 'FOLLOW-UP'){
            $where_caller = array("enquiry_detail.user_id"=>$caller);
            }else if($caller != '' && $search_by == 'FRESH'){
                $where_caller = array("enquiry_master.user_id"=>$caller);
             
           }else{
            $where_caller = array();
        }
        // if($mobile_no != ''){
        //     $where_mob = array("enquiry_master.MOBILE1"=>$mobile_no);
        //     }else{
        //     $where_mob = array();
        // }
        if($category != ''){
                $where_wing_cat = array("enquiry_master.wing_cat_id"=>$category);
            }else {
    
                $where_wing_cat = array();
             
           }
        $data = array();    
        $query = $this->db->select("enquiry_detail.*,enquiry_master.*,pin_master.pin_code,pin_master.location as pin_location,branch_master.BRANCH_NAME,users.name as caller_name")
                          ->from('enquiry_detail')
                          ->join('enquiry_master','enquiry_detail.enq_id = enquiry_master.ID','INNER')   
                          ->join('pin_master','enquiry_master.PIN = pin_master.id','LEFT')   
                          ->join('branch_master','enquiry_detail.branch_id = branch_master.BRANCH_ID','INNER')   
                          ->join('users','enquiry_detail.user_id = users.id','LEFT')
                          ->where($where_comp)   
                          ->where($where)   
                          ->where($where_brn)   
                          ->where($where_wing)   
                          ->where($where_caller)   
                          ->where($where_wing_cat)   
                        //   ->where($where_mob) 
                           ->group_by($where_group)                          
                          ->order_by($where_order,$by);
                          
      
		$query = $this->db->get();
		# echo $this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = array(
                              'enqdtl'=>$rows,
                              'rowcount'=>$this->getEnquiryDataFromReg($rows->enq_id),
                              'followup_count'=>$this->getallenquirydtl($rows->enq_id)
                            );
            }
            return $data;            

        }
		else
		{
             return $data;
         }

    }
    
    public function getEnquiryDataFromReg($enq_id)
	{
        $data = 0;
        $where = array('ENQ_ID'=>$enq_id);
		$this->db->select("count(*) as rowcount")
				->from('customer_master')
				->where($where);
		$query = $this->db->get();
		# $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
                $row = $query->row();
				$data = $row->rowcount;
          
            return $data;
             
        }
		else
		{
             return $data;
         }
    }  

    public function getAllEnquiredMember($from_dt,$to_date,$branch,$wing,$company_id)
	{
        $data =array();
        $session = $this->session->userdata('mantra_user_detail');
        $where_comp = array('enquiry_master.company_id'=>$session['companyid']);
        if($from_dt !="" && $to_date != ""){
            $where = 'enquiry_master.DATE_OF_ENQ between "'.$from_dt.'" and "'.$to_date.'"';
        }else{
            $where = array();
        }
        if($branch !=""){
            $where2 = array('enquiry_master.branch_id'=>$branch);
        }else{
            $where2 = array();
        }
         $where_company = array('enquiry_master.company_id'=>$company_id);

        // if($wing !=""){
        //     $where3 = array('enquiry_master.wing_id'=>$wing);
        // }else{
        //     $where3 = array();
        // }
        $where4 = "enquiry_master.MOBILE1 NOT IN(SELECT DISTINCT CUS_PHONE FROM customer_master WHERE CUS_PHONE <> '')";
		$this->db->select("enquiry_master.*,enquiry_detail.*,branch_master.BRANCH_NAME")
                ->from('enquiry_master')
                ->join('branch_master','enquiry_master.branch_id = branch_master.BRANCH_Id','INNER')
                ->join('enquiry_detail','enquiry_master.ID = enquiry_detail.enq_id','LEFT')
				->where($where_comp)
				->where($where)
				->where($where2)
				->where($where_company)
				// ->where($where3)
                ->where($where4)
                ->group_by('enquiry_master.ID');
				
		$query = $this->db->get();
		#echo  $this->db->last_query();exit;

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
                              
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
    
    public function getenquiryreportlist($branch,$gender,$from_dt,$to_date,$from_dob,$to_dob)

    {
        $session = $this->session->userdata('mantra_user_detail');
       if($from_dt != '' && $to_date != ''){
           $where = "enquiry_master.DATE_OF_ENQ between '$from_dt' and '$to_date'";           
       }else{
        $where = array();
       }

       if($gender != ''){

           $where_gen = array("enquiry_master.gender"=>$gender);

        }else{
            $where_gen = array();
       }
      
       if($from_dob != '' && $to_dob != ''){
            $from_db = date('Y', strtotime('-'.$to_dob.' years'));
            $to_db = date('Y', strtotime('-'.$from_dob.' years'));

          $where_dob = "DATE_FORMAT(enquiry_master.dob, '%Y') between '$from_db' and '$to_db'";           
          $where_age = "(enquiry_master.age between '$from_dob' and '$to_dob' or $where_dob)";           
       }else{
           $where_dob = array();
        }
        if($branch != ''){

            $where_brn = array("enquiry_master.branch_id"=>$branch);
 
         }else{
             $where_brn = array();
        }
        
        $where_comp = array('enquiry_master.company_id'=>$session['companyid']);
        $where_group = "enquiry_master.ID";
        $where_order = "enquiry_detail.tran_id";
        $by = "DESC";

        $data = array();    
        $query = $this->db->select("enquiry_detail.*,enquiry_master.*,pin_master.pin_code,pin_master.location as pin_location,branch_master.BRANCH_NAME,users.name as caller_name")
                          ->from('enquiry_detail')
                          ->join('enquiry_master','enquiry_detail.enq_id = enquiry_master.ID','INNER')   
                          ->join('pin_master','enquiry_master.PIN = pin_master.id','LEFT')   
                          ->join('branch_master','enquiry_detail.branch_id = branch_master.BRANCH_ID','INNER')   
                          ->join('users','enquiry_detail.user_id = users.id','LEFT')
                          ->where($where)   
                          ->where($where_brn)   
                          ->where($where_gen)   
                          ->where($where_age)
                          ->where($where_comp)
                           ->group_by($where_group)                          
                          ->order_by($where_order,$by);
                          
      
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = array(
                              'enqdtl'=>$rows,
                              'rowcount'=>$this->getEnquiryDataFromReg($rows->enq_id),
                              'followup_count'=>$this->getallenquirydtl($rows->enq_id)
                            );
            }
            return $data;            

        }
		else
		{
             return $data;
         }

    }


    public function getEnquiryDetailsByIds($enquiryids)
	{
		$data = array();
		$this->db->select("*")
                ->from('enquiry_master')
                ->where_in('enquiry_master.ID', $enquiryids);
        $query = $this->db->get();
        #echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }


    public function getMemberDetailsByIds($customerids)
	{
		$data = array();
		$this->db->select("*")
                ->from('customer_master')
                ->where_in('customer_master.CUS_ID', $customerids);
        $query = $this->db->get();
        #echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
    
     public function getEnquirySms($enquiry_id)
	{
        $data = array();
        $where = array('enq_id' => $enquiry_id,'err_id' => 1 );
		$this->db->select("*")
                ->from('enquiry_sms_report')
                ->join('sms_matter','sms_matter.tran_id = enquiry_sms_report.sms_sub_id','INNER') 
                ->where($where)
                ->order_by("date_of_sending", "desc");
                ;
        $query = $this->db->get();
       # echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }


    public function getOldMemberSms($cus_id)
	{
        $data = array();
        $where = array('member_id' => $cus_id,'err_id' => 1 );
		$this->db->select("*")
                ->from('old_member_sms')
                ->join('sms_matter','sms_matter.tran_id = old_member_sms.sms_matter_id','INNER') 
                ->where($where)
                ->order_by("date_of_sending", "desc");
                ;
        $query = $this->db->get();
       # echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

    public function getExtMemberSms($cus_id)
	{
        $data = array();
        $where = array('member_id' => $cus_id,'err_id' => 1 );
		$this->db->select("*")
                ->from('smsnew_report_bulk')
                ->join('sms_matter','sms_matter.tran_id = smsnew_report_bulk.sms_master_id','INNER') 
                ->where($where)
                ->order_by("date_of_sending", "desc");
                ;
        $query = $this->db->get();
        #echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
    
    public function getEnquiryEmail($enquiry_id)
	{
        $data = array();
        $where = array('enq_id' => $enquiry_id);
		$this->db->select("*")
                ->from('email_report_bulk')
                ->join('email_matter','email_matter.tran_id = email_report_bulk.matter_id','INNER')
                ->where($where) 
                ->order_by("date_of_sending", "desc");
                ;
        $query = $this->db->get();
       # echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

      public function getOldmemberEmail($membership_no)
	{
        $data = array();
        $where = array('membership_no' => $membership_no);
		$this->db->select("*")
                ->from('email_report_bulk')
                ->join('email_matter','email_matter.tran_id = email_report_bulk.matter_id','INNER')
                ->where($where) 
                ->order_by("date_of_sending", "desc");
                ;
        $query = $this->db->get();
       # echo "<br>".$this->db->last_query();
       
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
    
    
 public function getCategoryList($company_id)
	{
        $data = array();
        $where = array('company_id' => $company_id,'is_active_web_menu' => 'Y' );
		$this->db->select("*")
				->from('product_category')
				->where($where)
				->order_by('product_category.category_name', 'asc');
		$query = $this->db->get();
		#q();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data; 
        }
		else
		{
             return $data;
         }
    }

    public function GetCardByCategoryByCompny($cat,$comp)
	{
        $data = array();
		$where1 = array('card_master.IS_ACTIVE' => 'Y',
						'card_master.company_id' => $comp
					 );
	    $where2="substr(CARD_CODE,1,1)='".$cat."'";
		$this->db->select("*")
				->from('card_master')
				->where($where1)
				->where($where2)
				->order_by('CARD_DESC', 'asc');
				;
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();	
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data; 
        }
		else
		{
             return $data;
         }
    }
    


     public function getAllOldMemberList($from_dt,$to_date,$sel_category,$sel_card,$branch_id,$company_id)
	{
        $data = array();
        $where = array(
                        'payment_master.company_id' => $company_id,
                       );
        if($from_dt !="" && $to_date != ""){
         $where_expiary_date = 'payment_master.EXPIRY_DT between "'.$from_dt.'" and "'.$to_date.'" and payment_master.EXPIRY_DT  < CURDATE()';
        }else{
            $where_expiary_date = array();
        }

        
     if($sel_category!=''){
           $where_category = array(
                        'product_category.id' => $sel_category,
                       ); 
       }else{
            $where_category = [];
       }

        
     if($sel_card!=''){
           $where_card = array(
                        'payment_master.card_id' => $sel_card,
                       ); 
       }else{
            $where_card = [];
       }

       if($branch_id!=''){
           $where_branch = array(
                        'payment_master.branch_id' => $branch_id,
                       ); 
       }else{
            $where_branch = [];
       }

       
        $this->db->select("
                            customer_master.`CUS_ID`,
                            product_category.category_name,
                            customer_master.`MEMBERSHIP_NO` AS membership_no,
                            customer_master.`CUS_NAME`,
                            customer_master.`CUS_SEX`,
                            customer_master.`CUS_PHONE`,
                            customer_master.`CUS_EMAIL`,
                            payment_master.`CARD_CODE`,
                            payment_master.`BRANCH_CODE`,
                            DATE_FORMAT(payment_master.`FROM_DT`,'%d-%m-%Y') AS validFrom,
                            DATE_FORMAT(payment_master.`EXPIRY_DT`,'%d-%m-%Y') AS expiryDate")
                ->from('payment_master')
                ->join('customer_master','customer_master.MEMBERSHIP_NO = payment_master.MEMBERSHIP_NO','INNER')
                ->join('card_master','card_master.CARD_ID = payment_master.card_id','INNER')
                ->join('product_category','product_category.id = card_master.PROD_CATEGORY_ID','INNER')
				->where($where_branch)
				->where($where_category)
				->where($where_card)
				->where($where)
                ->where($where_expiary_date)
                ->group_by('customer_master.CUS_PHONE')
				->order_by('payment_master.EXPIRY_DT', 'desc');
        $query = $this->db->get();
        #echo "<br>".$this->db->last_query();	
		#q();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                

               $currentPackagedata= $this->countCurrentPackage($rows->CUS_PHONE,$company_id);

               if($currentPackagedata==0){
                    $data[] = $rows;
               }

           
              
            }
            return $data; 
        }
		else
		{
             return $data;
         }
    }

         public function getAllExistingMemberList($from_dt,$to_date,$sel_category,$sel_card,$branch_id,$company_id)
	{
        $data = array();
        $where = array(
                        'payment_master.company_id' => $company_id,
                       );
        if($from_dt !="" && $to_date != ""){
            $where_expiary_date = 'payment_master.EXPIRY_DT between "'.$from_dt.'" and "'.$to_date.'" and payment_master.EXPIRY_DT  >=CURDATE()';
        }else{
            $where_expiary_date = array();
        }

        
     if($sel_category!=''){
           $where_category = array(
                        'product_category.id' => $sel_category,
                       ); 
       }else{
            $where_category = [];
       }

        
     if($sel_card!=''){
           $where_card = array(
                        'payment_master.card_id' => $sel_card,
                       ); 
       }else{
            $where_card = [];
       }

       if($branch_id!=''){
           $where_branch = array(
                        'payment_master.branch_id' => $branch_id,
                       ); 
       }else{
            $where_branch = [];
       }

       
        $this->db->select("
                            customer_master.`CUS_ID`,
                            product_category.category_name,
                            customer_master.`MEMBERSHIP_NO` AS membership_no,
                            customer_master.`CUS_NAME`,
                            customer_master.`CUS_SEX`,
                            customer_master.`CUS_PHONE`,
                            customer_master.`CUS_EMAIL`,
                            payment_master.`CARD_CODE`,
                            payment_master.`BRANCH_CODE`,
                            DATE_FORMAT(payment_master.`FROM_DT`,'%d-%m-%Y') AS validFrom,
                            DATE_FORMAT(payment_master.`EXPIRY_DT`,'%d-%m-%Y') AS expiryDate")
                ->from('payment_master')
                ->join('customer_master','customer_master.MEMBERSHIP_NO = payment_master.MEMBERSHIP_NO','INNER')
                ->join('card_master','card_master.CARD_ID = payment_master.card_id','INNER')
                ->join('product_category','product_category.id = card_master.PROD_CATEGORY_ID','INNER')
				->where($where_branch)
				->where($where_category)
				->where($where_card)
				->where($where)
                ->where($where_expiary_date)
                ->group_by('customer_master.CUS_PHONE')
				->order_by('payment_master.EXPIRY_DT', 'desc');
        $query = $this->db->get();
        #echo "<br>".$this->db->last_query();	
		#q();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                

               $currentPackagedata= $this->countCurrentPackage($rows->CUS_PHONE,$company_id);

                    $data[] = $rows;
               

           
              
            }
            return $data; 
        }
		else
		{
             return $data;
         }
    }

    	public function countCurrentPackage($mobile_no,$company_id)
	{
        // $session = $this->session->userdata('mantra_user_detail');
        // $company_id = $session['companyid'];
        $data = array();
        $date = date("Y-m-d");
        $where = array('customer_master.IS_ACTIVE'=>'Y',
                       'customer_master.pack_type'=>'M',
                       'customer_master.CUS_PHONE'=>$mobile_no,
                       'payment_master.company_id' => $company_id);
        $where_in = array('F','R','RA');

        $today_date=date('Y-m-d');
       
        $query = $this->db->select("count(*) as total_active")
                          ->from('payment_master')
                          ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','INNER')   
                          ->where($where)
                          ->where_in('payment_master.FRESH_RENEWAL',$where_in)
                          ->where('DATE_FORMAT(`payment_master`.`EXPIRY_DT`,"%Y-%m-%d") >= ', $today_date)
                          ->where('DATE_FORMAT(`payment_master`.`FROM_DT`,"%Y-%m-%d") <= ', $today_date); 
                                                
      
        $query = $this->db->get();
          #echo $this->db->last_query();exit;
        if($query->num_rows()> 0)
		{

             $row = $query->row();
            return $row->total_active;
             
        }
		else
		{
             return 0;
         }

    }
    
    

}