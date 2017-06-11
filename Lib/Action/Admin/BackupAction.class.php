<?php
class BackupAction extends AdminInitAction {
	public function db() {
		$this->checkper ( 'backup_db' );
		$this->display ( './Public/Admin/Backup/db.html' );
	}
	public function file() {
		$this->checkper ( 'backup_file' );
		$this->display ( './Public/Admin/Backup/file.html' );
	}
	public function host() {
		$this->checkper ( 'backup_host' );
		$this->display ( './Public/Admin/Backup/host.html' );
	}
	public function dodb() {
		if (! file_exists ( APP_PATH . 'Data/backup/db' ))
			@mkdir ( APP_PATH . 'Data/backup/db', 0777 );
		
		$tables = array ();
		$tableid = intval ( $_GET ['tableid'] ) ? intval ( $_GET ['tableid'] ) : 0;
		$file_num = intval ( $_GET ['vol'] ) ? intval ( $_GET ['vol'] ) : 1;
		$nexttable = 0;
		$tables_dump = $data_str = '';
		$start = intval ( $_GET ['start'] ) && $nexttable == 0 ? intval ( $_GET ['start'] ) : 0;
		$sizelimit = 2048 * 1000;
		$time = date ( 'Ymd', time () );
		$rand = intval ( $_GET ['code'] ) ? intval ( $_GET ['code'] ) : mt_rand ( 1, 1000 );
		
		$tables_query = M ( '' )->query ( 'SHOW TABLES' );
		
		foreach ( $tables_query as $value ) {
			
			$tables [] = $value ['Tables_in_' . C ( 'DB_NAME' )];
		}
		
		if (empty ( $tableid ) && empty ( $start )) {
			
			for($i = 0; $i < count ( $tables ); $i ++) {
				$tables_dump .= $this->dumpTable ( $tables [$i] );
			}
			
			// 结构文件生成
			// file_put_contents(APP_PATH.'data/backup/backup_'.$time.'_'.$rand.'.sql',
			// $tables_dump);
			// 表结构长度
			$table_leng = strlen ( $tables_dump );
			if ($sizelimit < $table_leng) {
				$con_str = 1; // 是否生成了表结构
				file_put_contents ( APP_PATH . 'Data/backup/db/backup_' . $time . '_' . $rand . "_$file_num.sql", $tables_dump );
				$file_num ++;
			}
			$str = $tables_dump;
		}
		
		for($i = $tableid; $i <= count ( $tables ); $i ++) {
			
			$think_tablename = str_replace ( C ( 'DB_PREFIX' ), '', $tables [$i] );
			
			$count = M ( $think_tablename )->count ();
			
			while ( $start < $count ) {
				$rs = M ( $think_tablename )->limit ( $start, 300 )->select ();
				if (! empty ( $rs )) {
					$colown = array ();
					$value = array ();
					foreach ( $rs as $key => $value ) {
						
						unset ( $colown );
						unset ( $val );
						foreach ( $value as $k => $v ) {
							$colown [] = "`" . $k . "`";
							$val [] = "'" . $v . "'";
						}
						
						$str .= "INSERT INTO $tables[$i] (" . implode ( ',', $colown ) . ") VALUES (" . implode ( ',', $val ) . "); \n";
						$start += 1;
						
						if (strlen ( $str ) >= $sizelimit) {
							// 跳转生成一个单独文件
							if ($con_str) {
								$file_str = $str;
							} else {
								$file_str = $tables_dump . $str;
							}
							file_put_contents ( APP_PATH . 'Data/backup/backup_' . $time . '_' . $rand . "_$file_num.sql", $file_str );
							$this->success ( "生成 成功", U ( 'Admin/Backup/db', array (
									'tableid' => $i,
									'start' => $start,
									'code' => $rand,
									'vol' => $file_num + 1 
							) ) );
							exit ();
						}
					}
				} else {
					$nexttable = 1;
					continue 2;
				}
			}
			
			$start = 0;
			
			if (strlen ( $str ) < $sizelimit && count ( $tables ) == $i) {
				$file_str = $str;
				file_put_contents ( APP_PATH . 'Data/backup/db/backup_' . $time . '_' . $rand . "_$file_num.sql", $file_str );
				$this->success ( '备份成功' );
				exit ();
			}
		}
	}
	public function doBackupUpload() {
		$time = date ( 'Ymd', time () );
		$rand = mt_rand ( 1, 1000 );
		
		if (! file_exists ( APP_PATH . 'Data/backup/uploaddata' ))
			@mkdir ( APP_PATH . 'Data/backup/uploaddata', 0777 );
		
		import ( 'ORG.Util.PclZip' );
		
		$sqlzip = APP_PATH . 'Data/backup/uploaddata/backup_' . $time . '_' . $rand . ".zip";
		$zipfile = APP_PATH . "Upload";
		
		$zip = new PclZip ( $sqlzip );
		$zip->create ( $zipfile );
		
		$this->success ( '备份成功' );
	}
	public function doBackupHost() {
		set_time_limit ( 0 );
		$time = date ( 'Ymd', time () );
		$rand = mt_rand ( 1, 1000 );
		
		if (! file_exists ( APP_PATH . 'Data/backup/host' ))
			@mkdir ( APP_PATH . 'Data/backup/host', 0777 );
		
		import ( 'ORG.Util.PclZip' );
		
		$sqlzip = APP_PATH . 'Data/backup/host/backup_' . $time . '_' . $rand . ".zip";
		$zipfile = '../' . __ROOT__;
		
		$zip = new PclZip ( $sqlzip );
		$zip->create ( $zipfile );
		$this->success ( '备份成功' );
	}
	private function dumpTable($tablename) {
		$tabledump = "\n";
		$table_string = M ( '' )->query ( 'SHOW CREATE TABLE ' . $tablename );
		$tabledump .= $table_string [0] ['Create Table'] . ";\n\n";
		return $tabledump;
	}
}