<?php
class PublicAction extends HomeInitAction {
	Public function verify() {
		import ( 'ORG.Util.Image' );
		Image::buildImageVerify ();
	}
	public function getOnline() {
		$customer = F ( $this->lang . 'customer' );
		
		$data['html']='';
		if($this->config['customer_b']==1){
			
			$new_customer = array ();
			foreach ( $customer as $k => $v ) {
					
				if (! empty ( $v ['qq'] )) {
					$new_customer ['qq'] [] = $v ['qq'];
				}
				if (! empty ( $v ['msn'] )) {
					$new_customer ['msn'] [] = $v ['msn'];
				}
				if (! empty ( $v ['taobao'] )) {
					$new_customer ['taobao'] [] = $v ['taobao'];
				}
				if (! empty ( $v ['alibaba'] )) {
					$new_customer ['alibaba'] [] = $v ['alibaba'];
				}
			}
			$this->assign ( 'customer', $new_customer );
			$data ['html'] = $this->fetch ( 'online' );
			
		}
		
		
		
		$this->ajaxReturn ( $data, '' );
	}
	public function getWords(){
		
		
		$keytype=explode(',', $_GET['keytype']);
		
		$init=intval($_GET['init']);
		$longkeyword=$productcity=$keyword=array();
		$config_array = F ( $this->lang . 'config' );
		
		
		if(in_array('mainkey', $keytype)){
			if(!empty($config_array['keyword'])){
				$keyword=explode(',', $config_array['keyword']);
			}
		}
		if(!empty($config_array['longkeyword'])){
			$longkeyword=explode(',', $config_array['longkeyword']);
		}
		if(!empty($config_array['productcity'])){
			$productcity=explode(',', $config_array['productcity']);
		}
		
		
		if(in_array('arekey', $keytype)){
			$product=M('product')->where(array('lang'=>'zh-cn'))->select();
			if(!empty($product)){
		
				foreach($product as $pk=>$pv){
					foreach($productcity as $k=>$v){
						$keyword[]=$v.$pv['title'];
					}
						
				}
		
			}
		}
		
		
		if(in_array('longkey', $keytype)){
			$product=M('product')->where(array('lang'=>'zh-cn'))->select();
			if(!empty($product)){
				foreach($product as $pk=>$pv){
					$keyword[]=$pv['title'];
					foreach($longkeyword as $k=>$v){
						$keyword[]=$pv['title'].$v;
						foreach($productcity as $ck=>$cv){
							$keyword[]=$cv.$pv['title'].$v;
						}
					}
						
				}
			}
		}
		
		
		//$keyword=array('山东海事局','哈哈','烟台网站','啦啦','恩恩','好的','品牌');
		$rs=array('count'=>count($keyword),'data'=>$keyword);
		
		$this->ajaxReturn($rs);
		
	}
	
	public function sitemap(){
		/*

		*/
		
	}
	
	public function alexa() {
		$sid = intval ( $_GET ['sid'] );
		$aid = intval ( $_GET ['id'] );
		$url = h ( $_GET ['url'] );
		$referer = h ( $_GET ['referer'] );
		$browser = h ( $_GET ['browser'] );
		$cook = intval ( $_GET ['urlcookie'] );
		$alexamax = 1000;
		$alexaok = 1;
		// /获取IP
		if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] )) {
			$ipadd = $_SERVER ['HTTP_CLIENT_IP'];
		} elseif (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$ipadd = $_SERVER ['HTTP_X_FORWARDED_FOR'];
		} else {
			$ipadd = $_SERVER ['REMOTE_ADDR'];
		}
		
		if (isUrl ( 1, $ipadd ) && isUrl ( 2, $url ) && $browser != '') {
			
			if (! $referer || isUrl ( 2, $referer )) {
				$now = strtotime ( date ( "Y-m-d H:i:s" ) );
				
				$data ['sid'] = $sid;
				$data ['aid'] = $aid;
				$data ['ip'] = $ipadd;
				$data ['url'] = $url;
				$data ['referer'] = $referer;
				$data ['brower'] = $browser;
				$data ['dateline'] = $now;
				
				// 添加日访问记录
				M ( 'visitday' )->add ( $data );
				$day_time = strtotime ( date ( "Y-m-d" ) ); // 获取当天的
				                                     
				// 查出当天流量概况
				$visit = M ( 'visitsummary' )->where ( array (
						'dateline' => $day_time 
				) )->find ();
				$day_start = strtotime ( date ( "Y/m/d 00:00:00" ) ); // 一天开始时间
				$day_end = strtotime ( date ( "Y/m/d 23:59:59" ) ); // 一天结束时间
				
				if ($visit) {
					// 如果有当天的浏览记录那么就更新
					$vsip = M ( 'visitday' )->where ( array (
							'ip' => $ipadd,
							'dateline' => array (
									array (
											'egt',
											$day_start 
									),
									array (
											'elt',
											$day_end 
									) 
							) 
					) )->select ();
					$pv = $visit ['pv'] + 1; // 今天的PV+1
					                      
					// 流量限制
					if ($pv < $alexamax) {
						$ip = $vsip ? $visit ['ip'] : $visit ['ip'] + 1;
						$alone = $vsip && $cook ? $visit ['alone'] : $visit ['alone'] + 1;
						$parip = $vsip ? 0 : 1;
						$paral = $vsip && $cook ? 0 : 1;
						$parttime = parttime ( date ( 'G' ), $visit ['part'], 1, $parip, $paral );
						
						M ( 'visitsummary' )->where ( array (
								'id' => $visit ['id'] 
						) )->save ( array (
								'pv' => $pv,
								'ip' => $ip,
								'alone' => $alone,
								'part' => $parttime 
						) );
					} else {
						$alexaok = 0;
					}
				} else {
					// 没有则添加
					$parstr = '';
					for($i = 0; $i < 24; $i ++) {
						$parstr .= '|';
					}
					$parttime = parttime ( date ( 'G' ), $parstr, 1, 1, 1 );
					
					$sdata ['pv'] = 1;
					$sdata ['ip'] = 1;
					$sdata ['alone'] = 1;
					$sdata ['part'] = $parttime;
					$sdata ['dateline'] = $day_time;
					M ( 'visitsummary' )->add ( $sdata );
				}
				
				if ($alexaok) { // 如果没有超出流量限制则进行统计
				              // 搜索引擎
					$lurlkey = keytype ( $referer );
					if ($lurlkey && $lurlkey [0] != '') {
						
						$keyok = M ( 'visitdetail' )->where ( array (
								'name' => $lurlkey [0],
								'dateline' => $day_time,
								'type' => 1 
						) )->find ();
						
						if ($keyok) {
							$keyok_remark = explode ( '|', $keyok ['remark'] );
							$remark = '';
							$p = 0;
							for($i = 0; $i < count ( $keyok_remark ); $i ++) {
								if ($keyok_remark [$i] != '') {
									$rk = explode ( '-', $keyok_remark [$i] );
									if ($rk [0] == $lurlkey [1]) {
										$k = $rk [1] + 1;
										$keyok_remark [$i] = $rk [0] . '-' . $k;
										$p = 1;
									}
									$remark .= $keyok_remark [$i] . '|';
								}
							}
							
							if ($p == 0)
								$remark = $remark . '|' . $lurlkey [1] . '-1|';
							
							$vsip = M ( 'visitdetail' )->where ( array (
									'ip' => $ipadd,
									'dateline' => array (
											array (
													'egt',
													$day_start 
											),
											array (
													'elt',
													$day_end 
											) 
									),
									'referer' => $referer 
							) )->select ();
							
							$pv = $keyok ['pv'] + 1;
							$ip = ! $vsip ? $keyok ['ip'] + 1 : $keyok ['ip'];
							$alone = $vsip && $cook ? $keyok ['alone'] : $keyok ['alone'] + 1;
							
							M ( 'visitdetail' )->where ( array (
									'id' => $keyok ['id'] 
							) )->save ( array (
									'pv' => $pv,
									'ip' => $ip,
									'alone' => $alone,
									'remark' => $remark,
									'type' => 1 
							) );
						} else {
							if ($lurlkey [0] != '') {
								$lurlkey [1] = $lurlkey [1] . '-1|';
								$en_data ['name'] = $lurlkey [0];
								$en_data ['pv'] = 1;
								$en_data ['ip'] = 1;
								$en_data ['alone'] = 1;
								$en_data ['remark'] = $lurlkey [1];
								$en_data ['type'] = 1;
								$en_data ['dateline'] = $day_time;
								M ( 'visitdetail' )->add ( $en_data );
							}
						}
					}
					
					// 2:受访分析
					$urlok = M ( 'visitdetail' )->where ( array (
							'name' => $url,
							'dateline' => $day_time,
							'type' => 2 
					) )->find ();
					if ($urlok) {
						// 更新2:受访分析
						$vsip = M ( 'visitday' )->where ( array (
								'ip' => $ipadd,
								'dateline' => array (
										array (
												'egt',
												$day_start 
										),
										array (
												'elt',
												$day_end 
										) 
								),
								'referer' => $referer 
						) )->select ();
						$pv = $urlok ['pv'] + 1;
						$ip = ! $vsip ? $urlok ['ip'] + 1 : $urlok ['ip'];
						$alone = $vsip && $cook ? $urlok ['alone'] : $urlok ['alone'] + 1;
						M ( 'visitdetail' )->where ( array (
								'id' => $urlok ['id'] 
						) )->save ( array (
								'pv' => $pv,
								'ip' => $ip,
								'alone' => $alone,
								'remark' => '',
								'type' => 2 
						) );
					} else {
						// 插入2:受访分析
						M ( 'visitdetail' )->add ( array (
								'name' => $url,
								'pv' => 1,
								'ip' => 1,
								'alone' => 1,
								'remark' => '',
								'type' => 2,
								'sid' => $sid,
								'aid' => $aid,
								'dateline' => $day_time 
						) );
					}
					
					$lurlok = M ( 'visitdetail' )->where ( array (
							'name' => $referer,
							'dateline' => $day_time,
							'type' => 3 
					) )->find ();
					if ($lurlok) { // 更新 3:来路分析
						
						$vsip = M ( 'visitday' )->where ( array (
								'ip' => $ipadd,
								'dateline' => array (
										array (
												'egt',
												$day_start 
										),
										array (
												'elt',
												$day_end 
										) 
								),
								'referer' => $referer 
						) )->select ();
						$pv = $lurlok ['pv'] + 1;
						$ip = ! $vsip ? $lurlok ['ip'] + 1 : $lurlok ['ip'];
						$alone = $vsip && $cook ? $lurlok ['alone'] : $lurlok ['alone'] + 1;
						M ( 'visitdetail' )->where ( array (
								'id' => $lurlok ['id'] 
						) )->save ( array (
								'pv' => $pv,
								'ip' => $ip,
								'alone' => $alone,
								'remark' => '',
								'type' => 3 
						) );
					} else {
						M ( 'visitdetail' )->add ( array (
								'name' => $referer,
								'pv' => 1,
								'ip' => 1,
								'alone' => 1,
								'remark' => '',
								'type' => 3,
								'dateline' => $day_time 
						) );
					}
				}
			}
		}
	}
	
	
	public function viewNum(){
		
		$module=$_POST['module'];
		$id=intval($_POST['id']);
		if(in_array($module, array('article','product'))){
			
			$item=M($module)->where(array('id'=>$id))->find();
			
			if(!empty($item)){
				M($module)->where(array('id'=>$id))->setInc("hit",1);
				echo $item['hit']+1;
			}
			
		}
		
	}
	
	public function getShop() {
		$shop = F ( 'shopconfig' );
		
		if ($shop ['shop_swich']) {
			
			$style = $shop ['order_style'];
			$data ['style'] = $style;
			
			$content = $this->fetch ( 'Shop/ajax_' . $style . '_' . $shop ['order_color'] );
			$data ['content'] = $content;
			$this->ajaxReturn ( $data, '', 1 );
		}
		
		$this->ajaxReturn ( '', '', 0 );
	}
	public function buy() {
		
		
		if(empty($_GET['is_cart'])){
			cookie ( 'count',null);
			cookie ( 'price',null);
			cookie ( 'id',null);
		}
		
		$id = intval ( $_GET ['id'] );
		$count_a = $price_a = $id_a = array ();
		$pro = M ( 'product' )->where ( array (
				'id' => $id 
		) )->find ();
		
		$id = $pro ['title'];
		$count = cookie ( 'count' ) ? cookie ( 'count' ) : 1;
		$price = cookie ( 'price' ) ? cookie ( 'price' ) : $pro ['price'];
		
		if (empty ( $pro )) {
			$this->error ( '不存在该产品' );
		}
		
		
		
		
		
		$id_list = cookie ( 'id' );
		if (! empty ( $id_list )) {
			$id_a = explode ( '|', $id_list );
			$k = array_search ( $pro ['id'], $id_a );
			$count_a = explode ( '|', $count );
			$price_a = explode ( '|', $price );
			
			if ($k === false) {
				// 如果不存在
				array_push ( $id_a, $pro ['id'] );
				array_push ( $count_a, 1 );
				array_push ( $price_a, $pro ['price'] );
			} else {
				// 已经存在
				$count_a [$k] = $count_a [$k] + 1;
				$price_a [$k] = $price_a [$k] + $pro ['price'];
			}
			
			$count = array_sum ( $count_a );
			$price = array_sum ( $price_a );
		} else {
			$count_a [] = $count;
			$price_a [] = $pro ['price'];
			$id_a [] = $pro ['id'];
		}
		
		cookie ( 'count', implode ( '|', $count_a ) );
		cookie ( 'price', implode ( '|', $price_a ) );
		cookie ( 'id', implode ( '|', $id_a ) );
		
		$this->assign ( 'count', $count );
		$this->assign ( 'price', $price );
		$this->display ( 'Shop/buy' );
	}
	public function checkout() {
		if (! cookie ( 'count' )) {
			exit ( '购物车无商品' );
		} else {
			
			$count = cookie ( 'count' );
			$price = cookie ( 'price' );
			$this->assign ( 'count', array_sum ( explode ( '|', $count ) ) );
			$this->assign ( 'price', array_sum ( explode ( '|', $price ) ) );
			$this->display ( 'Shop/buy' );
		}
	}
	//参数state的作用:确认登录操作loginsubmit产生的状态
	//默认值0 登录操作正常
	//1：第一次登录成功  2：登录密码错误
	public function pay($state =0) {
		$shop = F ( 'shopconfig' );
		$this->assign ( 'shop', $shop );
		
		if($this->config['pc_memshop'])
		{
			switch ($state){
				case 0:
					//支付前进行用户登录判断
					if(empty($this->islogin)){
						$shop = F ( 'shopconfig' );
						$this->assign ( 'shop', $shop['dio'] );//加载的样式参数
						$this->display('Public/login');
						exit();
					}
					break;
				case 1:
					$this->assign('Login',1);//标示登陆成功
					//读取会员信息
					
					
					
					break;
				case 2:
					$this->assign('Login',1);
					$this->display('Public/login');
					exit();
			}
		}
		$ids = cookie ( 'id' );
		$ids_a = explode ( '|', $ids );
		// 数量
		$count = cookie ( 'count' );
		$count_a = explode ( '|', $count );
		// 单品总价格
		$price = cookie ( 'price' );
		$price_a = explode ( '|', $price );
		
		$new_a = $new_pro = array ();
		foreach ( $ids_a as $key => $value ) {
			$new_a [$value] ['count'] = $count_a [$key];
			$new_a [$value] ['price'] = $price_a [$key];
		}
		
		$pro = M ( 'product' )->where ( array (
				'id' => array (
						'in',
						$ids_a 
				) 
		) )->select ();
		
		$total = 0;
		foreach ( $pro as $key => $value ) {
			$new_pro [$value ['id']] = $value;
			$new_pro [$value ['id']] ['count'] = $new_a [$value ['id']] ['count'];
			$new_pro [$value ['id']] ['list_price'] = $new_a [$value ['id']] ['price'];
			$total = $total + $new_a [$value ['id']] ['price'];
		}
		$this->assign('IsLogin',1);
		$this->assign ( 'total', $total );
		$this->assign ( 'pro', $new_pro );
		$this->display ( 'Shop/step1' );
	}
	public function doOrder() {
		$shop = F ( 'shopconfig' );
		$this->assign ( 'shop', $shop );
		$ids = $_POST ['ids'];
		$beizhu = h ( $_POST ['beizhu'] );
		$p = M ( 'product' );
		
		if ($p->autoCheckToken ( $_POST )) {
			$new_ids = array_keys ( $ids );
			
			$pro = $p->where ( array (
					'id' => array (
							'in',
							$new_ids 
					) 
			) )->select ();
			
			foreach ( $pro as $k => $v ) {
				$new_pro [$v ['id']] = $ids [$v ['id']];
			}
			
			if (empty ( $pro )) {
				$this->error ( '请选择产品' );
			}
			if (! empty ( $beizhu )) {
				session ( 'beizhu', $beizhu );
			}
			session ( 'pro', $new_pro );
		} else {
			$this->error ( '提交错误' );
		}
		
		$this->assign ( 'total', array_sum ( explode ( '|', $_COOKIE ['price'] ) ) );
		// 地址填写页面
		$this->display ( 'Shop/step2' );
	}
	public function saveOrder() {
		$shop = F ( 'shopconfig' );
		$this->assign ( 'shop', $shop );
		$paytype=$_POST['PAY_TYPE'];
		$p = M ( 'product' );
		if ($p->autoCheckToken ( $_POST )) {
			$order_ids = session ( 'pro' );
			$beizhu = session ( 'beizhu' );
			
			if (empty ( $order_ids )) {
				$this->error ( '没有选择商品' );
			}
			
			$order_p = $p->where ( array (
					'id' => array (
							'in',
							array_keys ( $order_ids ) 
					) 
			) )->select ();
			
			$total = 0;
			$order_list = array ();
			
			$temp [] = h($_POST ['sheng']);
			$temp [] =h($_POST ['shi']);
			$temp [] = h($_POST ['qu']);
			
			$provinces = implode ( ' ', $temp );
			
			$order_num = substr ( date ( "ymdHis" ), 2, 8 ) . mt_rand ( 100000, 999999 );
			
			//计算总价格
			foreach ( $order_p as $k => $v ) {
				
				$total +=$order_ids[$v['id']] * $v ['price'];
			}
			
			
			$oid = M ( 'order' )->add ( array (
					
					'provinces' => $provinces,
					'price' => $total,
					'username' => h($_POST ['rname']),
					'status' => 1,
					'dateline' => time (),
					'phone' => h($_POST ['mobile']),
					'provinces' => $provinces,
					'address' => h($_POST ['addr']),
					'email' => ! empty ( $_POST ['email'] ) ? h($_POST ['email']) : '',
					'num' => $order_num,
					'beizhu' => h($_POST ['biezhu']) 
			) );
			
			foreach ( $order_p as $k => $v ) {
				$order_p [$k] ['item_price'] = $order_ids [$v ['id']] * $v ['price'];
				$order_p [$k] ['count'] = $order_ids [$v ['id']];
				
				M ( 'orderdetail' )->add ( array (
						'oid' => $oid,
						'url' => U ( 'Product/show', array (
								'sid' => $order_p [$k] ['sort'],
								'id' => $order_p [$k] ['id'] 
						) ),
						'pname' => $order_p [$k] ['title'],
						'pcount' => $order_p [$k] ['count'],
						'price' => $order_p [$k] ['item_price'],
						'perprice' => $order_p [$k] ['price'] 
				) );
			}
		} else {
			$this->error ( '提交错误' );
		}
		
		// 成功页面显示
		$this->assign('paytype',$paytype);
		$this->assign ( 'order_num', $order_num );
		$this->display ( 'Shop/step3' );
	}
	public function ordersearch() {
		$mobile = h ( $_POST ['phone'] );
		$order = h ( $_POST ['num'] );
		
		$order = M ( 'order' )->where ( array (
				'num' => $order,
				'phone' => $mobile 
		) )->find ();
		
		if (empty ( $order )) {
			$this->display ( 'Shop/tips' );
			return false;
		}
		
		$detail = M ( 'orderdetail' )->where ( array (
				'oid' => $order ['id'] 
		) )->select ();
		
		$this->assign ( 'order', $order );
		$this->assign ( 'detail', $detail );
		$this->display ( 'Shop/myorder' );
	}
	public function search() {
		$this->display ( 'Shop/search' );
	}
	
	public function onlinepay(){
		
		$paytype=$_POST['paytype'];
		$m_order=M('order');
		
		if($m_order->autoCheckToken ( $_POST )){
			
			
			if(!empty($_POST['paytype'])&&!in_array($paytype, array('alipay','chinabank'))){
				$this->error('不支持该支付类型');
			}
			
			
			
		}else{
			$this->error('重复提交订单');
		}
		
		
		$total=0;
		$order_num=$_POST['ordernum'];
		$order=M('order')->where(array('num'=>$order_num))->find();
		
		if(empty($order)){
			$this->error('不存在该订单');
		}
		
		$p_array=explode('|', $order['price']);
		
		foreach($p_array as $v){
			$total +=$v;
		}
		
		$order['total_price']=$total;
		
		if($paytype=='alipay'){
			$this->createAlipay($order);
		}
		
		if($paytype=='chinabank'){
			
			$this->createChinabank($order);
		}
		
		
	}
	
	
	private function createAlipay($order){
		
		//加载PC网站即时到账
		require_once(VENDOR_PATH.'Alipay_direct_pay/alipay.config.php');
		require_once(VENDOR_PATH."Alipay_direct_pay/lib/alipay_submit.class.php");
		
		/**************************请求参数**************************/
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url = U('Public/aliNotify');//"http://www.xxx.com/create_direct_pay_by_user-PHP-UTF-8/notify_url.php";
		//需http://格式的完整路径，不能加?id=123这类自定义参数
		
		//页面跳转同步通知页面路径
		$return_url = U('/');//"http://www.xxx.com/create_direct_pay_by_user-PHP-UTF-8/return_url.php";
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
		
		//卖家支付宝帐户
		$seller_email = $shop_config['ali_seller'];
		//必填
		
		//商户订单号
		$out_trade_no = $order['num'];
		//商户网站订单系统中唯一订单号，必填
		
		//订单名称
		$subject = $order['num'];
		//必填
		
		//付款金额
		$total_fee = $order['total_price'];
		//必填
		
		//订单描述
		
		$body = '';
		//商品展示地址
		$show_url = '';
		//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html
		
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数
		
		//客户端的IP地址
		$exter_invoke_ip = "";
		//非局域网的外网IP地址，如：221.0.0.1
		
		
		/************************************************************/
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "please wait...");
		echo $html_text;
		
		
		
	}
	
	private function createChinabank($order){
		$shop_config=F('shopconfig');
		
		$v_mid = $shop_config['bank_id'];								    // 商户号，这里为测试商户号1001，替换为自己的商户号(老版商户号为4位或5位,新版为8位)即可
		$v_url = U('Public/chinaBanknotify');	// 请填写返回url,地址应为绝对路径,带有http协议
		$key   = $shop_config['bank_md5'];								    // 如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/
		
		
		$v_oid = trim($order['num']);
		$v_amount = trim($order['total_price']);                   //支付金额
		$v_moneytype = "CNY";                                            //币种
		
		$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;        //md5加密拼凑串,注意顺序不能变
		$v_md5info = strtoupper(md5($text));                             //md5函数加密并转化成大写字母
		
		
		$str = <<<EOD
					<form method="post" name="E_FORM" action="https://pay3.chinabank.com.cn/PayGate">
	<input type="hidden" name="v_mid"         value="$v_mid">
	<input type="hidden" name="v_oid"         value="$v_oid">
	<input type="hidden" name="v_amount"      value="$v_amount">
	<input type="hidden" name="v_moneytype"   value="$v_moneytype">
	<input type="hidden" name="v_url"         value="$v_url">
	<input type="hidden" name="v_md5info"     value="$v_md5info">
	<script>document.E_FORM.submit();</script>
</form>
EOD;

		
		echo $str;
		
	}
	
	
	
	public function aliNotify(){
		require_once(VENDOR_PATH.'Alipay_direct_pay/alipay.config.php');
		require_once(VENDOR_PATH."Alipay_direct_pay/lib/alipay_notify.class.php");
		
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
		
		
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
		
			//商户订单号
		
			$out_trade_no = $_POST['out_trade_no'];
		
			//支付宝交易号
		
			$trade_no = $_POST['trade_no'];
		
			//交易状态
			$trade_status = $_POST['trade_status'];
		
		
			if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
		
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
		
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
				
				M('order')->where(array('num'=>$out_trade_no,'status'=>1))->save(array('status'=>2));
				echo "success";		//请不要修改或删除
				
				
			}
			else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
		
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
		
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
				
				//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
				M('order')->where(array('num'=>$out_trade_no,'status'=>1))->save(array('status'=>2));
				echo "success";		//请不要修改或删除
			}
		
			
		
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			echo "fail";
		
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
		
		
	}
	
	public function chinaBanknotify(){
		$shop_config=F('shopconfig');
		$key=$shop_config['bank_md5'];
		$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号
		$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）
		$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
		$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）；
		$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
		$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种
		$remark1   =trim($_POST['remark1' ]);      //备注字段1
		$remark2   =trim($_POST['remark2' ]);     //备注字段2
		$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值
		$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));
		
		if ($v_md5str==$md5string)
		{
			if($v_pstatus=="20")
			{
				
				M('order')->where(array('num'=>$v_oid,'status'=>1))->save(array('status'=>2));
				$this->success('支付成功，正在跳转到主页',site_url());
			}else{
				echo "支付失败";
			}
		
		}else{
			echo "<br>校验失败,数据可疑";
		}
		
	}
	
	public function checkpay(){
		
		$order_num=$_POST['ordernum'];
		$rs_array=array('error'=>1,'data'=>array());
		$order=M('order')->where(array('num'=>$order_num,'status'=>2))->find();
		
		if(!empty($order)){
			$rs_array['error']=0;
			$rs_array['data']['num']=$order['num'];
		}
		$this->ajaxReturn($rs_array);
		
	}
	
	public function order() {
		$phone = h ( $_POST ['phone'] );
		$num = h ( $_POST ['num'] );
		
		$order = M ( 'order' )->where ( array (
				'phone' => $phone,
				'order_num' => $num 
		) )->find ();
		
		if (empty ( $order )) {
			$this->display ( 'Shop/tips' );
			return false;
		}
		$detail = M ( 'orderdetail' )->where ( array (
				'oid' => $order ['id'] 
		) )->select ();
		
		$this->assign ( 'detail', $detail );
		$this->assign ( 'order', $order );
		$this->display ( 'Shop/order' );
	}
	//参数jump:默认值0为跳转回原页面，其余值自己定义跳转，设定参数避免在购物过程中出现问题
	public function loginsubmit($jump = 0) {
		
		$username = isset ( $_POST ['username'] ) ? trim ( $_POST ['username'] ) : '';
		$password = isset ( $_POST ['password'] ) ? trim ( $_POST ['password'] ) : '';
		$remeber = isset ( $_POST ['remeber'] ) ? intval ( $_POST ['remeber'] ) : 0;
		
		$model = D ( 'User' );
		if ($model->checkUser ( $username, $password )) {
			$model->doLogin ( $username, $password );
			$user = $model->getUserSesstion ();
			// 存储cookie
			$model->setAuthCookie ( $username, $user ['uid'], $remeber );
			if ($jump == 1)
			{
				$this->redirect(  'public/pay?state=1' );
			}	
			if($jump ==2)
			{
				$this->ajaxReturn(0,"登录成功",1);
			}		
			$this->success ( L ( 'loginsuccess' ) );
		} 
		else {
			if ($jump == 1)
			{
				$this->redirect(  'public/pay?state=2' );
			}
			if($jump ==2)
			{
				$this->ajaxReturn(0,"密码错误！",0);
			}
			$this->error ( L ( 'pwderror' ) );
		}
	}
	public function reg() {
		if(!empty($this->islogin)){
			$this->error('您已登录，请退出登录',site_url());
		}
		$this->assign('webtitle','会员注册');
		$this->display ();
	}
	public function doreg() {
		if ($_SESSION ['verify'] != md5 ( $_POST ['checkcode'] )) {
			$this->error ( '验证码错误！' );
		}
		
		$uid = intval ( $_POST ['uid'] );
		
		$pwd = $_POST ['pwd'];
		$pwdc = $_POST ['pwdconfirm'];
		$data ['realname'] = h ( $_POST ['realname'] );
		$data ['phone'] = h ( $_POST ['phone'] );
		$data ['sex'] = intval ( $_POST ['sex'] );
		$data ['mobile'] = h ( $_POST ['mobile'] );
		$data ['qq'] = h ( $_POST ['qq'] );
		$data ['email'] = h ( $_POST ['email'] );
		$data ['isadmin'] = 0;
		$data ['groupid'] = 14;
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
			if (empty ( $_POST ['username'] )) {
				$this->error ( '用户名不能为空' );
			}
			
			if (empty ( $_POST ['realname'] )) {
				$this->error ( '真实姓名不能为空' );
			}
			
			if (empty ( $pwd )) {
				$this->error ( '密码为空' );
			}
			
			$user = M ( 'user' )->where ( array (
					'username' => $_POST ['username'] 
			) )->find ();
			if (! empty ( $user )) {
				$this->error ( '用户名已经存在' );
			}
			$data ['username'] = h ( $_POST ['username'] );
			$data ['dateline'] = time ();
			M ( 'user' )->add ( $data );
			$this->success ( '添加成功' );
		}
	}
	public function logout() {
		$cookie_name = C ( 'COOKIE_NAME' );
		$this->user_model->generateAuthCookie ( $this->_USESSION ['username'], $this->_USESSION ['uid'] );
		
		setcookie ( $cookie_name, '', - 86400, '/' );
		session ( 'user', null );
		session ( 'islogin', null );
		redirect ( U ( 'Home/index/index' ) );
	}
	
	public function ajaxlogin(){
		
		$html=$this->fetch();
		echo $html;
	}
}