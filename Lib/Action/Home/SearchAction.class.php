<?php
class SearchAction extends HomeInitAction {
	public function search() {
		$type = h ( $_POST ['searchid'] );
		$text = $_POST ['searchtext'];
		if (empty ( $text )) {
			$this->error ( '请输入关键字' );
		}
		
		if (! in_array ( $type, array (
				'article',
				'product',
				'job' 
		) )) {
			$this->error ( '不存在该查询' );
		}
		import ( 'ORG.Util.Page' ); // 导入分页类
		$model = M ( $type );
		$count = $model->where ( array (
				'lang' => $this->lang,
				'title' => array (
						'like',
						'%' . $text . '%' 
				) 
		) )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $model->where ( array (
				'lang' => $this->lang,
				'title' => array (
						'like',
						'%' . $text . '%' 
				) 
		) )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		if (! empty ( $list )) {
			
			foreach ( $list as $key => $value ) {
				$list [$key] ['url'] = listurl ( '/' . $type . '/show', array (
						'id' => $value ['id'],
						'sid' => $value ['sort'] 
				) );
			}
		}
		
		$this->assign ( 'title', '搜索' );
		$this->assign ( 'keyword', $this->config ['keyword'] );
		$this->assign ( 'desc', $this->config ['desc'] );
		
		$this->assign ( 'list', $list );
		$this->display ( 'search' );
	}
	
	
	
}