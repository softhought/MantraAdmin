<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enquirymodel extends CI_Model{

    public function getenquirylist($search_by,$from_dt,$to_date,$branch,$wing,$caller,$mobile_no)

    {
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
        $where_wing = array("enquiry_detail.for_the_wing"=>$wing);
        }else{
          $where_wing = array();
        }
        if($caller != ''){
            $where_caller = array("enquiry_detail.for_the_wing"=>$wing);
            }else{
            $where_caller = array();
        }

        $data = array();    
        $query = $this->db->select("enquiry_detail.*,company_master.company_name")
                          ->from('enquiry_detail')
                          ->join('company_master','branch_master.company_id = company_master.comany_id','INNER')   
                          ->order_by('branch_master.BRANCH_NAME','ASC');
      
		$query = $this->db->get();
		// echo $this->db->last_query();
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



}