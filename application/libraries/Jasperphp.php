<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Jasperphp { 
	function jasperphp() { 
		$CI = & get_instance(); 
		log_message('Debug', 'jasper class is loaded.');
	 } 
	 function jasper($param=NULL) { 
		include_once APPPATH.'/third_party/phpjasperxml/class/tcpdf/tcpdf.php'; 
		include_once APPPATH.'/third_party/phpjasperxml/class/PHPJasperXML.inc.php'; 
		include_once APPPATH.'/third_party/phpjasperxml/class/PHPJasperXMLSubReport.inc.php'; 
			
		
		return new PHPJasperXML("en","TCPDF"); 
	 } 
 } 
 

    