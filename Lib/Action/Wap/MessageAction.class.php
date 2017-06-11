<?php
class MessageAction extends WapInitAction {
	public function index() {
		$sid = intval ( $_GET ['sid'] );
		$where = array (
				'lang' => $this->lang,
				'hidden' => 0 
		);
		
		$this->display ();
	}
	public function doSaveMessage() {
		if ($_SESSION ['verify'] != md5 ( $_POST ['checkcode'] )) {
			$this->error ( '验证码错误！' );
		}
		$data ['username'] = h ( $_POST ['Guest_Name'] );
		$data ['email'] = h ( $_POST ['Guest_Email'] );
		$data ['phone'] = h ( $_POST ['Guest_TEL'] );
		$data ['add'] = h ( $_POST ['Guest_ADD'] );
		$data ['fax'] = h ( $_POST ['Guest_FAX'] );
		$data ['zip'] = h ( $_POST ['Guest_ZIP'] );
		$data ['content'] = h ( $_POST ['Content'] );
		$data ['lang'] = $this->lang;
		$data ['dateline'] = time ();
		
		M ( 'message' )->add ( $data );
		
		$this->success ( '感谢您的留言' );
	}
}