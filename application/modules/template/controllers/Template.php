<?php



class Template extends MX_Controller

{

	public function __construct()

	{

		parent ::__construct();

        date_default_timezone_set('Asia/Kolkata'); 

		$this->load->model('Template_model','_templates',TRUE);

		$this->load->model('commondatamodel','commondatamodel',TRUE);

	}

	public function admin_template($data = NULL)

	{

		$session = $this->session->userdata('mantra_user_detail');	

	

		$user_id = $session['userid'];	

		//pre($session);exit;

		$menus = $this->_templates->getadminmenulist('admin_menu_master',$user_id);

		$data['menu'] = $menus;

		$data['username'] = $session['username'];

		$data['acc_period'] = $session['acc_period'];

		$data['companyname'] = $session['companyname'];

		$where = array('year_id'=>$session['yearid']);

    //   pre($data['menu']);exit;

		$financialyear = $this->commondatamodel->getSingleRowByWhereCls('year_master',$where);

		$data['start_date']=$financialyear->starting_date;

		$data['end_date']=$financialyear->ending_date;

		$data['menuListDropdown']=$this->menuList($user_id);

		//pre($data['menu']);exit;

		

		$this->load->view('template/admin_template', $data);

	}

	function menuList($user_id){

       $menuParentList = $this->_templates->getSearchParentMenuList($user_id);
       $menuList=[];
       foreach ($menuParentList as $menuparentlist) {
          $childList = $this->_templates->getSearchMenuListParentId($menuparentlist->id,$user_id);
          if ($childList) {
              foreach ($childList as $childlist) {
                $subChildList = $this->_templates->getSearchMenuListParentId($childlist->id,$user_id);
                if ($subChildList) {
                    foreach ($subChildList as $subchildlist) {
                        $menuList[] = array(
                                  'menuid' => $subchildlist->id, 
                                 // 'name' => $menuparentlist->menu_name."&#10233;".$childlist->menu_name."&#10233;".$subchildlist->menu_name, 
                                  'name' => $subchildlist->menu_name, 
                                  'menulink' => $subchildlist->menu_link, 
                                );
                    }
                }else{
                    $menuList[] = array(
                                  'menuid' => $childlist->id, 
                                 // 'name' => $menuparentlist->menu_name."&#10233;".$childlist->menu_name, 
                                  'name' => $childlist->menu_name, 
                                  'menulink' => $childlist->menu_link, 
                                );
                }
              }
          }else{
            $menuList[] = array(
                                  'menuid' => $menuparentlist->id, 
                                  'name' => $menuparentlist->menu_name, 
                                  'menulink' => $menuparentlist->menu_link, 
                                );
          }
       }

       return $menuList;

}

}