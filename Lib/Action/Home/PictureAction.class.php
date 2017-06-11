<?php
class PictureAction extends HomeInitAction {
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
		
		$count = M ( 'picture' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $config_array ['list_picture_num'],'',$page_url ); // 实例化分页类
		                                                              // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'picture' )->where ( $where )->order ( 'top desc,p_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp;
		$this->assign ( 'webtitle',$this->firTitle );
		$this->assign ( 'keyword', $sort ['keyword'] ? $sort ['keyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $sort ['desc'] ? $sort ['desc'] : $this->config ['desc'] );
		
		// 处理URL
		if (! empty ( $list )) {
			foreach ( $list as $k => $v ) {
				$list [$k] ['url'] = listurl ( 'picture/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ($this->current_sort['index_tpl']);
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
			$this->pageNotFound();
		}
		
		$picture['content']=dereplace($picture['content']);
		
		$piclist = M ( 'attachment' )->where ( array (
				'type' => 'picture',
				'app_id' => $picture ['id'] 
		) )->select ();
		
		$pre = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $picture ['sort'],
				'dateline' => array (
						'gt',
						$picture ['dateline'] 
				) 
		) )->limit ( 1 )->select ();
		$next = $model->where ( array (
				'lang' => $this->lang,
				'sort' => $picture ['sort'],
				'dateline' => array (
						'lt',
						$picture ['dateline'] 
				) 
		) )->limit ( 1 )->select ();
		
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
		
		// 网站头部优化设置
		$this->assign ( 'webtitle', titleValue ( $picture ['seotitle'] ? $picture ['seotitle'] : $picture ['title'] ) );
		$this->assign ( 'keyword', $picture ['seokeyword'] ? $picture ['seokeyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $picture ['seodesc'] ? $picture ['seodesc'] : $this->config ['desc'] );
		
		// 二维码
		$img = D ( 'Qrcode' )->imgcode ( 'picture', $picture ['id'], $picture ['sort'] );
		$this->assign ( 'qrcode', $img );
		
		$this->assign ( 'plist', $piclist );
		$this->assign ( 'relate', $relate );
		$this->assign ( 'pre', $pre [0] );
		$this->assign ( 'next', $next [0] );
		$this->assign ( $picture );
		$this->display ($this->current_sort['show_tpl']);
	}
	
}