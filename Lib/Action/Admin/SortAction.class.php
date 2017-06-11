<?php
class SortAction extends AdminInitAction {
	public function sortList() {
		$m = M ( 'sort' );
		session('sorturl',__SELF__);
		$parent = $m->where ( array (
				'parent_id' => 0,
				'lang' => $this->lang 
		) )->order ( 'sort_order ASC' )->select ();
		
		$li = M ( 'sort' )->field('id,parent_id,root,path,idpath,name,mobiletitle,show_type,sort_order,folder,module,title,hidden,index_hidden,keyword,desc,lang,img,show_pid,index_tpl,show_tpl')->where ( array (
				'lang' => $this->lang 
		) )->order ( 'sort_order ASC,id ASC' )->select ();
		$tree = list_to_tree ( $li, 'id', 'parent_id' );
		$html = $this->handleHtmlMenu ( $tree );
		$this->assign ( 'html', $html );
		$this->display ( './Public/Admin/Sort/sortList.html' );
	}
	
	
	public function doSaveConfig() {
		$config_array = F ( $this->lang . 'config' );
		
		$config_array ['topmenu_level'] = intval ( $_POST ['topmenu_level'] );
		$config_array ['leftmenu_active'] = intval ( $_POST ['leftmenu_active'] );
		$config_array ['moblie_index'] = intval ( $_POST ['mobileindex'] );
		
		if (!empty($_POST["Sjump"]))
		{
			$config_array ['Sjump'] = $_POST ['Sjump'];
			$config_array ['jumpID'] = intval ( $_POST ['JSID'] );
		}
		else
		{
			$config_array ['Sjump'] = NULL;
		}
		F ( $this->lang . 'config', $config_array );
		$this->success ( '保存成功' );
	}
	public function config() {
		$config_array = F ( $this->lang . 'config' );
		
		$sort = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'hidden' => 0,
				'show_type' => array (
						'neq',
						2 
				) 
		) )->select ();
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'Sjump', $config_array ['Sjump'] );
		$this->assign ( 'jumpID', $config_array ['jumpID'] );
		$data ['topmenu_level'] = $config_array ['topmenu_level'];
		$data ['leftmenu_active'] = $config_array ['leftmenu_active'];
		
		$this->assign ( $data );
		$this->display ( './Public/Admin/Sort/config.html' );
	}
	private function handleHtmlMenu($sortarray) {
		
		$temp_a=explode('-', $_GET['hidden']);
		$html = '';
		foreach ( $sortarray as $key => $value ) {
			$hidden_array=explode('-', $_GET['hidden']);
			$count = count ( explode ( '-', $value ['idpath'] ) ) - 1;
			
			$hidden_a='';
			if(!empty($value ['_child'])){
				
				if(in_array($value['id'], $hidden_array)){
					//隐藏的栏目，变为展开连接,去掉ID
					foreach($hidden_array as $hk=>$hv){
						if($hv==$value['id']){
							unset($hidden_array[$hk]);
						}
					}
					$hidden_a="&nbsp;&nbsp;<strong><a href='".U('Admin/sort/sortList',array('hidden'=>implode('-', $hidden_array)))."'>[+]</a></strong>";
				}else{
					
					$hidden_a="&nbsp;&nbsp;<strong><a href='".U('Admin/sort/sortList',array('hidden'=>!empty($_GET['hidden'])?implode('-', $temp_a).'-'.$value['id']:$value['id']))."'>[-]</a></strong>";
				}
			}
			
			$html .= "<tr id='p_{$value['id']}' class='list_tr'>
				    <td class='list_td'><input class='check_all' type='checkbox' value='{$value['id']}' name='check[{$value['id']}]'  /></td>
				    <td class='list_td'>{$value['id']}</td>
				    <td class='list_td'><input type='text' name='order[{$value['id']}]' value='{$value['sort_order']}' style='width:50px;' class='bind_change' /></td>
				    <td style='text-align: left;'><span class='gi'>" . str_repeat ( '|-', $count ) . "</span><input type='text' name='name[{$value['id']}]' value='{$value['name']}' style='width:100px;' class='bind_change' /> <a href='javascript:void(0)' class='a_addsort' onclick='add_sub({$value['id']}," . ($count + 1) . ")' >添加子类</a> $hidden_a</td>
				    <td class='list_td'>{$value['module']}</td>
				    <td class='list_td'>".msubstr($value['folder'],0,20)."</td>
				    <td class='list_td'>
					</a>
					<a href='" . U ( 'Admin/Sort/editSort', array (
					'id' => $value ['id'] 
			) ) . "'>编辑</a>
					<a href='javascript:void(0)' onclick=\"del_one(this,'" . U ( 'Admin/Sort/doDelSort' ) . "')\">删除
					</td>
				</tr>";
			if (! empty ( $value ['_child'] )&&!in_array($value['id'], $temp_a)) {
				$html .= $this->handleHtmlMenu ( $value ['_child'] );
			}
		}
		
		return $html;
	}
	public function editSort() {
		$sort = M ( 'sort' )->where ( array (
				'id' => $_GET ['id'] 
		) )->find ();
		
		if (! empty ( $sort ['extend'] )) {
			$sort ['extend'] = dereplace(unserialize ( $sort ['extend'] ));
		}
		
		$parent = M ( 'sort' )->where ( array (
				'id' => $sort ['parent_id'] 
		) )->find ();
		
		
		
		$this->cacheList ();
		$this->cachePath ();
		
		
		$li = M ( 'sort' )->where ( array (
				'lang' => $this->lang 
		) )->order ( 'sort_order ASC,id ASC' )->select ();
		$tree = list_to_tree ( $li, 'id', 'parent_id' );
		$html = $this->sorttree ( $tree,$sort);
		
		$this->assign('html',$html);
		$this->assign ( 'parent', $parent );
		$this->assign ( 'sort', $sort );
		$this->display ( './Public/Admin/Sort/editSort.html' );
	}
	
	private function sorttree($sortarray,$current_sort){
	
		$html =$check= '';
		foreach ( $sortarray as $key => $value ) {
			$count = count ( explode ( '-', $value ['idpath'] ) ) - 1;
			if(!empty($current_sort)&&$current_sort['parent_id']!=0&&$current_sort['parent_id']==$value['id']){
				$check='selected = "selected"';
			}
			$html .='<option '.$check.' value="'.$value['id'].'">'.str_repeat ( '|-', $count ).$value['name'].'</option>';
			$check='';
			if (! empty ( $value ['_child'] )) {
				$html .= $this->sorttree ( $value ['_child'],$current_sort);
			}
		}
		return $html;
	}
	
	
	public function doEditSort() {
		$id = intval ( $_POST ['id'] );
		$sort = M ( 'sort' )->where ( array (
				'id' => $id 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		
		$data ['name'] = h ( $_POST ['name'] );
		$data ['sort_order'] = intval ( $_POST ['sort_order'] );
		$data ['title'] = h ( $_POST ['title'] );
		$data ['desc'] = h ( $_POST ['desc'] );
		$data ['keyword'] = h ( $_POST ['keyword'] );
		$data ['lang'] = $this->lang;
		$data ['index_tpl'] = $_POST['index_tpl'];
		$data ['show_tpl'] = $_POST['show_tpl'];
		$data ['module']=$_POST['module_name'];
		$data ['jump_to_son']=$_POST['jump_to_son'];
		
		if(!ctype_alnum($_POST['folder'])&&$_POST['module_name']!='Link'){
			$this->error ( '目录名只能为数组和字母~！');
		}
		
		$data ['folder']=h($_POST['folder']);
		
		$fcout=M('sort')->where(array('folder'=>$data ['folder'],'lang'=>$this->lang,'id'=>array('neq',$id)))->count();
		if($fcout!=0){
			$this->error('应经存在该目录名称');
		}
		
		if($sort['folder']!=$data ['folder']){
			if(!empty($data['folder'])){
				M('sort')->where(array('id'=>$sort['id']))->save(array('folder'=>$data['folder'],'path'=>$data['folder']));
			}
			
			//修改了目录要重新整理
			$this->handlePath($sort,$data ['folder'],$data['module']);
		}
		
		
		if($_POST ['extend']['content']){
			$_POST ['extend']['content']=replacesrc(stripslashes($_POST ['extend']['content']));
		}


		$data ['extend'] = ! empty ( $_POST ['extend'] ) ? serialize ( $_POST ['extend']) : '';
		$data ['mobiletitle'] = empty ( $_POST ['mobiletitle'] ) ? h ( $_POST ['name'] ) : h ( $_POST ['mobiletitle'] );
		$data ['show_type'] = intval ( $_POST ['show_type'] );
		$data ['hidden'] = intval ( $_POST ['hidden'] );
		$data ['index_hidden'] = intval ( $_POST ['index_hidden'] );
		$sub = M ( 'sort' )->where ( array (
				'idpath' => array (
						'like',
						$sort ['idpath'] . '-%' 
				) 
		) )->select ();
		$subid = array ();
		foreach ( $sub as $k => $v ) {
			$subid [] = $v ['id'];
		}
		
		M ( 'sort' )->where ( array (
				'id' => array (
						'in',
						$subid 
				) 
		) )->save ( array (
				'hidden' => $data ['hidden'],
				'index_hidden' => $data ['index_hidden']
		) );
		
		if ($_POST ['parent_id'] == 0) {
			$parent ['idpath'] = '';
			$parent ['path'] = '';
			$parent ['parent_id'] = 0;
			$parent ['root'] = 0;
			$parent ['id'] = 0;
		} else {
			$parent = M ( 'sort' )->where ( array (
					'id' => intval ( $_POST ['parent_id'] ) 
			) )->find ();
			if (empty ( $parent )) {
				$this->error ( '不存在' );
			}
		}
		
		if ($sort ['parent_id'] != $parent ['id'] ) {
			
			if (strpos ( $parent ['idpath'], $sort ['idpath'] ) === 0) {
				$this->error ( '不能移动到子类或当前类' );
			}
			// 父类移动
			$data ['idpath'] = $parent ['idpath'] ? $parent ['idpath'] . '-' . $sort ['id'] : $sort ['id'];
			$data ['path'] = $parent ['path'] ? $parent ['path'] . '/' . $sort ['folder'] : $sort ['folder'];
			$data ['parent_id'] = $parent ['id'] ? $parent ['id'] : 0;
			
			$data ['root'] = 0;
			
			if (empty ( $parent ['id'] )) {
				// 顶级分类
				$data ['root'] = 0;
			} else {
				// 存在上级那么root就是上级ID
				if (empty ( $parent ['root'] )) {
					$data ['root'] = $parent ['id'];
				} else {
					$data ['root'] = $parent ['root'];
				}
			}
			
			$findstr = $sort ['idpath'];
			
			$update = M ( 'sort' )->where ( array (
					'id' => array (
							'neq',
							$sort ['id'] 
					),
					'lang' => $this->lang,
					'idpath' => array (
							'like',
							$sort ['idpath'] . '%' 
					) 
			) )->select ();
			
			if (! empty ( $update )) {
				foreach ( $update as $key => $value ) {
					$update_data ['idpath'] = str_replace ( $sort ['idpath'], $data ['idpath'], $value ['idpath'] );
					$update_data ['path'] = str_replace ( $sort ['path'], $data ['path'], $value ['path'] );
					$idarray = explode ( '-', $update_data ['idpath'] );
					$update_data ['root'] = $idarray [0];
					M ( 'sort' )->where ( array (
							'id' => $value ['id'] 
					) )->save ( $update_data );
				}
			}
		}
		
		//上传分类图片
		
		if(!empty($_FILES['img']['name'])){
			
			import ( 'ORG.Net.UploadFile' );
			$upload = new UploadFile (); // 实例化上传类
			$upload->maxSize = 3145728; // 设置附件上传大小
			$upload->allowExts = array (
					'jpg',
					'gif',
					'png',
					'jpeg'
			); // 设置附件上传类型
			$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
			if (! $upload->upload ()) { // 上传错误提示错误信息
				$msg = $upload->getErrorMsg ();
				$this->error($msg);
			} else { // 上传成功 获取上传文件信息
				$info = $upload->getUploadFileInfo ();
				$data['img']='Upload/'.$info [0] ['savename'];
			}
			
		}
		
		
		
		
		
		M ( 'sort' )->where ( array (
				'id' => $id 
		) )->save ( $data );
		$this->cacheList ();
		$this->cachePath ();
		if (C ( 'HTML_ON' ) && $this->lang == 'zh-cn') {
			$this->assign ( 'type', 'all' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		$this->success ( '保存成功' );
	}
	
	private  function handlePath($sort,$newpath,$newmodule){
		$model=M('sort');
		
		//查询当前类的子类（包括当前类）
		
		$son=$model->where(array('idpath'=>array('like','%'.$sort['id'].'%')))->order('path ASC')->select();
		import ( 'ORG.Util.Io.Dir' );
		$dir=new Dir ( '/');
		$html_on=C ( 'HTML_ON' );
		foreach ($son as $k=>$v){
			
			if(!empty($v['path'])&&$html_on){
				$path='./'.$v['path'];
				$dir->delDir($path);
			}
			$newpath_str=str_replace($sort['folder'], $newpath, $v['path']);
			$model->where(array('id'=>$v['id']))->save(array('path'=>$newpath_str));
			if($newmodule=='Link'){
				//改完当前path不修改子类
				break;
			}
		}
		
	}
	
	
	public function addSort() {
		$this->display ( './Public/Admin/Sort/addSort.html' );
	}
	public function doAddSort() {
		
		// 一级栏目添加
		$m = M ( 'sort' );
		
		if (! empty ( $_POST ['new_name'] )) {
			foreach ( $_POST ['new_name'] as $key => $value ) {
				
				foreach ( $value as $k => $v ) {
					
					if (empty ( $v )) {
						$this->error ( '栏目名称不能为空', U ( 'admin/sort/sortList' ) );
					}
					if (empty ( $_POST ['new_index'] [$key] [$k] )) {
						$this->error ( '目录不能为空', U ( 'admin/sort/sortList' ) );
					}
					
					if(!ctype_alnum($_POST ['new_index'] [$key] [$k])&&$_POST ['new_module'] [$key] [$k]!='Link'){
						$this->error ( '目录名只能为数组和字母~！', U ( 'admin/sort/sortList' ) );
					}
					
					$folder = $m->where ( array (
							'folder' => $_POST ['new_index'] [$key] [$k] 
					) )->find ();
					
					if (! empty ( $folder )) {
						$this->error ( $_POST ['new_index'] [$key] [$k] . '目录已经存在', U ( 'admin/sort/sortList' ) );
					}
					
					if ($key == 0) {
						// 添加一级新分类
						
						$data ['name'] = h ( $_POST ['new_name'] [$key] [$k] );
						$data ['sort_order'] = intval ( $_POST ['new_order'] [$key] [$k] );
						$data ['module'] = h ( $_POST ['new_module'] [$key] [$k] );
						$data ['folder'] = h ( $_POST ['new_index'] [$key] [$k] );
						$data ['lang'] = $this->lang;
						$data ['path'] = h ( $_POST ['new_index'] [$key] [$k] );
						$data ['parent_id'] = 0;
						$data ['root'] = 0;
					} else {
						
						$parent = M ( 'sort' )->where ( array (
								'id' => $key 
						) )->find ();
						if (empty ( $parent )) {
							$this->error ( '不存在该父类' );
						}
						
						$data ['name'] = h ( $_POST ['new_name'] [$key] [$k] );
						$data ['sort_order'] = intval ( $_POST ['new_order'] [$key] [$k] );
						$data ['module'] = h ( $_POST ['new_module'] [$key] [$k] );
						$data ['folder'] = h ( $_POST ['new_index'] [$key] [$k] );
						$data ['lang'] = $this->lang;
						$data ['parent_id'] = $key;
						$data ['path'] = $parent ['path'] . '/' . h ( $_POST ['new_index'] [$key] [$k] );
						$data ['root'] = $parent ['root'] ? $parent ['root'] : $parent ['id'];
					}
					
					$add_id = $m->add ( $data );
					
					if ($key != 0) {
						$path = $parent ['idpath'] . '-' . $add_id;
					} else {
						$path = $add_id;
					}
					$m->where ( array (
							'id' => $add_id 
					) )->save ( array (
							'idpath' => $path 
					) );
				}
			}
		}
		
		// 更新栏目
		if (! empty ( $_POST ['check'] )) {
			
			foreach ( $_POST ['check'] as  $value ) {
				
				if (empty ( $_POST ['name'] [$value] )) {
					$this->error ( '栏目名称不能为空' );
				}
				
				$data_new ['sort_order'] = intval ( $_POST ['order'] [$value] );
				$data_new ['name'] = $_POST ['name'] [$value];
				$m->where ( array (
						'id' => $value 
				) )->save ( $data_new );
			}
		}
		
		$sort = M ( 'sort' )->where ( array (
				'lang' => $this->lang 
		) )->order ( 'path ASC' )->select ();
		$newsort = array ();
		foreach ( $sort as $key => $value ) {
			$newsort [$value ['id']] = $value;
		}
		$this->cacheList ();
		$this->cachePath ();
		if (C ( 'HTML_ON' ) && $this->lang == 'zh-cn') {
			$this->assign ( 'type', 'all' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		
		$this->success ( '保存成功' );
	}
	public function htmlRule() {
		// 更新静态HTML规则
		/*
		 * $config_array=require './Conf/setting.php';
		 * $sort=M('sort')->where(array('lang'=>$this->lang))->order('path
		 * ASC')->select(); $rules=array(); foreach($sort as $key=>$value){
		 * $rules[strtolower($value['module'].'index')]=array($value['path'].'/{$sid}','60');
		 * } $new['HTML_CACHE_RULES']=$rules;
		 * $new_c=array_merge($config_array,$new);
		 * arr2file('./Conf/setting.php',$new_c); @unlink('./Runtime/~app.php');
		 */
	}
	public function doDelSort() {
		if (! empty ( $_POST ['check'] )) {
			
			foreach ( $_POST ['check'] as $key => $value ) {
				$this->delsort ( intval ( $value ) );
			}
			
			
			$this->cacheList ();
			$this->cachePath ();
			if (C ( 'HTML_ON' )&& $this->lang == 'zh-cn') {
				$this->assign ( 'type', 'all' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			$this->success ( '删除成功' );
		} else {
			
			$this->error ( '请选择要删除的条目' );
		}
	}
	
	//遍历删除.
	private function delsort($id) {
		$m = M ( 'sort' );
		$sort = $m->where ( array (
				'id' => $id 
		) )->find ();
		
		if (empty ( $sort )) {
			$this->error ( '不存在该分类' );
		}
		$m->where ( array (
				'id' => $sort ['id'] 
		) )->delete ();
		
		if (C ( 'HTML_ON' )&& $this->lang == 'zh-cn') {
			import ( 'ORG.Util.Io.Dir' );
			$path='./'.$sort['path'];
			$dir=new Dir ( '/');
			$dir->delDir($path);
		}
		
		$sub = $m->where ( array (
				'parent_id' => $sort ['id'] 
		) )->select ();
		
		if (! empty ( $sub )) {
			
			foreach ( $sub as $k => $v ) {
				//遍历删除.
				$this->delsort ( $v ['id'] );
			}
			$this->cacheList ();
			$this->cachePath ();
		} else {
			
			return false;
		}
	}
	public function uploadarticalimg() {
		import ( 'ORG.Net.UploadFile' );
		$config_array = F ( $this->lang . 'config' );
		$upload = new UploadFile (); // 实例化上传类
		$upload->maxSize = 3145728; // 设置附件上传大小
		$upload->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg',
				'swf',
				'doc',
				'zip',
				'rar',
		); // 设置附件上传类型
		$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
		$upload->thumb = false;
		$upload->thumbMaxWidth = 4000;
		$upload->thumbMaxHeight = 4000;
		$upload->thumbRemoveOrigin = false;
		
		if (! $upload->upload ()) { // 上传错误提示错误信息
			$result ['error'] = 1;
			$result ['message'] = $upload->getErrorMsg ();
			echo json_encode ( $result );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['error'] = 0;
			$result ['url'] = __ROOT__ . '/Upload/' . $info [0] ['savename'];
			
			echo json_encode ( $result );
		}
	}
	private function cacheList() {
		$li = M ( 'sort' )->where ( array (
				'lang' => $this->lang 
		) )->field('id,parent_id,root,path,idpath,name,mobiletitle,show_type,sort_order,folder,module,title,hidden,index_hidden,keyword,desc,lang,img,show_pid,index_tpl,show_tpl,jump_to_son')->order ( 'sort_order ASC,id ASC' )->select ();
		$tree = list_to_tree ( $li, 'id', 'parent_id' );
		
		F ( $this->lang . 'sort', $tree );
	}
	private function cachePath() {
		$sort = M ( 'sort' )->field ( 'id,path,module' )->where ( array (
				'lang' => $this->lang 
		) )->order ( 'path ASC' )->select ();
		$newsort = array ();
		foreach ( $sort as $key => $value ) {
			$newsort [$value ['id']] = $value;
		}
		
		F ( $this->lang . 'path', $newsort );
	}
	
	public function improtSort(){
		$model=M('sort');
		
		$sort=$model->where(array('lang'=>'zh-cn'))->select();

		
		foreach($sort as $k=>$v){
			unset($v['id']);
			$v['lang']='en-us';
			$model->add($v);
		}
		
		$sort_en=$model->where(array('lang'=>'en-us'))->select();
		
		foreach($sort_en as $k=>$v){
			$idarray=explode('/', $v['path']);
			
			if(count($idarray)>=2){
				
				$s=$model->where(array('folder'=>array('in',$idarray),'lang'=>'en-us'))->order('path asc')->select();
				$news=$ids=array();
				foreach($s as $sk=>$sv){
					$news[]=$sv;
					$ids[]=$sv['id'];
				}
				$countid=count($ids);
				
				$model->where(array('id'=>$v['id']))->save(array('root'=>$news[0]['id'],'parent_id'=>$ids[$countid-2],'idpath'=>implode('-', $ids)));
				
			}else{
				
				$model->where(array('id'=>$v['id']))->save(array('idpath'=>$v['id']));
			}
			
		}
		$model->where(array('lang'=>$this->lang))->save(array('show_pid'=>0));
		
		$this->cacheList ();
		$this->cachePath ();
		$this->success('导入成功');
	}
}