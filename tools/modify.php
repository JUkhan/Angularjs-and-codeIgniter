<?php

switch($_POST["action"]){	
	case "model" : get_model_content();break;
	case "model-update" : model_update();break;
	case "view" : get_view_content();break;
	case "view-update" : view_update();break;
	case "controller" : get_controller_content();break;
	case "controller-update" : controller_update();break;
	case "script" : get_script_content();break;
	case "script-update" : script_update();break;
	default: echo "Unknown action action";break;
}
function get_model_content(){
	
	print json_encode( array('content'=>file_get_contents('../application/models/'.$_POST["name"])));
}
function model_update(){
	$content=$_POST["content"];
	put_content('../application/models/'.$_POST["name"], $content);
	print json_encode( array('msg'=>'successfully updated'));
}
function get_view_content(){
	
	print json_encode( array('content'=>file_get_contents('../application/views/'.$_POST["name"])));
}
function view_update(){
	$content=$_POST["content"];
	put_content('../application/views/'.$_POST["name"], $content);
	print json_encode( array('msg'=>'successfully updated'));
}
function get_controller_content(){
	
	print json_encode( array('content'=>file_get_contents('../application/controllers/'.$_POST["name"])));
}
function controller_update(){
	$content=$_POST["content"];
	put_content('../application/controllers/'.$_POST["name"], $content);
	print json_encode( array('msg'=>'successfully updated'));
}
function get_script_content(){
	
	print json_encode( array('content'=>file_get_contents('../static/appScript/'.$_POST["name"])));
}
function script_update(){
	$content=$_POST["content"];
	put_content('../static/appScript/'.$_POST["name"], $content);
	print json_encode( array('msg'=>'successfully updated'));
}
 function put_content($path, $content){
	//file_put_contents($path, $content, FILE_APPEND | LOCK_EX);
	$file=fopen($path, "w+");
	if($file==false){
		echo "Error in opening $file ";
		exit();
	}
	fwrite($file, $content);
	fclose($file);
 }
?>