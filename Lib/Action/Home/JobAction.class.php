<?php
class JobAction extends HomeInitAction {
	public function index() {
		$sub = $three = $sids = array ();
		
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
		
		// 用于查找当前分类下面子类文章
		
		$sids [] = $sort ['id'];
		
		//子级查找
		$son=M('sort')->field('id,idpath,name')->where(array('idpath'=>array('like','%'.$sort['id'].'-%')))->select();
		if(!empty($son)){
			foreach($son as $sk=>$sv){
				$sids[]=$sv['id'];
			}
		}
		$where ['sort'] = array (
				'in',
				$sids 
		);
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		
		
		$page_url = '';
		
		if (C ( 'HTML_ON' ) || C ( 'SEF_ROUTER' )) {
			$sort = F ( 'zh-cnpath' );
			$path = $sort [intval ( $_GET ['sid'] )] ['path'];
			$page_url = $path;
		}
		
		
		$config_array = F ( $this->lang . 'config' );
		$count = M ( 'job' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $config_array ['list_job_num'] ,'',$page_url); // 实例化分页类
		                                                              // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'job' )->where ( $where )->order ( 'top desc,j_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		// 处理URL
		if (! empty ( $list )) {
			foreach ( $list as $k => $v ) {
				$list [$k] ['url'] = listurl ( 'Job/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
			$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp; 
		$this->assign ( 'webtitle',$this->firTitle );
		$this->assign ( 'keyword', $sort ['keyword'] ? $sort ['keyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $sort ['desc'] ? $sort ['desc'] : $this->config ['desc'] );
		
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ($this->current_sort['index_tpl']);
	}
	public function show() {
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'job' );
		$job = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		if (empty ( $job )) {
			$this->pageNotFound();
		}
		$job['content']=dereplace($job['content']);
		// 二维码
		$img = D ( 'Qrcode' )->imgcode ( 'job', $job ['id'], $job ['sort'] );
		$this->assign ( 'qrcode', $img );
		
		// 网站头部优化设置
		$this->assign ( 'webtitle', $this->config ['sitename'] );
		$this->assign ( 'keyword', $this->config ['keyword'] );
		$this->assign ( 'desc', $this->config ['desc'] );
		
		$this->assign ( 'sid', $job ['sort'] );
		$this->assign ( 'job', $job );
		$this->display ($this->current_sort['show_tpl']);
	}
	public function doJob() {
		$id = intval ( $_GET ['id'] );
		$job = M ( 'job' )->where ( array (
				'id' => $id 
		) )->find ();
		if (empty ( $job )) {
			$this->error ( '不存在该职位' );
		}
		
		$field = M ( 'formfield' )->where ( array (
				'module' => 'job',
				'lang' => $this->lang 
		) )->order ( 'f_order ASC' )->select ();
		
		foreach ( $field as $key => $value ) {
			$field [$key] ['html'] = input_html ( $value );
		}
		
		$this->assign ( 'field', $field );
		$this->assign ( $job );
		$this->display ();
	}
	public function submitJob() {
		$jid = intval ( $_POST ['jid'] );
		$job = M ( 'job' )->where ( array (
				'id' => $jid 
		) )->find ();
		if (empty ( $job )) {
			$this->error ( '不存在该职位' );
		}
		
		$field = M ( 'formfield' )->where ( array (
				'module' => 'job',
				'lang' => $this->lang 
		) )->order ( 'f_order ASC' )->select ();
		
		foreach ( $field as $value ) {
			if($value ['type']== 'file'){
				$hasfile=1;
			}
			
			if($value ['type'] == 'file'&&empty ( $_FILES ['field' . $value ['id']] ['name'] )){
				unset($_FILES ['field' . $value ['id']]);
			}
			
			if ($value ['type'] == 'file' && $value ['required'] && empty ( $_FILES ['field' . $value ['id']] ['name'] )) {
				$this->error ( '附件' . $value ['title'] . '不能为空' );
			}
			
			if ($value ['type'] != 'file' && $value ['required'] && empty ( $_POST ['field' . $value ['id']] )) {
				$this->error ( $value ['title'] . '不能为空' );
			}
			
			$data ['field' . $value ['id']] = h ( $_POST ['field' . $value ['id']] );
		}
		
		if($hasfile&&!empty($_FILES)){
			import ( 'ORG.Net.UploadFile' );
			$upload = new UploadFile (); // 实例化上传类
			$upload->maxSize = 3145728; // 设置附件上传大小
			$upload->allowExts = array (
					'jpg',
					'gif',
					'png',
					'jpeg',
					'docx',
					'dotx',
					'doc',
					'html',
					'pdf',
					'txt'
			); // 设置附件上传类型
			$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
			
			if (! $upload->upload ()) { // 上传错误提示错误信息
				$this->error ( $upload->getErrorMsg () );
			} else { // 上传成功 获取上传文件信息
				$info = $upload->getUploadFileInfo ();
				foreach ( $info as $key => $value ) {
					$data [$info [$key] ['key']] = 'Upload/' . $info [$key] ['savename'];
				}
			}
			
		}
		
		
		$add ['jid'] = $job ['id'];
		$add ['dateline'] = time ();
		$add ['jobname'] = $job ['title'];
		if (! empty ( $data )) {
			$add ['extend'] = serialize ( $data );
		}
		
		$config_array = F ( $this->lang . 'config' );
		
		if ($config_array ['re_type'] == 'email') {
			// 自动回复
			$extend = unserialize ( $add ['extend'] );
			$field = M ( 'formfield' )->where ( array (
					'lang' => $this->lang,
					'module' => 'job' 
			) )->order ( 'f_order ASC' )->select ();
			$val = '';
			foreach ( $field as $key => $value ) {
				
				if ($extend ['field' . $value ['id']]) {
					if ($value ['type'] == 'file') {
						$val = site_url () . '/' . $extend ['field' . $value ['id']];
					} else {
						$val = $extend ['field' . $value ['id']];
					}
				}
				
				$field [$key] ['val'] = $val;
			}
			
			$this->assign ( 'field', $field );
			$content = $this->fetch ( './Public/Admin/Job/jobProTmpl.html' );
			$this->sendJobMail ( '有应聘简历发送', $content, $config_array ['re_email_add'] );
		} else {
			M ( 'jobpro' )->add ( $add );
		}
		
		$this->success ( '提交成功' );
	}
	private function sendJobMail($title, $content, $tomail) {
		$config_array = F ( $this->lang . 'config' );
		
		$subject = $title;
		$body = $content;
		
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
}