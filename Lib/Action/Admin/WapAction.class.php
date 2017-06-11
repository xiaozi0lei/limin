<?php
class WapAction extends AdminInitAction {
	public function config() {
		$config_array = F ( $this->lang . 'config' );
		
		$data ['wapon'] = intval ( $config_array ['wapon'] );
		$data ['waplink'] = intval ( $config_array ['waplink'] );
		$data ['wapjump'] = intval ( $config_array ['wapjump'] );
		$this->assign ( $data );
		$this->display ( './Public/Admin/Wap/config.html' );
	}
	public function doSaveConfig() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['wapon'] = intval ( $_POST ['wapon'] );
		$config_array ['waplink'] = intval ( $_POST ['waplink'] );
		$config_array ['wapjump'] = intval ( $_POST ['wapjump'] );
		
		F ( $this->lang . 'config', $config_array );
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$this->assign ( 'type', 'home' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		$this->success ( '保存成功' );
	}
	public function home() {
		$config_array = F ( $this->lang . 'config' );
		
		$data ['wap_art_num'] = intval ( $config_array ['wap_art_num'] );
		$data ['wap_pro_num'] = intval ( $config_array ['wap_pro_num'] );
		$data ['wap_pic_num'] = intval ( $config_array ['wap_pic_num'] );
		$data ['wap_down_num'] = intval ( $config_array ['wap_down_num'] );
		$data ['wap_jon_num'] = intval ( $config_array ['wap_jon_num'] );
		$this->assign ( $data );
		$this->display ( './Public/Admin/Wap/home.html' );
	}
	public function doSaveHome() {
		$config_array = F ( $this->lang . 'config' );
		$config_array ['wap_art_num'] = intval ( $_POST ['wap_art_num'] );
		$config_array ['wap_pro_num'] = intval ( $_POST ['wap_pro_num'] );
		$config_array ['wap_pic_num'] = intval ( $_POST ['wap_pic_num'] );
		$config_array ['wap_down_num'] = intval ( $_POST ['wap_down_num'] );
		$config_array ['wap_jon_num'] = intval ( $_POST ['wap_jon_num'] );
		
		F ( $this->lang . 'config', $config_array );
		
		$this->success ( '保存成功' );
	}
	public function lists() {
		$config_array = F ( $this->lang . 'config' );
		$data ['wap_list_art_num'] = intval ( $config_array ['wap_list_art_num'] );
		$data ['wap_list_pro_num'] = intval ( $config_array ['wap_list_pro_num'] );
		$data ['wap_list_pic_num'] = intval ( $config_array ['wap_list_pic_num'] );
		$data ['wap_list_down_num'] = intval ( $config_array ['wap_list_down_num'] );
		$data ['wap_list_job_num'] = intval ( $config_array ['wap_list_job_num'] );
		$this->assign ( $data );
		$this->display ( './Public/Admin/Wap/lists.html' );
	}
	public function doSaveLists() {
		$config_array = F ( $this->lang . 'config' );
		$config_array ['wap_list_art_num'] = intval ( $_POST ['wap_list_art_num'] );
		$config_array ['wap_list_pro_num'] = intval ( $_POST ['wap_list_pro_num'] );
		$config_array ['wap_list_pic_num'] = intval ( $_POST ['wap_list_pic_num'] );
		$config_array ['wap_list_down_num'] = intval ( $_POST ['wap_list_down_num'] );
		$config_array ['wap_list_job_num'] = intval ( $_POST ['wap_list_job_num'] );
		
		F ( $this->lang . 'config', $config_array );
		
		$this->success ( '保存成功' );
	}
	public function detail() {
		$config_array = F ( $this->lang . 'config' );
		$data ['wap_prothumb_width'] = intval ( $config_array ['wap_prothumb_width'] );
		$data ['wap_prothumb_height'] = intval ( $config_array ['wap_prothumb_height'] );
		$data ['wap_picthumb_width'] = intval ( $config_array ['wap_picthumb_width'] );
		$data ['wap_picthumb_height'] = intval ( $config_array ['wap_picthumb_height'] );
		$this->assign ( $data );
		$this->display ( './Public/Admin/Wap/detail.html' );
	}
	public function doSaveDetail() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['wap_prothumb_width'] = intval ( $_POST ['wap_prothumb_width'] );
		$config_array ['wap_prothumb_height'] = intval ( $_POST ['wap_prothumb_height'] );
		$config_array ['wap_picthumb_width'] = intval ( $_POST ['wap_picthumb_width'] );
		$config_array ['wap_picthumb_height'] = intval ( $_POST ['wap_picthumb_height'] );
		
		F ( $this->lang . 'config', $config_array );
		
		$this->success ( '保存成功' );
	}
}