<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// |         lanfengye <zibin_5257@163.com>
// +----------------------------------------------------------------------

class Page {
    
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 分页URL地址
    public $url     =   '';
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    protected $config  =    array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>'  %upPage%  %first%  %prePage%  %linkPage%  %nextPage% %downPage%  共 %totalPage% 页   %end%');
    // 默认分页变量名
    protected $varPage;

    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='',$url='') {
    	
    	$this->config['header']=GROUP_NAME=='Home'?L('record'):'条记录';
    	$this->config['prev']=GROUP_NAME=='Home'?L('prev'):'上一页';
    	$this->config['next']=GROUP_NAME=='Home'?L('next'):'下一页';
    	$this->config['first']=GROUP_NAME=='Home'?L('first'):'首页';
    	$this->config['last']=GROUP_NAME=='Home'?L('last'):'最后一页';
    	$totaltext=GROUP_NAME=='Home'?L('totaltext'):'总';
    	$pagetext=GROUP_NAME=='Home'?L('pagetest'):'页';
    	$this->config['theme']='%totalRow% '.$this->config['header'].' %upPage%  %first%  %prePage%  %linkPage%  %nextPage% %downPage% %select% '.$totaltext.' %totalPage% '.$pagetext.'   %end%';
    	
    	
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage);
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if($this->nowPage<1){
            $this->nowPage  =   1;
        }elseif(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
        if(!empty($url))    $this->url  =   $url; 
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);
        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
            
            //自己添加的代码
            if(C('SEF_ROUTER')&&strtolower(ACTION_NAME)!='admin'){
            	$url        =   rtrim(U('/'.$this->url,'',false),$depr).'/index_p/__PAGE__'.'.html';
            }
            //自己添加的代码
            if(C('HTML_ON')&&strtolower(ACTION_NAME)!='admin'){
            	$url=str_replace('/index.php', '', $url);
            }
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(is_array($this->parameter)){
                $parameter      =   $this->parameter;
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                $var =  !empty($_POST)?$_POST:$_GET;
                if(empty($var)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $var;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            //seo模式下修改url
            if(C('SEF_ROUTER')&&strtolower(GROUP_NAME)=='home'){
            	$url = listurl(MODULE_NAME."/".ACTION_NAME,$parameter)."/index_p/".$parameter[$p].".".C('URL_HTML_SUFFIX');
            	if(!empty($_GET["style"])&&!empty($_GET["key"]))
			          $url .= "?style=".$_GET['style']."&key=".$_GET['key'];
            	else 
            	{
            		if (!empty($_GET["style"]))
            			$url .= "?style=".$_GET['style'];
            		if(!empty($_GET["key"]))
            			$url .= "?key=".$_GET['key'];
            	}
            	/* foreach ($var as $name=>$k)
            	{
            		if ($name !="sid")
            		{
            			$url .= "/".$name."/".$k;
            		}
            	}
            	$url .="/index_p/".$parameter[$p].".".C('URL_HTML_SUFFIX'); */
            }  
            else          
            	$url            =   U('',$parameter);
        }
        
        
        $select_str='<select onchange="javascript:window.location.href=\''.str_replace('__PAGE__','\'+this.value+\'',$url).'\'">';
        for($i=1;$i<=$this->totalPages;$i++){
        	$select='';
        	if($this->nowPage==$i){
        		
        		$select="selected='seleted'";
        	}
        	$option .="<option $select value=".$i.">$i</option>";
        }
        
        $str=$select_str.$option.'</select>';
        
        
        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $upPage     =   "<a href='".str_replace('__PAGE__',$upRow,$url)."'>".$this->config['prev']."</a>";
        }else{
            $upPage     =   '';
        }

        if ($downRow <= $this->totalPages){
            $downPage   =   "<a href='".str_replace('__PAGE__',$downRow,$url)."'>".$this->config['next']."</a>";
        }else{
            $downPage   =   '';
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst   =   '';
            $prePage    =   '';
        }else{
            $preRow     =   $this->nowPage-$this->rollPage;
            $prePage    =   '';//"<a href='".str_replace('__PAGE__',$preRow,$url)."' >".L('uppage').$this->rollPage.L('pagetest')."</a>";
            $theFirst   =   "<a href='".str_replace('__PAGE__',1,$url)."' >".$this->config['first']."</a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage   =   '';
            $theEnd     =   '';
        }else{
            $nextRow    =   $this->nowPage+$this->rollPage;
            $theEndRow  =   $this->totalPages;
            $nextPage   =   '';//"<a href='".str_replace('__PAGE__',$nextRow,$url)."' >".L('downpage').$this->rollPage.L('pagetest')."</a>";
            $theEnd     =   "<a href='".str_replace('__PAGE__',$theEndRow,$url)."' >".$this->config['last']."</a>";
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page       =   ($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "<a href='".str_replace('__PAGE__',$page,$url)."'>".$page."</a>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "<span class='current'>".$page."</span>";
                }
            }
        }
        
       // $linkRedict = "";
        
        $pageStr     =   str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%','%select%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd,$str),$this->config['theme']);
        return $pageStr;
    }

}
