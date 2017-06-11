<?php
class ArticleAction extends HomeInitAction {
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
			$this->pageNotFound();
		}

		// 用于查找当前分类下面子类文章

		$sids [] = $sort ['id'];

		//子级查找
		$son=M('sort')->field('id,idpath,name')->where(array('idpath'=>array('like','%'.$sort['id'].'-%')))->select();
		if(!empty($son)){
			foreach($son as $sk=>$sv){
				$sids[]=$sv['id'];
			}
		}
		$where ['sort'] = array (
				'in',
		$sids
		);

		import ( 'ORG.Util.Page' ); // 导入分页类

		$page_url = '';

		if (C ( 'HTML_ON' ) || C ( 'SEF_ROUTER' )) {
			$sort = F ( 'zh-cnpath' );
			$path = $sort [intval ( $_GET ['sid'] )] ['path'];
			$page_url = $path;
		}

		$config_array = F ( $this->lang . 'config' );

		$count = M ( 'Article' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count,$config_array ['list_article_num'], '', $page_url ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Article' )->where ( $where )->order ( 'top desc,a_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$time = time ();
		foreach ( $list as $key => $value ) {
			$icon = '';
			if ($time - $value ['dateline'] < $config_array ['new_icon_day'] * 86400) {
				$icon .= '<img style="news_icon" src="' . site_url () . '/Public/images/news.gif' . '"/>';
			}
			if ($value ['hit'] > $config_array ['hot_icon_click']) {
				$icon .= '<img style="hot_icon" src="' . site_url () . '/Public/images/hot.gif' . '"/>';
			}
			$list [$key] ['icon'] = $icon;
			$list [$key] ['url'] = listurl ( '/Article/show', array (
					'id' => $value ['id'],
					'sid' => $value ['sort'] 
			) );
			$content_str=str_replace(array('　','&nbsp;'), '', strip_tags($value['content']));
			$list[$key]['desc']=strlen($content_str)>60?msubstr($content_str, 0,60):$content_str;
				
		}
		$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp;

		$this->assign ( 'webtitle',$this->firTitle );
		$this->assign ( 'keyword', $sort ['keyword'] ? $sort ['keyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $sort ['desc'] ? $sort ['desc'] : $this->config ['desc'] );
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ($this->current_sort['index_tpl']);
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
		$article['content']=dereplace($article['content']);

		$pre = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $article ['sort'],
				'dateline' => array (
						'gt',
		$article ['dateline']
		)
		) )->order ( 'dateline asc' )->limit ( 1 )->select ();
		$next = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $article ['sort'],
				'dateline' => array (
						'lt',
		$article ['dateline']
		)
		) )->order ( 'dateline desc' )->limit ( 1 )->select ();

		//根据SEOKEY查询相关文章
		if (empty ( $article ["seokeyword"] )) {
			$relate = $model->where ( array (
					'lang' => $this->lang,
					'sort' => $article ['sort'],
					'id' => array (
							'neq',
			$article ['id']
			)
			) )->limit ( 5 )->select ();
				
			$relatePro = M('product')->where ( array (
					'lang' => $this->lang,
			) )->limit ( 5 )->order('id DESC')->select ();
				
		}
		else
		{
			$relate = $model->where ( array (
					'lang' => $this->lang,
			//'sort' => $article ['sort'],
					'id' => array (
							'neq',
			$article ['id']
			),
					'title' => array("like","%".$article["seokeyword"]."%")
			) )->limit ( 5 )->select ();

			$relatePro = M('product')->where ( array (
					'lang' => $this->lang,
					'title' => array ('like',"%".$article["seokeyword"]."%")
			) )->limit ( 5 )->select ();
		}

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
		if (! empty ( $relatePro )) {
			foreach ( $relatePro as $k => $v ) {
				$relatePro[$k]['url'] = listurl ( 'Product/show', array (
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
		$config_array = F ( $this->lang . 'config' );
		$this->assign("seokeyword",$article["seokeyword"]);
		$this->assign('artSource',$config_array['artSource']?$config_array['artSource']:'空');
		$this->assign ( 'webtitle', titleValue ( $article ['seotitle'] ? $article ['seotitle'] : $article ['title'] ) );
		$this->assign ( 'keyword', $article ['seokeyword'] ? $article ['seokeyword'] :$article ['title']  );
		$this->assign ( 'desc', $article ['seodesc'] ? $article ['seodesc'] :h(mb_substr(str_replace("\"","'",$article['content']),0,60,'utf-8') ));
		$this->assign("relatePro",$relatePro);
		$this->assign ( 'sid', $article ['sort'] );
		$this->assign ( 'relate', $relate );
		//上一篇下一篇
		$this->assign ( 'pre', $pre [0] );
		$this->assign ( 'next', $next [0] );
		$this->assign ( $article );
		$this->display ($this->current_sort['show_tpl']);
	}
}