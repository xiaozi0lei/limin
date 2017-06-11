<?php
class MessageAction extends AdminInitAction {
	public function messageList() {
		
		$where=isset($_GET['xunpan'])?array('isxunpan'=>intval($_GET['xunpan'])):array();
		
		$where['lang']=$this->lang;
		
		$this->checkper ( 'message_messagelist' );
		import ( 'ORG.Util.Page' ); // 导入分页类
		$list = M ( 'Message' )->where ($where)->select ();
		
		$count = M ( 'Message' )->where ($where)->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M ( 'Message' )->where ($where)->order ( 'dateline' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		foreach($list as $k=>$v){
			$ids[]=$v['id'];
		}
		
		
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ( './Public/Admin/Message/messageList.html' );
	}
	public function doDelMessage() {
		if (! empty ( $_POST ['check'] )) {
			foreach ( $_POST ['check'] as $key => $vlaue ) {
				$Job = M ( 'message' )->where ( array (
						'id' => $key 
				) )->find ();
				
				if (empty ( $Job )) {
					$this->error ( '不存在该留言' );
				}
				
				M ( 'message' )->where ( array (
						'id' => $key 
				) )->delete ();
			}
		} else {
			$this->error ( '请选择留言' );
		}
		
		$this->success ( '删除成功' );
	}
	public function messageDetail() {
		$id = intval ( $_GET ['aid'] );
		$message = M ( 'message' )->where ( array (
				'id' => $id 
		) )->find ();
		M ( 'message' )->where ( array (
				'id' => $id 
		) )->save ( array (
				'isnew' => 0
		) );
		if (empty ( $message )) {
			$this->error ( '不存在留言' );
		}
		M ( 'message' )->where ( array (
				'id' => $id 
		) )->save ( array (
				'readok' => 1 
		) );
		
		if($message['isxunpan']){
			$pro=M('product')->where(array('id'=>$message['productid']))->find();
			$this->assign($pro);
		}
		
		$this->assign ( $message );
		$this->display ( './Public/Admin/Message/messageDetail.html' );
	}
}