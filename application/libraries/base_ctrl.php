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
	
	protected $auth;
	protected $user;
	
}

?>