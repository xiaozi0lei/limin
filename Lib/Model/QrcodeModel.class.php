<?php

class QrcodeModel extends Model {
	
	public function generate($data,$level,$size){
		
		
		Vendor('phpqrcode.qrlib');
		$PNG_WEB_DIR = '/Data/qrcode/';
		
		
		$errorCorrectionLevel = 'L';
		if (isset($level) && in_array($level, array('L','M','Q','H')))
			$errorCorrectionLevel = $level;
		
		$matrixPointSize = 4;
		if (isset($size))
			$matrixPointSize = min(max((int)$size, 1), 10);
		
		
		$filename=$this->getUrl($data, $level, $size);
		 
		$root=dirname($_SERVER['SCRIPT_FILENAME']);
		if (isset($data)) {
			if (trim($data) == '')
				return false;
			QRcode::png($data, $root.$filename, $errorCorrectionLevel, $matrixPointSize, 2);
		
		}
		$src=$PNG_WEB_DIR.basename($filename);
		return $src;
	}
	
	
	public function getUrl($data,$level,$size){
		
		$PNG_TEMP_DIR='/Data/qrcode/';
		$filename = $PNG_TEMP_DIR.'test.png';
		
		$errorCorrectionLevel = 'L';
		if (isset($level) && in_array($level, array('L','M','Q','H')))
			$errorCorrectionLevel = $level;
		
		$matrixPointSize = 4;
		if (isset($size))
			$matrixPointSize = min(max((int)$size, 1), 10);
		
		if(isset($data)){
			$filename=$PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		}
		
		
		return $filename;
		
	}
	
	
	
	function imgcode($module,$id,$sid){
		
		$imgstr='';
		
		$config_array = F ( 'qrcode' );
		
		$level =  $config_array ['level'] ;
		$size = intval ( $config_array ['size'] );
		
		$config=$config_array[strtolower($module)];
		
		if($config){
			$url=U('Wap/'.$module.'/show',array('id'=>$id,'sid'=>$sid));
			$src=$this->getUrl($url, $level, $size);
			
			if(!file_exists('.'.$src)){
				$src=$this->generate($url, $level, $size);
			}
			
			$imgstr='<img id="qrcode" src="'.__ROOT__.$src.'"/>';
		}
		
		
		return $imgstr;
	}
	
	
}
?>