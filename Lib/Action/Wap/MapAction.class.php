<?php
class MapAction extends WapInitAction {
	Public function index() {
		$postion = F ( 'position' );
		$this->assign ( $postion );
		$this->display ();
	}
}