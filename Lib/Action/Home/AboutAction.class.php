<?php
class AboutAction extends HomeInitAction {
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
			$this->pageNotFound();
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
		// 网站头部优化设置
		$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp; 
		$this->assign ( 'webtitle',$this->firTitle );
		$this->assign ( 'keyword', $sort ['keyword'] ? $sort ['keyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $sort ['desc'] ? $sort ['desc'] : $this->config ['desc'] );
		
		$this->assign ( 'sort_content', $sort_content );
		$this->display ($this->current_sort['index_tpl']);
	}
}