<?php
class PublicAction extends InitAction {
	public function top() {
		$this->display ( './Public/Admin/Public/top.html' );
	}
	public function left() {
		$this->display ( './Public/Admin/Public/left.html' );
	}
	public function cpanel() {
		$list = M ( 'article' )->limit ( 10 )->select ();
		$this->assign ( 'list', $list );
		$this->display ( './Public/Admin/Public/cpanel.html' );
	}
	
	public function dohtml() {
		$where ['lang'] = $this->lang;
		$where['module']=array('neq','Link');
		$where ['hidde'] = 0;
		$urls = array ();
	
		$_SESSION ['code'] = mt_rand ( 5, 15 );
		$sortmodel = M ( 'sort' );
		$sids = $sort = $temp_sort = array ();
		$op = $_GET ['op'];
		$urls [] = U ( 'Home/public/sitemap' );//网站地图
		$urls [] = U ( 'Home/Index/index' );//网站主页
		// 内页生成
		if ($op == 'show') {
			$id = intval ( $_GET ['id'] );
			$module = $_GET ['module'];
			$a = M ( $module )->where ( array (
					'id' => $id
			) )->find ();
			$urls [] = U ( '/' . $module . '/show', array (
					'sid' => $a ['sort'],
					'id' => $a ['id']
			) );
		}
		// 生成指定类别
		if ($op == 'sort' || $op == 'index') {
			$sid = $_GET ['sid'];
				
			$sids = array_filter ( explode ( '-', $sid ) );
				
			$sortlist = $sortmodel->where ( array (
					'module'=>array('neq','Link'),
					'id' => array (
							'in',
							$sids
					)
			) )->select ();
						
					foreach ( $sortlist as $key => $value ) {
	
						$temp_sort [$value ['id']] = $value;
					}
		} elseif ($op == 'all') {
			// 一键生成所有
			$temp_sort = M ( 'sort' )->where ( $where )->order ( 'path ASC' )->select ();
		}
	
	
	
	
		// 生成类别中的列表也和内页
		if(!empty($temp_sort)){
			foreach ( $temp_sort as $key => $value ) {
				$sids = $subids = null;
				$sids [] = $value ['id'];
				$urls [] = U ( '/' . $value ['module'] . '/index', array (
						'sid' => $value ['id']
				) );
					
					
				//如果是一键生成全站上面已经查询出所有类别不需要查询子类
				//if($op != 'all'){
				$subsort=$sortmodel->where(array('idpath'=>array('like','%'.$value['id'].'-%')))->select();
				foreach($subsort as $k=>$v){
					$sids[]=$v['id'];
				}
				//}
					
					
					
					
				$model = null;
				switch ($value ['module']) {
					case 'Article' :
						$model = M ( 'Article' );
						$order_field = 'a_order';
						break;
					case 'Product' :
						$model = M ( 'Product' );
						$order_field = 'p_order';
						break;
					case 'Picture' :
						$model = M ( 'Picture' );
						$order_field = 'p_order';
						break;
					case 'Download' :
						$model = M ( 'Download' );
						$order_field = 'd_order';
						break;
					case 'Job' :
						$model = M ( 'Job' );
						$order_field = 'j_order';
						break;
				}
					
				$sids = array_unique ( $sids );
					
				if (! empty ( $model )) {
					// 内容页URL
						
					if (! empty ( $_GET ['id'] )) {
						$list = $model->where ( array (
								'id' => intval ( $_GET ['id'] )
						) )->select ();
					} else {
						$list = $model->where ( array (
								'lang' => $this->lang,
								'sort' => array (
										'in',
										$sids
								)
						) )->order ( $order_field . ' ASC,dateline DESC' )->select ();
					}
						
					if (! empty ( $_GET ['id'] ) || in_array ( $op, array (
							'sort',
							'all',
							'show'
					) )) {
						foreach ( $list as $v ) {
							$urls [] = U ( '/' . $value ['module'] . '/show', array (
									'sid' => $value ['id'],
									'id' => $v ['id']
							) );
						}
					}
						
					// 列表页
					$count = $model->where ( array (
							'lang' => $this->lang,
							'sort' => array (
									'in',
									$sids
							)
					) )->count ();
							$config_array = F ( $this->lang . 'config' );
							$numkey='list_'.strtolower($value ['module']).'_num';
							$pagecount = ceil ( $count / $config_array [$numkey] );
								
							if ($pagecount > 1) {
								for($p = 1; $p <= $pagecount; $p ++) {
									$urls [] = U ( '/' . $value ['module'] . '/index', array (
											'sid' => $value ['id'],
											'p' => $p
									) );
								}
							}
				}
			}
				
		}
	
	
	
		$_SESSION ['num'] = count ( $urls );
		$data ['code'] = $_SESSION ['code'];
		$data ['url'] = $urls;
		$this->ajaxReturn ( $data );
	}
	
	
}