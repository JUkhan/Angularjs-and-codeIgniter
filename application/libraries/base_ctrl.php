<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class base_ctrl extends CI_Controller {
	function __construct() {
		parent::__construct();		
		$this->load->database();
	    $this->load->helper('url');
		if ( $this->session->userdata('login_state') == FALSE ) {
			redirect( "login" );
		}
		else{
			$this->auth=$this->session->userdata('auth');
			$this->user=$this->session->userdata('user');			
		}
	}
	
	protected function post(){
		return  json_decode(file_get_contents("php://input"));
	}
	
	protected function is_authentic($roleId, $userId, $action){
		$query= $this->db->query("SELECT NavigationId, NavName, NavOrder,ParentNavId,ActionPath
From navigations where NavigationId in(SELECT a.Navigations FROM NavigViewRight a 
WHERE a.Roles=".$this->db->escape($roleId)." or a.Users=".$this->db->escape($userId).") AND ActionPath =".$this->db->escape($action)." order by NavOrder");
	return $query->num_rows()>0;
	}
	
	protected $auth;
	protected $user;
	
}

?>