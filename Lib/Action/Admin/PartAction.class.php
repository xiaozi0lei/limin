<?php
class PartAction extends AdminInitAction {
	public function index() {
		$part = M ( 'part' )->where(array('lang'=>$this->lang))->select ();
		
		$this->assign ( 'part', $part );
		$this->display ( './Public/Admin/Part/index.html' );
	}
	public function doSavePart() {
		$content = $_POST ['newpart'];
		$model = M ( 'part' );
		if (! empty ( $content )) {
			foreach ( $content as $k => $v ) {
				$data ['contant'] = replacesrc(stripslashes($v));
				$data ['lang'] = $this->lang;
				$model->add ( $data );
			}
		}
		
		// 更新
		
		$part = $_POST ['part'];
		foreach ( $part as $key => $value ) {
			$data ['contant'] = replacesrc(stripslashes($value));
			$model->where ( array (
					'id' => $key 
			) )->save ( $data );
		}
		
		$list = $model->where ( array (
				'lang' => $this->lang 
		) )->select ();
		$newlist = array ();
		
		foreach ( $list as $key => $value ) {
			$newlist [$value ['id']] = $value;
		}
		
		F ( $this->lang.'part_content', $newlist );
		
		$this->success ( '操作成功' );
	}
	public function uploadPartImg() {
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
		$upload->thumb = true;
		$upload->thumbMaxWidth = 400;
		$upload->thumbMaxHeight = 400;
		$upload->thumbRemoveOrigin = false;
		
		if (! $upload->upload ()) { // 上传错误提示错误信息
			$result ['error'] = 1;
			$result ['message'] = $upload->getErrorMsg ();
			echo json_encode ( $result );
		} else { // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo ();
			$result ['error'] = 0;
			if(!in_array($info[0]['extension'],array('jpg','gif','png','jpeg'))){
				$result ['url'] = __ROOT__ . '/Upload/' . $info [0] ['savename'];
			}else{
				$result ['url'] = __ROOT__ . '/Upload/thumb_' . $info [0] ['savename'];
			}
			echo json_encode ( $result );
		}
	}
}