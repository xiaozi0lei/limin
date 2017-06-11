<?php
defined('THINK_PATH') or exit();

class SEFRouterBehavior extends Behavior {
	
	private $lang='zh-cn';
	
    // 行为扩展的执行入口必须是run
    public function run(&$params){
    	$this->lang=cookie('think_language')?cookie('think_language'):'zh-cn';
    	$url='';
    	if(!empty($_SERVER['PATH_INFO'])){
    		//手机自定义主页
    		$path=explode('/', $_SERVER['PATH_INFO']);
    		if((strtolower($path[1])=='wap'||strtolower($path[1])=='wap.html')&&(strtolower($path[2])=='index'||empty($path[2]))){
    			$config=F ( $this->lang.'config');
    			
    			if($config['moblie_index']&&$config['mobile_tmpl']!='kehuduan'){
    				$sort=M('sort')->field('id,module')->where(array('id'=>$config['moblie_index']))->find();
    				$_SERVER['PATH_INFO']='/wap/'.strtolower($sort['module']).'/index/sid/'.$sort['id'].'.html';
    			}
    		}
    	}
    	
    	
    	//伪静态模式自定义URL解析
    	if(C('SEF_ROUTER')==true||C('SEF_ROUTER')==false&&C('HTML_ON')){
    		$url=$this->doRoute();
    		if(!empty($url)){
    			$_SERVER['PATH_INFO']=$url;
    		}
    	}
    	
    	
    	
    	//动态模式下跳转到相应的静态页
    	if(C('HTML_ON')&&!empty($_SERVER['PATH_INFO'])&&empty($_GET['code'])&&$this->lang=='zh-cn'){
    		
    		$path=explode('/', $_SERVER['PATH_INFO']);
    		
    		if(!empty($path[1])&&strtolower($path[1])!='wap'&&strtolower($path[1])!='admin'&&in_array(strtolower($path[1]), array('about','article','download','job','picture','product'))){
	   			//不对手机站处理 和后台
    			
    			$action_name='';
    			if(strpos($_SERVER['PATH_INFO'], 'sid')!=0){
    				//普通模式的URL跳转到静态页
    				$action_name=$path[1];
    				$id_key=array_search('id', $path);
    				$id_value=str_replace('.html','',$path[$id_key+1]);
    				
    				$sid_key=array_search('sid', $path);
    				$sid_value=str_replace('.html', '', $path[$sid_key+1]);
    				$function_name=$path[2];
    				
    				$page_key=array_search('p', $path);
    				$page_value=str_replace('.html', '', $path[$page_key+1]);
    				
    				$sort=F($this->lang.'path');
    				foreach($sort as $key=>$value){
    					if($value['id']==$sid_value){
    						$sort_path=$value['path'];
    						break;
    					}
    				}
    				if(empty($id_key)){
    					//为列表页
    					if(!empty($page_key)){
    						$path='/'.$sort_path.'/'.$page_value.'/index.html';
    					}else{
    						$path='/'.$sort_path.  '/index.html';
    					}
    					
    				}else{
    					//内页
    					$path='/'.$sort_path.  '/show'.$id_value.'.html';
    				}
    				if(file_exists('./'.$path)){
    					$to_url=site_url().$path;
    				}
    				
    			}else{
    				//伪静态模式的URL跳转到静态页
    				$sort=F($this->lang.'path');
    				
    				foreach($sort as $key=>$value){
    					if(strpos($_SERVER['PATH_INFO'], '/'.$value['path'])===0){
    						$item=$value;
    						break;
    					}
    				}

    				

    				if($item){
    					$show=substr($_SERVER['PATH_INFO'], strlen('/'.$item['path']));
    					if($show=='/'||$show==false){
    						$path = '/'.$item['path'].  '/';
    					}else{
    						preg_match('#\/show(.+)#', $show,$match);
    						if(!empty($match)){
    							$path='/'.$item['path'].  '/show'.$match[1].'.html';
    						}
    						else						// 是否分页
    						{
    							if($show==false){
    								$path = '/'.$item['path'].  '/';
    							}else{
    								preg_match ( '#\/index_p/(\d+)#', $show, $match );

    								if ( $match [1]) {

    									$path = '/'.$item['path'].  '/'.$match[1].'/';
    								}
    							}
    						}
    					}

    					if(file_exists('.'.$path)){
    						$to_url=site_url().$path;
    					}
    				}
    			}
    			if(!empty($to_url)){
    				Header("HTTP/1.1 301 Moved Permanently");
    				Header("Location: ".$to_url);
    				exit();
    			}
    		}
    		
    	}
    	
    	
    	
    	
    	
    }
    
    
    private function doRoute(){

    	//开启了伪静态模式根据栏目处理链接
    	$sort=F ( $this->lang . 'path');
    	foreach($sort as $key=>$value){
    		 
    		if(strpos($_SERVER['PATH_INFO'], '/'.$value['path'])===0){
    			$item=$value;
    			break;
    		}
    	}
    	
    	$path_url=$_SERVER['PATH_INFO'];
    	preg_match('#\/show(.+)#', $path_url,$match);
    	if(!empty($match)){
    		//内页
    		strlen($match[0]);
    		$item_url=str_replace($match[0], '', $path_url);
    		$is_show_page=1;
    	}else{
    		//列表页
    		preg_match ( '#\/index_(.+)#', $path_url, $match );
    		if(preg_match ( '#^p\/\d+#', $match [1] )){
    			//分页列表页
    			$item_url=str_replace('/index_'.$match [1], '', $path_url);
    			$is_list_page=1;
    		}else{
    			//列表页
    			$item_url=$path_url;
    		}
    		
    	}
    	
    	foreach($sort as $key=>$value){
    		if($item_url== strtolower('/'.$value['path'])){
    			$item=$value;
    			break;
    		}
    	}
    	if(!empty($item)){
    		
    		if(!empty($is_show_page)){
    			$url='/'.$item['module'].'/show/sid/'.$item['id'].'/id/'.$match[1];
    		}elseif(!empty($is_list_page)){
    			$url = '/' . $item ['module'] . '/index/sid/' . $item ['id'] . "/" . $match [1];
    		}else{
    			$url=$url='/'.$item['module'].'/index/sid/'.$item['id'];
    		}
    	}else{
    		$url=$_SERVER['PATH_INFO'];
    	}
    	
    	
    	return $url;
    	
    }
    
    
}