<?php

$setting=require 'setting.php';
$array=array(


	'APP_GROUP_LIST' => 'Home,Admin,Wap', //项目分组设定
	'DEFAULT_GROUP'  => 'Home', //默认分组
	'DEFAULT_THEME'  	=> 	'default',
    'THEME_LIST'		=>	'default,think',
	'TMPL_CACHE_ON'     => false,
    'TMPL_DETECT_THEME' => 	true, // 自动侦测模板主题
	'COOKIE_NAME'               => 'sjhl',
	'COOKIE_VALUE_HASH'         => 'sjhl1234',
	'SHOW_PAGE_TRACE' =>false, // 显示页面Trace信息
	'URL_CASE_INSENSITIVE' =>true,
	'TOKEN_ON'=>true,
	'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称
	'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为
	'TMPL_STRIP_SPACE'=>false,
	'TMPL_DETECT_THEME'=>false

);

return array_merge($array,$setting);
?>