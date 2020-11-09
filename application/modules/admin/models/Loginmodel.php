<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginmodel extends CI_Model{



    public function checkLogin($username,$password,$branch,$company)

    {      

        $userId="";

        $where_arr =["user_name"=>$this->db->escape_str($username),
                     "password"=>md5($this->db->escape_str($password))
                    //  "branch_id"=>$this->db->escape_str($branch),
                    //  "company_id"=>$this->db->escape_str($company),
                    //  "user_stat"=>1
            
            ];

       $query= $this->db->select("users.*")
                ->where($where_arr)
                ->get("users");            
#echo q();exit;
       if($query->num_rows()>0)
       {
           $rows = $query->row();
           $userId = $rows->id;
       }
       return $userId;
    }


    public function get_user($user_id)

    {

        $user="";

        $query=$this->db->select("users.*")                        
                ->where("users.id",$user_id)
                ->get("users");

        if($query->num_rows()>0){
            $user = $query->row();

        }

        return $user;

    }
    public function get_branch($branch)

    {

        $user="";

        $query=$this->db->select("branch_master.*")                        
                ->where("branch_master.BRANCH_ID",$branch)
                ->get("branch_master");

        if($query->num_rows()>0){
            $user = $query->row();

        }

        return $user;

    }
    public function get_company($company)

    {

        $user="";

        $query=$this->db->select("company_master.*")                        
                ->where("company_master.comany_id",$company)
                ->get("company_master");

        if($query->num_rows()>0){
            $user = $query->row();

        }

        return $user;

    }
    public function get_financialyear($yearid)

    {

        $user="";

        $query=$this->db->select("year_master.*")                        
                ->where("year_master.year_id",$yearid)
                ->get("year_master");

        if($query->num_rows()>0){
            $user = $query->row();

        }

        return $user;

    }



    



}//end of class