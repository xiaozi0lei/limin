<?php
class PictureAction extends AdminInitAction {
	public function pictureList() {
		$this->checkper ( 'picture_picturelist' );
		
		session('jumpurl',$_SERVER ['REQUEST_URI']);
		$where['lang']=$this->lang;
		$sortid=$_GET['sortid']?intval($_GET['sortid']):0;
		if(!empty($sortid)){
			$findsort=M('sort')->where(array('id'=>$sortid))->find();
			if(empty($findsort)){
				$this->error('不存在该分类');
			}
			$where['sort']=$findsort['id'];
		}
		
		if(!empty($_GET['keywords'])){
		
			$where['title']=array('like','%'.$_GET['keywords'].'%');
		}
		
		
		$sort=M('sort')->where(array('lang'=>$this->lang,'module'=>'Picture'))->select();
		$newsort=array();
		if(!empty($sort)){
			foreach($sort as $k=>$v){
				$newsort[$v['id']]=$v;
			}
		
		}
		
		
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		
		$count = M ( 'Picture' )->where ($where)->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Picture' )->where ($where)->order ( 'dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['sortname']=$newsort[$value['sort']]['name'];
			}
		}
		
		
		$tree=$this->getTree('Picture');
		$html = $this->sorttree ( $tree,$sortid,'Picture');
		$this->assign('html',$html);
		$this->assign($_GET);
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ( './Public/Admin/Picture/pictureList.html' );
	}
	
	
	private function getTree($module){
	
		$sids=array();
		$li = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'module'=>$module
		) )->order ( 'sort_order ASC,id ASC' )->select ();
	
		foreach($li as $k=>$v){
			$ids=explode('-', $v['idpath']);
			foreach($ids as $iv){
				$sids[]=$iv;
			}
		}
		$li=M('sort')->where(array('id'=>array('in',array_unique($sids))))->order ( 'sort_order ASC,id ASC' )->select();
	
	
		$tree = list_to_tree ( $li, 'id', 'parent_id' );
		return $tree;
	}
	
	
	private function sorttree($sortarray,$current_sort_id=0,$module){
	
		$html ='';
		foreach ( $sortarray as $key => $value ) {
			$check=$disable='';
			$count = count ( explode ( '-', $value ['idpath'] ) ) - 1;
			if(!empty($current_sort_id)&&$current_sort_id==$value['id']){
				$check='selected = "selected"';
			}
	
			if($value['module']!=$module){
				$disable='disabled="disabled"';
			}
	
			$html .='<option '.$check.$disable.' value="'.$value['id'].'">'.str_repeat ( '|-', $count ).$value['name'].'</option>';
			
			if (! empty ( $value ['_child'] )) {
				$html .= $this->sorttree ( $value ['_child'],$current_sort_id,$module);
			}
		}
		return $html;
	}
	
	
	public function addPicture() {
		
	// 自定义字段获取
		$newfield = array ();
		$field = M ( 'field' )->where ( array (
				'lang' => $this->lang,
				'type' => 'picture'
		) )->order('fid ASC')->select ();
		
		if (! empty ( $field )) {
				
			foreach ( $field as $value ) {
				$newfield [$value ['id']] = $value;
				$newfield [$value ['id']]['value'] = "";
			}	
			
				
			$this->assign ( 'p_field', $newfield );
		}
		
		$tree=$this->getTree('Picture');
		$html = $this->sorttree ( $tree,0,'Picture');
		$this->assign('html',$html);
		$this->display ( './Public/Admin/Picture/addPicture.html' );
	}
	public function doTop() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Picture = M ( 'Picture' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Picture )) {
					$this->error ( '不存在该产品' );
				}
				
				if (empty ( $Picture ['top'] )) {
					M ( 'Picture' )->where ( array (
							'id' => $key 
					) )->save ( array (
							'top' => 1 
					) );
				} else {
					M ( 'Picture' )->where ( array (
							'id' => $key 
					) )->save ( array (
							'top' => 0 
					) );
				}
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Picture ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择产品' );
		}
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$sids = array_unique ( explode ( '-', substr ( $ids_str, 0, - 1 ) ) );
			$this->assign ( 'type', 'index' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function editPicture() {
		$id = intval ( $_GET ['id'] );
		$picture = M ( 'Picture' )->where ( array (
				'id' => $id 
		) )->find ();
		
		$sort = M ( 'sort' )->where ( array (
				'module' => 'Picture',
				'lang' => $this->lang 
		) )->select ();
		
		$this->assign ( 'sortlist', $sort );
		
		if (empty ( $picture )) {
			$this->error ( '不存在该产品' );
		}
		$picture['content']=dereplace($picture['content']);
		
		
	// 自定义字段获取
		$field = M ( 'field' )->where ( array (
				'lang' => $this->lang,
				'type' => 'picture'
		) )->order('fid ASC')->select ();
		
		if (! empty ( $field )) {
				
			foreach ( $field as $value ) {
				$newfield [$value ['id']] = $value;
				$newfield [$value ['id']]['value'] = "";
			}	
			$this->assign ( 'p_field', $newfield );
		}
		
		$pics = M ( 'attachment' )->where ( array (
				'type' => 'picture',
				'app_id' => $id 
		) )->select ();
		
		
		$psort=M('sort')->where(array('id'=>$picture['sort']))->find();
		
		$this->assign($psort);
		
		$tree=$this->getTree('Picture');
		$html = $this->sorttree ( $tree,$picture['sort'],'Picture');
		$this->assign('html',$html);
		$this->assign ( 'pics', $pics );
		$this->assign ( $picture );
		$this->display ( './Public/Admin/Picture/addPicture.html' );
	}
	public function doSaveOrder() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Picture = M ( 'Picture' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Picture )) {
					$this->error ( '不存在' );
				}
				
				M ( 'Picture' )->where ( array (
						'id' => $key 
				) )->save ( array (
						'p_order' => intval ( $_POST ['order'] [$key] ) 
				) );
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Picture ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择条目' );
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
	public function doDelPicture() {
		
		$path=F ( $this->lang . 'path');
		
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Picture = M ( 'Picture' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Picture )) {
					$this->error ( '不存在该图片' );
				}
				
				M ( 'Picture' )->where ( array (
						'id' => $key 
				) )->delete ();
				
				if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
					@unlink('./'.$path[$Picture['sort']]['path'].'/show'.$key.'.html');
				}
				
				
				//删除相关图片
				@unlink('./'.$Picture['pic']);
				$oth=str_replace('thumb_', '', $Picture['pic']);
				unlink($oth);
				delcontentimg($Picture['content']);
				$pics=M('attachment')->where(array('app_id'=>$key,'type'=>'picture'))->select();
				M('attachment')->where(array('app_id'=>$key,'type'=>'picture'))->delete();
				if(!empty($pics)){
					foreach($pics as $v){
						@unlink ( './Upload/' . $v ['filename'] );
						@unlink ( './Upload/thumb_' . $v ['filename'] );
					}
				}
				
				
				
				$sids [] = $Picture ['sort'];
				
				$alist = M ( 'attachment' )->query ( "SELECT * FROM " . C ( 'DB_PREFIX' ) . "attachment WHERE app_id =" . $key . " AND type='picture'" );
				
				foreach ( $alist as $key => $value ) {
					
					if (file_exists ( APP_PATH . $value ['filepath'] )) {
						unlink ( APP_PATH . $value ['filepath'] );
					}
					M ( 'attachment' )->where ( array (
							'id' => $value ['id'] 
					) )->delete ();
				}
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $Picture ['sort'] 
				) )->find ();
				$ids_str .= $sort ['idpath'] . '-';
			}
		} else {
			$this->error ( '请选择图片' );
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
	public function doAddPicture() {
		$sid = intval ( $_POST ['sort'] );
		$id = intval ( $_POST ['id'] );
		$attid = array ();
		
		$sort = M ( 'sort' )->where ( array (
				'id' => $sid 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		if (empty ( $_POST ['title'] )) {
			$this->error ( '题目不能为空' );
		}
		
		$data ['title'] = h ( $_POST ['title'] );
		$data ['top'] = intval ( $_POST ['top'] );
		$data ['piclist'] = '';
		$data ['user'] = h ( $_POST ['user'] );
		$data ['p_order'] = intval ( $_POST ['order'] );
		$data ['dateline'] = intval ( strtotime ( $_POST ['dateline'] ) );
		$data ['seotitle'] = h ( $_POST ['seotitle'] );
		$data ['seokeyword'] = h ( $_POST ['seokeyword'] );
		$data ['seodesc'] = h ( $_POST ['seodesc'] );
		$data ['content'] = replacesrc(stripslashes($_POST ['content']));
		$data ['lang'] = $this->lang;
		$data ['sort'] = intval ( $sort ['id'] );
		$data ['field1'] = h ( $_POST ['field1'] )?h ( $_POST ['field1'] ):'';
		$data ['field2'] = h ( $_POST ['field2'] )?h ( $_POST ['field2'] ):'';
		$data ['field3'] = h ( $_POST ['field3'] )?h ( $_POST ['field3'] ):'';
		$data ['field4'] = h ( $_POST ['field4'] )?h ( $_POST ['field4'] ):'';
		$data ['field5'] = h ( $_POST ['field5'] )?h ( $_POST ['field5'] ):'';
		$data ['field6'] = h ( $_POST ['field6'] )?h ( $_POST ['field6'] ):'';
		// 自定义字段
		if (! empty ( $_POST ['field'] )) {
			$data ['extend'] = serialize ( $_POST ['field'] );
		}
		
		if (! empty ( $_POST ['imagedes'] )) {
			
			$img_ids = array_keys ( $_POST ['imagedes'] );
			
			$pics = M ( 'attachment' )->where ( array (
					'id' => array (
							'in',
							$img_ids 
					) 
			) )->select ();
			$newpic = array ();
			foreach ( $pics as $k => $v ) {
				$newpic [$v ['id']] = $v;
				$newpicids [] = $v ['id'];
			}
			
			if (! empty ( $_POST ['feng'] ) && ! empty ( $newpic [$_POST ['feng']] )) {
				$data ['pic'] = $newpic [$_POST ['feng']] ['hasthumb'] ? 'Upload/thumb_' . $newpic [$_POST ['feng']] ['filename'] : $newpic [$_POST ['feng']] ['filepath'];
				
				if (! empty ( $id )) {
					M ( 'attachment' )->where ( array (
							'app_id' => $id,
							'type' => 'picture',
							'feng' => 1 
					) )->save ( array (
							'feng' => 0 
					) );
				}
				
				M ( 'attachment' )->where ( array (
						'id' => $_POST ['feng'] 
				) )->save ( array (
						'feng' => 1 
				) );
			} else {
				$data ['pic'] = $pics [0] ['hasthumb'] ? 'Upload/thumb_' . $pics [0] ['filename'] : $pics [0] ['filepath'];
				M ( 'attachment' )->where ( array (
						'id' => $pics [0] ['id'] 
				) )->save ( array (
						'feng' => 1 
				) );
			}
		}
		
		if (empty ( $id )) {
			$id = M ( 'Picture' )->add ( $data );
			
			// 生成二维码
			$config_array = F ( 'qrcode' );
			if ($config_array ['picture']) {
				$model = D ( 'Qrcode' );
				$model->imgcode ( 'picture', $id, intval ( $_POST ['sort'] ) );
			}
			
		} else {
			
			$isedit=1;
				
			$one=M('picture')->where(array('id'=>$id))->find();
				
			if(empty($one)){
				$this->error('不存在');
			}
			
			
			M ( 'Picture' )->where ( array (
					'id' => $id 
			) )->save ( $data );
			
		}
		
		if (! empty ( $newpicids )) {
			foreach ( $newpic as $k => $v ) {
				M ( 'attachment' )->where ( array (
						'id' => $k 
				) )->save ( array (
						'type' => 'picture',
						'app_id' => $id,
						'desc' => $_POST ['imagedes'] [$k] 
				) );
			}
		}
		
		
		if(!empty($_POST['show_pid'])){
			M('sort')->where(array('id'=>$sort['id']))->save(array('show_pid'=>$id));
		}
		if($isedit&&$one['sort']!=$sid){
			M('sort')->where(array('show_pid'=>$one['id']))->save(array('show_pid'=>0));
		}
		//更新下栏目缓存
		$li = M ( 'sort' )->where ( array (
				'lang' => $this->lang
		) )->order ( 'sort_order ASC,id ASC' )->select ();
		$tree = list_to_tree ( $li, 'id', 'parent_id' );
		F ( $this->lang . 'sort', $tree );
		
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			// 更新所有文章类静态
		
			$sids = explode ( '-', $sort ['idpath'] );
			$this->assign ( 'id', $id );
			$this->assign ( 'sid', implode ( '-', $sids ) );
			$this->assign ( 'type', 'index' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		$this->success ( '保存成功', U ( 'Admin/Picture/PictureList' ) );
	}
	public function swfupload() {
		$config_array = F ( $this->lang . 'config' );
		if (! empty ( $_FILES )) {
			
			$rejson = array ();
			import ( "ORG.Net.UploadFile" );
			$upload_obj = new UploadFile ();
			
			$upload_obj->maxSize = 20145728; // 设置附件上传大小
			$upload_obj->allowExts = array (
					'jpg',
					'gif',
					'png',
					'jpeg' 
			); // 设置附件上传类型
			$upload_obj->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
			$upload_obj->thumb = true;
			$upload_obj->thumbMaxWidth = $config_array ['pic_list_w'];
			$upload_obj->thumbMaxHeight = $config_array ['pic_list_h'];
			$upload_obj->thumbRemoveOrigin = false;
			
			if (empty ( $_FILES ) === false) {
				$upload_obj->upload ();
				
				$file_info = $upload_obj->getUploadFileInfo ();
				
				if ($upload_obj->getErrorMsg () != '') {
					$rejson = array (
							'error' => 1,
							'message' => $upload_obj->getErrorMsg () 
					);
				} else {
					$swf_temp = site_url () . '/Upload/' . $file_info [0] ['savename'];
					
					
					if($_POST['bat']){
						//复制通过falsh上传的图片然后进行缩略放到编辑器中
					
						$bateditorname=str_replace('.'.$file_info[0]['extension'],'_bateditor.'.$file_info[0]['extension'],$file_info[0]['savename']);
						$copyname=$file_info[0]['savepath'].'/'.$bateditorname;
					
						@copy($file_info[0]['savepath'].'/'.$file_info[0]['savename'],$copyname);
						Image::thumb($copyname,'./Upload/thumb_'.$bateditorname,'',$config_array['product_w'],$config_array['product_h'],true);
					}
					
					
					
					
					$rs = M ( "attachment" );
					$data = array (
							'filepath' => 'Upload/' . $file_info [0] ['savename'],
							'type' => '',
							'app_id' => '0',
							'filename' => $file_info [0] ['savename'] 
					);
					
					if (file_exists ( './Upload/thumb_' . $file_info [0] ['savename'] )) {
						$data ['hasthumb'] = 1;
					}
					if ($_POST ['bat']) {
						$data ['temp_content'] = '<p><img  src="Upload/thumb_'. $bateditorname . '"/></p>';
					}
					$imageid = $rs->add ( $data );
					$rejson = array (
							'error' => 0,
							'message' => '上传成功',
							'imageid' => $imageid,
							'path' => $swf_temp,
							'pname'=> str_replace('.'.$file_info[0]['extension'], '', $file_info[0]['name'])
					);
				}
				$json = json_encode ( $rejson );
				echo $json;
				exit ();
			} else {
				
				$rejson = array (
						'error' => 1,
						'message' => '上传异常' 
				);
				echo $json;
				exit ();
			}
		}
	}
	public function deleteImage() {
		$id = intval ( $_POST ['id'] );
		$where ['id'] = array (
				'eq',
				$id 
		);
		$rs = M ( 'attachment' );
		$one = $rs->where ( $where )->find ();
		
		if (empty ( $one )) {
			$this->ajaxReturn ( '', '不存在该图片', 0 );
		}
		
		$rs->Where ( $where )->delete ();
		
		if ($one ['hasthumb']) {
			@unlink ( './Upload/thumb_' . $one ['filename'] );
		}
		@unlink ( './Upload/' . $one ['filename'] );
		$this->ajaxReturn ( '', '删除成功', 1 );
	}
	
	public function uploadEditerImg() {
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
		$upload->thumbMaxWidth = $config_array['pic_w'];
		$upload->thumbMaxHeight = $config_array['pic_h'];
		$upload->thumbRemoveOrigin = false;
	
		if (! $upload->upload ()) { // 上传错误提示错误信息
			$result ['error'] = 1;
			$result ['message'] = $upload->getErrorMsg ();
			echo json_encode ( $result );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['error'] = 0;
			if(!in_array($info[0]['extension'],array('jpg','gif','png','jpeg'))){
				$result ['url'] = __ROOT__ . '/Upload/' . $info [0] ['savename'];
			}else{
				$result ['url'] = __ROOT__ . '/Upload/thumb_' . $info [0] ['savename'];
			}
			echo json_encode ( $result );
		}
	}
	public function bat() {
		$tree=$this->getTree('Picture');
		$html = $this->sorttree ( $tree,0,'Picture');
		$this->assign('html',$html);
		
		$this->display('./Public/Admin/Picture/bat.html');
	}
	
	
	public function saveBatContent() {
	
		$imgid = intval ( $_POST ['imgid'] );
		M ( 'attachment' )->where ( array (
		'id' => $imgid
		) )->save ( array (
		'temp_content' => $_POST ['content']
		) );
	}
	public function batcontent() {
		$imgid = intval ( $_GET ['imgid'] );
		$img = M ( 'attachment' )->where ( array (
				'id' => $imgid
		) )->find ();
		if (empty ( $img )) {
			exit ( '不存在图片' );
		}
	
		if (empty ( $img ['temp_content'] )) {
			
			$html = dereplace('<p><img  src="'. $img ['filepath'] . '"/></p>');
		} else {
			
			$html = dereplace($img ['temp_content']);
		}
	
		$this->assign ( 'img', $html );
	
		$html = $this->fetch ( './Public/Admin/Picture/batcontent.html' );
		exit ( $html );
	}
	public function saveBatPicture() {
	
		if(empty($_POST['title'])){
			$this->error('请添加图片');
		}
		$time=time ();
		$i=1;
		foreach ( $_POST ['title'] as $imgid => $title ) {
				
			$img = M ( 'attachment' )->where ( array (
					'id' => $imgid
			) )->find ();
				
			$pid=M ( 'picture' )->add ( array (
			'title' => $title,
			'sort' => $_POST ['sort'] [$imgid],
			'pic' => 'Upload/thumb_' . $img ['filename'],
			'content' => $img ['temp_content'],
			'dateline' => time (),
			'lang' => $this->lang
			) );
			M('attachment')->where(array('id'=>$imgid))->save(array('app_id'=>$pid,'type'=>'picture'));
			$i++;
		}
	
		$this->success ( '添加成功' );
	}
	
	public function improtPicture(){
		$model=M('picture');
		$picmodel=M('attachment');
		$fieldm=M('field');
		$tempsort=$tempensort=array();
	
		$art=$model->where(array('lang'=>'zh-cn'))->select();
		$sort=M('sort')->where(array('lang'=>'zh-cn'))->select();
		$ensrot=M('sort')->where(array('lang'=>'en-us'))->select();
	
		$fields=$fieldm->where(array('lang'=>'zh-cn','type'=>'picture'))->select();
		
		foreach($sort as $k=>$v){
			$tempsort[$v['id']]=$v;
		}
	
		foreach($ensrot as $k=>$v){
			$tempensort[$v['folder']]=$v;
		}
	
		foreach($tempsort as $k=>$v){
			$tempsort[$k]['idr']=!empty($tempensort[$v['folder']]['id'])?$tempensort[$v['folder']]['id']:0;
		}
	
		foreach($fields as $fv){
			unset($fv['id']);
			$fv['lang']=$this->lang;
			$fieldm->add($fv);
		}
		
		
		foreach($art as $k=>$v){
			$pics=$picmodel->where(array('type'=>'picture','app_id'=>$v['id']))->select();
			unset($v['id']);
			$v['lang']=$this->lang;
			$v['sort']=$tempsort[$v['sort']]['idr'];
			$n_pid=$model->add($v);
			foreach($pics as $pv){
				unset($pv['id']);
				$pv['app_id']=$n_pid;
				$picmodel->add($pv);
			}
		}
	
		$this->success('导入成功 ');
	
	
	}
	
	
	
}