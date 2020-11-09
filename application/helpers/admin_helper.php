<?php
/**
** Admin helper for all sub admin related data
**/


/*Get Super Admin Email*/
function getSupEmail(){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getSupEmail();
}

/*Get Tutor name*/
function getAdminname($adminid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getadminName($adminid);
}

/*Count sub admin*/
function countSubadmin(){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countsubAdmin();
}





/*Count User against Admin*/
function countUseragad($id){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countUseragad($id);
}

/*Count Leads against Admin*/
function countLeadsagad($id){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countLeadsagad($id);
}

/*Count Leads against User*/
function countLeadsaguser($id){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countLeadsaguser($id);
}

/*get  Username against Admin*/
function getusernameagad($id){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getusernameagad($id);
}



/*Get All Admin Id*/
function getAlladminid(){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getallAdminid();
}

/*Get leads from notify table*/
function getLeadsqty($adminid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getLeadsqty($adminid);
}

/*Count numrows by tbl*/
function countAllData($tbl){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countAllData($tbl);
}

/*Count numrows by tbl*/
function countsource($tbl){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countsource($tbl);
}