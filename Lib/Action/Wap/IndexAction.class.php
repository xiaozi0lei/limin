<?php
class IndexAction extends WapInitAction {
	public function index() {
		$config_array = F ( $this->lang . 'config' );
		
		// 置顶产品查询
		$product = M ( 'product' )->where ( array (
				'lang' => $this->lang,
				'home_show' => 1 
		) )->order('p_order ASC')->limit ( $config_array ['wap_pro_num'] )->select ();
		
		// 处理URL
		if (! empty ( $product )) {
			foreach ( $product as $k => $v ) {
				$product [$k] ['url'] = listurl ( 'Product/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		// 新闻查询
		$article = M ( 'Article' )->where ( array (
				'lang' => $this->lang 
		) )->limit ( $config_array ['wap_art_num'] )->select ();
		
		// 处理URL
		if (! empty ( $article )) {
			foreach ( $article as $k => $v ) {
				$article [$k] ['url'] = listurl ( 'Article/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
		// 招聘查询
		$job = M ( 'job' )->where ( array (
				'lang' => $this->lang 
		) )->limit ( $config_array ['wap_jon_num'] )->select ();
		
		// 处理URL
		if (! empty ( $job )) {
			foreach ( $job as $k => $v ) {
				$job [$k] ['url'] = listurl ( 'Job/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
		// 下载查询
		$download = M ( 'download' )->where ( array (
				'lang' => $this->lang 
		) )->limit ( $config_array ['wap_down_num'] )->select ();
		
		// 处理URL
		if (! empty ( $download )) {
			foreach ( $download as $k => $v ) {
				$download [$k] ['url'] = listurl ( 'Download/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
		// 图片案例查询
		$picture = M ( 'picture' )->where ( array (
				'lang' => $this->lang 
		) )->limit ( $config_array ['wap_pic_num'] )->select ();
		
		// 处理URL
		if (! empty ( $picture )) {
			foreach ( $picture as $k => $v ) {
				$picture [$k] ['url'] = listurl ( 'Picture/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
		// 普通产品
		$other_product = M ( 'product' )->where ( array (
				'lang' => $this->lang 
		) )->select ();
		
		// 处理URL
		if (! empty ( $other_product )) {
			foreach ( $other_product as $k => $v ) {
				$other_product [$k] ['url'] = listurl ( 'Product/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
		$newp = array_chunk ( $product, 4 );
		$this->assign ( 'title', $config_array['sitename'] );
		$this->assign ( 'other_product', $other_product );
		$this->assign ( 'product', $newp );
		$this->assign ( 'article', $article );
		$this->assign ( 'job', $job );
		$this->assign ( 'download', $download );
		$this->assign ( 'picture', $picture );
		
		$this->display ();
	}
}