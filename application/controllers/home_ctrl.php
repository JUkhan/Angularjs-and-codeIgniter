<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class home_ctrl extends CI_Controller {
	function __construct() {
		parent::__construct();		
		
	}
	public function index()
	{
		$this->load->view('home_view');
	}

	
}

?>