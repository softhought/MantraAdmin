<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Balancesheetmodel extends CI_Model{

    public function getLiabilities($companyId,$yearid,$fiscalStartDt,$frmDate,$toDate)

    {
 
        $data = [];
 
         $call_procedure = "CALL usp_GetLiabilities($companyId,$yearid,'".$fiscalStartDt."','".$toDate."','".$frmDate."')";
 
        $query =$this->db->query($call_procedure);
       
 
        if($query->num_rows()>0){
 
            foreach ($query->result() as $rows) {
 
            $data[] = [
 
               "GroupDescription"=>$rows->GroupDescription,
 
               "AccountName"=>$rows->AccountName,
 
               "Liabilities"=>$rows->Liabilities,
 
               "TotalIncome"=>$rows->TotalIncome,
 
               "Total"=>$rows->Total,
 
              
 
 
            ];
 
        }
 
        }
        $query->next_result(); 
        $query->free_result();
         
        return $data;
        
 
    }

    public function getAssets($companyId,$yearid,$fiscalStartDt,$frmDate,$toDate)

    {
 
        $data = [];
 
         $call_procedure2 = "CALL usp_GetAssets($companyId,$yearid,'".$fiscalStartDt."','".$frmDate."','".$toDate."')";
 
        $query =$this->db->query($call_procedure2);
       
 
        if($query->num_rows()>0){
 
            foreach ($query->result() as $rows) {
 
            $data[] = [
 
               "GroupDescription"=>$rows->GroupDescription,
 
               "AccountName"=>$rows->AccountName,
 
               "Asset"=>$rows->Asset,
 
               "TotalIncome"=>$rows->TotalIncome,
 
               "Total"=>$rows->Total,
 
              
 
 
            ];
 
        }
 
        }
        $query->next_result(); 
        $query->free_result();
        return $data;
 
    }
 


}