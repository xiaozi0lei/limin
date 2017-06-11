<?php
class ArticleAction extends WapInitAction {
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
		
		$page_url = '';
		if (C ( 'HTML_ON' )) {
			$sort = F ( 'sort' );
			$path = $sort [intval ( $_GET ['sid'] )] ['path'];
			$page_url = $path;
		}
		
		$count = M ( 'Article' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $this->config ['wap_list_art_num'], '', $page_url ); // 实例化分页类
		                                                                               // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Article' )->where ( $where )->order ( 'a_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		foreach ( $list as $key => $value ) {
			$list [$key] ['url'] = listurl ( 'wap/Article/show', array (
					'id' => $value ['id'],
					'sid' => $value ['sort'] 
			) );
		}
		
		$this->assign ( 'title', $sort ['name'] );
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ();
	}
	public function show() {
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'Article' );
		$article = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		if (empty ( $article )) {
			$this->error ( '不存在该文章' );
		}
		
		$article['content']=dereplace($article['content']);
		
		$sub = M ( 'sort' )->field('id')->where ( array (
				'idpath' => array (
						'LIKE',
						$this->sort ['idpath'] . '%' 
				) 
		) )->select ();
		
		$subid = array ();
		foreach ( $sub as $k => $v ) {
			$subid [] = $v ['id'];
		}
		
		$next = $model->where ( array (
				'hidden' => 0,
				'lang' => $this->lang,
				'id' => array('lt',$article['id'])
		) )->limit ( 1 )->order ( 'id desc' )->select ();
		$pre = $model->where ( array (
				'hidden' => 0,
				'lang' => $this->lang,
				'id' => array('gt',$article['id'])
		) )->limit ( 1 )->order ( 'id asc' )->select ();
		
		$this->assign ( 'title', $article ['title'] );
		$this->assign ( 'sid', $article ['sort'] );
		$this->assign ( 'pre', $pre [0] );
		$this->assign ( 'next', $next [0] );
		$this->assign ( $article );
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
		
		$sub = M ( 'sort' )->field('id')->where ( array (
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
		
		$list = M ( 'Article' )->where ( $where )->order ( 'a_order asc,dateline desc' )->limit ( $count . ',' . $this->config ['wap_list_art_num'] )->select ();
		
		foreach ( $list as $key => $value ) {
			$list [$key] ['url'] = U ( 'wap/Article/show', array (
					'id' => $value ['id'],
					'sid' => $value ['sort'] 
			) );
			$list [$key] ['time'] = date ( 'Y/m/d', $value ['dateline'] );
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