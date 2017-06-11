<?php
class ShopAction extends WapInitAction {
	public function index() {
		$this->display();
	}
	//购物
	public function shopA(){
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
		if ($_GET['go']==1)
		{
			$this->redirect('Shop/Scar');
		}
		else
			$this->display();
	}
	//购物车结算界面
	public function Scar(){
		$this->sumP();
		//$this->assign('IsLogin',1);
		$this->display();
	}
	//结算
	public function Accounts(){
		
			if (($this->islogin ==0)&&(!empty($this->config['mobile_memshop'])))
			{
				header("Content-Type:text/html; charset=utf-8");
				echo "<script type='text/javascript'>alert('请登录！');window.location.href = '".U('Public/login?jump=2')."';</script>";
				exit();
				//$this->redirect('Public/login');http://192.168.0.194/wap/public/mebCenter
			}
		
			
			$ids = $_POST ['ids'];
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
			
			
			
			
		$this->assign($this->_USESSION);
		$this->sumP();
		$this->display();
	}
	public function sumP()
	{
		$ids = cookie ( 'id' );
		$ids_a = explode ( '|', $ids );
		// 数量
		$num = 0;
		$count = cookie ( 'count' );
		$count_a = explode ( '|', $count );
		// 单品总价格
		$price = cookie ( 'price' );
		$price_a = explode ( '|', $price );
		
		$new_a = $new_pro = array ();
		foreach ( $ids_a as $key => $value ) {
			$new_a [$value] ['count'] = $count_a [$key];
			$new_a [$value] ['price'] = $price_a [$key];
			$num += $count_a [$key];
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
		$this->assign ( 'total', $total );
		$this->assign ( 'num', $num );
		$this->assign ( 'pro', $new_pro );
	}
	//生成订单
	public function doOrder()
	{
		$p = M ( 'product' );
		//if ($p->autoCheckToken ( $_POST )) {
		if (TRUE) {
			$order_ids = session ( 'pro' );
			//$beizhu = session ( 'beizhu' );
				
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
						
					$temp [] = $_POST ['sheng'];
					$temp [] = $_POST ['shi'];
					$temp [] = $_POST ['qu'];
						
					$provinces = implode ( ' ', $temp );
						
					$order_num = substr ( date ( "ymdHis" ), 2, 8 ) . mt_rand ( 100000, 999999 );
					if (empty($this->config['mobile_memshop']))
					{
						$uid = 0;
					}
					else
						$uid = $this->_USESSION['uid'];
					$info = array (
							'payMath'=>$_POST['payMethord'],
							'uid' => $uid,	
							'provinces' => $provinces,
							'price' => $_COOKIE ['price'],
							'username' => $_POST ['member_account'],
							'status' => 1,
							'dateline' => time (),
							'phone' => $_POST ['member_cellphone'],
							'provinces' => $provinces,
							'address' => $_POST ['member_addres'],
							'email' => ! empty ( $_POST ['member_Email'] ) ? $_POST ['member_Email'] : '',
							'num' => $order_num,
							'beizhu' => $_POST ['member_beizhu'],
							'payMath' =>intval($_POST['payMethord']) 
					);
					$oid = M ( 'order' )->add ( $info );
					foreach ( $order_p as $k => $v ) {
						$order_p [$k] ['item_price'] = $order_ids [$v ['id']] * $v ['price'];
						$order_p [$k] ['count'] = $order_ids [$v ['id']];
						$total = $total + $order_p [$k] ['item_price'];
		
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
		$this->assign ( 'order_num', $order_num );
		$this->assign($info);
		$this->sumP();
		var_dump($info);
		$this->display();
	}
	public function pay()
	{
		
		//使用支付宝付款
		switch($_POST["order_way"])
		{
			//默认支付方式，支付宝支付
			case 0:
				require_once(VENDOR_PATH.'Alipay/config.php');
				require_once(VENDOR_PATH."Alipay/lib/alipay_submit.class.php");
				//返回格式
				$format = "xml";
				//必填，不需要修改
				//返回格式
				$v = "2.0";
				//必填，不需要修改
				//请求号
				$req_id = date('Ymdhis');
				//必填，须保证每次请求都是唯一
				
				//**req_data详细信息**
				//服务器异步通知页面路径
				$notify_url = "http://www.xxx.com/WS_WAP_PAYWAP-PHP-UTF-8/notify_url.php";
				//需http://格式的完整路径，不允许加?id=123这类自定义参数
				//页面跳转同步通知页面路径
				$call_back_url = "http://127.0.0.1:8800/WS_WAP_PAYWAP-PHP-UTF-8/call_back_url.php";
				//需http://格式的完整路径，不允许加?id=123这类自定义参数
				
				//操作中断返回地址
				$merchant_url = "http://127.0.0.1:8800/WS_WAP_PAYWAP-PHP-UTF-8/xxxx.php";
				//用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数
				
				//卖家支付宝帐户
				$seller_email = 'zhengdaoshili@qq.com';
				//商户订单号
				$out_trade_no = $_POST['order_num'];
				//商户网站订单系统中唯一订单号，必填
				
				//订单名称
				$subject = $_POST['order_num'];
				//必填
				
				//付款金额
				$total_fee = $_POST['order_money'];
				//必填
				//请求业务参数详细
				$req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
				//必填
				
				/************************************************************/
				
				//构造要请求的参数数组，无需改动
				$para_token = array(
						"service" => "alipay.wap.trade.create.direct",
						"partner" => trim($alipay_config['partner']),
						"sec_id" => trim($alipay_config['sign_type']),
						"format"	=> $format,
						"v"	=> $v,
						"req_id"	=> $req_id,
						"req_data"	=> $req_data,
						"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
				);
				//建立请求
				$alipaySubmit = new AlipaySubmit($alipay_config);
				$html_text = $alipaySubmit->buildRequestHttp($para_token);
				
				//URLDECODE返回的信息
				$html_text = urldecode($html_text);
				//解析远程模拟提交后返回的信息
				$para_html_text = $alipaySubmit->parseResponse($html_text);
				
				//获取request_token
				$request_token = $para_html_text['request_token'];
				/**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/
				
				//业务详细
				$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
				//必填
				//构造要请求的参数数组，无需改动
				$parameter = array(
						"service" => "alipay.wap.auth.authAndExecute",
						"partner" => trim($alipay_config['partner']),
						"sec_id" => trim($alipay_config['sign_type']),
						"format"	=> $format,
						"v"	=> $v,
						"req_id"	=> $req_id,
						"req_data"	=> $req_data,
						"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
				);
				
				//建立请求
				$alipaySubmit = new AlipaySubmit($alipay_config);
				$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
				echo $html_text;
				break;
			//余额支付
			case 1:
				header("Content-Type:text/html; charset=utf-8");
				echo "<script type='text/javascript'>alert('qing！');</script>";
				break;
		}
		exit();
	}
	
	
}