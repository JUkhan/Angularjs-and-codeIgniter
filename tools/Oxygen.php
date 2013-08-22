<?php
require_once ('JCrud.php');
require_once ('util.php');
$data = json_decode(file_get_contents("php://input"));
/*<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js" ></script>*/
//$this->load->helper('url');
switch($data->action){
	
	case "addTable": addTable($data);break;
	case "getTableList": getTableList(); break;
	
	case "insertColumn":insertColumn($data);break;
	case "getColumnList" : getColumnList($data); break;
	case "updateColumn" : updateColumn($data); break;
	case "removeColumn" : removeColumn($data); break;
	case "drop-table" : drop_table($data); break;
	case "save-order" : save_order($data);break;
	case "model" : get_model_content($data);break;
	default: echo "Unknown action $action";break;
}
function get_model_content($data){
	
	return json_encode( array('content'=>$data->name));
}
function save_order($data){
	try{
		$list=json_decode($data->orders);	
		$db=new JCrud();
		foreach($list as $item){		
			$db->query2('update columns set orderNo=? where colId=?', array($item->orderNo, $item->colId));
		}		
		response(null, null, 'msg updated', TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }
}
function drop_table($data){
	try{
		$sql="drop table ".$data->tableName;		
		$db=new JCrud();
		 $db->query1($sql);
		response(null, null, 'Table droped successfully', TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }
}
function addTable($data){
	try{
		$sql="Insert into tables(tableName) values(?)";		
		$params[]=$data->tableName;		
		
		$db=new JCrud();
		$id= $db->insert($sql, $params);
		response(null, null, $id, TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }
}
function getTableList(){
	$db=new JCrud();	
	$res=$db->query1("select * from tables");		
	responseObj($res);
}
function removeTable(){
	try{
		$sql="Delete from tables Where tableId=:tableName";		
		$params[]=$_POST["tableId"];	
		
		$db=new JCrud();
		$id= $db->update($sql, $params);
		response(null, null, "Removed Successfully", TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }
}
function insertColumn($data){
	try{
		$sql="insert into columns(tableId,colName,isForm,isGrid,isQuickSearch,dataBind,refTableName,optionsText,optionsValue,isPk,ai,dataType,size, isNull) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";		
		$params[]=$data->tableId;	
		$params[]=$data->colName;
		$params[]=$data->isForm;
		$params[]=$data->isGrid;
		$params[]=$data->isQuickSearch;
		$params[]=$data->dataBind;
		$params[]=$data->refTableName;
		$params[]=$data->optionsText;
		$params[]=$data->optionsValue;
		$params[]=$data->isPk;
		$params[]=$data->ai;
		$params[]=$data->dataType;
		$params[]=$data->size;
		$params[]=$data->isNull;
		
		$db=new JCrud();
		$id= $db->insert($sql, $params);
		response(null, null, $id, TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }				
}
function updateColumn($data){
	try{
		$sql="Update columns set colName=?,isForm=?,isGrid=?,isQuickSearch=?,dataBind=?,refTableName=?,optionsText=?,optionsValue=?,isPk=?,ai=?,dataType=?,size=?, isNull=? Where colId=?";		
			
		$params[]=$data->colName;
		$params[]=$data->isForm;
		$params[]=$data->isGrid;
		$params[]=$data->isQuickSearch;
		$params[]=$data->dataBind;
		$params[]=$data->refTableName;
		$params[]=$data->optionsText;
		$params[]=$data->optionsValue;
		$params[]=$data->isPk;
		$params[]=$data->ai;
		$params[]=$data->dataType;
		$params[]=$data->size;
		$params[]=$data->isNull;
		$params[]=$data->colId;
		
		$db=new JCrud();
	    $db->update($sql, $params);
		response(null, null, $data->colId, TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }	
}
function removeColumn($data){
	try{
		$sql="Delete from Columns Where colId=?";		
		$params[]=$data->colId;	
		
		$db=new JCrud();
		$id= $db->update($sql, $params);
		response(null, null, "Removed Successfully", TRUE);
	}catch(Exception $ex ){ response(null, null, $ex->getMessage(), FALSE); }
}
function getColumnList($data){
	$db=new JCrud();	
	$params[]=$data->tableId;
	$res=$db->query2("select * from columns where tableId=? order by orderNo",	$params);		
	responseObj($res);
}
?>