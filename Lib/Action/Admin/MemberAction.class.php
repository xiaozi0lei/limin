<?php
class MemberAction extends AdminInitAction {
	public function listMember() {
		$this->checkper ( 'member_listmember' );
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		$where=array();
		if($this->_USESSION['groupid']==8||$this->_USESSION['groupid']==10){
			$where['groupid']=$this->_USESSION['groupid'];
		}		
		
		
		$count = M ( 'user' )->where($where)->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'user' )->where($where)->order ( 'uid' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		//var_dump($list);
		$this->assign( "IsAdmin",$this->IsAdmin );
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ( './Public/Admin/Member/listMember.html' );
	}
	public function memberAdd() {
		$this->assign('UserGroup', $this->Allgroup );
		$this->assign( "IsAdmin",$this->IsAdmin );
		$this->display ( './Public/Admin/Member/memberAdd.html' );
	}
	public function group() {
		$this->checkper ( 'member_group' );
		$list = M ( 'group' )->select ();
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->display ( './Public/Admin/Member/group.html' );
	}
	public function groupEdit() {
		$group = M ( 'group' )->where ( array (
				'gid' => intval ( $_GET ['gid'] ) 
		) )->find ();
		
		if (empty ( $group )) {
			$this->error ( '不存在该用户组' );
		}
		
		$per = unserialize ( $group ['per'] );
		$this->assign ( 'per', $per );
		$this->assign ( 'group', $group );
		$this->display ( './Public/Admin/Member/groupEdit.html' );
	}
	public function myInfo() {
		$user = session ( 'user' );
		$my = M ( 'user' )->where ( array (
				'uid' => $user ['uid'] 
		) )->find ();
		
		$this->assign ( $my );
		$this->display ( './Public/Admin/Member/myInfo.html' );
	}
	public function groupAdd() {
		$this->display ( './Public/Admin/Member/groupAdd.html' );
	}
	public function doSaveMember() {
		$uid = intval ( $_POST ['uid'] );
		$gname = $_POST['powerGroup'];
		$pwd = $_POST ['pwd'];
		$pwdc = $_POST ['pwdconfirm'];
		
		$data ['realname'] = h ( $_POST ['realname'] );
		$data ['phone'] = h ( $_POST ['phone'] );
		
		$data ['sex'] = intval ( $_POST ['sex'] );
		$data ['mobile'] = h ( $_POST ['mobile'] );
		$data ['qq'] = h ( $_POST ['qq'] );
		$data ['email'] = h ( $_POST ['email'] );
		//是否可以进行后台登录


		if(!empty($_POST['powerGroup'])){
			$data['groupid'] = intval($_POST["powerGroup"]);
			$group =  F('_group/group_'.$data['groupid']);
			$login = $group['config_login'];
			if (empty($login)) $login =0;
			$data ['isadmin'] = $login;
		}
		
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
			$this->success ( '更新成功' );
		} else {
			if (empty ( $_POST ['username'] )) {
				$this->error ( '用户名不能为空' );
			}
			
			if (empty ( $_POST ['realname'] )) {
				$this->error ( '真实姓名不能为空' );
			}
			
			if (empty ( $pwd )) {
				$this->error ( '密码为空' );
			}
			
			$user = M ( 'user' )->where ( array (
					'username' => $_POST ['username'] 
			) )->find ();
			if (! empty ( $user )) {
				$this->error ( '用户名已经存在' );
			}
			$data ['username'] = h ( $_POST ['username'] );
			$data ['dateline'] = time ();
			M ( 'user' )->add ( $data );
			$this->success ( '添加成功', U ( 'Admin/Member/listMember' ) );
		}
	}
	public function memberDetail() {
		$uid = intval ( $_GET ['uid'] );
		$user = M ( 'user' )->where ( array (
				'uid' => $uid 
		) )->find ();
		
		if (empty ( $user )) {
			$this->error ( '不存在该用户' );
		}
		$this->assign('UserGroup', $this->Allgroup );
		$this->assign( "IsAdmin",$this->IsAdmin );
		$this->assign ( $user );
		$this->display ( './Public/Admin/Member/memberAdd.html' );
	}
	public function doDelMember() {
		$current_user = session ( 'user' );
		
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				if ($key == 1 || $key == $current_user ['uid']) {
					$this->error ( '不能删除当前登录账户',U('Admin/Member/listMember'));
					continue;
				}
				$user = M ( 'user' )->where ( array (
						'uid' => $key 
				) )->find ();
				
				if (empty ( $user )) {
					$this->error ( '不存在该用户' );
				}
				
				if($user['uid']==1){
					
					$this->error ( '该用户为超级管理员无法删除' );
				}
				
				M ( 'user' )->where ( array (
						'uid' => $key 
				) )->delete ();
			}
		} else {
			$this->error ( '请选择用户' );
		}
		
		$this->success ( '删除成功' );
	}
	public function doDelGroup() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$group = M ( 'group' )->where ( array (
						'gid' => $key 
				) )->find ();
				
				if (empty ( $group )) {
					$this->error ( '不存在该用户组' );
				}
				if($group['issys']){
					$this->error ( '该用户组是系统用户组无法删除' );
				}
				M ( 'group' )->where ( array (
						'gid' => $key 
				) )->delete ();
				F ( '_group/group_' . $key, null );
			}
		} else {
			$this->error ( '请选择用户组' );
		}
		
		$this->success ( '删除成功' );
	}
	public function doSaveGroup() {
		$group = $_POST ['group'];
		
		if (empty ( $_POST ['gname'] )) {
			$this->error ( '用户组名称不能为空' );
		}
		
		$gid = intval ( $_POST ['gid'] );
		
		$data ['gtype'] = intval ( $_POST ['grouptype'] );
		$data ['gname'] = h ( $_POST ['gname'] );
		$data ['per'] = serialize ( $group );
		$data ['lang'] = $this->lang;
		
		if ($gid) {
			
			if($gid==9){
				$this->error ( '改用户组为超级管理组无法编辑' );
			}
			
			// 编辑
			$rs = M ( 'group' )->where ( array (
					'gid' => $gid 
			) )->find ();
			
			if (empty ( $rs )) {
				$this->error ( '不存在该用户组' );
			}
			
			M ( 'group' )->where ( array (
					'gid' => $gid 
			) )->save ( $data );
			F ( '_group/group_' . $gid, $group );
			$this->success ( '编辑成功', U ( 'Admin/Member/group' ) );
		} else {
			
			$gid = M ( 'group' )->add ( $data );
			
			F ( '_group/group_' . $gid, $group );
			$this->success ( '添加成功', U ( 'Admin/Member/group' ) );
		}
	}
}