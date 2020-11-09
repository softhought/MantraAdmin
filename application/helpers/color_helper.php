<?php

function getColor($acnt)
{
	if($acnt == '1')
	{
		$acnt = '#f56954';
	}
	else if($acnt == '2')
	{
		$acnt = '#00a65a';
	}
	else if($acnt == '3')
	{
		$acnt = '#f39c12';
	}
	else if($acnt == '4')
	{
		$acnt = '#00c0ef';
	}
	else if($acnt == '5')
	{
		$acnt = '#3c8dbc';
	}
	else if($acnt == '6')
	{
		$acnt = '#d2d6de';
	}
	else if($acnt == '7')
	{
		$acnt = '#99d1be';
	}
	else if($acnt == '8')
	{
		$acnt = '#7ef86e';
	}
	else if($acnt == '9')
	{
		$acnt = '#e6c4a3';
	}
	else if($acnt == '10')
	{
		$acnt = '#d662f4';
	}
	else if($acnt == '11')
	{
		$acnt = '#e3b56a';
	}
	else if($acnt == '12')
	{
		$acnt = '#d82392';
	}


	return $acnt;
}

?>