<?php
class DownloadAction extends HomeInitAction {
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
		
		$count = M ( 'download' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $config_array ['list_download_num'],'',$page_url); // 实例化分页类
		                                                               // 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'download' )->where ( $where )->order ( 'top desc,d_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		$this->assign ( 'webtitle', $sort ['title'] ? $sort ['title'] : $this->config ['sitename'] );
		$this->assign ( 'keyword', $sort ['keyword'] ? $sort ['keyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $sort ['desc'] ? $sort ['desc'] : $this->config ['desc'] );
		
		// 处理URL
		if (! empty ( $list )) {
			foreach ( $list as $k => $v ) {
				$list [$k] ['url'] = listurl ( 'download/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
			}
		}
		$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp;
		$this->assign ( 'webtitle',$this->firTitle );
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ($this->current_sort['index_tpl']);
	}
	public function show() {
		$aid = intval ( $_GET ['id'] );
		$model = M ( 'download' );
		$down = $model->where ( array (
				'id' => $aid 
		) )->find ();
		
		if (empty ( $down )) {
			$this->pageNotFound();		}
		
		
		$down['content']=dereplace($down['content']);
			
		$this->getLeftMenu ( $down ['sort'] );
		$this->getLocation ( $down ['sort'] );
		
		// 二维码
		$img = D ( 'Qrcode' )->imgcode ( 'download', $down ['id'], $down ['sort'] );
		$this->assign ( 'qrcode', $img );
		
		// 网站头部优化设置
		$this->assign ( 'webtitle', titleValue ( $down ['seotitle'] ? $down ['seotitle'] : $down ['title'] ) );
		$this->assign ( 'keyword', $down ['seokeyword'] ? $down ['seokeyword'] : $this->config ['keyword'] );
		$this->assign ( 'desc', $down ['seodesc'] ? $down ['seodesc'] : $this->config ['desc'] );
		
		$this->assign ( 'sid', $down ['sort'] );
		$this->assign ( $down );
		$this->display ($this->current_sort['show_tpl']);
	}
	public function doDownload() {
		$id = intval ( $_GET ['id'] );
		$down = M ( 'download' )->where ( array (
				'id' => $id 
		) )->find ();
		
		if (empty ( $down )) {
			$this->pageNotFound();
		}
		$url = site_url () . '/' . $down ['filepath'];
		header ( 'Location:' . $url );
	}
}