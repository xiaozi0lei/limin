<?php
class SeoAction extends AdminInitAction {
	
	public function _initialize(){
		parent::_initialize();
		$this->checkper ( 'seo_static' );
	}
	
	public function link() {
		

			import ( 'ORG.Util.Page' ); // 导入分页类
			$list = M ( 'link' )->where ( array (
					'lang' => $this->lang
			) )->select ();
			
			$count = M ( 'link' )->where ( array (
					'lang' => $this->lang
			) )->count (); // 查询满足要求的总记录数
			$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
			$show = $Page->show (); // 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = M ( 'link' )->where ( array (
					'lang' => $this->lang
			) )->order ( 'l_order' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
			$this->assign ( 'list', $list ); // 赋值数据集
			$this->assign ( 'page', $show ); // 赋值分页输出
			$this->display ( './Public/Admin/Seo/link.html' );
			
	
		
	}
	

	
	
	
	public function doSaveLinkOrder() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$link = M ( 'link' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $link )) {
					$this->error ( '不存在该链接' );
				}
				
				M ( 'link' )->where ( array (
						'id' => $key 
				) )->save ( array (
						'l_order' => intval ( $_POST ['order'] [$key] ) 
				) );
			}
		} else {
			$this->error ( '请选择链接' );
		}
		$this->cacheLinks();
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$this->assign ( 'type', 'home' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		header ( 'Location:' . $_SERVER ['HTTP_REFERER'] );
	}
	public function doDelLink() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$article = M ( 'link' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $article )) {
					$this->error ( '不存在该链接' );
				}
				M ( 'link' )->where ( array (
						'id' => $key 
				) )->delete ();
			}
		} else {
			$this->error ( '请选择链接' );
		}
		$this->cacheLinks();
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$this->assign ( 'type', 'home' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		$this->success ( '删除成功' );
	}
	public function addLink() {
		$this->display ( './Public/Admin/Seo/addLink.html' );
	}

	public function editLink() {
		$id = intval ( $_GET ['id'] );
		
		$data = M ( 'link' )->where ( array (
				'id' => $id 
		) )->find ();
		if (empty ( $data )) {
			$this->error ( '不存在该链接' );
		}
		$this->assign ( $data );
		$this->display ( './Public/Admin/Seo/addLink.html' );
	}
	public function doSaveLink() {
		$id = intval ( $_POST ['id'] );

		$data ['name'] = h (preg_replace("/\s|　/","",$_POST ['name'])  );
		$data ['url'] = preg_replace("/\s|　/","",$_POST ['url']) ;
		$data ['linkkeyword'] = preg_replace("/\s|　/","",$_POST ['linkkeyword']);
		$data ['l_order'] = intval ( $_POST ['l_order'] );
		$data ['lang'] = $this->lang;
		$data ['dateline'] = time();
		if (! empty ( $id )) {
			
			$link = M ( 'link' )->where ( array (
					'id' => $id 
			) )->find ();
			
			if (empty ( $link )) {
				$this->error ( '不存在该链接' );
			}
			M ( 'link' )->where(array('id'=>$id))->save ( $data );
			$this->cacheLinks();
			
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				$this->assign ( 'type', 'home' );
				$this->assign('jumpurl',U('Admin/Seo/link'));
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			
			$this->success ( '编辑成功' );
		} else {
			
			M ( 'link' )->add ( $data );
			$this->cacheLinks();
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				$this->assign ( 'type', 'home' );
				$this->assign('jumpurl',U('Admin/Seo/link'));
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			
			$this->success ( '添加成功', U ( 'Admin/Seo/link' ) );
		}
	}
	
	private function cacheLinks() {
		$li = M ( 'link' )->order ( 'l_order ASC' )->select ();
		F ( $this->lang.'links', $li );
	}
	
	public function setting() {
		$this->checkper ( 'seo_static' );
		$config_array = F ( $this->lang . 'config' );
		$data ['code'] = htmlspecialchars ( $config_array ['code'] );
		$data ['titleext'] = $config_array ['sitename'];
		$data ['keyword'] = $config_array ['keyword'];
		$data['artSource'] = $config_array ['artSource'];
		$data ['detailtitle'] = $config_array ['detailtitle'];
		$data ['indextitle'] = $config_array ['indexsite'];
		$data ['longkeyword'] = $config_array ['longkeyword'];
		$data ['productcity'] = $config_array ['productcity'];
		$data ['pdescription'] = $config_array ['pdescription'];
		$this->assign ( $data );
		$this->display ( './Public/Admin/Seo/setting.html' );
	}
	public function doSaveSetting() {
		$config_array = F ( $this->lang . 'config' );
		
		
		$config_array ['code'] = $_POST ['code'];
		$config_array ['desc'] = $_POST ['desc'];
		$config_array ['indexsite'] = h ( $_POST ['indextitle'] );
		$config_array ['sitename'] = h ( $_POST ['titleext'] );
		$config_array ['keyword'] = h ( $_POST ['keyword'] );
		$config_array ['detailtitle'] = intval ( $_POST ['detailtitle'] );
		$config_array ['artSource'] = h ( $_POST ['artSource'] );
		$config_array ['longkeyword'] = h ( $_POST ['longkeyword'] );
		$config_array ['productcity'] = h ( $_POST ['productcity'] );
		$config_array ['pdescription'] = intval( $_POST ['pdescription'] );
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function html() {
		$this->checkper ( 'seo_static' );
		
		$mode = C ( 'url_model' );
		
		$sort = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'module'=>array('neq','Link') 
		) )->order ( 'path ASC' )->select ();
		$this->assign ( 'sort', $sort );
		$this->assign ( 'mode', $mode );
		$this->assign ( 'html', intval ( C ( 'HTML_ON' ) ) );
		$this->assign ( 'sef', intval ( C ( 'SEF_ROUTER' ) ) );
		$this->display ( './Public/Admin/Seo/html.html' );
	}
	public function doMode() {
		$config_array = require './Conf/setting.php';
		
		$mode = intval ( $_POST ['url_mode'] );
		
		if ($mode == 3) {
			$new ['url_model'] = 2;
			$new ['HTML_ON'] = true;
			$new ['SEF_ROUTER'] = false;
		}
		if ($mode == 4) {
			
			if(intval ( C ( 'HTML_ON' ) )==1){
				$new ['url_model'] = 1;
			}else{
				$new ['url_model'] = intval ( $_POST ['rewrite'] );
			}
			
			$new ['HTML_ON'] = false;
			$new ['SEF_ROUTER'] = true;
		}
		
		if ($mode == 5) {
			if(intval ( C ( 'HTML_ON' ) )==1){
				$new ['url_model'] = 1;
			}else{
				$new ['url_model'] = intval ( $_POST ['rewrite'] );
			}
			$new ['HTML_ON'] = false;
			$new ['SEF_ROUTER'] = false;
		}
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			
			$parentsort = M('sort')->where ( array (
					'parent_id' => 0,
					'lang' => $this->lang
			) )->select ();
			
			import ( 'ORG.Util.Io.Dir' );
			$dir=new Dir ( '/');
			
			foreach($parentsort as $k=>$v){
				
				if(!empty($v['path'])){
					$path='./'.$v['path'];
					if(file_exists($path)){
						$dir->delDir($path);
					}
				}
			}
			
		}
		
		
		
		$new_c = array_merge ( $config_array, $new );
		arr2file ( './Conf/setting.php', $new_c );
		@unlink ( './Runtime/~runtime.php' );
		@unlink ( './index.html' );
		
		$this->success ( '保存成功' );
	}
	
	
	/**
	 * 根据当前分类查找该分类下的所有子类
	 */
	private function findSort($sid) {
		$sort = array ();
		if ($sid != 0) {
			$p_sids = array ();
			$where ['id'] = intval ( $sid );
			$p_sort = M ( 'sort' )->where ( array (
					'lang' => $this->lang,
					'id' => $sid 
			) )->find ();
			if (empty ( $p_sort )) {
				$this->error ( '不存在该分类' );
			}
			$sort [] = $p_sort;
			$p_sub = M ( 'sort' )->where ( array (
					'lang' => $this->lang,
					'parent_id' => $p_sort ['id'] 
			) )->select ();
			
			if (! empty ( $p_sub )) {
				foreach ( $p_sub as $p_k => $p_v ) {
					$p_sids [] = $p_v ['id'];
					$sort [] = $p_v;
				}
				
				if (! empty ( $p_sids )) {
					$p_three = M ( 'sort' )->where ( array (
							'lang' => $this->lang,
							'parent_id' => array (
									'in',
									$p_sids 
							) 
					) )->select ();
				}
				
				if (! empty ( $p_three )) {
					foreach ( $p_three as $value ) {
						$sort [] = $value;
					}
				}
			}
		}
		
		return $sort;
	}
	public function destroy() {
		$_SESSION ['code'] = NULL;
		unset ( $_SESSION ['code'] );
	}
	private function sortUrl($item) {
		$url = '';
		switch ($item ['type']) {
			case 'Product' :
				$url = U ( '/Article/index', array (
						'sid' => $item ['id'] 
				) );
				break;
			case 'About' :
				$url = U ( '/About/index', array (
						'sid' => $item ['id'] 
				) );
				break;
			case 'About' :
				$url = U ( '/Article/index', array (
						'sid' => $item ['id'] 
				) );
				break;
			case 'Picture' :
				$url = U ( '/Picture/index', array (
						'sid' => $item ['id'] 
				) );
				break;
			case 'Job' :
				$url = U ( '/Job/index', array (
						'sid' => $item ['id'] 
				) );
				break;
			case 'Message' :
				$url = U ( '/Job/index', array (
						'sid' => $item ['id'] 
				) );
				break;
		}
	}
	
	
	
	
	
	
	
	
	
}