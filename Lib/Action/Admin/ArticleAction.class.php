<?php
class ArticleAction extends AdminInitAction {
	public function articleList() {
		$this->checkper ( 'artical_articallist' );
		$where['lang']=$this->lang;
		$sortid=$_GET['sortid']?intval($_GET['sortid']):0;
		
		
		if(intval($_GET['home_show'])==1){
			$where['home_show']=intval($_GET['home_show']);
		}
		if(intval($_GET['top'])==1){
			$where['top']=intval($_GET['top']);
		}
		
		session('jumpurl',$_SERVER ['REQUEST_URI']);
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
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		$sort=M('sort')->where(array('lang'=>$this->lang,'module'=>'Article'))->select();
		$newsort=array();
		if(!empty($sort)){
			foreach($sort as $k=>$v){
				$newsort[$v['id']]=$v;
			}
			
		}
		
		$count = M ( 'Article' )->where ($where)->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 15 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Article' )->where ($where)->order ( 'id desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['sortname']=$newsort[$value['sort']]['name'];
			}
			
		}
		
		$sortlist = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'module'=>'Article'
		) )->order ( 'idpath ASC,sort_order ASC' )->select ();
		
		//$this->assign($this->group);

		
		$tree=$this->getTree('Article');
		$html = $this->sorttree ( $tree,$sortid,'Article');
		$this->assign('html',$html);
		
		$this->assign($_GET);
		$this->assign ( 'html', $html );
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ( './Public/Admin/Article/articleList.html' );
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
	
	
	public function addArticle() {
		
		$field = M ( 'formfield' )->where ( array (
				'lang' => $this->lang,
				'module' => 'article' 
		) )->select ();
		
		$tree=$this->getTree('Article');
		$html = $this->sorttree ( $tree,0,'Article');
		$this->assign('html',$html);
		
		$this->assign('html',$html);
		$this->assign ( 'field', $field );
		$this->display ( './Public/Admin/Article/addArticle.html' );
	}
	
	
	public function doTop() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$article = M ( 'Article' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->find ();
				
				if (empty ( $article )) {
					$this->error ( '不存在该文章' );
				}
				
				if (empty ( $article ['top'] )) {
					M ( 'Article' )->where ( array (
							'id' => $key,
							'lang' => $this->lang 
					) )->save ( array (
							'top' => 1 
					) );
				} else {
					M ( 'Article' )->where ( array (
							'id' => $key,
							'lang' => $this->lang 
					) )->save ( array (
							'top' => 0 
					) );
				}
				$sids [] = $article ['sort'];
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $article ['sort'] 
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
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	
	
	public function doHome() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$article = M ( 'article' )->where ( array (
						'id' => $key
				) )->find ();
	
				if (empty ( $article )) {
					$this->error ( '不存在' );
				}
	
				if (empty ( $article ['home_show'] )) {
					M ( 'article' )->where ( array (
					'id' => $key
					) )->save ( array (
					'home_show' => 1
					) );
				} else {
					M ( 'article' )->where ( array (
					'id' => $key
					) )->save ( array (
					'home_show' => 0
					) );
				}
				$sort = M ( 'sort' )->where ( array (
						'id' => $article ['sort']
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
	
	
	public function editArticle() {
		
		
		$aid = intval ( $_GET ['aid'] );
		$article = M ( 'Article' )->where ( array (
				'id' => $aid,
				'lang' => $this->lang 
		) )->find ();
		
		
		if (empty ( $article )) {
			$this->error ( '不存在该文章' );
		}
		
		$article['content']=dereplace($article['content']);
		
		// 自定义字段获取
		$newfield = array ();
		$field = M ( 'formfield' )->where ( array (
				'lang' => $this->lang,
				'module' => 'article' 
		) )->order('f_order ASC')->select ();
		if (! empty ( $field )) {
			
			foreach ( $field as $value ) {
				$newfield [$value ['id']] = $value;
			}
			
			if (! empty ( $article ['extend'] )) {
				$article_E = unserialize ( $article ['extend'] );
				
				foreach ( $article_E as $key => $value ) {
					if(!empty($newfield[$key])){
						$newfield [$key] ['value'] = $value;
					}
					
					
				}
			}
			
			$this->assign ( 'field', $newfield );
		}
		
		$tree=$this->getTree('Article');
		$html = $this->sorttree ( $tree,$article['sort'],'Article');
		$this->assign('html',$html);
		$this->assign ( $article );
		$this->display ( './Public/Admin/Article/addArticle.html' );
	}
	public function doSaveOrder() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$article = M ( 'Article' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->find ();
				
				if (empty ( $article )) {
					$this->error ( '不存在该文章' );
				}
				
				M ( 'Article' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->save ( array (
						'a_order' => intval ( $_POST ['order'] [$key] ) 
				) );
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $article ['sort'] 
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
		
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function doDelArticle() {
		
		
		$path=F ( $this->lang . 'path');
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$article = M ( 'Article' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->find ();
				
				if (empty ( $article )) {
					$this->error ( '不存在该文章' );
				}
				
				M ( 'Article' )->where ( array (
						'id' => $key,
						'lang' => $this->lang 
				) )->delete ();
				
				if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
					@unlink('./'.$path[$article['sort']]['path'].'/show'.$key.'.html');
				}
				
				
				$sort = M ( 'sort' )->where ( array (
						'id' => $article ['sort'] 
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
	public function doAddArticle() {
		$sortid = intval ( $_POST ['sort'] );
		$aid = intval ( $_POST ['aid'] );
		
		$sort = M ( 'sort' )->where ( array (
				'id' => $sortid,
				'lang' => $this->lang 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		if (empty ( $_POST ['title'] )) {
			$this->error ( '题目不能为空' );
		}
		
		$post_title =$this->lang=='zh-cn'?preg_replace("/\s|　/","",$_POST ['title']):$_POST ['title'];
		$data ['title'] = h ($post_title);
		$data ['top'] = intval ( $_POST ['top'] );
		$data ['home_show'] = intval ( $_POST ['home_show'] );
		$data ['user'] = h ( $_POST ['user'] );
		$data ['a_order'] = intval ( $_POST ['order'] );
		$data ['dateline'] = intval ( strtotime ( $_POST ['dateline'] ) );
		$data ['seotitle'] = h ( $_POST ['seotitle'] );
		$data ['seokeyword'] = h ( $_POST ['seokeyword'] );
		$data ['seodesc'] = h ( $_POST ['seodesc'] );
		$data ['content'] = replacesrc(stripslashes($_POST ['content']));
		$data ['lang'] = $this->lang;
		$data ['sort'] = $sortid;
		
		if(!empty($_FILES['pic']['name'])){
				
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
			$upload->thumbMaxWidth = 1000;
			$upload->thumbMaxHeight = 1000;
			$upload->thumbRemoveOrigin = false;
				
			if (! $upload->upload ()) { // 上传错误提示错误信息
				$result ['message'] = $upload->getErrorMsg ();
				$this->error($result ['message']);
			} else { // 上传成功 获取上传文件信息
				$info = $upload->getUploadFileInfo ();
				$data['pic'] = 'Upload/' . $info [0] ['savename'];
			}
				
		}
		
		// 自定义字段
		if (! empty ( $_POST ['field'] )) {
			$data ['extend'] = serialize ( $_POST ['field'] );
		}
		
		if (empty ( $aid )) {
			$aid = M ( 'Article' )->add ( $data );
			
			// 生成二维码
			$config_array = F ( 'qrcode' );
			if ($config_array ['article']) {
				
				$model = D ( 'Qrcode' );
				$model->imgcode ( 'article', $aid, $sortid );
			}
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				// 更新所有文章类静态
				$sids = explode ( '-', $sort ['idpath'] );
				$this->assign ( 'id', $aid );
				$this->assign ( 'sid', implode ( '-', $sids ) );
				$this->assign ( 'type', 'index' );
				$this->assign('jumpurl',U('Admin/Article/articleList'));
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			$this->success ( '保存成功',U('Admin/Article/articleList'));
		} else {
			
			M ( 'Article' )->where ( array (
					'id' => $aid,
					'lang' => $this->lang 
			) )->save ( $data );
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				
				$sids = explode ( '-', $sort ['idpath'] );
				$this->assign ( 'id', $aid );
				$this->assign ( 'sid', implode ( '-', $sids ) );
				$this->assign ( 'type', 'index' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			$this->success ( '编辑成功', session('jumpurl'));
		}
		
	}
	public function uploadArticleImg() {
		$config_array = F ( $this->lang . 'config' );
		import ( 'ORG.Net.UploadFile' );
		$upload = new UploadFile (); // 实例化上传类
		$upload->maxSize = 3145728; // 设置附件上传大小
		$upload->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg',
		); // 设置附件上传类型
		$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
		$upload->thumb = true;
		$upload->thumbMaxWidth = $config_array['art_w'];
		$upload->thumbMaxHeight = $config_array['art_h'];
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
	
	public function improtArticle(){
		$model=M('article');
		
		$tempsort=$tempensort=array();
		
		$art=$model->where(array('lang'=>'zh-cn'))->select();
		$sort=M('sort')->where(array('lang'=>'zh-cn'))->select();
		$ensrot=M('sort')->where(array('lang'=>'en-us'))->select();
		
		foreach($sort as $k=>$v){
			$tempsort[$v['id']]=$v;
		}
		
		foreach($ensrot as $k=>$v){
			$tempensort[$v['folder']]=$v;
		}
		
		foreach($tempsort as $k=>$v){
			$tempsort[$k]['idr']=!empty($tempensort[$v['folder']]['id'])?$tempensort[$v['folder']]['id']:0;
		}
		
		
		foreach($art as $k=>$v){
			unset($v['id']);
			$v['lang']='en-us';
			$v['sort']=$tempsort[$v['sort']]['idr'];
			$model->add($v);
		}
		
		$this->success('导入成功 ');
		
		
	}
	
}