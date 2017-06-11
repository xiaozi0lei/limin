<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

<title><?php echo ($webtitle); ?></title>
<?php if((strtolower(MODULE_NAME)=='product'&&$pdescription)||strtolower(MODULE_NAME)=='index'): ?>
<meta name="keywords" content="<?php echo ($keyword); ?>" />
<meta name="description" content="<?php echo ($desc); ?>" />

<?php endif; ?>
<link rel="stylesheet" type="text/css" href="../Public/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../Public/css/bootstrap-responsive.css"/>

<link href="../Public/css/style.css" rel="stylesheet" type="text/css" />
<!--
你的样式写到oneself.css里
-->
<link href="../Public/css/oneself.css" rel="stylesheet" type="text/css" />
<link href="../Public/css/slideshow.css" rel="stylesheet" type="text/css" />

<script>
var site_url='<?php echo U('/');?>';
var tpl_path='<?php echo (APP_TMPL_PATH); ?>';
var public = '__PUBLIC__';
var mobile = '<?php echo ($wapon); ?>';
var root_path='<?php echo (__ROOT__); ?>';
</script>
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
<script type="text/javascript" src="../Public/js/jquery.min.js"></script>
<script type="text/javascript" src="../Public/js/jquery.flexslider-min.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "MainMenu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<script type="text/javascript" src="../Public/js/superslide.2.1.js"></script>
</head>
<body>

<div class="header">
 <div class="header_nr gg">
 <div class="logo fl"><img src="../Public/images/index_03.jpg" /></div>
<div class="daohang fr">
<div class="nav-pc">
     
  
  <div class="mobile_nav " id="mnav">
  <?php echo ($menu); ?>
   </div>
  
    </div>
</div>
 <br class="clear" />
 </div>
</div>
 
</div>

  	

 

<script>
$(function(){

$.ajax({
   type: "POST",
   url: "<?php echo U('Home/Public/viewNum');?>",
   data: "module=article&id=<?php echo ($id); ?>",
   success: function(msg){
   		$('#hitnum').text(msg);
   }
});

})
</script>
<div class="nynews">	
<img src="../Public/images/news.jpg" />   		 
</div>
 <div class="nyk gg">
<div class="nynr"><p><?php echo ($current_sort['name']); ?></p></div></div>
           
<div class="main">

<div id="page_main" class="clearfix">
 <div class="container">
  <div class="page-right">
  <div class="lanmu">
          <div class="lmdh fl">
 <div class="listnr"><div class="ddsmoothmenu-v" id="LeftMenu">
          <?php echo ($leftmenu); ?>
          <br class="clear" />
        </div></div>
</div>
      <div class="site-nav fr"><span>当前位置 : </span>
	  
		<?php echo ($location); ?>
	  
	  </div>
      <br class="clear" />
      </div>
    <div class="page-news">
      <div id="shownews">
       <h1 class="title"><?php echo ($title); ?></h1>
       <div class="hits">
	    <?php if($click_num): ?>点击次数：<span id="hitnum"></span>&nbsp;&nbsp;<?php endif; ?>
	    <?php if($add_time): ?>更新时间：<?php echo (date("y/m/d H:i:m",$dateline)); ?>&nbsp;&nbsp;<?php endif; ?>
		  &nbsp;&nbsp;来源：<a href="http://<?php echo ($artSource); ?>"><?php echo ($artSource); ?></a>  
	    <?php if($page_close): ?>【<a href="javascript:self.close()">关闭</a>】<?php endif; ?>

		<?php if(!empty($share_button)): ?><span >分&nbsp;&nbsp;&nbsp;&nbsp;享: </span> 
		<div class="bdsharebuttonbox" style="display: inline-flex;"><a href="#" class="bds_more" data-cmd="more"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a><a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script></span><?php endif; ?>
	    
       </div>
	   <?php echo ($qrcode); ?>
	   <ul style=" margin:10px 0px;">
		<?php if(is_array($field)): $i = 0; $__LIST__ = $field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$f): $mod = ($i % 2 );++$i;?><li><?php echo ($f["title"]); ?>: <?php echo ($f["value"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>	
	   </ul>
       <div class="text editor"><?php echo ($content); ?></div>
	   
	   
      <div class="page" style="clear:both;">
		<span >上一条：<?php if(!empty($pre)): ?><a href="<?php echo ($pre['url']); ?>"><?php echo ($pre['title']); ?></a><?php else: ?>没有了<?php endif; ?></span>
		<span >下一条：<?php if(!empty($next)): ?><a href="<?php echo ($next['url']); ?>"><?php echo ($next['title']); ?></a><?php else: ?>没有了<?php endif; ?></a></span>
	  </div>

    
   </div> 
  </div>
  </div>
 
    <br class="clear" />
 </div>
</span>
</div>




<div class="footer">

 <div class="foot gg">
 
  <div class="foot_nr">
  <div class="foot_z fl"><img src="../Public/images/index_27.jpg" /></div>
  <div class="foot_y fr"><?php echo ($content_4); ?></div>
  <br class="clear" /></div>
<div class="bq">版权所有：烟台市立民红木家具有限公司  Copyright  2017  ICP 备案号：鲁ICP备16050511号</div>
  <div class="banquan "><img src="../Public/images/banquan.gif" /></div>
 </div>
</div>






<script>
//流量统计代码代码
    <!--  
function getOs()  
{  
    var OsObject = "";  
   if(navigator.userAgent.indexOf("MSIE")>0) {  
        return "MSIE";  
   }  
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){  
        return "Firefox";  
   }  
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) {  
        return "Safari";  
   }   
   if(isCamino=navigator.userAgent.indexOf("Camino")>0){  
        return "Camino";  
   }  
   if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){  
        return "Gecko";  
   }  
    
}  


var url=encodeURIComponent(window.location.href),
    referer=encodeURIComponent(document.referrer);
var url_cookie=$.cookie('url');
var cookie_str = url_cookie?url_cookie:'';
var urlcookie = url_cookie?1:0;
$.cookie('url',cookie_str+','+url, {expires: 7, path: '/'});
$.ajax({
   type: "GET",
   url: "<?php echo U('Home/Public/alexa');?>",
   data:"sid=<?php echo ($_GET['sid']); ?>&id=<?php echo ($_GET['id']); ?>&url="+url+'&referer='+referer+'&browser='+getOs()+'&urlcookie='+urlcookie,
   dataType:'json',
   success: function(msg){
   
   }
});
//在线客服代码
$.ajax({
   type: "POST",
   url: "<?php echo U('Home/Public/getOnline');?>",
   dataType:'json',
   success: function(msg){
   	
     $("body").append(msg.html);
   }
});

</script>
</body>
</html>