<?php
/**
** User helper for all user related data
**/

/*Count user*/
function countUser(){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countUser();
}

/*Get user name*/
function getUsername($userid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getUsername($userid);
}

function getUseridag_leads($leadid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getUseridag_leads($leadid);
}

function countfollowLeadsaguser($id){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countfollowLeadsaguser($id);
}

function countcallsaguser($id){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countcallsaguser($id);
}