<?php
class ShopAction extends AdminInitAction {
	public function orderAll() {
		import ( 'ORG.Util.Page' ); // 导入分页类
		$type = intval ( $_GET ['type'] );
		$where = array ();
		if (! empty ( $type )) {
			$where ['status'] = $type;
		}
		
		$count = M ( 'order' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'order' )->where ( $where )->order ( 'dateline DESC' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		$ids = array ();
		foreach ( $list as $k => $v ) {
			$ids [] = $v ['id'];
			$newlist [$v ['id']] = $v;
		}
		
		$detail = M ( 'orderdetail' )->where ( array (
				'oid' => array (
						'in',
						$ids 
				) 
		) )->select ();
		
		foreach ( $detail as $key => $value ) {
			$newlist [$value ['oid']] ['detail'] [] = $value;
		}
		
		$this->assign ( 'list', $newlist ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		
		$this->display ( './Public/Admin/Shop/order.html' );
	}
	public function pro() {
		$this->display ( './Public/Admin/Shop/pro.html' );
	}
	public function setting() {
		$config_array = F ( 'shopconfig' );
		
		$data ['shop_swich'] = $config_array ['shop_swich'];
		$data ['shop_mobile'] = $config_array ['shop_mobile'];
		$data ['shop_email'] = $config_array ['shop_email'];
		$data ['order_style'] = $config_array ['order_style'];
		$data ['msg_acc'] = $config_array ['msg_acc'];
		$data ['msg_mima'] = $config_array ['msg_mima'];
		$data ['order_color'] = $config_array ['order_color'];
		$data ['dio'] = $config_array ['dio'];
		
		$this->assign ( $data );
		
		$this->display ( './Public/Admin/Shop/setting.html' );
	}
	public function doSaveConfig() {
		$config_array = F ( 'shopconfig' );
		
		$config_array ['shop_swich'] = $_POST ['shop_swich'];
		$config_array ['shop_mobile'] = $_POST ['shop_mobile'];
		$config_array ['shop_email'] = $_POST ['shop_email'];
		$config_array ['order_style'] = $_POST ['order_style'];
		$config_array ['order_color'] = $_POST ['order_color'];
		$config_array ['msg_acc'] = $_POST ['msg_acc'];
		$config_array ['msg_mima'] = $_POST ['msg_mima'];
		$config_array ['dio'] = $_POST ['dio'];
		
		F ( 'shopconfig', $config_array );
		$this->success ( '保存成功' );
	}
	public function cancle() {
		$id = intval ( $_GET ['id'] );
		$order = M ( 'order' )->where ( array (
				'id' => $id 
		) )->find ();
		
		$this->assign ( 'order', $order );
		$this->display ( './Public/Admin/Shop/cancle.html' );
	}
	public function doCancle() {
		$id = intval ( $_POST ['id'] );
		$order = M ( 'order' )->where ( array (
				'id' => $id 
		) )->find ();
		
		if (empty ( $order )) {
			$this->error ( '不存在' );
		}
		
		M ( 'order' )->where ( array (
				'id' => $id 
		) )->save ( array (
				'status' => 6 
		) );
		
		$this->success ( '取消成功' );
	}
	public function send() {
		$id = intval ( $_GET ['id'] );
		$order = M ( 'order' )->where ( array (
				'id' => $id 
		) )->find ();
		
		if (empty ( $order )) {
			$this->error ( '不存在该订单' );
		}
		
		$this->assign ( 'order', $order );
		$this->display ( './Public/Admin/Shop/send.html' );
	}
	public function dosend() {
		$data ['sendtype'] = h ( $_POST ['wuliu'] );
		$data ['sender'] = $_POST ['sender'];
		$data ['num'] = $_POST ['order_num'];
		$data ['status'] = 4;
		M ( 'order' )->where ( array (
				'id' => $_POST ['id'] 
		) )->save ( $data );
		$this->success ( '发货成功' );
	}
	
	public function delorder(){
		
		$id=$_GET['oid'];
		$order=M('order')->where()->find();
		if(empty($order)){
			$this->error('不存在该订单');
		}
		
		
		M('order')->where(array('id'=>$id))->delete();
		M('orderdetail')->where(array('oid'=>$id))->delete();
		$this->success('删除成功');
	}
	
	public function paySetting(){
		
		$config_array = F ( 'shopconfig' );
		$this->assign($config_array);
		$this->display('./Public/Admin/Shop/paysetting.html');
	}
	
	
	public function doSavePaySeting(){
		$config_array = F ( 'shopconfig' );
		
		$config_array ['alipay'] = $_POST ['alipay'];
		$config_array ['ali_seller'] = $_POST ['ali_seller'];
		$config_array ['ali_pid'] = $_POST ['ali_pid'];
		$config_array ['ali_key'] = $_POST ['ali_key'];
		
		
		
		$config_array ['bankpay'] = $_POST ['bankpay'];
		$config_array ['bank_id'] = $_POST ['bank_id'];
		$config_array ['bank_md5'] = $_POST ['bank_md5'];
		
		F ( 'shopconfig', $config_array );
		$this->success ( '保存成功' );
		
	}
	
	
}