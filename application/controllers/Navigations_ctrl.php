<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Navigations_ctrl extends base_ctrl {
	private static $tab2="\t\t";
	 private static $newLine="\r\n";
	function __construct() {
		parent::__construct();		
	    $this->load->model('Navigations_model','model');
	}
	public function index()
	{
		if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Navigations')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('Navigations_view', $data);
		}
		else
		{
			$this->load->view('forbidden');
		}
		
	}
	private function generate_routes(){
	
	$data=$this->model->get_all();
	$routes="";
	foreach($data as $col){
		$routes .=Navigations_ctrl::$tab2.'when(\'/'.$col->ActionPath.'\', { templateUrl:BASE_URL+\''.$col->ActionPath.'_ctrl\'}).'.Navigations_ctrl::$newLine;
		
	}
	$content='angular.module(\'project\', [\'ui.bootstrap\', \'ngGrid\', \'jQuery-ui\']).
  config(function($routeProvider) {
    $routeProvider.
      when(\'/\', { templateUrl:BASE_URL+\'home_ctrl\'}).
      '.$routes.'
      otherwise({redirectTo:\'/\'});
  });';
  $this->putContent('static/appScript/app.js', $content);
 }
  private function putContent($path, $content){
	//file_put_contents($path, $content, FILE_APPEND | LOCK_EX);
	$file=fopen($path, "w+");
	if($file==false){
		echo "Error in opening $file ";
		exit();
	}
	fwrite($file, $content);
	fclose($file);
 }
	public function save()
	{
		$data=$this->post();
		$success=FALSE;
		$msg= 'You are not permitted.';
		$id=0;
		if(!isset($data->NavigationId))
		{
			if($this->auth->IsInsert){
				$id=$this->model->add($data);
				$msg='Data inserted successfully';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){
				$id=$this->model->update($data->NavigationId, $data);
				$success=TRUE;
				$msg='Data updated successfully';				
			}		
		}
		$this->generate_routes();
		print json_encode(array('success'=>$success, 'msg'=>$msg, 'id'=>$id));
	}

	public function delete()
	{
		if($this->auth->IsDelete){
			$data=$this->post();
			print json_encode( array("success"=>TRUE,"msg"=>$this->model->delete($data->NavigationId)));
		}
		else{
			print json_encode( array("success"=>FALSE,"msg"=>"You are not permitted"));
		}
		$this->generate_routes();
	}
	public function get_Navigations_list(){
		print  json_encode($this->model->get_Navigations_list());
	}
	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->NavigationId));
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