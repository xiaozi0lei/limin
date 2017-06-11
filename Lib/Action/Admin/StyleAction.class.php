<?php
class StyleAction extends AdminInitAction {
	public function index() {
		$config_array = F ( $this->lang . 'config' );
		$this->checkper ( 'style_index' );
		$data ['index_art_num'] = intval ( $config_array ['index_art_num'] );
		$data ['index_pro_num'] = intval ( $config_array ['index_pro_num'] );
		$data ['index_pic_num'] = intval ( $config_array ['index_pic_num'] );
		$data ['index_down_num'] = intval ( $config_array ['index_down_num'] );
		$data ['index_jon_num'] = intval ( $config_array ['index_jon_num'] );
		$this->assign ( $data );
		$this->display ( './Public/Admin/Style/index.html' );
	}
	function tmpl() {
		$config_array = F ( $this->lang . 'config' );
		
		$data ['pc_value'] = $config_array ['pc_tmpl'];
		$data ['mobile_value'] = $config_array ['mobile_tmpl'];
		$data ['pc_mem'] = $config_array ['pc_memshop'];
		$data ['mb_mem'] = $config_array ['mobile_memshop'];
		 
		import ( 'ORG.Util.Io.Dir' );
		$pc = $pc_dir = new Dir ( TMPL_PATH . 'Home' );
		$mobile = $mobile_dir = new Dir ( TMPL_PATH . 'Wap' );
		
		$pc_array = $pc_dir->toArray ();
		$mobile_array = $mobile_dir->toArray ();
		$this->assign ( $data );
		$this->assign ( 'pc', $pc_array );
		$this->assign ( 'mobile', $mobile_array );
		$this->display ( './Public/Admin/Style/tmpl.html' );
	}
	function dotmpl() {
		$config_array = F ( $this->lang . 'config' );
		$config_array ['pc_memshop'] = $_POST ['pc_memshop'];
		$config_array ['mobile_memshop'] = $_POST ['mobile_memshop'];
		$config_array ['pc_tmpl'] = $_POST ['pc_tmpl'];
		$config_array ['mobile_tmpl'] = $_POST ['mobile_tmpl'];
		F ( $this->lang . 'config', $config_array );
		$this->success ( '修改成功' );
	}
	public function doSaveStyle() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['index_art_num'] = intval ( $_POST ['index_art_num'] );
		$config_array ['index_pro_num'] = intval ( $_POST ['index_pro_num'] );
		$config_array ['index_pic_num'] = intval ( $_POST ['index_pic_num'] );
		$config_array ['index_down_num'] = intval ( $_POST ['index_down_num'] );
		$config_array ['index_jon_num'] = intval ( $_POST ['index_jon_num'] );
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function lists() {
		$this->checkper ( 'style_lists' );
		$config_array = F ( $this->lang . 'config' );
		
		$data ['list_article_num'] = intval ( $config_array ['list_article_num'] );
		$data ['list_product_num'] = intval ( $config_array ['list_product_num'] );
		$data ['list_picture_num'] = intval ( $config_array ['list_picture_num'] );
		$data ['list_download_num'] = intval ( $config_array ['list_download_num'] );
		$data ['list_job_num'] = intval ( $config_array ['list_job_num'] );
		$data ['new_icon_day'] = intval ( $config_array ['new_icon_day'] );
		$data ['hot_icon_click'] = intval ( $config_array ['hot_icon_click'] );
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Style/lists.html' );
	}
	public function doSaveStyleList() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['list_article_num'] = intval ( $_POST ['list_article_num'] );
		$config_array ['list_product_num'] = intval ( $_POST ['list_product_num'] );
		$config_array ['list_picture_num'] = intval ( $_POST ['list_picture_num'] );
		$config_array ['list_download_num'] = intval ( $_POST ['list_download_num'] );
		$config_array ['list_job_num'] = intval ( $_POST ['list_job_num'] );
		$config_array ['new_icon_day'] = intval ( $_POST ['new_icon_day'] );
		$config_array ['hot_icon_click'] = intval ( $_POST ['hot_icon_click'] );
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function detail() {
		$this->checkper ( 'style_details' );
		
		$config_array = F ( $this->lang . 'config' );
		
		$data ['share_button'] = intval ( $config_array ['share_button'] );
		$data ['click_num'] = intval ( $config_array ['click_num'] );
		$data ['add_time'] = intval ( $config_array ['add_time'] );
		$data ['print_page'] = intval ( $config_array ['print_page'] );
		$data ['page_close'] = intval ( $config_array ['page_close'] );
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Style/detail.html' );
	}
	public function doSaveStyleDetail() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['share_button'] = intval ( $_POST ['share_button'] );
		$config_array ['click_num'] = intval ( $_POST ['click_num'] );
		$config_array ['add_time'] = intval ( $_POST ['add_time'] );
		$config_array ['print_page'] = intval ( $_POST ['print_page'] );
		$config_array ['page_close'] = intval ( $_POST ['page_close'] );
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function customer() {
		$this->checkper ( 'style_customer' );
		
		$config_array = F ( $this->lang . 'config' );
		
		$data ['customer_b'] = h ( $config_array ['customer_b'] );
		$data ['customer_position'] = $config_array ['customer_position'];
		$data ['customer_color'] = $config_array ['customer_color'];
		$data ['customer_qq'] = h ( $config_array ['customer_qq'] );
		$data ['customer_msn'] = h ( $config_array ['customer_msn'] );
		$data ['customer_taobao'] = h ( $config_array ['customer_taobao'] );
		$data ['customer_alibaba'] = h ( $config_array ['customer_alibaba'] );
		$data ['customer_bottomer'] = $config_array ['customer_bottomer'];
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Style/customer.html' );
	}
	public function doSaveStyleCustomer() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['customer_b'] = h ( $_POST ['customer_b'] );
		$config_array ['customer_color'] = $_POST ['customer_color'];
		$config_array ['customer_qq'] = h ( $_POST ['customer_qq'] );
		$config_array ['customer_msn'] = h ( $_POST ['customer_msn'] );
		$config_array ['customer_taobao'] = h ( $_POST ['customer_taobao'] );
		$config_array ['customer_alibaba'] = h ( $_POST ['customer_alibaba'] );
		$config_array ['customer_bottomer'] = $_POST ['customer_bottomer'];
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function customerList() {
		$customer = M ( 'customer' )->where ( array (
				'lang' => $this->lang 
		) )->select ();
		
		$this->assign ( 'customer', $customer );
		$this->display ( './Public/Admin/Style/customerList.html' );
	}
	public function doEditStyleCustomer() {
		if (! empty ( $_POST ['check'] )) {
			
			foreach ( $_POST ['check'] as $key => $value ) {
				
				$data ['c_order'] = intval ( $_POST ['order'] [$value] );
				$data ['name'] = h($_POST ['name'] [$value]);
				$data ['qq'] = h ( $_POST ['qq'] [$value] );
				$data ['msn'] = h ( $_POST ['msn'] [$value] );
				$data ['taobao'] = h($_POST ['taobao'] [$value]);
				$data ['alibaba'] = h($_POST ['alibaba'] [$value]);
				$data ['lang'] = $this->lang;
				
			
				M ( 'customer' )->where ( array (
						'id' => intval ( $value ) 
				) )->save ( $data );
			}
		}
		
		$list = M ( 'customer' )->order ( 'c_order ASC' )->select ();
		F ( $this->lang . 'customer', $list );
		$this->success ( '保存成功' );
	}
	public function delCustomer() {
		if (! empty ( $_POST ['check'] )) {
			
			foreach ( $_POST ['check'] as $key => $value ) {
				M ( 'customer' )->where ( array (
						'id' => intval ( $value ) 
				) )->delete ();
			}
			
			$list = M ( 'customer' )->order ( 'c_order ASC' )->select ();
			F ( $this->lang . 'customer', $list );
			$this->success ( '删除成功' );
		} else {
			
			$this->error ( '请选择要删除的条目' );
		}
	}
	public function addCustomer() {
		$this->display ( './Public/Admin/Style/addCustomer.html' );
	}
	public function doaddCustomer() {
		$data ['name'] = htmlspecialchars ( $_POST ['name'] );
		$data ['c_order'] =  h ( $_POST ['order'] );
		$data ['qq'] =  h ( $_POST ['qq'] );
		$data ['msn'] =  h ( $_POST ['msn'] );
		$data ['taobao'] =  h ( $_POST ['taobao'] );
		$data ['alibaba'] =  h ( $_POST ['alibaba'] );
		$data ['lang'] = $this->lang;
		
		if (empty ( $data ['name'] )) {
			$this->error ( '名称不能为空' );
		}
		
		M ( 'customer' )->add ( $data );
		
		$list = M ( 'customer' )->order ( 'c_order ASC' )->select ();
		F ( $this->lang . 'customer', $list );
		$this->success ( '添加成功', U ( 'Admin/Style/customerList' ) );
	}
}