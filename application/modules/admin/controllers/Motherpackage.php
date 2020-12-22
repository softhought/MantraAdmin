<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Motherpackage extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		$this->load->model('motherpackagemodel','motherpackagemodel',TRUE);		
		$this->load->model('renewalemindersmsmodel','renewalemindersmsmodel',TRUE);		
		$this->load->model('enquirymodel','enquirymodel',TRUE);		
     $this->load->module('template');
   

		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
      $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');     
      $data['cardlist'] = $this->motherpackagemodel->GetCardList();   
      $data['trainerlist'] = $this->renewalemindersmsmodel->GetTrainerListAll();  
      $data['userlist'] = $this->enquirymodel->getuserslist();  
            // pre($data['userlist']);exit;
      $data['view_file'] = 'dashboard/registration/report/motherpackage_reg_list';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function getmotherpackagereglist(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  
   
   
      if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
        $from_dt = date('Y-m-d',strtotime($this->input->post('from_dt')));
       }else{
        $from_dt=NULL;
       }
       if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
        $to_date = date('Y-m-d',strtotime($this->input->post('to_date')));
       }else{
        $to_date=NULL;
       }
       $branch =  $this->input->post('branch');
       $status =  $this->input->post('status');
       $search_by =  $this->input->post('search_by');
       $package =  $this->input->post('package');
       $trainer =  $this->input->post('trainer');
       $doneby =  $this->input->post('doneby');
       $close_by =  $this->input->post('close_by');
    
      // $branch =  $this->input->post('branch');
     
     
      $data['motherackagelist'] = $this->motherpackagemodel->getenquiryreportlist($from_dt,$to_date,$branch,$status,$search_by,$package,$trainer,$doneby,$close_by);
     // pre($data['motherackagelist']);exit;
    
     $page = 'dashboard/registration/report/motherpackage_reg_partial_list';      
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}

public function receiptpdf(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  { 

  //$payment_id = 49817;
  $payment_id = $this->uri->segment(4);
  $cus_id = $this->uri->segment(5);
 
//  pre($payment_id);

   $result['paymentdtl'] =  $this->motherpackagemodel->getpaymentdtl($payment_id,$cus_id);
    // pre($result['paymentdtl']);exit;
   $result['brn'] = $result['paymentdtl']->BRANCH_CODE;
   
   $fig_in_words =$this->no_to_words($result["paymentdtl"]->TOTAL_AMOUNT);
     
    $result['fig_in_words'] = rtrim($fig_in_words,' & ');
 
     $srl= $result['paymentdtl']->RCPT_NO;
    $srl_len=strlen($srl);
   $rem_len=3-$srl_len;
 
   for ($i=1; $i<=$rem_len; $i++)
   {
     $zero=@$zero."0";
   }
     $result['receipt_no']=$this->gen_rcpt_no_pad($srl,$result['brn']);
   
    
      // load library
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      ini_set('memory_limit', '256M'); 
      $page = "dashboard/registration/report/payment_receipt"; 

      $html = $this->load->view($page, $result, true);
     // render the view into HTML
     $pdf->WriteHTML($html); 
     $output = 'testPdf' . date('Y_m_d_H_i_s') . '_.pdf'; 
     $pdf->Output("$output", 'I');
     exit();

    //  $this->m_pdf->pdf->Output($pdfFilename, "D");
 
    }else{
      redirect('admin','refresh');

}
 
 }


 public function printwelletter(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  { 

  //$payment_id = 49817;
  
  $cus_id = $this->uri->segment(4);
 
//  pre($payment_id);
   $arrFitNesDesc = array();
   $arrFitNesQty = array();
   $arrWorkOutDesc = array();
   $arrWorkOutQty = array();
   $sum_qty = 0;
   $sum_qty2 = 0;
   $sum_qty3 = 0;
   $sum_qty4 = 0;
   $sum_qty5 = 0;
   $result['memberdtl'] =  $this->motherpackagemodel->getmemeberdtl($cus_id);
   $result['mem_name'] = ucwords(strtolower($result['memberdtl']->CUS_NAME));
    // pre($result['paymentdtl']);exit;
    $branch = $result['memberdtl']->branch_id;
    $card = $result['memberdtl']->card_id;
    $type="Part of Package";
    $sub_type="W/OUT";

    $result['carddtlbytype'] =  $this->motherpackagemodel->getCardDetailByType($branch,$card,$type,$sub_type);
    foreach($result['carddtlbytype'] as $carddtlbytype)
{
   
	   $cpn_desc=$carddtlbytype->coupon_title;  
      array_push($arrWorkOutDesc,$cpn_desc);
      array_push($arrWorkOutQty,number_format($carddtlbytype->qty,0));
}


    $group="GEN MED";
    $group_name="GENERAL MEDICAL ASSESSMENT";
    $carddtlbygroup1 =  $this->motherpackagemodel->getCardDetailBygroup($branch,$card,$group);

    foreach($carddtlbygroup1 as $carddtlbygroup1)
    {
      $sum_qty=$carddtlbygroup1->qty;
    }

    if ($sum_qty>0)
    {
      array_push($arrFitNesDesc,$group_name);
      array_push($arrFitNesQty,number_format($sum_qty,0));
    }

  
     $group="GEN FIT";
     $group_name="GENERAL FITNESS ASSESSMENT";
     $carddtlbygroup2 =  $this->motherpackagemodel->getCardDetailBygroup($branch,$card,$group);

     foreach($carddtlbygroup2 as $carddtlbygroup2)
     {
       $sum_qty2=$carddtlbygroup2->qty;
     }
 
     if ($sum_qty2>0)
     {
       array_push($arrFitNesDesc,$group_name);
       array_push($arrFitNesQty,number_format($sum_qty2,0));
     }
     
     $group="ORTHO";
     $group_name="ORTHOPEDIC SCREENING";
     $carddtlbygroup3 =  $this->motherpackagemodel->getCardDetailBygroup($branch,$card,$group);

     foreach($carddtlbygroup3 as $carddtlbygroup3)
     {
       $sum_qty3=$carddtlbygroup3->qty;
     }
 
     if ($sum_qty3>0)
     {
       array_push($arrFitNesDesc,$group_name);
       array_push($arrFitNesQty,number_format($sum_qty3,0));
     }

     $group="BODY COMP";
     $group_name="BODY COMPOSITION ASSESSMENT";
     $carddtlbygroup4 =  $this->motherpackagemodel->getCardDetailBygroup($branch,$card,$group);

     foreach($carddtlbygroup4 as $carddtlbygroup4)
     {
       $sum_qty4=$carddtlbygroup4->qty;
     }
 
     if ($sum_qty4>0)
     {
       array_push($arrFitNesDesc,$group_name);
       array_push($arrFitNesQty,number_format($sum_qty4,0));
     }

     $group="BLOOD TEST";
     $group_name="BLOOD TEST";
     $carddtlbygroup5 =  $this->motherpackagemodel->getCardDetailBygroup($branch,$card,$group);

     foreach($carddtlbygroup5 as $carddtlbygroup5)
     {
       $sum_qty5=$carddtlbygroup5->qty;
     }
 
     if ($sum_qty5>0)
     {
       array_push($arrFitNesDesc,$group_name);
       array_push($arrFitNesQty,number_format($sum_qty5,0));
     }


     $maxIndex=max(count($arrWorkOutDesc),count($arrFitNesDesc));
    
      if (count($arrWorkOutDesc)>count($arrFitNesDesc))
      {
        $fitMore=count($arrWorkOutDesc)-count($arrFitNesDesc);
        
        for($k=count($arrFitNesDesc);$k<$fitMore;$k++)
        {
          array_push($arrFitNesDesc,"");
          array_push($arrFitNesQty,"");
        }
        
      }

      if (count($arrFitNesDesc)>count($arrWorkOutDesc))
      {
        $workMore=count($arrFitNesDesc)-count($arrWorkOutDesc);
        for($k=count($arrWorkOutDesc);$k<$workMore;$k++)
        {
          array_push($arrWorkOutDesc,"");
          array_push($arrWorkOutQty,"");
        }
      }

     $result['arrFitNesDesc'] = $arrFitNesDesc;
     $result['arrFitNesQty'] = $arrFitNesQty;
     $result['arrWorkOutDesc'] = $arrWorkOutDesc;
     $result['arrWorkOutQty'] = $arrWorkOutQty;
     $result['maxIndex'] = $maxIndex;


       
     $type="Complimentary";
     $result['CardDetailByCompl'] =  $this->motherpackagemodel->getCardDetailByCompl($branch,$card,$type);

      
      // load library
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      ini_set('memory_limit', '256M'); 
      $page = "dashboard/registration/report/welcome_letter"; 

      $html = $this->load->view($page, $result, true);
      #echo $html;exit;
     // render the view into HTML
     $pdf->WriteHTML($html); 
     $output = 'testPdf' . date('Y_m_d_H_i_s') . '_.pdf'; 
     $pdf->Output("$output", 'I');
     exit();

    //  $this->m_pdf->pdf->Output($pdfFilename, "D");
 
    }else{
      redirect('admin','refresh');

}
 
 }



 function gen_rcpt_no_pad($srl,$brn)
{
	$srl_len=strlen($srl);
    $rem_len=8-$srl_len;

    for ($i=1; $i<=$rem_len; $i++)
    {
	    $zero=@$zero."0";
    }
	if($brn=="LT")
	{
	    $mSrl_no="SM".$zero.$srl;
	}
	else
	{
	    $mSrl_no="MH".$zero.$srl;
	}
   	return $mSrl_no;
}

public function no_to_words($no) {
		
	$words = array('0' => '', 
		'1' => 'one',
		'2' => 'two', 
		'3' => 'three', 
		'4' => 'four', 
		'5' => 'five', 
		'6' => 'six', 
		'7' => 'seven', 
		'8' => 'eight', 
		'9' => 'nine', 
		'10' => 'ten', 
		'11' => 'eleven',
		'12' => 'twelve', 
		'13' => 'thirteen', 
		'14' => 'fourteen', 
		'15' => 'fifteen', 
		'16' => 'sixteen', 
		'17' => 'seventeen', 
		'18' => 'eighteen', 
		'19' => 'nineteen', 
		'20' => 'twenty', 
		'30' => 'thirty', 
		'40' => 'fourty', 
		'50' => 'fifty', 
		'60' => 'sixty',
		'70' => 'seventy', 
		'80' => 'eighty', 
		'90' => 'ninty',
		'100' => 'hundred &', 
		'1000' => 'thousand', 
		'100000' => 'lakh', 
		'10000000' => 'crore');
	if ($no == 0)
		return ' ';
	else {
		$novalue = '';
		$highno = $no;
		$remainno = 0;
		$value = 100;
		$value1 = 1000;
		while ($no >= 100) {
			if (($value <= $no) && ($no < $value1)) {
				$novalue = $words["$value"];
				$highno = (int) ($no / $value);
				$remainno = $no % $value;
				break;
			}
			$value = $value1;
			$value1 = $value * 100;
		}
		if (array_key_exists("$highno", $words))
			return $words["$highno"] . " " . $novalue . " " .$this->no_to_words($remainno);
		else {
			$unit = $highno % 10;
			$ten = (int) ($highno / 10) * 10;
			return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " .$this->no_to_words($remainno);
		}
	}
}



}