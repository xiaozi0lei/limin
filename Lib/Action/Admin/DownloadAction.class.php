<?php
class DownloadAction extends AdminInitAction {
	public function downloadList() {
		$this->checkper ( 'download_downloadlist' );
		
		$where['lang']=$this->lang;
		$sortid=$_GET['sortid']?intval($_GET['sortid']):0;
		if(!empty($sortid)){
			$findsort=M('sort')->where(array('id'=>$sortid))->find();
			if(empty($findsort)){
				$this->error('不存在该分类');
			}
			$where['sort']=$findsort['id'];
		}
		
		$sort=M('sort')->where(array('lang'=>$this->lang,'module'=>'Download'))->select();
		$newsort=array();
		if(!empty($sort)){
			foreach($sort as $k=>$v){
				$newsort[$v['id']]=$v;
			}
		
		}
		
		
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		
		$count = M ( 'Download' )->where ($where)->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Download' )->where($where)->order ( 'dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['sortname']=$newsort[$value['sort']]['name'];
			}
		}
		
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ( './Public/Admin/Download/downloadList.html' );
	}
	public function addDownload() {
		$sort = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'module' => 'Download' 
		) )->select ();
		$field = M ( 'formfield' )->where ( array (
				'lang' => $this->lang,
				'module' => 'Download' 
		) )->select ();
		
		$this->assign ( 'field', $field );
		$this->assign ( 'sortlist', $sort );
		$this->display ( './Public/Admin/Download/addDownload.html' );
	}
	public function doTop() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Download = M ( 'Download' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->find ();
				
				if (empty ( $Download )) {
					$this->error ( '不存在该文章' );
				}
				
				if (empty ( $Download ['top'] )) {
					M ( 'Download' )->where ( array (
							'id' => $key,
							'lang' => $this->lang 
					) )->save ( array (
							'top' => 1 
					) );
				} else {
					M ( 'Download' )->where ( array (
							'id' => $key,
							'lang' => $this->lang 
					) )->save ( array (
							'top' => 0 
					) );
				}
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Download ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择文章' );
		}
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$sids = array_unique ( explode ( '-', substr ( $ids_str, 0, - 1 ) ) );
			$this->assign ( 'type', 'index' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function editDownload() {
		$id = intval ( $_GET ['id'] );
		$Download = M ( 'Download' )->where ( array (
				'id' => $id,
				'lang' => $this->lang 
		) )->find ();
		
		$sort = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'module' => 'Download' 
		) )->select ();
		
		$this->assign ( 'sortlist', $sort );
		
		if (empty ( $Download )) {
			$this->error ( '不存在该文章' );
		}
		
		$Download['content']=dereplace($Download['content']);
		
		// 自定义字段获取
		$newfield = array ();
		$field = M ( 'formfield' )->where ( array (
				'lang' => $this->lang,
				'module' => 'download' 
		) )->select ();
		if (! empty ( $field )) {
			
			foreach ( $field as $value ) {
				$newfield [$value ['id']] = $value;
			}
			
			if (! empty ( $Download ['extend'] )) {
				$download_E = unserialize ( $Download ['extend'] );
				
				foreach ( $download_E as $key => $value ) {
					$newfield [$key] ['value'] = $value;
				}
			}
			
			$this->assign ( 'field', $newfield );
		}
		
		$this->assign ( $Download );
		$this->display ( './Public/Admin/Download/addDownload.html' );
	}
	public function doSaveOrder() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Download = M ( 'Download' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->find ();
				
				if (empty ( $Download )) {
					$this->error ( '不存在该文章' );
				}
				
				M ( 'Download' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->save ( array (
						'd_order' => intval ( $_POST ['order'] [$key] ) 
				) );
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Download ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择' );
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
	public function doDelDownload() {
		
		$path=F ( $this->lang . 'path');
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Download = M ( 'Download' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->find ();
				
				if (empty ( $Download )) {
					$this->error ( '不存在该文章' );
				}
				
				M ( 'Download' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->delete ();
				
				
				if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
					@unlink('./'.$path[$Download['sort']]['path'].'/show'.$key.'.html');
				}
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Download ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择文章' );
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
	public function doAddDownload() {
		$sort = intval ( $_POST ['sort'] );
		$id = intval ( $_POST ['id'] );
		
		$sort = M ( 'sort' )->where ( array (
				'id' => $sort,
				'lang' => $this->lang,
				'module' => 'Download' 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		if (empty ( $_POST ['title'] )) {
			$this->error ( '题目不能为空' );
		}
		
		$data ['title'] = h ( $_POST ['title'] );
		$data ['filepath'] = h ( $_POST ['filepath'] );
		$data ['top'] = intval ( $_POST ['top'] );
		$data ['user'] = h ( $_POST ['user'] );
		$data ['d_order'] = intval ( $_POST ['order'] );
		$data ['dateline'] = intval ( strtotime ( $_POST ['dateline'] ) );
		$data ['seotitle'] = h ( $_POST ['seotitle'] );
		$data ['seokeyword'] = h ( $_POST ['seokeyword'] );
		$data ['seodesc'] = h ( $_POST ['seodesc'] );
		$data ['content'] = replacesrc(stripslashes($_POST ['content']));
		$data ['lang'] = $this->lang;
		$data ['sort'] = intval ( $_POST ['sort'] );
		
		// 自定义字段
		if (! empty ( $_POST ['field'] )) {
			$data ['extend'] = serialize ( $_POST ['field'] );
		}
		
		if (empty ( $id )) {
			$did = M ( 'Download' )->add ( $data );
			
			// 生成二维码
			$config_array = F ( 'qrcode' );
			if ($config_array ['download']) {
				$model = D ( 'Qrcode' );
				$model->imgcode ( 'download', $did, intval ( $_POST ['sort'] ) );
			}
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				// 更新所有文章类静态
				
				$sids = explode ( '-', $sort ['idpath'] );
				$this->assign ( 'id', $did );
				$this->assign ( 'sid', implode ( '-', $sids ) );
				$this->assign ( 'type', 'index' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
		} else {
			M ( 'Download' )->where ( array (
					'id' => $id,
					'lang' => $this->lang 
			) )->save ( $data );
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				$sids = explode ( '-', $sort ['idpath'] );
				$this->assign ( 'id', $did );
				$this->assign ( 'sid', implode ( '-', $sids ) );
				$this->assign ( 'type', 'index' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
		}
		
		$this->success ( '保存成功', U ( 'Admin/Download/DownloadList' ) );
	}
	public function uploadFile() {
		import ( 'ORG.Net.UploadFile' );
		$upload = new UploadFile (); // 实例化上传类
		$upload->maxSize = 30145728; // 设置附件上传大小
		$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
		
		if (! $upload->upload ()) { // 上传错误提示错误信息
			$result ['error'] = 1;
			$result ['message'] = $upload->getErrorMsg ();
			echo json_encode ( $result );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['error'] = 0;
			$result ['url'] = 'Upload/' . $info [0] ['savename'];
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