<?php
defined('THINK_PATH') or exit();
/**
 * 系统行为扩展：静态缓存写入
 * @category   Think
 * @package  Think
 * @subpackage  Behavior
 * @author   liu21st <liu21st@gmail.com>
 */
class HtmlBehavior extends Behavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content){
    	
    	$module=strtolower(MODULE_NAME);
    	$action=strtolower(ACTION_NAME);
    	$group=strtolower(GROUP_NAME);
    	
    	
    	if(C('HTML_ON')&&$group=='home'&&!empty($_SESSION['code'])&&$_SESSION['code']==intval($_GET['code'])){
    		$sort=F('zh-cnpath');
    		$p=intval($_GET['p']);
    		
    		
    		$path=$sort[intval($_GET['sid'])]['path'];
    		
    		if($group=='home'&&$module=='index'&&$action=='index'){
    			//网站首页
    			$path='/';
    			$file='./index.html';
    		}
    		
    		if($group=='home'&&$module=='public'&&$action=='sitemap'){
    			//网站首页
    			$path='/';
    			$file='./sitemap.html';
    		}
    		
    		if($action=='index'&&empty($p)&&$path){
    			$file='./'.$path.'/index.html';
    		}
    		
    		if($action=='index'&&!empty($p)&&$path){
    			$file='./'.$path.'/'.$p.'/index.html';
    		}
    		
    		if($action=='show'){
    			$item=M($module)->where(array('id'=>intval($_GET['id'])))->find();
    			$path=$sort[$item['sort']]['path'];
    			$file='./'.$path.'/show'.intval($_GET['id']).'.html';
    		}
    		
    		if($path){
    			if(!is_dir(dirname($file)))
    				@mkdir(dirname($file),0755,true);
    			if( false === file_put_contents( $file , $content ))
    				throw_exception(L('_CACHE_WRITE_ERROR_').':'.$file);
    		}
    		
    		if($module!='about'){
    			//防止内容简介fetch成sccuess
    			$content='success';
    		}
    		
    		
    	}
    	
    	
    }
}