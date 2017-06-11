<?php
class ProductAction extends WapInitAction {
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
		
		$sids [] = $sort ['id'];
		//子级查找
		$son=M('sort')->field('id')->where(array('idpath'=>array('like','%'.$sort['id'].'-%')))->select();
		if(!empty($son)){
			foreach($son as $sk=>$sv){
				$sids[]=$sv['id'];
			}
		}
		$where ['sort'] = array (
				'in',
				$sids
		);
		
		$list = M ( 'product' )->where ( $where )->order ( 'p_order asc,dateline desc' )->limit ( $this->config ['wap_list_pro_num'] )->select ();
		$this->assign ( 'title', $sort ['name'] );
		$this->assign ( 'prodcut', $list ); // 赋值数据集
		$this->display ();
	}
	public function plist() {
		$sid = intval ( $_GET ['sid'] );
		
		$where = array (
				'lang' => $this->lang,
				'hidden' => 0 
		);
		
		$sort = M ( 'sort' )->field('id')->where ( array (
				'id' => $sid 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		$list = M ( 'product' )->where ( $where )->order ( 'p_order asc,dateline desc' )->limit ( $this->config ['wap_list_pro_num'] )->select ();
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->display ();
	}
	public function show() {
		$shop = F ( 'shopconfig' );
		$this->assign ( 'shop', $shop );
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'product' );
		$product = $model->where ( array (
				'id' => $aid 
		) )->find ();
		$product ['sortname'] = M ( 'sort' )->field ( 'name' )->where ( array (
				'id' => $product ['sort']
		) )->find ();
		
		if (empty ( $product )) {
			$this->error ( '不存在该产品' );
		}
		
		
		
		$product['content']=dereplace($product['content']);
		 $next= $model->where ( array (
				'lang' => $this->lang,
				'id' => array('lt',$product['id'])
		) )->limit ( 1 )->order ( 'id desc' )->select ();
		
		 $pre= $model->where ( array (
				'lang' => $this->lang,
				'id' => array('gt',$product['id'])
		) )->limit ( 1 )->order ( 'id asc' )->select ();
		
		$relate = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $product ['sort'],
				'id' => array (
						'neq',
						$product ['id'] 
				) 
		) )->limit ( 5 )->select ();
		
		// URL处理
		if (! empty ( $relate )) {
			foreach ( $relate as $k => $v ) {
				$relate [$k] ['url'] = listurl ( 'Product/show', array (
						'id' => $v ['id'],
						'sid' => $v ['sort'] 
				) );
			}
		}
		if (! empty ( $pre )) {
			$pre [0] ['url'] = listurl ( 'Product/show', array (
					'id' => $pre [0] ['id'],
					'sid' => $pre [0] ['sort'] 
			) );
		}
		
		if (! empty ( $next )) {
			$next [0] ['url'] = listurl ( 'Product/show', array (
					'id' => $next [0] ['id'],
					'sid' => $next [0] ['sort'] 
			) );
		}
		
		$this->assign ( 'relate', $relate );
		$this->assign ( 'pre', $pre [0] );
		$this->assign ( 'next', $next [0] );
		$this->assign ( $product );
		$this->display ();
	}
	public function more() {
		$status = 1;
		$count = intval ( $_GET ['count'] );
		$sid = intval ( $_GET ['sid'] );
		
		$sort = M ( 'sort' )->field('id,idpath')->where ( array (
				'id' => $sid 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		// 用于查找当前分类下面子类文章
		$sids [] = $sort ['id'];
		
		$sub = M ( 'sort' )->field('id,idpath')->where ( array (
				'idpath' => array (
						'like',
						$sort ['idpath'] . '-%' 
				) 
		) )->select ();
		
		foreach ( $sub as $k => $v ) {
			$sids [] = $v ['id'];
		}
		
		$where ['sort'] = array (
				'in',
				$sids 
		);
		
		$list = M ( 'product' )->where ( $where )->order ( 'p_order asc,dateline desc' )->limit ( $count . ',' . $this->config ['wap_list_pro_num'] )->select ();
		
		foreach ( $list as $key => $value ) {
			$list [$key] ['url'] = U ( 'wap/product/show', array (
					'id' => $value ['id'],
					'sid' => $value ['sort'] 
			) );
			$list [$key] ['time'] = date ( 'Y/m/d', $value ['dateline'] );
			$list [$key] ['pic'] = site_url () . '/' . $value ['pic'];
		}
		if (empty ( $list )) {
			$status = 0;
		}
		
		$this->ajaxReturn ( array (
				'data' => $list ? $list : array (),
				'status' => $status 
		), 'json' );
	}
}