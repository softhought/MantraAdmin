<?php

class Trialbalancemodel extends CI_Model {

    public function getFiscalStartDt($yearid){
        $data = "";
        $where = array('year_id'=>$yearid);
        
        $this->db->select("starting_date")                
                ->from('year_master') 
                ->where($where);
        $query = $this->db->get();
        #echo "<br>".$this->db->last_query();
        if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->starting_date;
             
        }
		else
		{
            return $data;
        }       

    }   

    public function getAccountingPeriod($yearid){
        $data = array();
         $sql="SELECT * FROM financialyear WHERE financialyear.year_id=".$yearid;
         $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data=array(
                     "start_date"=>$rows->start_date,
                     "end_date"=>$rows->end_date
                 );                          

                }
                return $data;
         }else{
              return $data;
         }

    }

    public function getTypeOfAccount(){
        $data=array();
        $sql = "SELECT group_master.`id`,group_master.`group_name`
                FROM group_master WHERE group_master.`group_name` LIKE 'Sundry%' ";
        $query = $this->db->query($sql);

         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data[]=array(
                     "id"=>$rows->id,
                     "group_name"=>$rows->group_name
                 );                         

                }
                return $data;
         }else{
              return $data;
         }
    }
 

     public function getGroupName($groupId){
        $data = array();
         $sql="SELECT group_master.`id`,group_master.`group_name` FROM group_master WHERE group_master.id=".$groupId;
         $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data=array(
                    "id"=>$rows->id,
                     "group_name"=>$rows->group_name
                 );                         

                }
                return $data;
         }else{
              return $data;
         }


    }

   

}



?>