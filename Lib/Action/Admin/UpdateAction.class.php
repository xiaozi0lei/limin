<?php
//aa
class UpdateAction extends AdminInitAction {
	public function index() {
				
		$this->checkper ( 'update' );
		
		$version=F('version');
		
		$this->assign ( $version);
		$this->display ( './Public/Admin/Update/index.html' );
	}
	public function checkupdate() {
		$this->checkper ( 'update' );
		
		$url = 'http://www.mywyx.net/cms/update.xml';
		
		$node = $this->xmlnode ( $url );
		
		if ($node == false) {
			$this->ajaxReturn ( '', '程序为最新', 0 );
			return false;
		}
		
		if (! empty ( $node )) {
			$this->ajaxReturn ( array (
					'name' => ( string ) $node->name,
					'desc' => ( string ) $node->description,
					'version' => ( string ) $node->version,
					'downurl' => ( string ) $node->downloads->downloadurl 
			), '', 1 );
		} else {
			$this->ajaxReturn ( '程序为最新', 1 );
		}
	}
	private function xmlnode($xml_url) {
		$nvserion = F('version');
		
		
		
		$findxml_obj = null;
		$xml_str = file_get_contents ( $xml_url );
		
		if (empty ( $xml_str )) {
			return false;
		}
		
		$xml_obj = ( array ) simplexml_load_string ( $xml_str );
		
		if (is_array ( $xml_obj ['update'] )) {
			$count = count ( $xml_obj ['update'] );
			arsort ( $xml_obj ['update'] );
			
			
			foreach($xml_obj['update'] as $k=>$v){
				
				$att = $v->targetplatform->attributes ();
				
				foreach ( $att as $a_k => $a_v ) {
					if ((string)$v->version != $nvserion ['version'] && $a_k == 'version' && ( string ) $a_v == $nvserion ['version']) {
						$findxml_obj = $v;
					}
				}
				
			}
			
			
		} else {
			
				$att = $xml_obj['update']->targetplatform->attributes ();
			
				foreach ( $att as $a_k => $a_v ) {
					if ((string)$xml_obj['update']->version != $nvserion ['version'] && $a_k == 'version' && ( string ) $a_v == $nvserion ['version']) {
						$findxml_obj = $xml_obj['update'];
					}
				}
			
		}
		
		return $findxml_obj;
	}
	public function doupdate() {
		set_time_limit (0);
		
		$this->checkper ( 'update' );
		
		$url = 'http://www.mywyx.net/cms/update.xml';
		
		$node = $this->xmlnode ( $url );
		
		if (empty ( $node )) {
			
			$this->ajaxReturn ( '', '获取信息失败', 0 );
			return false;
		}
		
		$url = ( string ) $node->downloads->downloadurl;
		$name = basename ( $url );
		
		$savepath = APP_PATH . 'Data/' . $name; // 设置附件上传目录
		
		if (! empty ( $node )) {
			
			$fp = fopen ( $savepath, 'wb' );
			$result = $this->remoteDownload ( $url, $fp );
			
			if ($result === true) {
				
				@fclose ( $fp );
				$filesize = @filesize ( $savepath );
				if ($filesize <= 0) {
					$result = false;
					$fp = @fopen ( $savepath, 'wb' );
				}
			}
			
			if ($result === false) {
				@fclose ( $fp );
				$this->ajaxReturn ( '', '下载失败', 0 );
				return false;
			}
			$file_info = get_headers ( $url );
			$remote_size=0;
			foreach($file_info as $k=>$v){
				
				if(strpos($v, 'Content-Length:')===0){
					$remote_size = str_replace ( 'Content-Length:', '', $v );
				}
			}
			
			if ($remote_size == filesize ( $savepath )) {
				import ( 'ORG.Util.PclZip' );
				
				$zip = new PclZip ( $savepath );
				$list = $zip->extract ( PCLZIP_OPT_PATH, "./",PCLZIP_CB_PRE_EXTRACT, "callback_pre_extract" );
				
				if (file_exists ( './Data/update.sql' )) {
					$sql = file_get_contents ( './Data/update.sql' );
					$sql=str_replace('\r\n', '', $sql);
					$sql_array=explode(';', $sql);
					$m=M ( '' );
					foreach($sql_array as $v){
						if(!empty($v)){
							$m->execute ( $v );
						}
					}
				}
				
				
				$data=array('version'=>( string ) $node->version);
				F('version',$data);
				import ( 'ORG.Util.Io.Dir' );
				@unlink('./Runtime/~runtime.php');
				$dir=new Dir ( './');
				$dir->delDir('Runtime/Data/_fields');
				
				
				$this->ajaxReturn ( '', '更新陈功', 1 );
				return true;
			} else {
				$this->ajaxReturn ( '', '更新包数据不完整，请重新下载', 0 );
				return false;
			}
		} else {
			
			$this->ajaxReturn ( '', '无法获取更新信息', 0 );
			return false;
		}
	}
	public function remoteDownload($url, $fp) {
		$result = false;
		
		$ih = @fopen ( $url, 'r' );
		if (! is_resource ( $ih )) {
			return $result;
		}
		$bytes = 0;
		$result = true;
		$return = '';
		
		while ( ! feof ( $ih ) && $result ) {
			$contents = fread ( $ih, 4096 );
			if ($contents === false) {
				@fclose ( $ih );
				$result = false;
				return $result;
			} else {
				$bytes += strlen ( $contents );
				if (is_resource ( $fp )) {
					$result = @fwrite ( $fp, $contents );
				} else {
					$return .= $contents;
					unset ( $contents );
				}
			}
		}
		
		@fclose ( $ih );
		
		if (is_resource ( $fp )) {
			return $result;
		} elseif ($result === true) {
			return $return;
		} else {
			return $result;
		}
	}
}