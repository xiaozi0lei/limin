<?php
class QrcodeAction extends AdminInitAction {
	public function config() {
		$config_array = F ( 'qrcode' );
		
		$data ['article'] = intval ( $config_array ['article'] );
		$data ['product'] = intval ( $config_array ['product'] );
		$data ['download'] = intval ( $config_array ['download'] );
		$data ['picture'] = intval ( $config_array ['picture'] );
		$data ['job'] = intval ( $config_array ['job'] );
		
		$data ['level'] = $config_array ['level'];
		$data ['size'] = intval ( $config_array ['size'] );
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Qrcode/config.html' );
	}
	public function doSaveConfig() {
		$config_array = F ( 'qrcode' );
		
		$config_array ['article'] = intval ( $_POST ['article'] );
		$config_array ['product'] = intval ( $_POST ['product'] );
		$config_array ['download'] = intval ( $_POST ['download'] );
		$config_array ['picture'] = intval ( $_POST ['picture'] );
		$config_array ['job'] = intval ( $_POST ['job'] );
		
		$config_array ['level'] = $_POST ['level'];
		$config_array ['size'] = intval ( $_POST ['size'] );
		F ( 'qrcode', $config_array );
		
		$this->success ( '保存成功' );
	}
	public function generate() {
		
		$this->assign('codeurl',"尚未生成");
		//$this->assign('codeurl',site_url().'/data/qrcode/test.png');
		$this->display ( './Public/Admin/Qrcode/generate.html' );
	}
	public function doGenerate() {
		$level = $_POST ['level'];
		$size = intval ( $_POST ['size'] );
		
		Vendor ( 'phpqrcode.qrlib' );
		
		$PNG_TEMP_DIR = './Data/qrcode/';
		$PNG_WEB_DIR = __ROOT__ . '/Data/qrcode/';
		
		if (! file_exists ( $PNG_TEMP_DIR ))
			mkdir ( $PNG_TEMP_DIR );
		
		$filename = $PNG_TEMP_DIR . 'test.png';
		
		$errorCorrectionLevel = 'L';
		if (isset ( $_REQUEST ['level'] ) && in_array ( $_REQUEST ['level'], array (
				'L',
				'M',
				'Q',
				'H' 
		) ))
			$errorCorrectionLevel = $_REQUEST ['level'];
		
		$matrixPointSize = 4;
		if (isset ( $_REQUEST ['size'] ))
			$matrixPointSize = min ( max ( ( int ) $_REQUEST ['size'], 1 ), 10 );
		
		if (isset ( $_REQUEST ['data'] )) {
			
			if (trim ( $_REQUEST ['data'] ) == '')
				$this->error ( '请输入数据' );
			
			$filename = $PNG_TEMP_DIR . 'test' . md5 ( $_REQUEST ['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize ) . '.png';
			QRcode::png ( $_REQUEST ['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2 );
		}
		
		$src = $PNG_WEB_DIR . basename ( $filename );
		
		$this->assign ( 'src', $src );
		$this->assign ( 'codeurl', site_url () . '/Data/qrcode/' . basename ( $filename ) );
		$this->display ( './Public/Admin/Qrcode/generate.html' );
	}
}