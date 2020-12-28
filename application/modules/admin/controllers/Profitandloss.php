<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Profitandloss extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
         $this->load->model('commondatamodel','commondatamodel',TRUE);	        
        $this->load->model('trialbalancemodel', '', TRUE);	 	
        $this->load->model('profitandlossmodel', 'profitandlossmodel', TRUE);	 	
        $this->load->model('generalledgermodel', '', TRUE);	 	
        $this->load->model('companymodel', '', TRUE);	
       // $this->load->library('jasperphp'); 	
         $this->load->module('template');
   		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
        $where = array('year_id'=>$session['yearid']);

		$financialyear = $this->commondatamodel->getSingleRowByWhereCls('year_master',$where);
        $data['start_date']=$financialyear->starting_date;
        $data['ending_date']=$financialyear->ending_date;
        //pre($data['start_date']);exit;
        $data['view_file'] = 'dashboard/account/reports/profitloss/profit_and_loss';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function profitandlosspdf(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    { 
  
    $companyId = $session['companyid'];
    $yearid = $session['yearid'];

    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');

    $frmDate = date("Y-m-d",strtotime($fromdate));
    $toDate = date("Y-m-d",strtotime($todate)); 

    $fiscalStartDt = $this->trialbalancemodel->getFiscalStartDt($yearid);	   
	
     $result['expenditureData']= $this->profitandlossmodel->getExpenditure($companyId,$yearid,$fiscalStartDt,$frmDate,$toDate);
    
     $result['incomeData']= $this->profitandlossmodel->getallIncome($companyId,$yearid,$fiscalStartDt,$frmDate,$toDate);
    
    $result['expenditureSum'] =  $this->findGroupBySum($result['expenditureData'],'GroupDescription','Expenditure');  
    $result['incomeSum'] =  $this->findGroupBySum($result['incomeData'],'GroupDescription','Income');  
     //pre($result['expenditureData']);
    // pre($result['incomeSum']);
    // exit;
	 
	   $result['accounting_period']=$this->generalledgermodel->getAccountingPeriod($yearid);
	   $result['company']=  $this->companymodel->getCompanyNameById($companyId);
	   
	   $result['fromDate'] = $fromdate;
	   $result['toDate'] = $todate;
   
     
      
        // load library
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 
        $page = "dashboard/account/reports/profitloss/profit_and_loss_print"; 
  
        $html = $this->load->view($page, $result, true);
       // render the view into HTML
       $pdf->WriteHTML($html); 
       $output = 'profitlossPdf' . date('Y_m_d_H_i_s') . '_.pdf'; 
       $pdf->Output("$output", 'I');
       exit();
  
      //  $this->m_pdf->pdf->Output($pdfFilename, "D");
   
      }else{
        redirect('admin','refresh');
  
  }
   
   }

function findGroupBySum($input ,$keysearch,$val){ 
    $summedArray = array();
       foreach ($input as $key => $value) {
           @$summedArray[$value[$keysearch]] += $value[$val];
       }
   return $summedArray;
}


}
