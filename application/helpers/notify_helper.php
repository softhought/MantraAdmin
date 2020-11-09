<?php
/**
** Notify helper for all Notification related data
**/

function getnumrows($adminid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getnumrows($adminid);
}

function getLeadsforadmin($adminid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->getLeadsforadmin($adminid);
}


function countNotifyrows($adminid){
	$CI =& get_instance();
	$CI->load->model('commonhelper/Commonhelper_model');

	return $result = $CI->Commonhelper_model->countNotifyrows($adminid);
}