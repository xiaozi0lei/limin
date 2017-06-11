<?php
class PublicAction extends WapInitAction {
	Public function verify() {
		import ( 'ORG.Util.Image' );
		Image::buildImageVerify ();
	}
	public function login(){
		$this->assign('jump',$_GET['jump']);
		$this->display();
	}
	public function dologin(){
		$username = isset ($_POST['member_account'])?trim ( $_POST ['member_account'] ) : '';
		$password = isset ($_POST['member_password'])?trim ( $_POST ['member_password'] ) : '';
		if ($this->user_model->checkUser($username,$password))
		{
			$this->user_model->doLogin ( $username, $password );
			header("Content-Type:text/html; charset=utf-8");
			$strtemp = "<script type='text/javascript'>alert('登陆成功！');window.location.href='";
			switch ($_GET['jump'])
			{
				case 1:
					$strtemp .= U('Wap/Public/mebCenter');
					break;
				case 2:
					$strtemp .= U('Wap/Shop/Scar');
					break;
				default:
					$strtemp .= U('Wap/Index/index');
					break;
			}
			$strtemp .= "';</script>";
			echo $strtemp;
		}
		else {
			header("Content-Type:text/html; charset=utf-8");
			echo "<script type='text/javascript'>alert('用户名或密码错误！');history.go(-1);</script>";
		}
		//$this->display();
	}
	public function mebCenter(){
		
		if ($this->islogin ==0)
		{
			header("Content-Type:text/html; charset=utf-8");
			echo "<script type='text/javascript'>alert('请登录！');window.location.href = '".U('Public/login?jump=1')."';</script>";
			exit();
			//$this->redirect('Public/login');http://192.168.0.194/wap/public/mebCenter
		}
		//读取用户资料
		
		$user = M('user')->where(array(uid => $this->_USESSION['uid']))->find();
		
		
		
		$this->assign($user);
		$this->display();
	}
	public function mebList(){
		if ($this->islogin ==0)
		{
			header("Content-Type:text/html; charset=utf-8");
			echo "<script type='text/javascript'>alert('请不要进行非法操作！');window.location.href = '".U('Public/login?jump=1')."';</script>";
			exit();
		}
		if (empty($_GET["status"]))
			$list = M('order')->where(array(uid => $this->_USESSION['uid']))->select();
		else
			{
				$list = M('order')->where(array(
						uid => $this->_USESSION['uid'],
						status =>$_GET["status"]
				))->select();
			}
		$this->assign('list',$list);
		$this->display();
	}
	public function sign()
	{
		if (empty($_POST["member_account"]))
		{
			$this->display();
		}
		else {
			$username = h(trim($_POST["member_account"]));
			$password = h(trim($_POST["member_password"]));
			$uid = intval ( $_POST ['uid'] );
			
			$pwd = $_POST ['member_password'];
			$pwdc = $_POST ['member_password2'];
			$data ['realname'] = h ( $_POST ['realname'] );
			$data ['member_cellphone'] = h ( $_POST ['member_cellphone'] );
			$data ['sex'] = intval ( $_POST ['sex'] );
			$data ['mobile'] = h ( $_POST ['mobile'] );
			$data ['qq'] = h ( $_POST ['qq'] );
			$data ['email'] = h ( $_POST ['email'] );
			$data ['isadmin'] = 0;
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
				if (empty ( $username  )) {
					$this->error ( '用户名不能为空' );
				}
					
				if (empty ( $pwd )) {
					header("Content-Type:text/html; charset=utf-8");
					echo "<script type='text/javascript'>alert('请不要进行非法操作！');history.go(-1);</script>";
					exit();
					//$this->error ( '密码为空' );
				}
					
				$user = M ( 'user' )->where ( array (
						'username' => $username 
				) )->find ();
				if (! empty ( $user )) {
					$this->error ( '用户名已经存在' );
				}
				$data ['username'] = $username ;
				$data ['dateline'] = time ();
				M ( 'user' )->add ( $data );
				header("Content-Type:text/html; charset=utf-8");
				echo "<script type='text/javascript'>alert('注册成功！');window.location.href = '".U('Public/login?jump=1')."';</script>";
				exit();
				//$this->success ( '添加成功' );
			}
		}
		
	}
	public function addinfo(){
		if ($this->islogin ==0)
		{
			header("Content-Type:text/html; charset=utf-8");
			echo "<script type='text/javascript'>alert('请登录！');window.location.href = '".U('Public/login?jump=1')."';</script>";
			exit();
		}
		$user = M('user')->where(array(uid => $this->_USESSION['uid']))->find();
		$temp = explode(" ", $user['provinces']);
		$user['sheng'] = $temp[0];
		$user['shi'] = $temp[1];
		$user['qu'] = $temp[2];
		$this->assign($user);
		$this->display();
	}
	public function doaddinfo(){
		
		$temp [] = $_POST ['sheng'];
		$temp [] = $_POST ['shi'];
		$temp [] = $_POST ['qu'];
		$provinces = implode ( ' ', $temp );
		$info =array(
				realname =>h($_POST['member_account']),
				mobile =>h($_POST["member_tel"]),
				provinces =>$provinces,
				adds =>h($_POST['member_adds']),
				zipcode =>h($_POST['member_zip']),
				email =>h($_POST['member_email'])
				);
		M('user')->where(array(uid => $this->_USESSION['uid']))->save($info);
		header("Content-Type:text/html; charset=utf-8");
		echo "<script type='text/javascript'>alert('修改成功！');window.location.href = '".U('Public/addinfo')."';</script>";
		
	}
}
?>