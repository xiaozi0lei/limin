<?php
class JobAction extends WapInitAction {
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
			$this->error ( '不存在该分类' );
		}
		
		// 用于查找当前分类下面子类文章
		
		$sids [] = $sort ['id'];
		
		// 二级查找
		$sub = M ( 'sort' )->field('id,idpath,name')->where ( array (
				'lang' => $this->lang,
				'parent_id' => $sort ['id'],
				'hidden' => 0 
		) )->select ();
		
		if (! empty ( $sub )) {
			
			foreach ( $sub as $key => $value ) {
				$subid [] = $value ['id'];
				$sids [] = $value ['id'];
			}
		}
		if (! empty ( $subid )) {
			$three = M ( 'sort' )->field('id,idpath,name')->where ( array (
					'lang' => $this->lang,
					'parent_id' => array (
							'in',
							$subid 
					),
					'hidden' => 0 
			) )->select ();
			
			if (! empty ( $three )) {
				foreach ( $three as $k => $v ) {
					$sids [] = $v ['id'];
				}
			}
		}
		$where ['sort'] = array (
				'in',
				$sids 
		);
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		
		$count = M ( 'job' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $this->config ['wap_list_job_num'] ); // 实例化分页类
		                                                                  // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'job' )->where ( $where )->order ( 'j_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->assign ( 'title', $sort ['name'] );
		$this->display ();
	}
	public function show() {
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'job' );
		$job = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		if (empty ( $job )) {
			$this->error ( '不存在该招聘' );
		}
		$job['content']=dereplace($job['content']);
		$this->assign ( 'sid', $job ['sort'] );
		$this->assign ( 'job', $job );
		$this->display ();
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
			
			if ($value ['type'] == 'file' && $value ['required'] && empty ( $_FILES ['field' . $value ['id']] ['name'] )) {
				$this->error ( '附件' . $value ['title'] . '不能为空' );
			}
			
			if ($value ['type'] != 'file' && $value ['required'] && empty ( $_POST ['field' . $value ['id']] )) {
				$this->error ( $value ['title'] . '不能为空' );
			}
			
			$data ['field' . $value ['id']] = h ( $_POST ['field' . $value ['id']] );
		}
		
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
			$result ['error'] = 1;
			$result ['message'] = $upload->getErrorMsg ();
			$this->error ( $upload->getErrorMsg () );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['error'] = 0;
			$result ['url'] = __ROOT__ . '/Upload/thumb_' . $info [0] ['savename'];
			
			foreach ( $info as $key => $value ) {
				$data [$info [$key] ['key']] = 'Upload/' . $info [$key] ['savename'];
			}
		}
		
		$add ['jid'] = $job ['id'];
		$add ['dateline'] = time ();
		$add ['jobname'] = $job ['title'];
		if (! empty ( $data )) {
			$add ['extend'] = serialize ( $data );
		}
		
		M ( 'jobpro' )->add ( $add );
		
		$this->success ( '提交成功' );
	}
}