<?php
class ShareAction extends WapInitAction {
	Public function index() {
		$this->assign ( 'title', '分享' );
		$this->display ();
	}
}