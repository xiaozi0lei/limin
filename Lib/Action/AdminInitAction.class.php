<?php

/**
 * @author Administrator
 *	用于后台管理的会员初始化
 */
class AdminInitAction extends InitAction {
	protected $_USESSION;
	protected $islogin;
	protected $group;
	protected $user_model;
	protected $Allgroup;//所有权限组
	protected $IsAdmin;//管理员权限判定
	public function _initialize() {
	
		parent::_initialize ();
		$model = D ( "User" );
		
		$model->checklogin ();
		$this->user_model = $model;
		$this->_USESSION = $model->getUserSesstion ();
		$this->islogin = $model->isLogin ();
		$this->group = $model->getUserGroup ($this->_USESSION['groupid']);
		$this->Allgroup = M('group')->field('gid,gname')->select();
		$this->IsAdmin = $this->_USESSION["groupid"];
		//登录判断
		
		
		if (empty ( $this->islogin )) {
			//判断来源页
			
			if(strtolower(GROUP_NAME)=='admin'&&strtolower(ACTION_NAME)=='index'&&strtolower(MODULE_NAME)=='index'&&empty($_GET['from'])){
				//
				header("Location:http://".$_SERVER['HTTP_HOST']);
			}else	
			{
				$this->redirect('Login/index');
			}
		}
		
		if (empty ( $this->_USESSION ['isadmin'] )) {
			$this->error ( '没有后台操作权限', U ( 'Home/Index/index' ) );
		}
		/*
		 * if(ACTION_NAME!='swfupload'){
		 * if(empty($this->group['config_login'])){ $this->error('没有权限操作'); } }
		 */
		
		$this->assign ( 'space', $this->_USESSION );
		$this->assign ( 'group', $this->group );
		$this->assign ( $this->group );
		$this->assign ( 'islogin', $this->islogin );
	}
	//登陆之后各版块权限的判断
	protected function checkper($action) {

		$group_array = $this->group;
		if ($action == "config_login")
		{
			
			return $group_array [$action];
		}
		if (empty ( $group_array [$action] )) {
			$this->error ( '没有权限操作该板块！' );
		}
		
	}
}

?>