<?php

class UserModel extends Model {
	
	private $_USESSION = array ();
	private $islogin = 0;
	private $group=array();
	
	
	public function getUserGroup($gid){
		
		if(!empty($this->islogin)){
			$this->group= F('_group/group_'.$gid);
		}
		return $this->group;
	}
	
	/**
	 * 用来初始化当前USER对象
	 * @return boolean
	 */
	public function checklogin() {
		
		
		if (session( 'islogin' )) {
			//先查看SESSION是否存在存在直接返回
			$this->_USESSION = session( 'user' );
			$this->islogin=1;
			
		} else {
			//不存在SESSION则产看是否记录登录并验证
			if (isset ( $_COOKIE [C ( 'COOKIE_NAME' )] )) {
				$cookie = isset ( $_COOKIE [C ( 'COOKIE_NAME' )] ) ? $_COOKIE [C ( 'COOKIE_NAME' )] : '';
			} else {
				$cookie = isset ( $_REQUEST [C ( 'COOKIE_NAME' )] ) ? urldecode ( $_REQUEST [C ( 'COOKIE_NAME' )] ) : '';
			}
			
			if (empty ( $cookie ) === true) {
				return false;
			}
			
			$rs=$this->validateAuthCookie ( $cookie );
			
			if($rs){
				$this->_USESSION=$rs;
				$this->islogin=1;
				session('user', $this->_USESSION);
				session('islogin',1);
			}
			
		}
	}
	public function getUserSesstion() {
		return $this->_USESSION;
	}
	public function isLogin() {
		return $this->islogin;
	}
	
	public function validateAuthCookie($cookie = '') {
		
		if (empty ( $cookie )) {
			return false;
		}
		
		$cookie_elements = explode ( '|', $cookie );
		if (count ( $cookie_elements ) != 4) {
			return false;
		}
		list ( $username,$uid, $time, $hmac ) = $cookie_elements;
		
		if (! empty ( $time ) && $time < time ()) {
			return false;
		}
		
		$hashkey = hash ( 'md5', $username, C ( 'COOKIE_VALUE_HASH' ) );
		
		$hashvalue = $this->hash_hmac ( 'md5', $username . '|' .$uid.'|'. $time, $hashkey );
		
		if ($hmac != $hashvalue) {
			return false;
		}
		$this->_USESSION = $this->getUserDataById ( (int)$uid );
		
		
		if (empty ( $this->_USESSION )) {
			return false;
		}
		return $this->_USESSION;
	}
	
	/**
	 * 验证密码用户是否正确,正确则赋值给当前控制器
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @return boolean
	 */
	public function checkUser($username, $password) {
		if ($username == '' || $password == '') {
			return FALSE;
		} else {
			$rs= $this->getUserDataById ( $username );
			if (!$rs) {
				return false;
			} else {
				//更新当前对象SESSION
				$hash = $rs ['password'];
				$check = $this->checkPassword ( $password, $hash );
				return $check;
			}
		}
	}
	
	
	public function doLogin($username, $password){
		$rs= $this->getUserDataById ( $username );
		$this->_USESSION=$rs;
		$this->islogin=1;
		session('user', $this->_USESSION);
		session('islogin',1);
	}
	
	
	
	
	public function setAuthCookie($username,$uid, $remeber = false) {
		if ($remeber) {
			
			$time = time () + 60 * 60 * 24 * 30 * 12;
		} else {
			
			$time = null;
		}
		
		$cookie_name = C ( 'COOKIE_NAME' );
		$value = $this->generateAuthCookie ( $username,$uid ,$time );
		
		setcookie ( $cookie_name, $value, $time, '/' );
	}
	
	
	public function generateAuthCookie($username,$uid, $time) {
		$hashkey = hash ( 'md5', $username, C ( 'COOKIE_VALUE_HASH' ) );
		
		$hashvalue = $this->hash_hmac ( 'md5', $username . '|'. $uid.'|'. $time, $hashkey );
		
		$cookie = $username . '|' .$uid.'|'. $time . '|' . $hashvalue;
		return $cookie;
	}
	
	/**
	 * hmac 加密
	 *
	 * @param unknown_type $algo
	 *        	hash算法 md5
	 * @param unknown_type $data
	 *        	用户名和到期时间
	 * @param unknown_type $key        	
	 * @return unknown
	 */
	function hash_hmac($algo, $data, $key) {
		$packs = array (
				'md5' => 'H32',
				'sha1' => 'H40' 
		);
		
		if (! isset ( $packs [$algo] )) {
			return false;
		}
		
		$pack = $packs [$algo];
		
		if (strlen ( $key ) > 64) {
			$key = pack ( $pack, $algo ( $key ) );
		} else if (strlen ( $key ) < 64) {
			$key = str_pad ( $key, 64, chr ( 0 ) );
		}
		
		$ipad = (substr ( $key, 0, 64 ) ^ str_repeat ( chr ( 0x36 ), 64 ));
		$opad = (substr ( $key, 0, 64 ) ^ str_repeat ( chr ( 0x5C ), 64 ));
		
		return $algo ( $opad . pack ( $pack, $algo ( $ipad . $data ) ) );
	}
	
	
	
	/**
	 * 检测HASH字符串进行验证
	 * @param string $password
	 * @param string $hash
	 * @return boolean
	 */
	public function checkPassword($password, $hash) {
		import ( "ORG.Util.Hashpass" );
		
		$hash_obj = new PasswordHash ( 8, true );
		
		$check = $hash_obj->CheckPassword ( $password, $hash );
		return $check;
	}
	
	/**
	 * 通过ID获取用户基本信息
	 * @param string|int $id
	 * @return boolean|unknown
	 */
	public function getUserDataById($id) {
		$rs = M( "user" );
		if(is_string($id)){
			$where ['username'] = array (
					'eq',
					$id
			);
		}else{
			$where ['uid'] = array (
					'eq',
					intval($id)
			);
		}
		$array = $rs->where ( $where )->find();
		if (empty ( $array )) {
			return FALSE;
		} else {
			return $array;
		}
	}
	
	
	
}
?>