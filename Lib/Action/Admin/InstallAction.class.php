<?php
class InstallAction extends Action {
	public function _initialize() {
		header ( "Content-Type:text/html; charset=" . DEFAULT_CHARSET );
		if (is_file ( './Public/install/install.lock' )) {
			$this->error ( '已经安装过,重新安装请先删除Public/install/install.lock 文件!' );
		}
	}
	public function index() {
		$this->display ( './Public/Admin/Install/install.html' );
	}
	public function setup() {
		if (function_exists ( 'mysql_connect' )) {
			$this->assign ( 'db_mysql', '1' );
		}
		
		if (function_exists ( 'sqlite_open' ) && extension_loaded ( 'pdo_sqlite' )) {
			$this->assign ( 'db_sqlite', '1' );
		}
		
		$this->display ( './Public/Admin/Install/install.html' );
	}
	public function install() {
		$data = $_POST ['data'];
		
		if ($data ['dbtype'] == 'mysql') {
			$rs = @mysql_connect ( $data ['db_host'] . ":" . $data ['db_port'], $data ['db_user'], $data ['db_pwd'] );
			if (! $rs) {
				$this->error ( '数据库连接失败!请检查数据库连接参数!' );
			}
			// 数据库不存在,尝试建立
			if (! @mysql_select_db ( $data ['db_name'] )) {
				$sql = "CREATE DATABASE `" . $data ["db_name"] . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
				mysql_query ( $sql );
			}
			// 建立不成功
			if (! @mysql_select_db ( $data ['db_name'] )) {
				$this->error ( '建立失败,请手动创建数据库!~或者填写管理员分配的数据库名!' );
			}
		}
		
		// 保存配置文件
		
		$config_array = require './Conf/setting.php';
		
		if ($data ['dbtype'] == 'pdo') {
			$new ['DB_TYPE'] = 'pdo';
			$new ['DB_DSN'] = 'sqlite:./cms.db';
			$new ['DB_PREFIX'] = $data ['db_prefix'];
		} else {
			$new ['DB_TYPE'] = 'mysql';
			$new ['DB_HOST'] = $data ['db_host'];
			$new ['DB_NAME'] = $data ['db_name'];
			$new ['DB_USER'] = $data ['db_user'];
			$new ['DB_PWD'] = $data ['db_pwd'];
			$new ['DB_PORT'] = $data ['db_port'];
			$new ['DB_PREFIX'] = $data ['db_prefix'];
		}
		
		$new_c = array_merge ( $config_array, $new );
		arr2file ( './Conf/setting.php', $new_c );
		@unlink ( './Runtime/~app.php' );
		
		if ($data ['dbtype'] == 'mysql') {
			$db_config = array (
					'dbms' => 'mysql',
					'username' => $data ['db_user'],
					'password' => $data ['db_pwd'],
					'hostname' => $data ['db_host'],
					'hostport' => $data ['db_port'],
					'database' => $data ['db_name'] 
			);
			$sql = read_file ( './data/cms.sql' );
			$sql = str_replace ( 'cms_', $data ['db_prefix'], $sql );
			$this->batQuery ( $sql, $db_config );
			touch ( './Public/install/install.lock' );
			@unlink ( './Runtime/~app.php' );
			@unlink ( './Runtime/~runtime.php' );
		}
		$this->assign ( "jumpUrl", U ( 'Admin/Login/index' ) );
		$this->success ( '恭喜您！安装完成，点击进入后台管理！!' );
	}
	public function batQuery($sql, $db_config) {
		require THINK_PATH . '/Lib/Driver/Db/DbMysql.class.php';
		$db = new Dbmysql ( $db_config );
		$sql = str_replace ( "\r\n", "\n", $sql );
		$ret = array ();
		$num = 0;
		foreach ( explode ( ";\n", trim ( $sql ) ) as $query ) {
			$queries = explode ( "\n", trim ( $query ) );
			foreach ( $queries as $query ) {
				$ret [$num] .= $query [0] == '#' || $query [0] . $query [1] == '--' ? '' : $query;
			}
			$num ++;
		}
		unset ( $sql );
		foreach ( $ret as $query ) {
			if (trim ( $query )) {
				$db->query ( $query );
			}
		}
		return true;
	}
}