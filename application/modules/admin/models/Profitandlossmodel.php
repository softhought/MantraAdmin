<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profitandlossmodel extends CI_Model{

    public function getExpenditure($companyId,$yearid,$fiscalStartDt,$frmDate,$toDate)

    {
 
        $data = [];
 
         $call_procedure = "CALL usp_GetExpenditure($companyId,$yearid,'".$fiscalStartDt."','".$frmDate."','".$toDate."')";
 
        $query =$this->db->query($call_procedure);
       
 
        if($query->num_rows()>0){
 
            foreach ($query->result() as $rows) {
 
            $data[] = [
 
               "GroupDescription"=>$rows->GroupDescription,
 
               "AccountName"=>$rows->AccountName,
 
               "Expenditure"=>$rows->Expenditure,
 
               "TotalExpenditure"=>$rows->TotalExpenditure,
 
               "Total"=>$rows->Total,
 
              
 
 
            ];
 
        }
 
        }
        $query->next_result(); 
        $query->free_result();
         
        return $data;
        
 
    }

    public function getallIncome($companyId,$yearid,$fiscalStartDt,$frmDate,$toDate)

    {
 
        $data = [];
 
         $call_procedure2 = "CALL usp_GetIncome($companyId,$yearid,'".$fiscalStartDt."','".$frmDate."','".$toDate."')";
 
        $query =$this->db->query($call_procedure2);
       
 
        if($query->num_rows()>0){
 
            foreach ($query->result() as $rows) {
 
            $data[] = [
 
               "GroupDescription"=>$rows->GroupDescription,
 
               "AccountName"=>$rows->AccountName,
 
               "Income"=>$rows->Income,
 
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