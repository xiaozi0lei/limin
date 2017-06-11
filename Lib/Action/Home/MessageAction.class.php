<?php
class MessageAction extends HomeInitAction {
	public function index() {
		$sid = intval ( $_GET ['sid'] );
		$where = array (
				'lang' => $this->lang,
				'hidden' => 0 
		);
		$sort = M ( 'sort' )->field('id,idpath,title,keyword,desc,name')->where ( array (
				'id' => $sid 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->pageNotFound();
		}
		$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp;
		$this->assign ( 'webtitle',$this->firTitle );
		$this->display ($this->current_sort['index_tpl']);
		
	}
	public function doSaveMessage() {
		if ($_SESSION ['verify'] != md5 ( $_POST ['checkcode'] )) {
			$this->error ( '验证码错误！' );
		}
		$data ['username'] = h ( $_POST ['Guest_Name'] );
		$data ['email'] = h ( $_POST ['Guest_Email'] );
		$data ['phone'] = h ( $_POST ['Guest_TEL'] );
		$data ['addr'] = h ( $_POST ['Guest_ADD'] );
		$data ['fax'] = h ( $_POST ['Guest_FAX'] );
		$data ['zip'] = h ( $_POST ['Guest_ZIP'] );
		$data ['content'] = h ( $_POST ['Content'] );
		$data ['lang'] = $this->lang;
		$data ['isxunpan'] = intval ( $_POST ['isxunpan'] );
		$data ['dateline'] = time ();
		
		M ( 'message' )->add ( $data );
		
		$this->sendmail();
		
		$this->success ( '感谢您的留言' );
	}
	
	
	private function sendmsg(){
		$shop_array= F ( 'shopconfig' );
		if(!empty($shop_array['shop_mobile'])){
			import ( 'ORG.Util.Client' );
			$client=new Client();
			
			
		}
		
		
	}
	
	private  function sendmail() {
		$config_array = F ( $this->lang . 'config' );
		$mailconfig_array= F ( 'shopconfig' );
		if(!empty($mailconfig_array['shop_email'])){
			$tomail = $mailconfig_array['shop_email'];
			$subject = '产品询盘提醒';
			$body = '您有产品询盘留言,请登录后台查看';
			
			require_once LIBRARY_PATH . 'ORG/Util/phpmailer/class.phpmailer.php';
			require_once LIBRARY_PATH . 'ORG/Util/phpmailer/class.pop3.php';
			require_once LIBRARY_PATH . 'ORG/Util/phpmailer/class.smtp.php';
			$mail = new PHPMailer ();
			
			if ($config_array ['mailtype'] == 'smtp') {
				$mail->Mailer = "smtp";
				$mail->Host = 'smtp.exmail.qq.com'; // sets GMAIL as the SMTP server
				$mail->Port = 25; // set the SMTP port
			
				if ($config_array ['ssl']) {
					$mail->SMTPSecure = "ssl"; // sets the prefix to the servier tls,ssl
				}
			
				$mail->SMTPAuth = true; // turn on SMTP authentication
				$mail->Username = 'shangjihulian@renmai.com'; // SMTP username
				$mail->Password = '@renmai8923,.'; // SMTP password
			} else {
				$mail->Mailer = 'mail';
			}
			
			$mail->FromName = '询盘提醒'; // 发件人姓名
			$mail->From = 'shangjihulian@renmai.com'; // 发件人邮箱
			
			$mail->CharSet = "UTF-8"; // 这里指定字符集！
			$mail->Encoding = "base64";
			
			if (is_array ( $tomail )) {
				foreach ( $tomail as $v ) {
					$mail->AddAddress ( $v );
				}
			} else {
				$mail->AddAddress ( $tomail );
			}
			
			$mail->IsHTML ( true ); // send as HTML
			// 邮件主题
			$mail->Subject = $subject;
			// 邮件内容
			$mail->Body = $body;
			$mail->AltBody = "text/html";
			$mail->SMTPDebug = false;
			return $mail->Send ();
		}
		
	}
	
	
	public function sendmobile($content='aaa'){
		
		$config_array= F ( 'shopconfig' );
		
		if(!empty($config_array['msg_acc'])&&!empty($config_array['msg_mima'])&&!empty($config_array['shop_mobile'])){
			$url="http://service.winic.org:8009/sys_port/gateway/?id=%s&pwd=%s&to=%s&content=%s&time=";
			
			$id = urlencode($config_array['msg_acc']);
			$pwd = urlencode($config_array['msg_mima']);
			$to = urlencode($config_array['shop_mobile']);
			$content = urlencode(iconv('UTF-8', 'GB2312', $content));
			$rurl = sprintf($url, $id, $pwd, $to, $content);
			$ret = file($rurl);
			$e=explode('/', $ret[0]);
			
			if($e[0]=='-01'){
				//费用已经用完
				
			}
			
		}
		
		
		
	}
	
	
}