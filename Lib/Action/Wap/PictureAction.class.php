<?php
class PictureAction extends WapInitAction {
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
		
		$count = M ( 'picture' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $this->config ['wap_list_pic_num'] ); // 实例化分页类
		                                                                  // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'picture' )->where ( $where )->order ( 'p_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$this->assign ( 'list', $list ); // 赋值数据集
		
		$this->assign ( 'title', $sort ['name'] );
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ();
	}
	public function show() {
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'picture' );
		$picture = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		$this->getLeftMenu ( $picture ['sort'] );
		$this->getLocation ( $picture ['sort'] );
		
		if (empty ( $picture )) {
			$this->error ( '不存在该图片集' );
		}
		
		$picture['content']=dereplace($picture['content']);
		
		$piclist = M ( 'attachment' )->where ( array (
				'type' => 'picture',
				'app_id' => $picture ['id'] 
		) )->select ();
		
		$pre = $model->where ( array (
				'lang' => $this->lang,
				'id' => array('gt',$picture['id'])
		) )->limit ( 1 )->order ( 'id asc' )->select ();
		$next = $model->where ( array (
				'lang' => $this->lang,
				'id' => array('lt',$picture['id'])
		) )->limit ( 1 )->order ( 'id desc' )->select ();
		
		$relate = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $picture ['sort'],
				'id' => array (
						'neq',
						$picture ['id'] 
				) 
		) )->limit ( 5 )->select ();
		
		if (! empty ( $piclist )) {
			foreach ( $piclist as $key => $value ) {
				$piclist [$key] ['org'] = str_replace ( 'thumb_', '', $value ['filepath'] );
			}
		}
		
		// URL处理
		if (! empty ( $relate )) {
			foreach ( $relate as $k => $v ) {
				$relate [$k] ['url'] = listurl ( 'Picture/show', array (
						'id' => $v ['id'],
						'sid' => $v ['sort'] 
				) );
			}
		}
		if (! empty ( $pre )) {
			$pre [0] ['url'] = listurl ( 'Picture/show', array (
					'id' => $pre [0] ['id'],
					'sid' => $pre [0] ['sort'] 
			) );
		}
		
		if (! empty ( $next )) {
			$next [0] ['url'] = listurl ( 'Picture/show', array (
					'id' => $next [0] ['id'],
					'sid' => $next [0] ['sort'] 
			) );
		}
		
		// URL处理
		if (! empty ( $relate )) {
			foreach ( $relate as $k => $v ) {
				$relate [$k] ['url'] = listurl ( 'Picture/show', array (
						'id' => $v ['id'],
						'sid' => $v ['sort'] 
				) );
			}
		}
		if (! empty ( $pre )) {
			$pre [0] ['url'] = listurl ( 'Picture/show', array (
					'id' => $pre [0] ['id'],
					'sid' => $pre [0] ['sort'] 
			) );
		}
		
		if (! empty ( $next )) {
			$next [0] ['url'] = listurl ( 'Picture/show', array (
					'id' => $next [0] ['id'],
					'sid' => $next [0] ['sort'] 
			) );
		}
		
		$this->assign ( 'plist', $piclist );
		$this->assign ( 'relate', $relate );
		$this->assign ( 'pre', $pre [0] );
		$this->assign ( 'next', $next [0] );
		$this->assign ( $picture );
		$this->display ();
	}
}