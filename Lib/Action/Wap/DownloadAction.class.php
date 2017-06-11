<?php
class DownloadAction extends WapInitAction {
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
		
		$count = M ( 'download' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $this->config ['wap_list_down_num'] ); // 实例化分页类
		                                                                   // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'download' )->where ( $where )->order ( 'p_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		foreach ( $list as $key => $value ) {
			$list [$key] ['url'] = listurl ( 'Wap/Download/show', array (
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
		$model = M ( 'download' );
		$down = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		if (empty ( $down )) {
			$this->error ( '不存在该下载' );
		}
		
		$down['content']=dereplace($down['content']);
		$this->getLeftMenu ( $down ['sort'] );
		$this->getLocation ( $down ['sort'] );
		
		$this->assign ( 'sid', $down ['sort'] );
		$this->assign ( $down );
		$this->display ();
	}
	public function doDownload() {
		$id = intval ( $_GET ['id'] );
		$down = M ( 'download' )->where ( array (
				'id' => $id 
		) )->find ();
		
		if (empty ( $down )) {
			$this->error ( '不存在该下载' );
		}
		
		$url = site_url () . '/' . $down ['filepath'];
		header ( 'Location:' . $url );
	}
}