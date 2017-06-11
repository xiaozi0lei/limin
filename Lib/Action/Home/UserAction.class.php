<?php
class UserAction extends HomeInitAction {

	
	public function _initialize(){
		parent::_initialize();
		if(empty($this->islogin)){
			$this->error('还未登录');
		}
		
	}
	
	public function index(){
		
		
		$this->display();
	}
	
	public function updateUser(){
		
		

		$uid = $this->_USESSION['uid'];
		$pwd = $_POST ['pwd'];
		$pwdc = $_POST ['pwdconfirm'];
		$data['groupid'] = $this->_USESSION['groupid'];
		$data ['realname'] = h ( $_POST ['realname'] );
		$data ['phone'] = h ( $_POST ['phone'] );
		$data ['mobile'] = h ( $_POST ['mobile'] );
		$data ['qq'] = h ( $_POST ['qq'] );
		$data ['email'] = h ( $_POST ['email'] );
		$data ['isadmin'] = $this->_USESSION['isadmin'];
		
		if (! empty ( $pwd )) {
			import ( "ORG.Util.Hashpass" );
			if ($pwd != $pwdc) {
				$this->error ( '确认密码不正确' );
			} else {
				$hash_obj = new PasswordHash ( 8, true );
				$hash_password = $hash_obj->HashPassword ( $pwd );
				$data ['password'] = $hash_password;
			}
		}
		if (! empty ( $uid )) {
			$user = M ( 'user' )->where ( array (
					'uid' => $uid
			) )->find ();
			if (empty ( $user )) {
				$this->error ( '不存在该用户' );
			}
				
			M ( 'user' )->where ( array (
			'uid' => $uid
			) )->save ( $data );
			
			$array = M('user')->where ( array('uid'=>$uid) )->find();
			
			session('user', $array);
			
			$this->success ( '更新成功',U('User/index'));
		} 
		
		
		
	}
	
	
}