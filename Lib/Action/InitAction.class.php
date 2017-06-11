<?php

class InitAction extends Action {
	public $lang = 'zh-cn';
	public $tmpl = 'default';
	
	public $config = array ();
	public function _initialize() {
		dostrslashes();//去除PHP自动加的转义字符
		
		$this->tmpl = cookie ( 'think_template' ) ? cookie ( 'think_template' ) : $this->tmpl;
		$this->lang = cookie ( 'think_language' ) ? cookie ( 'think_language' ) : $this->lang;
		$this->config = $config_array = F ( $this->lang . 'config' );
		
		$part_content =F ( $this->lang . 'part_content');
		$this->checkLang ();
		$this->checkTmpl ();
		
		if (! empty ( $part_content )) {
			foreach ( $part_content as $key => $value ) {
				$this->assign ( 'content_' . $key, dereplace($value ['contant']) );
			}
		}
		
		$this->assign('lang',$this->lang);
		$this->assign ( 'language', '?l=' . $this->lang );
		$this->assign ( $config_array );
		$this->assign ( 'site_url', site_url () );
	}
	
	
	private function checkTmpl() {
		$config_array = F ( $this->lang . 'config' );
		$data ['pc_value'] = $config_array ['pc_tmpl'];
		$data ['mobile_value'] = $config_array ['mobile_tmpl'];
		
		$type = strtolower ( GROUP_NAME );
		
		if ($type == 'wap') {
			$type = 'mobile_tmpl';
		} else {
			
			$type = 'pc_tmpl';
		}
		
		C ( 'DEFAULT_THEME', $config_array [$type] );
		cookie ( 'think_template', $config_array [$type], 864000 );
	}
	private function checkLang() {
		$config_array = F ( 'lang' );
		$lang = cookie ( 'think_language' );
		if (strtolower ( GROUP_NAME ) == 'wap' || strtolower ( GROUP_NAME ) == 'home') {
			$varname = 'indexlang';
		}
		
		if (strtolower ( GROUP_NAME ) == 'admin') {
			$varname = 'adminlang';
		}
		
		if (empty ( $_GET [C ( 'VAR_LANGUAGE' )] ) && empty ( $lang )) {
			cookie ( 'think_language', $config_array [$varname], 864000 );
		}
		
		
	}
	
	function pageNotFound(){
		header('HTTP/1.1 404 Not Found');
		header("status: 404 Not Found");
		$this->error('您查找的页面未找到',site_url(),'10');
	}
	
	function _empty(){
		$this->pageNotFound();
	}
	
	
}

?>