<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employeeattendancemodel extends CI_Model{

    public function getTrainerByBrnAttReg($branch_id)
	{
        $data = array();
        $where = array('branch_id'=>$branch_id,'IS_ACTIVE'=>'Y','is_att_consider'=>'Y');

        $query = $this->db->select("*")
                          ->from('employee_master')
                          ->where($where)
                          ->order_by('empl_name')
                          ->get();
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

public function getAllEmployeeAtts($from_dt,$to_date,$branch_id,$employee)
	{
        $data = array();
        if($branch_id != ""){
        $where2 = array('employee_master.branch_id'=>$branch_id);
        }else{
            $where2 = array();
        }
        if($employee != ""){
            $where3 = array('employee_master.empl_id'=>$employee);
            }else{
                $where3 = array();
            }
        if($from_dt != "" && $to_date != ""){
            $where = "employee_attendance.att_date BETWEEN '".$from_dt."' AND '".$to_date."'";
        }else{
            $where = array();
        }
        $where4 = array('employee_master.is_att_consider'=>'Y');

        $query = $this->db->select("COUNT(*) AS presentDys,
                                    employee_master.empl_id,
                                    employee_master.empl_name,
                                    employee_master.desig_id,
                                    employee_master.empl_mobile,
                                    employee_master.branch_cd,
                                    employee_master.branch_id,
                                    employee_attendance.att_date,
                                    employee_attendance.tran_id,
                                    employee_attendance.in_time,
                                    employee_attendance.out_time,
                                    employee_attendance.time_spent,
                                    desig_master.desig_desc,
                                    branch_master.BRANCH_NAME")
                          ->from('employee_master')
                          ->join('employee_attendance','employee_master.empl_id = employee_attendance.employee_id')
                          ->join('desig_master','employee_master.desig_id = desig_master.desig_id')
                          ->join('branch_master','employee_master.branch_id = branch_master.BRANCH_ID')
                          ->where($where4)
                          ->where($where)
                          ->where($where2)
                          ->where($where3)
                          ->group_by('employee_attendance.employee_id')
                          ->order_by('employee_master.empl_name','ASC')
                          ->get();
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

public function getAllAttsEmployeeById($from_dt,$to_date,$employee)
	{
        $data = array();
        if($branch_id != ""){
        $where2 = array('employee_master.branch_id'=>$branch_id);
        }else{
            $where2 = array();
        }
        if($employee != ""){
            $where3 = array('employee_master.empl_id'=>$employee);
            }else{
                $where3 = array();
            }
        if($from_dt != "" && $to_date != ""){
            $where = "employee_attendance.att_date BETWEEN '".$from_dt."' AND '".$to_date."'";
        }else{
            $where = array();
        }
        $where4 = array('employee_master.is_att_consider'=>'Y');

        $query = $this->db->select("COUNT(*) AS presentDys,
                                    employee_master.empl_id,
                                    employee_master.empl_name,
                                    employee_master.desig_id,
                                    employee_master.empl_mobile,
                                    employee_master.branch_cd,
                                    employee_master.branch_id,
                                    employee_attendance.att_date,
                                    employee_attendance.tran_id,
                                    employee_attendance.in_time,
                                    employee_attendance.out_time,
                                    employee_attendance.time_spent,
                                    desig_master.desig_desc,
                                    branch_master.BRANCH_NAME")
                          ->from('employee_master')
                          ->join('employee_attendance','employee_master.empl_id = employee_attendance.employee_id')
                          ->join('desig_master','employee_master.desig_id = desig_master.desig_id')
                          ->join('branch_master','employee_master.branch_id = branch_master.BRANCH_ID')
                          ->where($where4)
                          ->where($where)
                          ->where($where2)
                          ->where($where3)
                          ->group_by('employee_attendance.employee_id')
                          ->order_by('employee_master.empl_name','ASC')
                          ->get();
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


}