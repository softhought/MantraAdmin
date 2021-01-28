<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class about extends CI_Controller {



 public function __construct()

 {

   parent::__construct();

    $this->load->model('homemodel','',TRUE);

    $this->load->model('aboutusmodel','',TRUE);

    $this->load->model('Commondatamodel','',TRUE);

  }

	

 public function index()

 {

	$page = 'about/about-us';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

 }





public function journey(){



	$page = 'about/our-journey';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

}



public function founder(){



	$page = 'about/founder-directors';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

}



public function advisory(){



	$page = 'about/advisory-board';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

}

public function award(){



	$page = 'about/award-media';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

}

public function bharat_gourav_award(){



	$page = 'about/bharat-gourav-award';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

}


 public function trainer()

 {

	$page = 'about/specialists';

	$header = "";

	$session="";

	$result=[];



    $result['GymTrainer'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Gym Trainer'","ALL");

    $result['FitnessTechnician'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Fitness Technician'","ALL");

    $result['YogaTeacher'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Yoga Teacher'","ALL");

    $result['CardioCoach'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Cardio Coach'","ALL");

    $result['Dietician'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Dietician'","ALL");

    $result['Physiotherapist'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Physiotherapist'","ALL");

    $result['contactBranch'] = $this->homemodel->getWebBranch();

    $result['teamCategory'] = $this->aboutusmodel->getWebTeamCategory();





		// echo "<pre>";

		// print_r($result['GymTrainer']);

		// echo "</pre>";



		// exit;

   		



	createbody_method($result,$page,$header,$session);

 }

 

public function branchandcategory(){



   	$branch_id=$this->input->post('branch_id');

    $category=$this->input->post('specialist_id');

    

	



	if($branch_id!="0" and $category == "0"){

   

     $wherebranch = array('web_branch.id' =>$branch_id);

	$branch_code=$this->Commondatamodel->getSingleRowByWhereCls('web_branch',$wherebranch)->branch_code;

		



		$result['GymTrainer'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Gym Trainer'",$branch_code);

		$result['FitnessTechnician'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Fitness Technician'",$branch_code);

        $result['YogaTeacher'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Yoga Teacher'",$branch_code);

        $result['CardioCoach'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Cardio Coach'",$branch_code);

        $result['Dietician'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Dietician'",$branch_code);

        $result['Physiotherapist'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Physiotherapist'",$branch_code);

		    



		    $this->load->view('about/all-specialist',$result);

	}

	elseif($branch_id =="0" and $category == "0"){



		    $result['GymTrainer'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Gym Trainer'","ALL");

		    $result['FitnessTechnician'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Fitness Technician'","ALL");

		    $result['YogaTeacher'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Yoga Teacher'","ALL");

		    $result['CardioCoach'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Cardio Coach'","ALL");

		    $result['Dietician'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Dietician'","ALL");

		    $result['Physiotherapist'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Physiotherapist'","ALL");

		    

		   $this->load->view('about/all-specialist',$result); 





	}

	else{



		$result['GymTrainer'] = $this->aboutusmodel->getcatbandata($branch_id,$category);

		$result['category'] = array('category'=>$category);

		$this->load->view('about/specific-specialist',$result);

	}

   //

   // $result['GymTrainer'] = $this->aboutusmodel->getTeamMantraByCatAndBranch("'Gym Trainer'","'BP'");

   

  //  echo "<pre>";

		// print_r( $result['GymTrainer']);

		// echo "</pre>";



		// exit;

  

	

}



public function pain()

 {

	$page = 'magic_mantra/pain-management';

	$header = "";

	$session="";

	$result=[];



	createbody_method($result,$page,$header,$session);

 }

} // end of class



?>