<?php
class ProductAction extends HomeInitAction {
	public function index() {
		$sub = $three = $sids = array ();
		$sid = intval ( $_GET ['sid'] );
		$keyword = h(trim($_GET['key']));
		$url = explode("?",__SELF__);
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
		        $sort_desc=$sort['desc'];
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
		//构造产品展示URL
		$TempU = explode("?",__SELF__);
		if (!empty($keyword))
		{
			$where['title'] = array('like',"%$keyword%");
			$surl = $TempU[0].'?key='.$keyword.'&';
			$kurl = $TempU[0].'?key='.$keyword;
		}
		else
		{
			$surl = $TempU[0].'?';
			$kurl = $TempU[0];
		}
		$surl .= "style=1" ;

		$config_array = F ( $this->lang . 'config' );

		import ( 'ORG.Util.Page' ); // 导入分页类

		$page_url = '';

		if (C ( 'HTML_ON' ) || C ( 'SEF_ROUTER' )) {
			$sortpath = F ( 'zh-cnpath' );
			$path = $sortpath [intval ( $_GET ['sid'] )] ['path'];
			$page_url = $path;
		}


		$count = M ( 'product' )->where ( $where )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count,$config_array ['list_product_num'],'',$page_url); // 实例化分页类
		// 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'product' )->where ( $where )->order ( 'top desc,p_order asc,dateline desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();

		// 处理URL
		if (! empty ( $list )) {
			foreach ( $list as $k => $v ) {
				$list [$k] ['url'] = listurl ( 'product/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id'] 
				) );
				$name = M("sort")->where("id = ".$v['sort'])->field("name")->find();
				$list [$k] ['name'] = $name['name'];
			}
		}

		// 网站头部优化设置
		if(strpos($sort ['name'],'产品')!==false&&$sort['parent_id']==0){
			//产品主导航
			$sort ['name']=$this->firTitle=!empty($this->config[productcity])?'('.$this->config[productcity].')'.$this->config['keyword']:$this->config['keyword'];
			$desc=$this->config['sitename'].'为您提供'.$this->config['keyword'].'产品的详细介绍,包括'.$this->config['keyword'].'的用途、规格、型号、图片、价格、供应信息等'.',产品覆盖:'.$this->config['productcity'].'等地区';
		}else{
			//子导航
			$desc=$this->pageDesc($sort['name']).',产品覆盖:'.$this->config['productcity'].'等地区';
		}


		// 网站头部优化设置
		$temp = $sort ['title'] ? $sort ['title'] : $this->config ['sitename'];
		$this->firTitle .="-".$temp;
		$this->assign('sort',$sort);
		$this->assign('sort_desc',$sort_desc);
		$this->assign ( 'webtitle',$this->firTitle );
		$this->assign ( 'keyword', $sort ['name']);
		$this->assign ( 'desc', $desc);
		$this->assign('surl',$surl);//url绑定展示样式
		$this->assign('kurl',$kurl);//url绑定搜索关键词
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		if($_GET['style']==1){
			$shop = F ( 'shopconfig' );
			$this->assign ( 'shop', $shop );
			$this->display('Product/index2');
		}
		else
		{
			$this->display ($this->current_sort['index_tpl']);
		}

	}
	public function show() {
		$shop = F ( 'shopconfig' );
		$this->assign ( 'shop', $shop );

		$aid = intval ( $_GET ['id'] );
		$model = M ( 'product' );

		$product = $model->where ( array (
				'id' => $aid 
		) )->find ();

		if (empty ( $product )) {
			$this->pageNotFound();
		}

		$product['content']=dereplace($product['content']);
		if(!empty($product['extend'])){
			$product['extend']=unserialize($product['extend']);
		}
		$product ['sortname'] = M ( 'sort' )->field ( 'name' )->where ( array (
				'id' => $product ['sort'] 
		) )->find ();
		$product ['bigimg'] = str_replace ( 'thumb_', '', $product ['pic'] );


		//缩略图列表
		$piclist = M ( 'attachment' )->where ( array (
				'app_id' => $product["id"],
				'type' => 'product' 
				) )->select ();
				if (count($piclist)==1)
				{
					$other = M ( 'product' )->where ( array (
					/* 'id' => array (
					 'neq',
					 $product ['id']
					 ), */
					'sort' => $product ['sort']
					) )->select ();
						
					$otherid = array ();
					foreach ( $other as $k => $v ) {
						$otherid [] = $v ['id'];
					}
					$piclist = M ( 'attachment' )->where ( array (
				'app_id' => array (
						'in',
					$otherid
					),
				'type' => 'product' 
				) )->select ();
				}

				if (! empty ( $piclist )) {
					foreach ( $piclist as $k => $v ) {

						$piclist [$k] ['pic'] = site_url () . '/Upload/' . $v ['filename'];
						$piclist [$k] ['thumb'] = ! empty ( $v ['hasthumb'] ) ? site_url () . '/Upload/thumb_' . $v ['filename'] : $piclist [$k] ['pic'];
					}
				}
				//补救批量上传造成的错误，产品正式发布后，可以删除
				if (count($piclist)==0)
				{
					$piclist = M ( 'product' )->where ( array (
					/* 'id' => array (
					 'neq',
					 $product ['id']
					 ), */
					'sort' => $product ['sort']
					) )->select ();
					if (! empty ( $piclist )) {
						foreach ( $piclist as $k => $v ) {
							$piclist [$k] ['pic'] =  site_url () . '/' .str_replace("thumb_","",$v ['pic']);
							$piclist [$k] ['thumb'] = site_url () . '/' .$v ['pic'];
							$piclist [$k] ['app_id'] = $v ['id'];
						}
					}

				}

				$this->assign ( 'piclist', $piclist );


				if (empty($product["seokeyword"]))
				{
					$relate = $model->where ( array (
					'lang' => $this->lang,
					'sort' => $product ['sort'],
					'id' => array (
							'neq',
					$product ['id']
					)
					) )->limit ( 5 )->select ();
						
					$relNew = M('article')->where ( array (
							'lang' => $this->lang,
							'title' => array(
									"like","%".$product["title"]."%"
									)
									) )->limit ( 5 )->select ();
										
				}
				else
				{
					$relate = $model->where ( array (
					'lang' => $this->lang,
					'id' => array (
							'neq',
					$product ['id']
					),
					'title' => array(
							"like","%".$product["seokeyword"]."%"
							)
							) )->limit ( 5 )->select ();
							$relNew = M('article')->where ( array (
					'lang' => $this->lang,
					'title' => array(
							"like","%".$product["seokeyword"]."%"
							)
							) )->limit ( 5 )->select ();
				}
				// URL处理
				if (! empty ( $relate )) {
					foreach ( $relate as $k => $v ) {
						$relate [$k] ['url'] = listurl ( 'Product/show', array (
						'id' => $v ['id'],
						'sid' => $v ['sort'] 
						) );
					}
				}
				if (! empty ( $relNew )) {
					foreach ( $relNew as $k => $v ) {
						$relNew [$k] ['url'] = listurl ( 'Article/show', array (
						'id' => $v ['id'],
						'sid' => $v ['sort']
						) );
					}
				}


				if(!empty($this->config['wapon'])){
		   // 二维码
					$img = D ( 'Qrcode' )->imgcode ( 'product', $product ['id'], $product ['sort'] );
					$this->assign ( 'qrcode', $img );
				}
             /**
              * 价格修改形式
              *  zxj 16-1-11
              */
				if($product['price']=='0.0')
				$product['price']='面议';
				else
				$product['price']='￥'.$product['price'];
				// 网站头部优化设置
				$this->assign ( 'webtitle', titleValue ( $product ['seotitle'] ? $product ['seotitle'] : $product ['title'] ) );
				$this->assign ( 'keyword', $this->pageKeyword($product['title']));
				$this->assign ( 'desc', $this->pageDesc($product['title']));
				$this->assign ( 'relate', $relate );
				$this->assign ( 'relNew', $relNew );

				$this->assign ( $product );
				$this->assign('productText','以上是关于'.$this->getContentLongKeyword($product['title']).'的具体介绍。');
				$this->display ($this->current_sort['show_tpl']);
	}


	private function pageDesc($desc){
		$desc=$this->config['sitename'].'为您提供'.$desc.'产品的详细介绍,包括'.$desc.'的用途、规格、型号、图片';
		if($this->config['longkeyword']){
			$longkeyword = str_replace(",", "、",$this->config['longkeyword']);
			$desc .='、'.$longkeyword;
		}
		$desc .= '等,产品覆盖市场'.str_replace(",", "、",$this->config['productcity']).'等.';
		return $desc;

	}

	public function getProduct() {
		$pid = intval ( $_GET ['pid'] );

		$product = M ( 'product' )->where ( array (
				'id' => $pid 
		) )->find ();

		if (empty ( $product )) {
				
			$this->ajaxReturn ( array (
					'data' => $product,
					'info' => '不存在',
					'status' => 0 
			) );
			return false;
		}
		$product ['dateline'] = date ( 'Y-m-d', $product ['dateline'] );
		$sort = M ( 'sort' )->where ( array (
				'id' => $product ['sort'] 
		) )->find ();
		$product ['sort'] = $sort ['name'];
		$product['content']=dereplace($product['content']);
		$this->ajaxReturn ( array (
				'data' => $product,
				'info' => '',
				'status' => 1 
		) );
	}

	private function pageKeyword($name){
		$keyword = $name.','.$this->getContentLongKeyword($name);
		return $keyword;

	}

	//获取产品名称与长尾关键字的组合  ADD.WUJING.20151015
	private function getContentLongKeyword($desc){
		$longkeyword = $this->config['longkeyword'];
		$text = '';
		if($longkeyword){
			$longKwArr = explode(",",$longkeyword);
			foreach ($longKwArr as $v){
				$text .= $desc.$v.',';
			}
			$text = substr($text,0,-1);
		}
		return $text;
	}
}