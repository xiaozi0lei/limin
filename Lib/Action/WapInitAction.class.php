<?php

/**bb
 * @author Administrator
 *	用于后台管理的会员初始化
 */
class WapInitAction extends InitAction {
	protected $_USESSION;
	protected $islogin;
	protected $group;
	protected $user_model;
	public function _initialize() {
		parent::_initialize ();
		// 自定义模板
		if(empty($this->config['wapon'])){
			$this->error('手机站正在建设中');
		}
		$model = D ( "User" );
		$model->checklogin ();
		$this->user_model = $model;
		$this->_USESSION = $model->getUserSesstion ();
		$this->islogin = $model->isLogin ();
		$this->group = $model->getUserGroup ();
		
		$menu = M ( 'sort' )->field('id,parent_id,root,path,idpath,name,mobiletitle,show_type,folder,module,title,hidden,keyword,desc,lang,img,show_pid,index_tpl,show_tpl')->where ( array (
				'lang' => $this->lang,
				'show_type' => array (
						'neq',
						2 
				),
				'hidden' => 0 
		) )->order ( 'sort_order ASC,id ASC' )->select ();
		$sid = intval ( $_GET ['sid'] );
		
		foreach ( $menu as $k => $v ) {
			
			if ($v ['module'] == 'Index') {
				$menu [$k] ['url'] = U ( "/Wap/" );
			} elseif ($v ['module'] == 'Link') {
				$menu [$k] ['url'] = $v ['folder'];
			} else {
				
				$menu [$k] ['url'] = U ( "/Wap/$v[module]/index/sid/$v[id]" );
			}
		}
		
		if (! empty ( $sid )) {
			$current_sort = M ( 'sort' )->field('id,parent_id,root,path,idpath,name,mobiletitle,show_type,folder,module,title,hidden,keyword,desc,lang,img,show_pid,index_tpl,show_tpl')->where ( array (
					'id' => $sid 
			) )->find ();
			$this->sort = $current_sort;
			if (empty ( $current_sort )) {
				$this->error ( '不存在该分类' );
			}
			$this->assign ( 'current_sort', $current_sort );
			$lefthtml = $this->getLeftMenu ( $current_sort );
			$this->getLocation ( $sid );
			// 网站头部属性设置
		}
		
		$this->assign ( 'nav', $menu );
		$this->assign ( 'leftmenu', $lefthtml );
		$this->assign ( 'space', $this->_USESSION );
		$this->assign ( 'group', $this->group );
		$this->assign ( 'islogin', $this->islogin );
	}
	private function handleLeftMenu($menuarray, $current, $haschild = 0, $simple = 0, $level = 0) {
		$html = '';
		$level ++;
		
		if (! empty ( $menuarray )) {
			$html = $simple && $level != 1 ? '' : '<ul>';
			
			foreach ( $menuarray as $key => $value ) {
				
				if ($simple) {
					$li_seleted = strpos ( $current ['id'], $value ['id'] ) !== false ? 'class="lihover"' : '';
					$sub = $this->handleLeftMenu ( $value ['_child'], $current, empty ( $value ['_child'] ) ? 0 : 1, $simple, $level );
					$html .= '<li ' . $li_seleted . '><a  href="' . listurl ( $value ['module'] . '/index', array (
							'sid' => $value ['id'] 
					) ) . '" title="' . $value ['name'] . '"><span>' . $value ['name'] . '</span></a></li>' . $sub;
				} else {
					
					$seleted = strpos ( $current ['idpath'], $value ['idpath'] ) !== false ? 'class="ahover"' : '';
					$li_seleted = strpos ( $current ['idpath'], $value ['idpath'] ) !== false ? 'class="lihover"' : '';
					$sub = '';
					
					if ($this->config ['leftmenu_active'] == 2) {
						$sub = $this->handleLeftMenu ( $value ['_child'], $current, empty ( $value ['_child'] ) ? 0 : 1, $level );
					} else {
						
						if (strpos ( $current ['idpath'], $value ['idpath'] ) !== false) {
							$sub = $this->handleLeftMenu ( $value ['_child'], $current, empty ( $value ['_child'] ) ? 0 : 1, $level );
						}
					}
					
					$html .= '<li ' . $li_seleted . '><a ' . $seleted . ' href="' . listurl ( $value ['module'] . '/index', array (
							'sid' => $value ['id'] 
					) ) . '" title="' . $value ['name'] . '"><span>' . $value ['name'] . '</span></a>' . $sub . '</li>';
				}
			}
			$html .= $simple ? '' : '<ul>';
		}
		
		return $html;
	}
	protected function getLeftMenu($current_sort) {
		$sub = M ( 'sort' )->field('id,parent_id,root,show_type,module,folder,show_pid,name')->where ( array (
				'root' => $current_sort ['root'] ? $current_sort ['root'] : $current_sort ['id'],
				'hidden' => 0 
		) )->order ( 'sort_order ASC' )->select ();
		$tree = list_to_tree ( $sub, 'id', 'parent_id', '_child', $current_sort ['root'] ? $current_sort ['root'] : $current_sort ['id'] );
		$config = F ( $this->lang . 'config' );
		$html = $this->handleLeftMenu ( $tree, $current_sort, 0, $config ['mobile_tmpl'] == 'default' ? 1 : 0 );
		
		return $html;
	}
	
	/**
	 * 获取内页导航条 (如：首页-新闻-公司新闻)
	 */
	protected function getLocation($sid) {
		$sid = ! empty ( $sid ) ? $sid : intval ( $_GET ['sid'] );
		$model = M ( 'sort' );
		
		$sort = $model->where ( array (
				'lang' => $this->lang,
				'id' => $sid 
		) )->find ();
		
		if (! empty ( $sort )) {
			
			$location [$sort ['name']] = listurl ( $sort ['module'] . '/index', array (
					'sid' => $sort ['id'] 
			) );
			$sub = $model->where ( array (
					'lang' => $this->lang,
					'id' => $sort ['parent_id'] 
			) )->find ();
			
			if (! empty ( $sub )) {
				// 二级
				$location [$sub ['name']] = listurl ( $sub ['module'] . '/index', array (
						'sid' => $sub ['id'] 
				) );
				// 三级
				$three = $model->where ( array (
						'lang' => $this->lang,
						'id' => $sub ['parent_id'] 
				) )->find ();
				
				if (! empty ( $three )) {
					$location [$three ['name']] = listurl ( $three ['module'] . '/index', array (
							'sid' => $three ['id'] 
					) );
				}
			}
		}
		
		$index_name = L ( 'index_name' );
		
		$location [$index_name] = U ( GROUP_NAME . '/index/index' );
		
		$str = '';
		$i = 0;
		$location = array_reverse ( $location );
		foreach ( $location as $key => $value ) {
			$i ++;
			if ($i < count ( $location )) {
				$str_suffix = '&gt;&gt;';
			}
			
			$str .= '<a href="' . $value . '">' . $key . '</a> ' . $str_suffix;
			$str_suffix = '';
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