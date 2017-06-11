<?php

/**
 * @author Administrator
 *	用于后台管理的会员初始化
 */
class HomeInitAction extends InitAction {
	protected $_USESSION;
	protected $islogin;
	protected $group;
	protected $user_model;
	protected $firTitle;
	protected $current_sort='';
	public function _initialize() {
		parent::_initialize ();
		$model = D ( "User" );
		$model->checklogin ();
		$this->user_model = $model;
		$this->_USESSION = $model->getUserSesstion ();
		$this->islogin = $model->isLogin ();
		$this->group = $model->getUserGroup ();
		
		$menuhtml = '';
		$menu = F ( $this->lang . 'sort' );
		$sid = intval ( $_GET ['sid'] );
		if (! empty ( $sid )) {
			$current_sort = M ( 'sort' )->field('id,parent_id,root,path,idpath,name,mobiletitle,show_type,folder,module,title,hidden,keyword,desc,lang,img,show_pid,index_tpl,show_tpl')->where ( array (
					'id' => $sid 
			) )->find ();
			if (empty ( $current_sort )) {
				$this->pageNotFound();
			}
			
			$lefthtml = $this->getLeftMenu ( $current_sort );
			$this->getLocation ( $sid );
			
			$this->current_sort=$current_sort;
			$this->assign('current_sort',$current_sort);
			
		}
		
		$menuhtml = $this->handleMenuHtml ( $menu, $current_sort );
		$this->assign ( 'leftmenu', $lefthtml );
		$this->assign ( 'menu', $menuhtml );
		$this->assign ( 'space', $this->_USESSION );
		$this->assign ( 'group', $this->group );
		$this->assign ( 'islogin', $this->islogin );
	}
	
	private function handleMenuHtml($menuarray, $current_sort, $haschild = 0, $level = 0) {
		if ($this->config ['topmenu_level'] != 0 && $level >= $this->config ['topmenu_level']) {
			return;
		}
		$ul_class = $haschild ? 'class="menulevel"' : '';
		$html = '';
		if (! empty ( $menuarray )) {
			$html = "<ul $ul_class>";
			$level ++;
			
			$count = count ( $menuarray );
			foreach ( $menuarray as $key => $value ) {
				
				if($value['hidden']==1||$value['show_type']==3){
					continue;
				}
				
				$liclass = '';
				if ($level == 1) {
					if ($key == 0) {
						$liclass = 'class="firstli"';
					}
					if ($key == $count - 1) {
						$liclass = 'class="lastli"';
					}
				}
				
				$seleted = ($current_sort ['id'] == $value ['id'] || strpos ( $current_sort ['idpath'], $value ['id'] ) !== false) && empty ( $haschild ) ? 'id="menu_selected"' : '';
				
				if ($value ['module'] == 'Index') {
					if ($level == 1 && strtolower ( ACTION_NAME ) == 'index' && strtolower ( MODULE_NAME ) == 'index') {
						$seleted = 'id="menu_selected"';
					}
					$link = $this->lang=='zh-cn'?str_replace('/index.php/', '', U ( '/' )):site_url().'/index.php';
				} elseif ($value ['module'] == 'Link') {
					$link = $value ['folder'];
				} else {
					
					if(!empty($value['show_pid'])){
						
						$link = listurl (  $value ['module'].'/show', array (
								'sid' => $value ['id'],
								'id'=>$value['show_pid']
						) );
						
					}elseif(!empty($value['_child'])&&!empty($value['jump_to_son'])){
						//如果后台设置了跳转到子类则修改当前类的链接
						$link =listurl (  $value ['module'].'/index', array (
								'sid' => $value['_child'][0]['id'],
						) );
						
					}else{
						
						$link = listurl ( $value ['module'] . '/index', array (
								'sid' => $value ['id']
						) );
					}
					
					
					
				}
				
				$html .= '<li ' . $liclass . '><a ' . $seleted . ' href="' . $link . '" title="' . $value ['name'] . '"><span>' . $value ['name'] . '</span></a>' . $this->handleMenuHtml ( $value ['_child'], $current_sort ['id'], empty ( $value ['_child'] ) ? 0 : 1, $level ) . '</li>';
			}
			$html .= '</ul>';
		}
		//去掉空的UL
		$html=str_replace('<ul class="menulevel"></ul>', '', $html);
		
		return $html;
	}
	private function handleLeftMenu($menuarray, $current, $haschild = 0) {
		$html = '';
		
		if (! empty ( $menuarray )) {
			$html = '<ul>';
			foreach ( $menuarray as $key => $value ) {
				
				if($value['show_type']==3){
					continue;
				}
				
				$seleted = strpos ( $current ['idpath'], $value ['idpath'] ) !== false ? 'class="ahover"' : '';
				$li_seleted = strpos ( $current ['idpath'], $value ['idpath'] ) !== false||$this->config ['leftmenu_active'] == 2 ? 'class="lihover"' : '';
				$sub = '';
				
				if ($this->config ['leftmenu_active'] == 2) {
					$sub = $this->handleLeftMenu ( $value ['_child'], $current, empty ( $value ['_child'] ) ? 0 : 1 );
				} else {
					
					if (strpos ( $current ['idpath'], $value ['idpath'] ) !== false) {
						$sub = $this->handleLeftMenu ( $value ['_child'], $current, empty ( $value ['_child'] ) ? 0 : 1 );
					}
				}
				
				if ($value ['module'] == 'Index') {
					$link = str_replace('/index.php/', '', U ( '/' ));
				} elseif ($value ['module'] == 'Link') {
					$link = $value ['folder'];
				} else {
					
					
					
					if(!empty($value['show_pid'])){
						$link = listurl (  $value ['module'].'/show', array (
								'sid' => $value ['id'],
								'id'=>$value['show_pid']
						) );
					}elseif(!empty($value['_child'])&&!empty($value['jump_to_son'])){
						//如果后台设置了跳转到子类则修改当前类的链接
						$link =listurl (  $value ['module'].'/index', array (
								'sid' => $value['_child'][0]['id'],
						) );
					}else{
						$link = listurl ( $value ['module'] . '/index', array (
								'sid' => $value ['id'] 
					) );
					}
					
					
				}
				
				$html .= '<li ' . $li_seleted . '><a ' . $seleted . ' href="' .$link . '" title="' . $value ['name'] . '"><span>' . $value ['name'] . '</span></a>' . $sub . '</li>';
			}
			$html .= '</ul>';
		}
		
		return $html;
	}
	protected function getLeftMenu($current_sort) {
		$sub = M ( 'sort' )->field('id,parent_id,root,show_type,module,folder,show_pid,name,idpath,jump_to_son')->where ( array (
				'root' => $current_sort ['root'] ? $current_sort ['root'] : $current_sort ['id'] 	
		) )->order ( 'sort_order ASC,id ASC' )->select ();
		$tree = list_to_tree ( $sub, 'id', 'parent_id', '_child', $current_sort ['root'] ? $current_sort ['root'] : $current_sort ['id'] );
		$html = $this->handleLeftMenu ( $tree, $current_sort );
		
		return $html;
	}
	
	/**
	 * 获取内页导航条 (如：首页-新闻-公司新闻)
	 */
	protected function getLocation($sid) {
		$sid = ! empty ( $sid ) ? $sid : intval ( $_GET ['sid'] );
		$model = M ( 'sort' );
		
		$sort = $model->field('id,idpath')->where ( array (
				'lang' => $this->lang,
				'id' => $sid 
		) )->find ();
		
		if (! empty ( $sort )) {
			
			
			$ids=explode('-', $sort['idpath']);
			
			if(!empty($ids)){
				$pathsorts = $model->field('id,name,module')->where (array('id'=>array('in',$ids)))->select ();
			}
			
			
			$index_name = L ( 'index_name' );
			$location [$index_name] = C('HTML_ON')?'http://'.$_SERVER['HTTP_HOST']:U ( "/" );
			foreach($pathsorts as $k=>$v){
				$location[$v['name']]=listurl ( $v ['module'] . '/index', array (
							'sid' => $v ['id'] 
					) );
			}
			
			
		}
		
		foreach ( $location as $key => $value ) {
			$i ++;
			if ($i < count ( $location )) {
				$str_suffix = '&gt;&gt;';
			}
			
			$str .= '<a href="' . $value . '">' . $key . '</a> ' . $str_suffix;
			$str_suffix = '';
			$this->firTitle = $key;
		}
		
		$this->assign ( 'location', $str );
	}
	protected function getField($item) {
		$newfield = $afild = array ();
		$field = M ( 'formfield' )->where ( array (
				'lang' => $this->lang,
				'module' => 'article' 
		) )->select ();
		
		if (empty ( $field ) || empty ( $item ['extend'] )) {
			return false;
		}
		
		foreach ( $field as $value ) {
			$newfield [$value ['id']] = $value;
		}
		
		if (! empty ( $item ['extend'] )) {
			$item_field = unserialize ( $item ['extend'] );
			foreach ( $item_field as $key => $value ) {
				$newfield [$key] ['value'] = $value;
			}
		}
		
		$this->assign ( 'field', $newfield );
	}
}

?>