<?php
class TextAction extends Action {
	public function index() {
	$this->display();
	}
	public function show() {
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'Article' );
		$article = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		if (empty ( $article )) {
			$this->pageNotFound();
		}
		
		$pre = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $article ['sort'],
				'dateline' => array (
						'gt',
						$article ['dateline'] 
				) 
		) )->limit ( 1 )->select ();
		$next = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $article ['sort'],
				'dateline' => array (
						'lt',
						$article ['dateline'] 
				) 
		) )->limit ( 1 )->select ();
				
				
				
				
		$relate = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $article ['sort'],
				'id' => array (
						'neq',
						$article ['id'] 
				) 
		) )->limit ( 5 )->select ();
		
		$this->getField ( $article );
		
		// 二维码
		$img = D ( 'Qrcode' )->imgcode ( 'article', $article ['id'], $article ['sort'] );
		$this->assign ( 'qrcode', $img );
		
		
		
		// URL处理
		if (! empty ( $relate )) {
			foreach ( $relate as $k => $v ) {
				$relate [$k] ['url'] = listurl ( 'Article/show', array (
						'id' => $v ['id'],
						'sid' => $v ['sort']
				) );
			}
		}
		if (! empty ( $pre )) {
			$pre [0] ['url'] = listurl ( 'Article/show', array (
					'id' => $pre [0] ['id'],
					'sid' => $pre [0] ['sort']
			) );
		}
		
		if (! empty ( $next )) {
			$next [0] ['url'] = listurl ( 'Article/show', array (
					'id' => $next [0] ['id'],
					'sid' => $next [0] ['sort']
			) );
		}
		
		
		
		// 网站头部优化设置
		$this->assign ( 'webtitle', titleValue ( $article ['seotitle'] ? $article ['seotitle'] : $article ['title'] ) );
		$this->assign ( 'keyword', $article ['seokeyword'] ? $article ['seokeyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $article ['seodesc'] ? $article ['seodesc'] : $this->config ['desc'] );
		
		$this->assign ( 'sid', $article ['sort'] );
		$this->assign ( 'relate', $relate );
		$this->assign ( 'pre', $pre [0] );
		$this->assign ( 'next', $next [0] );
		$this->assign ( $article );
		$this->display ();
	}
}