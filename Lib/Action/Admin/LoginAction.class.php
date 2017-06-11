<?php
class LoginAction extends Action {
	public function _initialize() {
		 if (session ( 'islogin' )) {
		 	
			redirect ( U ( 'Index/index' ) );
		} 
	}
	public function index() {
		$this->display ( './Public/Admin/Login/index.html' );
	}
	public function loginsubmit() {
		$username = isset ( $_POST ['username'] ) ? trim ( $_POST ['username'] ) : '';
		$password = isset ( $_POST ['password'] ) ? trim ( $_POST ['password'] ) : '';
		$remeber = isset ( $_POST ['remeber'] ) ? intval ( $_POST ['remeber'] ) : 0;
		$lang = h ( $_POST ['lang'] ) ? h ( $_POST ['lang'] ) : 'zh-cn';
		
		$model = D ( 'User' );
		if ($model->checkUser ( $username, $password )) {
			
			$model->doLogin ( $username, $password );
			$user = $model->getUserSesstion ();
			// 存储cookie
			$model->setAuthCookie ( $username, $user ['uid'], $remeber );
			cookie ( 'think_language', $lang, 3600 );
			$this->success ( L ( 'loginsuccess' ), U ( 'Index/index' ) );
		} else {
			$this->error ( L ( 'pwderror' ), U ( 'Login/index' ) );
		}
	}
}