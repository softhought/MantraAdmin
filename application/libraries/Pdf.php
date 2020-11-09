<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class pdf { 


public function __construct($param = "'c', 'A4-L'")
{
       $CI = & get_instance(); 
		log_message('Debug', 'mPDF class is loaded.');
}
	// function pdf() { 
	// 	$CI = & get_instance(); 
	// 	log_message('Debug', 'mPDF class is loaded.');
	//  } 
	public function load($param=NULL) { 
		include_once APPPATH.'/third_party/mpdf/mpdf.php'; 
		$param = "'','A4', 0, '', 0, 0, 0, 0, 0, 0"; 
		//$param = "'','', 0, '', 15, 15, 16, 16, 9, 9, 'P'";
		
		return new mPDF($param); 
	 } 
 } 
 

    