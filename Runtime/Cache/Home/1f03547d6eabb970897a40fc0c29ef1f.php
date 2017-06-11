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
    <ul class="newsList">
     <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li style="overflow:hidden;">
      	<a href="<?php echo ($li["url"]); ?>" title="<?php echo ($li["title"]); ?>">
      	<div class="lhfl fl">
        <img src="<?php echo ($site_url); ?>/<?php echo ($li['pic']); ?>" />
      		<!--<p><b><?php echo (date("d",$li['dateline'])); ?></b>
      			<?php echo (date("Y.m",$li['dateline'])); ?>
      		</p>-->
      	</div>
      	<div class="lhfr fr">
       <span class="dateTitle"><?php echo ($li["title"]); echo ($li["icon"]); ?></span>

	   <!--<span style="color: #ccc;font-size: 10px;line-height: 30px;">发布日期:<?php echo (date("Y.m.d",$li['dateline'])); ?></span>-->
	   <p style="color:#5d4a44; "><?php echo ($li["desc"]); ?></p>
	   
        <!--<b class="lhxq">查看详情></b>           用一个即可  查看更多=字-->
        <b class="lhjt"></b>                         <!--查看更多=箭头 -->
       </div>
      
       <div class="clear"></div>
       </a>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="page_list"><?php echo ($page); ?></div>
   </div>
 </div>

    <br class="clear" />
</div>
</div>
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