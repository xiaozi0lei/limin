<?php
class SearchAction extends WapInitAction {
	public function search() {
		$type = h ( $_GET ['SearchAction'] );
		$keyword = h ( $_GET ['keywords'] );
		
		if (! in_array ( $type, array (
				'article',
				'product' 
		) )) {
			$this->error ( '不存在' );
		}
		
		import ( 'ORG.Util.Page' ); // 导入分页类
		
		$page_url = '';
		
		$list = M ( $type )->where ( array (
				'title' => array (
						'like',
						'%' . $keyword . '%' 
				) 
		) )->order ( 'dateline desc' )->select ();
		
		foreach ( $list as $key => $value ) {
			$list [$key] ['url'] = listurl ( 'wap/' . $type . '/show', array (
					'id' => $value ['id'],
					'sid' => $value ['sort'] 
			) );
		}
		
		$this->assign ( 'keyword', $keyword );
		$this->assign ( 'list', $list ); // 赋值数据集
		
		if ($type == 'product') {
			$this->display ( 'Product/plist' );
		} else {
			$this->display ( 'Article/index' );
		}
	}
}