<?php
class JobAction extends AdminInitAction {
	public function jobList() {
		$this->checkper ( 'job_joblist' );
		
		$where['lang']=$this->lang;
		$sortid=$_GET['sortid']?intval($_GET['sortid']):0;
		if(!empty($sortid)){
			$findsort=M('sort')->where(array('id'=>$sortid))->find();
			if(empty($findsort)){
				$this->error('不存在该分类');
			}
			$where['sort']=$findsort['id'];
		}
		
		$sort=M('sort')->where(array('lang'=>$this->lang,'module'=>'Job'))->select();
		$newsort=array();
		if(!empty($sort)){
			foreach($sort as $k=>$v){
				$newsort[$v['id']]=$v;
			}
		
		}
		
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		
		$count = M ( 'Job' )->where ($where)->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Job' )->where($where)->order ( 'id desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['sortname']=$newsort[$value['sort']]['name'];
			}
		}
		
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ( './Public/Admin/Job/jobList.html' );
	}
	public function jobPro() {
		$id = intval ( $_GET ['id'] );
		
		$pro = M ( 'jobpro' )->where ( array (
				'id' => $id 
		) )->find ();
		
		$extend = unserialize ( $pro ['extend'] );
		
		if (empty ( $pro )) {
			$this->error ( '不存在该简历' );
		}
		
		$field = M ( 'formfield' )->where ( array (
				'lang' => $this->lang,
				'module' => 'job' 
		) )->order ( 'f_order ASC' )->select ();
		
		$val = '';
		foreach ( $field as $key => $value ) {
			if($value['id']==41){
				$a=1;
			}
				
			if ($value ['type'] == 'file') {
					$val = empty($extend ['field' . $value ['id']])?'':site_url () . '/' . $extend ['field' . $value ['id']];
			} else {
					$val = $extend ['field' . $value ['id']];
			}
			
			$field [$key] ['val'] = $val;
		}
		
		$this->assign ( 'field', $field );
		$this->display ( './Public/Admin/Job/jobPro.html' );
	}
	public function doDelJobPro() {
		
		$path=F ( $this->lang . 'path');
		
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'jobpro' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Job )) {
					$this->error ( '不存在该简历' );
				}
				
				M ( 'jobpro' )->where ( array (
						'id' => $key 
				) )->delete ();
				
				
				if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
					@unlink('./'.$path[$Job['sort']]['path'].'/show'.$key.'.html');
				}
				
			}
		} else {
			$this->error ( '请选择简历' );
		}
		
		$this->success ( '删除成功' );
	}
	public function proList() {
		$select = M ( 'jobpro' )->where ( array (
				'lang' => $this->lang 
		) )->select ();
		
		$this->assign ( 'list', $select );
		$this->display ( './Public/Admin/Job/proList.html' );
	}
	public function jobForm() {
		$list = M ( 'formfield' )->where ( array (
				'lang' => $this->lang 
		) )->select ();
		
		$this->assign ( 'list', $list );
		$this->display ( './Public/Admin/Job/jobForm.html' );
	}
	public function jobSetting() {
		$config_array = F ( $this->lang . 'config' );
		
		$data ['re_type'] = $config_array ['job_re_type'];
		$data ['re_email_add'] = $config_array ['job_re_email_add'];
		$data ['auto_replay'] = $config_array ['job_auto_replay'];
		$data ['reply_title'] = $config_array ['job_reply_title'];
		$data ['reply_content'] = $config_array ['job_reply_content'];
		$this->assign ( $data );
		$this->display ( './Public/Admin/Job/jobSetting.html' );
	}
	public function doJobSetting() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['job_re_type'] = $_POST ['re_type'];
		$config_array ['job_re_email_add'] = $_POST ['re_email_add'];
		$config_array ['job_auto_replay'] = $_POST ['auto_replay'];
		$config_array ['job_reply_title'] = $_POST ['reply_title'];
		$config_array ['job_reply_content'] = $_POST ['reply_content'];
		
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function addJob() {
		$sort = M ( 'sort' )->where ( array (
				'module' => 'Job',
				'lang' => $this->lang 
		) )->select ();
		
		$this->assign ( 'sortlist', $sort );
		$this->display ( './Public/Admin/Job/addJob.html' );
	}
	
	public function addFormfield() {
		$this->display ( './Public/Admin/Job/addFormfield.html' );
	}
	public function doAddFormfield() {
		$data ['f_order'] = intval ( $_POST ['order'] );
		$data ['title'] = h ( $_POST ['title'] );
		$data ['type'] = h ( $_POST ['type'] );
		$data ['required'] = intval ( $_POST ['required'] );
		$data ['lang'] = $this->lang;
		
		$opt = array_filter ( $_POST ['opt'] );
		if (! empty ( $opt )) {
			
			foreach ( $opt as $key => $value ) {
				$newopt [$key + 1] = $value;
			}
			
			$data ['options'] = serialize ( $newopt );
		}
		
		$data ['module'] = 'job';
		
		M ( 'formfield' )->add ( $data );
		
		$this->success ( '保存成功', U ( 'Admin/Job/jobForm' ) );
	}
	public function doDelFormfield() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'formfield' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Job )) {
					$this->error ( '不存在该字段' );
				}
				
				M ( 'formfield' )->where ( array (
						'id' => $key 
				) )->delete ();
			}
		} else {
			$this->error ( '请选择字段' );
		}
		
		
		
		
		$this->success ( '删除成功' );
	}
	public function doSaveFormfield() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'formfield' )->where ( array (
						'id' => $key 
				) )->find ();
				if (empty ( $Job )) {
					$this->error ( '不存在该职位' );
				}
				M ( 'formfield' )->where ( array (
						'id' => $key 
				) )->save ( array (
						'f_order' => intval ( $_POST ['order'] [$key] ),
						'required' => intval ( $_POST ['required'] [$key] ),
						'lang' => $this->lang 
				) );
			}
		} else {
			$this->error ( '请选择职位' );
		}
		
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function doTop() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'Job' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Job )) {
					$this->error ( '不存在该职位' );
				}
				
				if (empty ( $Job ['top'] )) {
					M ( 'Job' )->where ( array (
							'id' => $key 
					) )->save ( array (
							'top' => 1 
					) );
				} else {
					M ( 'Job' )->where ( array (
							'id' => $key 
					) )->save ( array (
							'top' => 0 
					) );
				}
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Job ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择职位' );
		}
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$sids = array_unique ( explode ( '-', substr ( $ids_str, 0, - 1 ) ) );
			$this->assign ( 'type', 'index' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function editJob() {
		$id = intval ( $_GET ['id'] );
		$Job = M ( 'Job' )->where ( array (
				'id' => $id 
		) )->find ();
		
		$sort = M ( 'sort' )->where ( array (
				'module' => 'Job',
				'lang' => $this->lang 
		) )->select ();
		
		$this->assign ( 'sortlist', $sort );
		
		if (empty ( $Job )) {
			$this->error ( '不存在该职位' );
		}
		$Job['content']=dereplace($Job['content']);
		
		if (! empty ( $Job ['pic'] )) {
			$Job ['pic'] = site_url () . '/' . $Job ['pic'];
		}
		
		$this->assign ( $Job );
		$this->display ( './Public/Admin/Job/addJob.html' );
	}
	public function doSaveOrder() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'Job' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Job )) {
					$this->error ( '不存在该职位' );
				}
				
				M ( 'Job' )->where ( array (
						'id' => $key 
				) )->save ( array (
						'j_order' => intval ( $_POST ['order'] [$key] ) 
				) );
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Job ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择职位' );
		}
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$sids = array_unique ( explode ( '-', substr ( $ids_str, 0, - 1 ) ) );
			$this->assign ( 'sid', implode ( '-', $sids ) );
			$this->assign ( 'type', 'index' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function doDelJob() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'Job' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Job )) {
					$this->error ( '不存在该职位' );
				}
				
				M ( 'Job' )->where ( array (
						'id' => $key 
				) )->delete ();
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Job ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择职位' );
		}
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$sids = array_unique ( explode ( '-', substr ( $ids_str, 0, - 1 ) ) );
			$this->assign ( 'sid', implode ( '-', $sids ) );
			$this->assign ( 'type', 'index' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		$this->success ( '删除成功' );
	}
	
	/**
	 * 编辑和添加
	 */
	public function doAddJob() {
		$id = intval ( $_POST ['id'] );
		
		$sort = M ( 'sort' )->where ( array (
				'id' => intval($_POST['sort']) 
		) )->find ();
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		if (empty ( $_POST ['title'] )) {
			$this->error ( '职位不能为空' );
		}
		
		$data ['title'] = h ( $_POST ['title'] );
		$data ['location'] = h ( $_POST ['location'] );
		$data ['top'] = intval ( $_POST ['top'] );
		$data ['j_order'] = intval ( $_POST ['order'] );
		$data ['deal'] = h ( $_POST ['deal'] );
		$data ['num'] = intval ( $_POST ['num'] );
		$data ['datelife'] = intval ( $_POST ['date_life'] );
		$data ['dateline'] = intval ( strtotime ( $_POST ['dateline'] ) );
		$data ['content'] = replacesrc(stripslashes($_POST ['content']));
		$data ['lang'] = $this->lang;
		$data ['sort'] = intval ( $_POST ['sort'] );
		
		if (empty ( $id )) {
			$jid = M ( 'Job' )->add ( $data );
			
			// 生成二维码
			$config_array = F ( 'qrcode' );
			if ($config_array ['job']) {
				$model = D ( 'Qrcode' );
				$model->imgcode ( 'job', $jid, intval ( $_POST ['sort'] ) );
			}
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				// 更新所有文章类静态
				
				$sids = explode ( '-', $sort ['idpath'] );
				$this->assign ( 'id', $jid );
				$this->assign ( 'sid', implode ( '-', $sids ) );
				$this->assign ( 'type', 'index' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
		} else {
			M ( 'Job' )->where ( array (
					'id' => $id 
			) )->save ( $data );
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				$sids = explode ( '-', $sort ['idpath'] );
				$this->assign ( 'id', $jid );
				$this->assign ( 'sid', implode ( '-', $sids ) );
				$this->assign ( 'type', 'index' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
		}
		
		$this->success ( '保存成功', U ( 'Admin/Job/JobList' ) );
	}
	public function doUploadJobPic() {
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
		$upload->thumbMaxWidth = 400;
		$upload->thumbMaxHeight = 400;
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
			$result ['picpath'] = 'Upload/thumb_' . $info [0] ['savename'];
			echo json_encode ( $result );
		}
	}
	public function uploadEditerImg() {
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
		$upload->thumbMaxWidth = 400;
		$upload->thumbMaxHeight = 400;
		$upload->thumbRemoveOrigin = false;
		
		if (! $upload->upload ()) { // 上传错误提示错误信息
			$result ['error'] = 1;
			$result ['message'] = $upload->getErrorMsg ();
			echo json_encode ( $result );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['error'] = 0;
			$result ['url'] = site_url () . '/Upload/thumb_' . $info [0] ['savename'];
			$result ['picpath'] = 'Upload/thumb_' . $info [0] ['savename'];
			echo json_encode ( $result );
		}
	}
}