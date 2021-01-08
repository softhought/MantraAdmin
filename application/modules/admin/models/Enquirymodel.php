<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enquirymodel extends CI_Model{

    public function getenquirylist($search_by,$from_dt,$to_date,$branch,$wing,$caller,$mobile_no)

    {
        $session = $this->session->userdata('mantra_user_detail');
        $where_comp = array('enquiry_detail.company_id'=>$session['companyid']);
       if($search_by == 'FOLLOW-UP DATE'){
           $where = "enquiry_detail.followup_date between '$from_dt' and '$to_date'";
       }else{
        $where = "enquiry_detail.enq_date between '$from_dt' and '$to_date'";
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
public function list_of_enquiry($search_by,$from_dt,$to_date,$branch,$wing,$caller)

    {
        $session = $this->session->userdata('mantra_user_detail');
        $where_comp = array('enquiry_detail.company_id'=>$session['companyid']);

       if($search_by == 'FOLLOW-UP'){
           $where = "enquiry_detail.followup_date between '$from_dt' and '$to_date'";
           $where_group = "enquiry_detail.tran_id";
           $where_order = "enquiry_master.FIRST_NAME";
           $by = "ASC";
       }else{
           $where = "enquiry_master.DATE_OF_ENQ between '$from_dt' and '$to_date'";
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

    public function getAllEnquiredMember($from_dt,$to_date,$branch,$wing)
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
    
    public function getenquiryreportlist($gender,$from_dt,$to_date,$from_dob,$to_dob)

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
          $where_dob = "enquiry_master.dob between '$from_dob' and '$to_dob'";           
       }else{
           $where_dob = array();
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
                          ->where($where_gen)   
                          ->where($where_dob)   
                          ->where($where_comp)
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
    
    

}