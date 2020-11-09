<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usermodel extends CI_Model{
    public function getUserList($user_role)
    {
        $data = array();
       if ($user_role==1) { // 1 is the role id for Developer
            $this->db->select("users.*,user_role.role")
            ->from('users')
            ->join('user_role','users.user_role_id = user_role.id','INNER')            
            ->order_by('name','ASC');
        }else {
            $this->db->select("users.*,user_role.role")
                ->from('users')
                ->join('user_role','users.user_role_id = user_role.id','INNER')
                ->where_not_in('user_role.id',1)
				->order_by('name','ASC');
        }
		
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

    public function getUserRoleList($user_role)
    {
        $data = array();
        if ($user_role==1) { // 1 is the role id for Developer
             $this->db->select("*")
             ->from('user_role')         
             ->order_by('role','ASC');
         }else {
             $this->db->select("*")
                 ->from('user_role')
                 ->where_not_in('id',1)
                 ->order_by('role','ASC');
         }
         
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


    public function ActiveInactiveUserAccount($userid,$is_active)
    {
        $where=[
            'id'=>$userid
        ];
        $data=[
            'is_active'=>$is_active,
            'updated_at'=>date('Y-m-d')
        ];
        try {
            $this->db->trans_begin();
            //$this->db->where($where);
			$this->db->update('users', $data,$where);
			$this->db->last_query();
			
            //$affectedRow = $this->db->affected_rows();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                
                return FALSE;
            } else {
                $this->db->trans_commit();
                
                return TRUE;
            }
        } catch (Exception $exc) {
             return FALSE;
        }
    }

    public function getUserAccountActivity($userid)
    {
        $where=[
            'user_id'=> $userid
        ];
        $data = array();
		$this->db->select("*")
				->from('user_account_activity')
				->where($where)
				->order_by('login_time','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();

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













}//end of class