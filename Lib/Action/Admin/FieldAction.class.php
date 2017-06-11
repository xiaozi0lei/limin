<?php
class FieldAction extends AdminInitAction {
	public function productField() {
		$list = M ( 'field' )->where ( array (
				'type' => 'product',
				'lang' => $this->lang 
		) )->select ();
		$this->assign ( 'list', $list );
		$this->display ( './Public/Admin/Field/productField.html' );
	}
	public function pictureField() {
		$list = M ( 'field' )->where ( array (
				'type' => 'picture',
				'lang' => $this->lang 
		) )->select ();
		$this->assign ( 'list', $list );
		$this->display ( './Public/Admin/Field/pictureField.html' );
	}
	public function doSave() {
		$type = $_GET ['type'];
		
		if(empty($_POST['name'])){
			$this->error('名称不能为空');
		}
		if(!in_array($_POST['fid'],array(1,2,3,4,5,6))){
			$this->error('fid 只能为1-6的数字');
		}
		
		
		$data ['type'] = $type;
		$data ['name'] = h ( $_POST ['name'] );
		$data ['fid'] = intval($_POST['fid']);
		$data ['lang'] = $this->lang;

		
		if(!empty($_POST['id'])){
			
			M ( 'field' )->where(array('id'=>$_POST['id']))->save ( $data );
		}else{
			$f=M('field')->where(array('lang'=>$this->lang,'type'=>$type,'fid'=>$_POST['fid']))->find();
			if(!empty($f)){
				$this->error('fid重复');
			}
			M ( 'field' )->add ( $data );
		}
		
		
		
		$this->success ( '操作成功' );
	}
	
	
	public function doDelField(){
		$field=M('field')->where(array('id'=>$_GET['id']))->find();
		M('field')->where(array('id'=>$field['id']))->delete();
		M($field['type'])->where(array('lang'=>$this->lang))->save(array('field'.$field['fid']=>''));
		$this->success('删除成功');
	}
	
	public function editproductField(){
		$field=M('field')->where(array('id'=>$_GET['id']))->find();
		if(empty($field)){
			$this->error('不存在该字段');
		}
		$this->assign('field',$field);
		$this->display('./Public/Admin/Field/addProductField.html');
		
	}

	
	public function editpictureField(){
		
		$field=M('field')->where(array('id'=>$_GET['id']))->find();
		if(empty($field)){
			$this->error('不存在该字段');
		}
		
		$this->assign('field',$field);
		$this->display('./Public/Admin/Field/addPictureField.html');
		
	}
	
	public function addPictureField() {
		
		$count=M('field')->where(array('lang'=>$this->lang,'type'=>'picture'))->count();
		if($count==6){
			$this->error('最多只能添加6个字段',U('Admin/Field/pictureField'));
		}
		
		$this->display ( './Public/Admin/Field/addPictureField.html' );
	}
	public function addProductField() {
		
		$count=M('field')->where(array('lang'=>$this->lang,'type'=>'product'))->count();
		if($count==6){
			$this->error('最多只能添加6个字段',U('Admin/Field/productField'));
		}
		
		$this->display ( './Public/Admin/Field/addProductField.html' );
	}
}