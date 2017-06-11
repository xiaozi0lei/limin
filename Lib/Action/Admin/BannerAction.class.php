<?php
class BannerAction extends AdminInitAction {
	
	
	public function bannerList() {
		
		
		
		$list=M('banner')->where(array('lang'=>$this->lang))->order('addtime desc')->select();
		
		$this->assign($_GET);
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->display ( './Public/Admin/Banner/bannerList.html' );
	}
	
	public function addBanner(){
	
		$this->display ( './Public/Admin/Banner/addBanner.html' );
	}
	
	
	
	public function doAddBanner(){
		
		
		$config_array = F ( $this->lang . 'config' );
		$data['blink']=h($_POST['link']);
		$data['bdesc']=h($_POST['desc']);
		$data['lang']=$this->lang;
		//上传分类图片
		if(!empty($_FILES['pic']['name'])){
	
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
			$upload->savePath = APP_PATH . 'Upload/'; // 设置附件上传目录
			$upload->thumb = true;
			$upload->thumbMaxWidth = empty($config_array['banner_w'])?600:$config_array['banner_w'];
			$upload->thumbMaxHeight = empty($config_array['banner_h'])?200:$config_array['banner_h'];
			$upload->thumbRemoveOrigin = false;
			
			
			if (! $upload->upload ()) { // 上传错误提示错误信息
				$msg = $upload->getErrorMsg ();
				$this->error($msg);
			} else { // 上传成功 获取上传文件信息
				$info = $upload->getUploadFileInfo ();
				$data['pic']='Upload/thumb_'.$info [0] ['savename'];
			}
	
		}
		
		
		if(!empty($_POST['bid'])){
			M('banner')->where(array('bid'=>intval($_POST['bid'])))->save($data);
			
			$banner=M('banner')->where(array('lang'=>$this->lang))->select();
			
			F ( $this->lang . 'banner', $banner );
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				$this->assign ( 'type', 'home' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			$this->success('编辑成功',U('Admin/Banner/bannerList'));
		}else{
			$data['addtime']=time();
			M('banner')->add($data);
			
			$banner=M('banner')->where(array('lang'=>$this->lang))->order('addtime desc')->select();
			F ( $this->lang . 'banner', $banner );
			
			
			if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
				$this->assign ( 'type', 'home' );
				$this->display ( './Public/Admin/Public/doHtml.html' );
				return;
			}
			$this->success('添加成功',U('Admin/Banner/bannerList'));
		} 
	
	}
	
	public function doDelBanner(){
		
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$banner = M ( 'Banner' )->where ( array (
						'bid' => $key,
				) )->find ();
		
				if (empty ( $banner )) {
					$this->error ( '不存在该幻灯片' );
				}
		
				M ( 'Banner' )->where ( array (
				'bid' => $key,
				) )->delete ();
		
				@unlink('./'.$banner['pic']);
				$org=str_replace('thumb_', '', $banner);
				@unlink($org);
		
			}
		} else {
			$this->error ( '请选择条目' );
		}
		
		$banner=M('banner')->where(array('lang'=>$this->lang))->order('addtime desc')->select();
		F ( $this->lang . 'banner', $banner );
		
		
		if (C ( 'HTML_ON' )&&$this->lang=='zh-cn') {
			$this->assign ( 'type', 'home' );
			$this->display ( './Public/Admin/Public/doHtml.html' );
			return;
		}
		$this->success('删除成功');
	}
	
	public function editBanner(){
		$banner = M ( 'Banner' )->where ( array (
				'bid' => intval($_GET['bid']),
		) )->find ();
		
		
		if(empty($banner)){
			$this->error('不存在');
		}
		
		
		$this->assign($banner);
		$this->display ( './Public/Admin/Banner/addBanner.html' );
		
	}
	
	
}