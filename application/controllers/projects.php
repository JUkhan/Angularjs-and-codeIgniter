<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Projects extends base_ctrl {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		 $this->load->model('Project_model','model');
	}
	public function index()
	{
		$result=$this->model->get_navigations($this->auth->RoleId, $this->user->UserId);
		$menu=$this->get_menu($result);
		
		$this->load->view('layout', array('menu'=>$menu));
	}
	private function get_menu($res){
	//NavigationId, NavName, NavOrder,ParentNavId,ActionPath
		$menu="";
		foreach($res as $item){
			if(is_null($item->ParentNavId)){
				$subMenu=$this->getSubMenu($res, $item->NavigationId);
				if($subMenu==""){
					$menu.='<li><a href="#/'.$item->ActionPath.'">'.$item->NavName.'</a></li>';
				}
				else{
					$menu .='<li class="dropdown">    
									<a data-toggle="dropdown" class="dropdown-toggle" href="#">'.$item->NavName.' <b class="caret"></b></a>
									<ul class="dropdown-menu">
										'.$subMenu.'
									</ul>
							</li>';
				}
			}
		}
		return $menu;
	}
	private function getSubMenu($list, $navId){
		$html="";
		foreach($list as $item){
			if($item->ParentNavId==$navId){		
				 $subMenu=$this->getSubMenu($list, $item->NavigationId);
				if($subMenu==""){
					$html.='<li><a href="#/'.$item->ActionPath.'">'.$item->NavName.'</a></li>';
				}
				else{
					$html .='<li class="dropdown">    
									<a data-toggle="dropdown" class="dropdown-toggle" href="#">'.$item->NavName.' <b class="caret"></b></a>
									<ul class="dropdown-menu">
										'.$subMenu.'
									</ul>
							</li>';
				}
			}
		}
		return $html;
	}
	
}

/* End of file projects.php */
/* Location: ./application/controllers/projects.php */