<?php
class AboutAction extends WapInitAction {
	public function index() {
		$sid = intval ( $_GET ['sid'] );
		
		$this->getLeftMenu ( $sid );
		$this->getLocation ( $sid );
		
		$sort_content = array ();
		
		$sortmodel = M ( 'sort' );
		$sort_content = $sort = $sortmodel->where ( array (
				'id' => $sid 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		

		
		if (! empty ( $sort_content ['extend'] )) {
			$sort_content ['extend'] = unserialize ( $sort_content ['extend'] );
			$sort_content ['extend'] ['content']=dereplace($sort_content ['extend'] ['content']);
		}
		
		if (preg_match_all ( '/{\$map}/', $sort_content ['extend'] ['content'], $matches )) {
			$postion = F ( 'position' );
			$this->assign ( $postion );
			$map = $this->fetch ( 'map' );
			$sort_content ['extend'] ['content'] = preg_replace ( '/{\$map}/', $map, $sort_content ['extend'] ['content'] );
		}
		
		$this->assign ( 'title', $sort ['name'] );
		$this->assign ( 'sort_content', $sort_content );
		$this->display ();
	}
}