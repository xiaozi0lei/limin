<?php
class IndexAction extends HomeInitAction {
	public function index() {
		$config_array = F ( $this->lang . 'config' );

		//友情链接
		$flink = M('link')->where(array('lang'=>$this->lang))->limit(50)->select();
		$this->assign ( "flink" , $flink );
		$this->assign('webtitle',$config_array ['indexsite']);
		
		$this->display ();
	}
}