<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Users_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model('Users_model','model');
	}
	public function index()
	{
		if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Users')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('Users_view', $data);
		}
		else
		{
			$this->load->view('forbidden');
		}
	}

	public function save()
	{
		$data=$this->post();
		$success=FALSE;
		$msg= 'You are not permitted.';
		$id=0;
		if(!isset($data->UserId))
		{
			if($this->auth->IsInsert){
				$id=$this->model->add($data);
				$msg='Data inserted successfully';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){
				$id=$this->model->update($data->UserId, $data);
				$success=TRUE;
				$msg='Data updated successfully';				
			}		
		}
		print json_encode(array('success'=>$success, 'msg'=>$msg, 'id'=>$id));
	}

	public function delete()
	{
		if($this->auth->IsDelete){
			$data=$this->post();
			print json_encode( array("success"=>TRUE,"msg"=>$this->model->delete($data->UserId)));
		}
		else{
			print json_encode( array("success"=>FALSE,"msg"=>"You are not permitted"));
		}
	}
	public function get_Roles_list(){
		print  json_encode($this->model->get_Roles_list());
	}
public function get_Navigations_list(){
		print  json_encode($this->model->get_Navigations_list());
	}
	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->UserId));
	}
	public function get_all()
	{		
		print json_encode($this->model->get_all());
	}
	public function get_page()
	{	
		$data=$this->post();
		print json_encode($this->model->get_page($data->size, $data->pageno));
	}
	public function get_page_where()
	{	
		$data=$this->post();
		print json_encode($this->model->get_page_where($data->size, $data->pageno, $data));
	}	
}

?>