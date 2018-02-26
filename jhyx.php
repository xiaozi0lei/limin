<?php

$a=rtrim($_SERVER['SCRIPT_NAME'],'/');
$_root = dirname($a);
$root =($_root=='/' || $_root=='\\')?'':$_root;
if(empty($root)&&strpos($_SERVER['HTTP_HOST'],'127.0.0.1')!==0&&strpos($_SERVER['HTTP_HOST'],'localhost')!==0){
	//header("Location: ./admin/login/index");
	header("Location: ./index.php/admin/login/index");
}else{
	header("Location: ./index.php/admin/login/index");
}

