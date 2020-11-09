<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('class/tcpdf/tcpdf.php');
include_once("class/PHPJasperXML.inc.php");
include_once("class/PHPJasperXMLSubReport.inc.php");
// include_once ('setting.php');


$dbdriver="mysql";//natively is 'mysql', 'psql', or 'sqlsrv'. the rest will use PDO driver. for oracle, use 'oci'
$server="localhost";
$db="teasamrat";
$user="root";
$pass="";


// usp_TrialBalance(1,8,'2018-04-01','2018-04-30','2018-04-01')


$PHPJasperXML = new PHPJasperXML("en","TCPDF"); //if export excel, can use PHPJasperXML("en","XLS OR XLSX"); 
// $PHPJasperXML->debugsql=true;	
$PHPJasperXML->arrayParameter = array('CompanyId'=>1,'YearId'=>8,'fromDate'=>'"2018-04-01"','toDate'=>'"2018-04-30"','fiscalstartdate'=>'"2018-04-01"','CompanyName'=>'Test CompanyName','CompanyAddress'=>'Test CompanyAddress');
$PHPJasperXML->load_xml_file('report44.jrxml'); //if xml content is string, then $PHPJasperXML->load_xml_string($templatestr);


$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db,$dbdriver);

$PHPJasperXML->outpage('I');  //$PHPJasperXML->outpage('I=render in browser/D=Download/F=save as server side filename according 2nd parameter','filename.pdf or filename.xls or filename.xls depends on constructor');


?>