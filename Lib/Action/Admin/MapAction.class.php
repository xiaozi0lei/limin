<?php
class MapAction extends AdminInitAction {
	public function index() {
		$config_array = F ( 'position' );
		
		$this->assign ( $config_array );
		$this->display ( './Public/Admin/Map/index.html' );
	}
	public function search() {
		$config_array = F ( 'position' );
		$word = h ( $_POST ['searchname'] );
		$this->assign ( $config_array );
		$this->assign ( 'searchname', $word );
		$this->display ( './Public/Admin/Map/index.html' );
	}
	public function savePosition() {
		$config_array = F ( 'position' );
		
		$config_array ['lng'] = $_POST ['lng'];
		$config_array ['lat'] = $_POST ['lat'];
		F ( 'position', $config_array );
	}
	public function saveform() {
		$config_array = F ( 'position' );
		
		$config_array ['add'] = $_POST ['add'];
		$config_array ['phone'] = $_POST ['phone'];
		$config_array ['cname'] = $_POST ['cname'];
		$config_array ['fax'] = $_POST ['fax'];
		$config_array ['customer'] = $_POST ['customer'];
		$config_array ['email'] = $_POST ['email'];
		F ( 'position', $config_array );
		$this->success ( '保存成功' ,U('Admin/Map/index'));
	}
}