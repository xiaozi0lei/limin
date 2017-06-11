<?php
class ConfigAction extends AdminInitAction {
	public function basic() {
		$config_array = F ( $this->lang . 'config' );
		
		$this->checkper ( 'config_basic' );
		
		$data ['logo'] = site_url () . '/' . $config_array ['logo'];
		$data ['sitename'] = $config_array ['sitename'];
		$data ['titleext'] = $config_array ['titleext'];
		$data ['keyword'] = $config_array ['keyword'];
		$data ['desc'] = $config_array ['desc'];
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Config/basic.html' );
	}
	public function doSaveLang() {
		$data ['indexlang'] = $_POST ['indexlang'];
		$data ['adminlang'] = $_POST ['adminlang'];
		F ( 'lang', $data );
		$this->success ( '保存成功' );
	}
	public function lang() {
		$this->checkper ( 'config_lang' );
		import ( 'ORG.Util.Io.Dir' );
		$now = F ( 'lang' );
		$dir = new Dir ( LANG_PATH );
		$file = $dir->toArray ();
		
		$this->assign ( 'now', $now );
		$this->assign ( 'lang', $file );
		$this->display ( './Public/Admin/Config/lang.html' );
	}
	public function mail() {
		$config_array = F ( $this->lang . 'config' );
		$this->checkper ( 'config_mail' );
		$data ['mailname'] = $config_array ['mailname'];
		$data ['mailtype'] = $config_array ['mailtype'];
		$data ['ssl'] = $config_array ['ssl'];
		$data ['mailport'] = $config_array ['mailport'];
		$data ['count'] = $config_array ['count'];
		$data ['pwd'] = $config_array ['pwd'];
		$data ['smtp'] = $config_array ['smtp'];
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Config/mail.html' );
	}
	public function testmail() {
		$config_array = F ( $this->lang . 'config' );
		
		$tomail = 'zooandzoo@sina.com';
		$subject = '测试测试邮件';
		$body = '邮件内容';
		
		require_once LIBRARY_PATH . 'ORG/Util/phpmailer/class.phpmailer.php';
		require_once LIBRARY_PATH . 'ORG/Util/phpmailer/class.pop3.php';
		require_once LIBRARY_PATH . 'ORG/Util/phpmailer/class.smtp.php';
		$mail = new PHPMailer ();
		
		if ($config_array ['mailtype'] == 'smtp') {
			$mail->Mailer = "smtp";
			$mail->Host = $config_array ['smtp']; // sets GMAIL as the SMTP server
			$mail->Port = $config_array ['mailport']; // set the SMTP port
			
			if ($config_array ['ssl']) {
				$mail->SMTPSecure = "ssl"; // sets the prefix to the servier tls,ssl
			}
			
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = $config_array ['count']; // SMTP username
			$mail->Password = $config_array ['pwd']; // SMTP password
		} else {
			
			$mail->Mailer = 'mail';
		}
		
		$mail->FromName = $config_array ['mailname']; // 发件人姓名
		$mail->From = $config_array ['count']; // 发件人邮箱
		
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
	public function pic() {
		$this->checkper ( 'config_pic' );
		
		$config_array = F ( $this->lang . 'config' );
		
		$data ['product_w'] = intval ( $config_array ['product_w'] );
		$data ['product_h'] = intval ( $config_array ['product_h'] );
		$data ['pic_w'] = intval ( $config_array ['pic_w'] );
		$data ['pic_h'] = intval ( $config_array ['pic_h'] );
		$data ['art_w'] = intval ( $config_array ['art_w'] );
		$data ['art_h'] = intval ( $config_array ['art_h'] );
		$data ['art_list_w'] = intval ( $config_array ['art_list_w'] );
		$data ['art_list_h'] = intval ( $config_array ['art_list_h'] );
		$data ['pro_list_w'] = intval ( $config_array ['pro_list_w'] );
		$data ['pro_list_h'] = intval ( $config_array ['pro_list_h'] );
		$data ['pic_list_w'] = intval ( $config_array ['pic_list_w'] );
		$data ['pic_list_h'] = intval ( $config_array ['pic_list_h'] );
		$data ['banner_w'] = intval ( $config_array ['banner_w'] );;
		$data ['banner_h'] = intval ( $config_array ['banner_h'] );;
		
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Config/pic.html' );
	}
	public function doSaveBasic() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['sitename'] = $_POST ['sitename'];
		$config_array ['titleext'] = $_POST ['titleext'];
		$config_array ['keyword'] = $_POST ['keyword'];
		$config_array ['desc'] = $_POST ['desc'];
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function doSaveEmail() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['mailname'] = $_POST ['mailname'];
		$config_array ['mailtype'] = $_POST ['mailtype'];
		$config_array ['ssl'] = $_POST ['ssl'];
		$config_array ['mailport'] = $_POST ['mailport'];
		$config_array ['count'] = $_POST ['count'];
		$config_array ['pwd'] = $_POST ['pwd'];
		$config_array ['smtp'] = $_POST ['smtp'];
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function doSavePic() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['product_w'] = intval ( $_POST ['product_w'] );
		$config_array ['product_h'] = intval ( $_POST ['product_h'] );
		$config_array ['pic_w'] = intval ( $_POST ['pic_w'] );
		$config_array ['pic_h'] = intval ( $_POST ['pic_h'] );
		$config_array ['art_w'] = intval ( $_POST ['art_w'] );
		$config_array ['art_h'] = intval ( $_POST ['art_h'] );
		
		$config_array ['art_list_w'] = intval ( $_POST ['art_list_w'] );
		$config_array ['art_list_h'] = intval ( $_POST ['art_list_h'] );
		$config_array ['pro_list_w'] = intval ( $_POST ['pro_list_w'] );
		$config_array ['pro_list_h'] = intval ( $_POST ['pro_list_h'] );
		$config_array ['pic_list_w'] = intval ( $_POST ['pic_list_w'] );
		$config_array ['pic_list_h'] = intval ( $_POST ['pic_list_h'] );
		$config_array ['banner_w'] = intval ( $_POST ['banner_w'] );
		$config_array ['banner_h'] = intval ( $_POST ['banner_h'] );
		
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function doUploadLogo() {
		$config_array = F ( $this->lang . 'config' );
		
		import ( 'ORG.Net.UploadFile' );
		$upload = new UploadFile (); // 实例化上传类
		$upload->maxSize = 3145728; // 设置附件上传大小
		$upload->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg'
		); // 设置附件上传类型
		$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
		$upload->thumb = true;
		$upload->thumbMaxWidth = 100;
		$upload->thumbMaxHeight = 100;
		$upload->thumbRemoveOrigin = false;
		
		if (! $upload->upload ()) { // 上传错误提示错误信息
			APP_PATH;
			$result ['status'] = 0;
			$result ['message'] = $upload->getErrorMsg ();
			echo json_encode ( $result );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['status'] = 1;
			$result ['message'] = '上传成功';
			$result ['url'] = site_url () . '/Upload/thumb_' . $info [0] ['savename'];
			
			$config_array ['logo'] = 'Upload/thumb_' . $info [0] ['savename'];
			
			F ( $this->lang . 'config', $config_array );
			
			echo json_encode ( $result );
		}
	}
}