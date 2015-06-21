<?php 
require_once ('JCrud.php');
require_once ('util.php');
$data = json_decode(file_get_contents("php://input"));
$cg=new CodeGen();
$cg->action=$data->action;
$cg->tableName= $data->tableName;
$cg->tableId= $data->tableId;
$cg->execute();

class CodeGen
{
 public function  __construct( ){}
 public $pkColName, $tableName, $tableId, $action, $mysql;
 private static $newLine="\r\n";
 private static $tab1="\t";
 private static $tab2="\t\t";
 private static $tab3="\t\t\t";
 private static $tab4="\t\t\t\t";
 private static $tab5="\t\t\t\t\t";
 
 private function loadData(){
	$db=new JCrud();
	$sql="select * from columns where tableId=? order by orderNo";
	$params[]=$this->tableId;
	$this->allColumns=$db->query2($sql, $params);
	
 }
 public function execute(){ 
	$this->loadData();
	if($this->action=='mysql'){
		$this->MySql();
		response(null, null, $this->mysql, TRUE);
	}
	else
	{	
		$this->PHP();		
		response(null, null, 'Code has been generated successfully !', TRUE);
	}	
 }
  private function PHP(){	
	$this->MySql();
	$this->helper();
	$controller=$this->generate_controller();
	$this->putContent('../application/controllers/'.$this->tableName.'_ctrl.php', $controller);
	$model=$this->generate_model();
	$this->putContent('../application/models/'.$this->tableName.'_model.php', $model);
	$view=$this->generate_view();
	$this->putContent('../application/views/'.$this->tableName.'_view.php', $view);
	$script=$this->generate_script();
	$this->putContent('../static/appScript/'.$this->tableName.'Ctrl.js', $script);
	$db=new JCrud();
	$params[]=$this->tableName;
	$db->insert('insert into SyncTables(TableName) values(?)', $params);
	$db->query1($this->mysql);
	//$routes=$this->generate_routes();
	//$this->putContent('../static/appScript/app.js', $routes);
 }
 private function generate_routes(){
	$db=new JCrud();
	$data=$db->query1('select TableName from SyncTables');
	$routes="";
	foreach($data as $col){
		$routes .=CodeGen::$tab2.'when(\'/'.$col->TableName.'\', { templateUrl:BASE_URL+\''.$col->TableName.'_ctrl\'}).'.CodeGen::$newLine;
	}
	$content='angular.module(\'project\', [\'ui.bootstrap\', \'ngGrid\', \'jQuery-ui\']).
  config(function($routeProvider) {
    $routeProvider.
      when(\'/\', { templateUrl:BASE_URL+\'home_ctrl\'}).
      '.$routes.'
      otherwise({redirectTo:\'/\'});
  });';
  return $content;
 }
 private function createNewFile($path){
	$file = fopen($path, 'w') or die("can't open file");	
	fclose( $file );
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
 
 private function getMysqlType($type, $size){
	if($type=='int') return " int(11)";
	else if($type=='bigInt') return " bigint(20)";
	else if($type=='varchar') return " varchar(".$size.")";
	else if($type=='date') return " date";
	else if($type=='dateTime') return " datetime";
	else if($type=='double') return " double";
	else if($type=='boolean') return " tinyint(1)";
	return " ";
 }
 private $ctrl_helper, $join, $select, $where,$model_for_dropdown, $form, $qs;
 private function setWhere($col){
	if($col->isQuickSearch==1){
				if($col->dataType=="varchar"){
					$this->where .='if(isset($params->'.$col->colName.') && !empty($params->'.$col->colName.')){
				$this->db->like("'.$this->tableName.'.'.$col->colName.'",$params->'.$col->colName.');
			}	'.CodeGen::$newLine;
				}
				else{
					$this->where .='if(isset($params->'.$col->colName.') && !empty($params->'.$col->colName.')){
				$this->db->where("'.$this->tableName.'.'.$col->colName.'",$params->'.$col->colName.');
			}	'.CodeGen::$newLine;
				}
		
	}
 }
 private function form_helper($col, $flag){
	//text 
	if($flag==1){
		$type=( stristr($col->colName, "password"))?'password':'text';
		if($col->isNull==1)
		{
			$this->form .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input class="input-xlarge" type="'.$type.'" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" />		  
		</div></div>'.CodeGen::$newLine;
		}
		else
		{
			$this->form .=' <div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
		<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input class="input-xlarge" type="'.$type.'" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" required />
		  <span ng-show="myForm.'.$col->colName.'.$error.required" class="help-inline">Required</span>
		</div>
	  </div>'.CodeGen::$newLine;
		}
	}
	//textarea
	else if($flag==2){
		if($col->isNull==1)
		{
			$this->form .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <textarea class="input-xxlarge"  name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" ></textarea>		  
		</div></div>'.CodeGen::$newLine;
		}
		else
		{
			$this->form .=' <div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
		<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <textarea class="input-xxlarge"  name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" required ></textarea>
		  <span ng-show="myForm.'.$col->colName.'.$error.required" class="help-inline">Required</span>
		</div>
	  </div>'.CodeGen::$newLine;
		}
	}
	//select 
	else if($flag==3){
		if($col->isNull==1)
		{
			$this->form .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <select ng-options="s.'.$col->optionsValue.' as s.'.$col->optionsText.' for s in '.$col->refTableName.'List"  name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" ></select>		  
		</div></div>'.CodeGen::$newLine;
		}
		else
		{
			$this->form .=' <div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
		<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <select ng-options="s.'.$col->optionsValue.' as s.'.$col->optionsText.' for s in '.$col->refTableName.'List"  name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" required ></select>
		  <span ng-show="myForm.'.$col->colName.'.$error.required" class="help-inline">Required</span>
		</div>
	  </div>'.CodeGen::$newLine;
		}
	}
	//date picker
	else if($flag==4)
	{
		$this->typeCast .='$scope.item.'.$col->colName.'=getDate($scope.item.'.$col->colName.');'.CodeGen::$newLine.CodeGen::$tab2;
		if($col->isNull==1)
		{
			$this->form .='<div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
			<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input  datepicker-popup="dd/MM/yyyy" type="date" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" />
			<span ng-show="myForm.'.$col->colName.'.$error.date" class="help-inline">Not a valid date</span>
		</div></div>'.CodeGen::$newLine;
		}
		else
		{
			$this->form .=' <div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
		<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input  datepicker-popup="dd/MM/yyyy" type="date" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" required />
		  <span ng-show="myForm.'.$col->colName.'.$error.required" class="help-inline">Required</span>
		  <span ng-show="myForm.'.$col->colName.'.$error.date" class="help-inline">Not a valid date</span>
		</div>
	  </div>'.CodeGen::$newLine;
		}
	}
	//checkbox
	else if($flag==5){
		$this->form .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input  type="checkbox" ng-true-value="1" ng-false-value="0" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" />		  
		</div></div>'.CodeGen::$newLine;
	}
	else if($flag==6)
	{
		if($col->isNull==1)
		{
			$this->form .='<div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
			<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input type="email" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" />
			<span ng-show="myForm.'.$col->colName.'.$error.email" class="help-inline">Not a valid email</span>
		</div></div>'.CodeGen::$newLine;
		}
		else
		{
			$this->form .=' <div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
		<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input type="email" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" required />
		  <span ng-show="myForm.'.$col->colName.'.$error.required" class="help-inline">Required</span>
		  <span ng-show="myForm.'.$col->colName.'.$error.email" class="help-inline">Not a valid email</span>
		</div>
	  </div>'.CodeGen::$newLine;
		}
	}
	else if($flag==7)
	{
		$this->typeCast .='$scope.item.'.$col->colName.'=Number($scope.item.'.$col->colName.');'.CodeGen::$newLine.CodeGen::$tab2;
		if($col->isNull==1)
		{
			$this->form .='<div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
			<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input type="number" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" />
			<span ng-show="myForm.'.$col->colName.'.$error.number" class="help-inline">Not a valid number</span>
		</div></div>'.CodeGen::$newLine;
		}
		else
		{
			$this->form .=' <div class="control-group" ng-class="{error: myForm.'.$col->colName.'.$invalid}">
		<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input type="number" name="'.$col->colName.'" id="'.$col->colName.'" ng-model="item.'.$col->colName.'" required />
		  <span ng-show="myForm.'.$col->colName.'.$error.required" class="help-inline">Required</span>
		  <span ng-show="myForm.'.$col->colName.'.$error.number" class="help-inline">Not a valid number</span>
		</div>
	  </div>'.CodeGen::$newLine;
		}
	}
 }
 private function qs_helper($col, $flag){
	//text 
	if($flag==1){
		
			$this->qs .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input class="input-xlarge" type="text"  ng-model="search.'.$col->colName.'" />		  
		</div></div>'.CodeGen::$newLine;
		
	}
	//textarea
	else if($flag==2){
		
			$this->qs .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <textarea class="input-xlarge"   ng-model="search.'.$col->colName.'" ></textarea>		  
		</div></div>'.CodeGen::$newLine;
		
	}
	//select 
	else if($flag==3){
		
			$this->qs .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <select ng-options="s.'.$col->optionsValue.' as s.'.$col->optionsText.' for s in '.$col->refTableName.'List"   ng-model="search.'.$col->colName.'" ></select>		  
		</div></div>'.CodeGen::$newLine;
		
	}
	//date picker
	else if($flag==4)
	{	
		$this->qs .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input  datepicker-popup="dd/MM/yyyy" type="date"  ng-model="search.'.$col->colName.'" />		  
		</div></div>'.CodeGen::$newLine;
	}
	//checkbox
	else if($flag==5){
		$this->qs .='<div class="control-group" ><label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input  type="checkbox" ng-true-value="1" ng-false-value="0"  ng-model="search.'.$col->colName.'" />		  
		</div></div>'.CodeGen::$newLine;
	}
	else if($flag==6){
		$this->qs .='<div class="control-group" >
			<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input type="email" ng-model="item.'.$col->colName.'" />
			
		</div></div>'.CodeGen::$newLine;
	}
	else if($flag==7){
		$this->qs .='<div class="control-group" >
			<label class="control-label" for="'.$col->colName.'">'.$col->colName.'</label>
		<div class="controls">
		  <input type="number" ng-model="item.'.$col->colName.'" />
			
		</div></div>'.CodeGen::$newLine;
	}
	
 }
 private $dropdownDalaLoad, $undefined_field, $grid, $typeCast, $date_time;
 private function helper(){
	//CodeGen::$newLine CodeGen::$tab1
	$this->typeCast="";
	$this->grid="";
	$this->undefined_field="";
	$this->dropdownDalaLoad="";
	$this->form="";
	$this->qs="";
	$this->ctrl_helper="";
	$this->join="";
	$this->select ="";
	$this->where ="";
	$this->model_for_dropdown ="";
	$this->date_time="";
	$this->select .=strval($this->tableName).'.'.$this->pkColName;	
	foreach($this->allColumns as $col){
		
		if($col->isPk==1){
			//$this->select .=strval($this->tableName).'.'.$col->colName;			
		}
		else if(!empty($col->refTableName)){
			$this->ctrl_helper .='public function get_'.$col->refTableName.'_list(){
		print  json_encode($this->model->get_'.$col->refTableName.'_list());
	}'.CodeGen::$newLine;
			if(($col->refTableName===$this->tableName)){
			$this->join	.=CodeGen::$newLine.'->join(\''.$col->refTableName.' as x\', \''.$this->tableName.'.'.$col->colName.' = x.'.$col->optionsValue.'\', \'left outer\')';
			$this->select .=',x.'.$col->optionsText.' as '.$col->refTableName.'_'.$col->optionsText;
			}
			else{
			$this->join	.=CodeGen::$newLine.'->join(\''.$col->refTableName.'\', \''.$this->tableName.'.'.$col->colName.' = '.$col->refTableName.'.'.$col->optionsValue.'\', \'left outer\')';
			$this->select .=','.$col->refTableName.'.'.$col->optionsText.' as '.$col->refTableName.'_'.$col->optionsText;
			}
			$this->select .=','.$this->tableName.'.'.$col->colName;			
			$this->setWhere($col);
			$this->model_for_dropdown .='public function get_'.$col->refTableName.'_list(){
		return $this->db->select(\''.$col->optionsValue.', '.$col->optionsText.'\')->get(\''.$col->refTableName.'\')->result();
	}';
		if($col->isForm==1)
			$this->form_helper($col, 3);
		if($col->isQuickSearch==1){
			$this->qs_helper($col, 3);
			}
			$this->dropdownDalaLoad .=CodeGen::$tab2.'loadData(\'get_'.$col->refTableName.'_list\',{}).success(function(data){$scope.'.$col->refTableName.'List=data;});'.CodeGen::$newLine;
			$this->undefined_field .=CodeGen::$tab2.'record.'.$col->refTableName.'_'.$col->optionsText.'=undefined;'.CodeGen::$newLine;
			if($col->isGrid==1){
				$this->grid .=CodeGen::$tab4.',{field: \''.$col->refTableName.'_'.$col->optionsText.'\', displayName: \''.$col->refTableName.'\'}'.CodeGen::$newLine;
			}
		}
		else {
			$this->select .=','.$this->tableName.'.'.$col->colName;
			$this->setWhere($col);
			if($col->isForm==1)
			$this->form_helper($col, $this->getFormType($col));
			if($col->isQuickSearch==1)
			$this->qs_helper($col, $this->getFormType($col));
			if($col->isGrid==1){
				if($this->getFormType($col)==4){				
					$this->grid .=CodeGen::$tab4.',{field: \''.$col->colName.'\', displayName: \''.$col->colName.'\', cellFilter: "date:\'dd/MM/yyyy\'"}'.CodeGen::$newLine;
					$this->date_time .='$scope.item.'.$col->colName.'=null; ';
				}
				else{
					$this->grid .=CodeGen::$tab4.',{field: \''.$col->colName.'\', displayName: \''.$col->colName.'\'}'.CodeGen::$newLine;
					}
			}
		}
		
	}
	
 }
 
 private function getFormType($col){
	if($col->dataType==="boolean") return 5;
	else if($col->dataType==="date" || $col->dataType==="dateTime" ) return 4;
	else if( stristr($col->colName, "description")) return 2;
	else if( stristr($col->colName, "address")) return 2;
	else if( stristr($col->colName, "note")) return 2;
	else if( stristr($col->colName, "email")) return 6;
	else if( $col->dataType==="int" || $col->dataType==="bigint" || $col->dataType==="double") return 7;	
	return 1;
	
 }
 private function countWhere(){
	if(!empty($this->join)) return '$this->db'. $this->join.';'.CodeGen::$newLine;
	return '';
 }
 private function findPkColumn(){
	foreach($this->allColumns as $col){
		
		if($col->ai==1 && $col->isPk==1){			
			return $col->colName;
		}
		else if( $col->isPk==1){
			$content.=CodeGen::$tab1.$col->colName.$this->getMysqlType($col->dataType, $col->size)." NOT NULL,".CodeGen::$newLine;
			return $col->colName;
		}
		
	}
	return 'pk_id';
 }
 private function MySql(/*$contentPath*/){
	$pk=$this->findPkColumn();
	$content=CodeGen::$newLine."CREATE TABLE IF NOT EXISTS ".$this->tableName." (".CodeGen::$newLine;
	foreach($this->allColumns as $col){
		
		if($col->ai==1 && $col->isPk==1){
			$content.=CodeGen::$tab1.$col->colName.$this->getMysqlType($col->dataType, $col->size)." NOT NULL AUTO_INCREMENT,".CodeGen::$newLine;
			//$pk=$col->colName;
		}
		else if( $col->isPk==1){
			$content.=CodeGen::$tab1.$col->colName.$this->getMysqlType($col->dataType, $col->size)." NOT NULL,".CodeGen::$newLine;
			//$pk=$col->colName;
		}
		else {
		$content.=CodeGen::$tab1.$col->colName.$this->getMysqlType($col->dataType, $col->size).($col->isNull==0?" NOT NULL ":'').",".CodeGen::$newLine;
		}
	}
	$content.=CodeGen::$tab1."PRIMARY KEY (".$pk.")".CodeGen::$newLine;
	$content.=") ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;".CodeGen::$newLine;
	//$this->putContent($contentPath, $content);
	$this->mysql=$content;
	$this->pkColName=$pk;
 }
 
private function generate_model(){
	$content='<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');

class '.$this->tableName.'_model extends CI_Model
{
    public $table = \''.$this->tableName.'\';

	'.$this->model_for_dropdown.'
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select(\''.$this->select.'\')
			'.$this->join.';
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select(\''.$this->select.'\')
		'.$this->join.';'.CodeGen::$newLine.'
		'.$this->where.'
		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		'.$this->countWhere().'
		'.$this->where.'
		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->count_all_results($this->table);
	}
    public function get($id)
    {
        return $this->db->where(\''.$this->pkColName.'\', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where(\''.$this->pkColName.'\', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where(\''.$this->pkColName.'\', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
	
}

?>';
	return $content;
}
private function generate_script(){

	$content='
function '.$this->tableName.'Ctrl($scope, $http){	
	$scope.auth=getAuth();
	this.init($scope);	
	
	//Grid,dropdown data loading
	loadGridData($scope.pagingOptions.pageSize,1);
	'.$this->dropdownDalaLoad.'
	
	//CRUD operation
	$scope.saveItem=function(){	
		var record={};
		angular.extend(record,$scope.item);
		'.$this->undefined_field.'
		loadData(\'save\',record).success(function(data){
			toastr.success(data.msg);
			if(data.success){
				loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
			}			
			$scope.item=null;
		});
	};			
	$scope.editItem=function(row){	
		$scope.item=row.entity;
		'.$this->typeCast.'
		$scope.fgShowHide=false;				
	};
	$scope.deleteItem=function(row){
		if(confirm(\'Delete sure!\')){
			loadData(\'delete\',row.entity).success(function(data){
				toastr.success(\'Data removed successfully\');
				$scope.list.splice($scope.list.indexOf(row.entity), 1);
				$scope.totalItems--;
			});
		}
	};
	
	//pager events
	$scope.$watch(\'pagingOptions\', function (newVal, oldVal) {
		if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {		  
		  loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
		}
		else if (newVal !== oldVal && newVal.pageSize !== oldVal.pageSize) {		  
		  loadGridData($scope.pagingOptions.pageSize, 1);
		}
	}, true);
	
	//search
	$scope.doSearch=function(){
		loadGridData($scope.pagingOptions.pageSize, 1);
	};
	
	//Utility functions
	function isSearch(){
		if(!$scope.search) return false;
		for(var prop in $scope.search){
			if($scope.search.hasOwnProperty(prop) && $scope.search[prop]) return true;
		}
		return false;
	}
	function loadGridData(pageSize, currentPage){
		var action=isSearch()?\'get_page_where\':\'get_page\', params={size:pageSize, pageno:(currentPage-1)*pageSize};
		angular.extend( params, $scope.search);
		loadData(action,params).success(function(res){
			$scope.list=res.data;
			$scope.totalItems=res.total
		});
	}
	function loadData(action,data){
		return $http({
			  method: \'POST\',
			  url: BASE_URL+\''.$this->tableName.'_ctrl/\'+action,
			  data: data,
			  headers: {\'Content-Type\': \'application/x-www-form-urlencoded\'}			  
			});		
	}
	function getDate(source){		
		if(typeof source ===\'string\'){;
			var dt=source.split(\' \')[0];
			return new Date(dt);
		}
		return source;
	}
}
 '.$this->tableName.'Ctrl.prototype.init=function($scope){
	$scope.search=null;
	$scope.item=null;
	$scope.list = null;
	$scope.fgShowHide=true;
	$scope.searchDialog=false;
	$scope.DepartmentList=null;	

	this.configureGrid($scope);	
	this.searchPopup($scope);
 };
'.$this->tableName.'Ctrl.prototype.configureGrid=function($scope){
	$scope.totalItems = 0;
    $scope.pagingOptions = {
        pageSizes: [10, 20, 30, 50, 100, 500, 1000],
        pageSize: 20,
        currentPage: 1
    };	
	var actionWidth=($scope.auth.update&&$scope.auth[\'delete\'])?130:($scope.auth.update || $scope.auth[\'delete\'])?75:0;
    $scope.gridOptions = { 
        data: \'list\',
        columnDefs: [
				{field:\'\', displayName:\'Action\', width:actionWidth,	cellTemplate:\'<div style="position:relative;top:4px;padding-left:2px"><button ng-show="auth.update"  ng-click="editItem(row)" class="btn btn-primary btn-mini" ><i class="icon-edit icon-white"></i> Edit</button>&nbsp;<button ng-show="auth.delete" ng-click="deleteItem(row)" class="btn btn-danger btn-mini"><i class="icon-trash icon-white"></i> Delete</button> </div>\'
				}
				'.$this->grid.'
			],
		enableRowSelection:false,
		enableCellSelection:true, 
		//enablePinning: true,
		enablePaging: true,
		showFooter: true,
		totalServerItems: \'totalItems\',
		pagingOptions: $scope.pagingOptions
	};
};
'.$this->tableName.'Ctrl.prototype.searchPopup=function($scope){
	$scope.showForm=function(){$scope.fgShowHide=false; $scope.item={}; '.$this->date_time.'};
	$scope.hideForm=function(){$scope.fgShowHide=true;};
	$scope.openSearchDialog=function(){		
		$scope.searchDialog=true;
	};
	$scope.closeSearchDialog=function(){		
		$scope.searchDialog=false;
	};	
	$scope.refreshSearch=function(){$scope.search=null;};
	
};';
	
	return $content;
}
private function generate_view(){
	$content='<script src="static/appScript/'.$this->tableName.'Ctrl.js"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="'.$this->tableName.'Ctrl">

<div ng-show="fgShowHide" class="btn-toolbar">
	<div class="btn-group">
	 <button type="button" ng-show="auth.insert" ng-click="showForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Add Item</b></button>
	  <button type="button" ng-click="openSearchDialog()"  class="btn btn-inverse" ng-click="getMysqlScript()"><i class="icon-search icon-white"></i><b> Quick Search	</b> </button>
	</div>
</div>
<div ng-show="fgShowHide" class="gridStyle" ng-grid="gridOptions"></div>
<div ng-show="!fgShowHide" style="display:none">
	<form name="myForm" class="form-horizontal well">
	   <fieldset>  
          <legend>'.$this->tableName.'</legend>  
		 '.$this->form.'	
		  <div class="form-actions">
			<button ng-click="saveItem()" ng-disabled="myForm.$invalid" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save</button>
			 <button class="btn btn-warning cancel" ng-click="hideForm()"><i class="icon-close icon-white"></i>Cancel</button>		
		  </div>
	  </fieldset>
	</form>
</div>
<div modal="searchDialog"  options="opts">
        <div class="modal-header">
		 <a class="close" ng-click="closeSearchDialog()" data-dismiss="modal">&times;</a>
            <h3>'.$this->tableName.'</h3>
        </div>
        <div class="modal-body">
           <form name="myForm" class="form-horizontal">
  			 '.$this->qs.'	   
			</form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning cancel" ng-click="closeSearchDialog()"><i class="icon-close icon-white"></i>Cancel</button>
			<button class="btn btn-primary cancel" ng-click="refreshSearch()"><i class="icon-refresh icon-white"></i> Refresh</button>
			 <button class="btn btn-primary cancel" ng-click="doSearch()"><i class="icon-search icon-white"></i> Search</button>
        </div>
</div>
<?php else: ?>
<p> Not permitted</p>
<?php endif; ?>
';
	
	return $content;
}	
private function generate_controller(){
	$content='<?php 
defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');
require_once(\'./application/libraries/base_ctrl.php\');
class '.$this->tableName.'_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model(\''.$this->tableName.'_model\',\'model\');
	}
	public function index()
	{
		if($this->is_authentic($this->auth->RoleId, $this->user->UserId, \''.$this->tableName.'\')){
			$data[\'fx\']=\'return \'.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data[\'read\']=$this->auth->IsRead;
			$this->load->view(\''.$this->tableName.'_view\', $data);
		}
		else
		{
			$this->load->view(\'forbidden\');
		}
	}

	public function save()
	{
		$data=$this->post();
		$success=FALSE;
		$msg= \'You are not permitted.\';
		$id=0;
		if(!isset($data->'.$this->pkColName.'))
		{
			if($this->auth->IsInsert){
				$id=$this->model->add($data);
				$msg=\'Data inserted successfully\';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){
				$id=$this->model->update($data->'.$this->pkColName.', $data);
				$success=TRUE;
				$msg=\'Data updated successfully\';				
			}		
		}
		print json_encode(array(\'success\'=>$success, \'msg\'=>$msg, \'id\'=>$id));
	}

	public function delete()
	{
		if($this->auth->IsDelete){
			$data=$this->post();
			print json_encode( array("success"=>TRUE,"msg"=>$this->model->delete($data->'.$this->pkColName.')));
		}
		else{
			print json_encode( array("success"=>FALSE,"msg"=>"You are not permitted"));
		}
	}
	'.$this->ctrl_helper.'	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->'.$this->pkColName.'));
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

?>';
return $content;
}
} 
?>

