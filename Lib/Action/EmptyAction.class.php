<?php
    class EmptyAction extends Action{
    	
    	
        public function _empty(){
        	 
        	header('HTTP/1.1 404 Not Found');
        	header("status: 404 Not Found");
        	$this->error('您查找的页面未找到',site_url(),5);
        	 
        	 
        }
     }
