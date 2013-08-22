<?php
 function getFiles($path){
	$dir = new RecursiveDirectoryIterator($path,
    FilesystemIterator::SKIP_DOTS);

// Flatten the recursive iterator, folders come before their files
$it  = new RecursiveIteratorIterator($dir,
    RecursiveIteratorIterator::SELF_FIRST);

// Maximum depth is 1 level deeper than the base folder
$it->setMaxDepth(1);
$res="";

		foreach ($it as $fileinfo) {
			$res .='<option >'. $fileinfo->getFilename(). '</option>';
		}
	return $res;
 } 
 
 ?>