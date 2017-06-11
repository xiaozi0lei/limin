<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($webtitle); ?></title>
<?php if((strtolower(MODULE_NAME)=='product'||strtolower(MODULE_NAME)=='index')&&$pdescription): ?>
<meta name="keywords" content="<?php echo ($keyword); ?>" />
<meta name="description" content="<?php echo ($desc); ?>" />
<?php endif; ?>
<link href="../Public/css/reset.css" rel="stylesheet" type="text/css" />
<link href="../Public/css/webmain.css" rel="stylesheet" type="text/css" />
<link href="../Public/css/ddsmoothmenu.css" rel="stylesheet" type="text/css" />
<script>
var site_url='<?php echo U('/');?>';
var tpl_path='<?php echo (APP_TMPL_PATH); ?>';
var public = '__PUBLIC__';
var mobile = '<?php echo ($wapon); ?>';
</script>
<script type="text/javascript" src="../Public/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
<script type="text/javascript" src="../Public/js/jquery.KinSlideshow-1.2.1.js"></script>
<script type="text/javascript" src="../Public/js/webtry_roll.js"></script>
<script type="text/javascript" src="../Public/js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "MainMenu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
</head>
<body>
<div id="wrapper">
  <div class="top"> <img src="../Public/images/logo.gif" width="650" height="90" alt="上海网聚化工有限公司" />
	<div id="lang"><a href="<?php echo ($site_url); ?>/?l=zh-cn">中文</a> 
    <?php if($waplink==1): ?>| <a href="<?php echo U('Wap/index/index');?>">WAP</a></div><?php endif; ?>
  </div>
  
  <div id="MainMenu" class="ddsmoothmenu">
  	
    <?php echo ($menu); ?>
  </div>
  
  
  <script type="text/javascript">
$(function(){
    $("#banner").KinSlideshow({
            moveStyle:"right",
            titleBar:{titleBar_height:32,titleBar_bgColor:"#000",titleBar_alpha:0.7},
            titleFont:{TitleFont_size:12,TitleFont_color:"#FFFFFF",TitleFont_weight:"normal"},
            btn:{btn_bgColor:"#2d2d2d",btn_bgHoverColor:"#1072aa",btn_fontColor:"#FFF",btn_fontHoverColor:"#FFF",btn_borderColor:"#4a4a4a",btn_borderHoverColor:"#1188c0",btn_borderWidth:1}
    });
})
</script>
  <div id="banner">
    <a href="#"><img src="../Public/images/banner01.jpg" alt="多年的经营过程中，不断优化货源渠道，使产品价格更具竞争力！" width="950" height="152" /></a>
    <a href="#"><img src="../Public/images/banner02.jpg" alt="aa多年的经营过程中，不断优化货源渠道，使产品价格更具竞争力！" width="950" height="152" /></a>
    <a href="#"><img src="../Public/images/banner03.jpg" alt="bb多年的经营过程中，不断优化货源渠道，使产品价格更具竞争力！" width="950" height="152" /></a>
   </div>
<div id="page_main" class="clearfix">
<div class="page-left">


	
      <div class="left-products">
        
		
        <div class="ddsmoothmenu-v" id="LeftMenu">
          <?php echo ($leftmenu); ?>
        </div>
      </div>
	
	  
	  
      <div class="left-search">
        <h2><span>站内搜索</span></h2>
        <form action="<?php echo U('Home/search/search');?>" method="post" id="sitesearch" name="sitesearch">
          <p>
            <select name="searchid" id="searchid">
              <option value="product">产品展示</option>
              <option value="article">新闻中心</option>
              <option value="job">招聘信息</option>
            </select>
          </p>
          <p>
            <input name="searchtext" type="text" id="searchtext"/>
          </p>
          <p>
            <input name="searchbutton" type="submit" id="searchbutton" value="" />
          </p>
        </form>
      </div>
	  <div class="left-contact">
        <h2><span>会员</span></h2>
		
		<?php if(!empty($islogin)): ?><div>
		用户名 : <?php echo ($space['username']); ?> <input type="button" value="退出" onclick="window.location.href='<?php echo U('Public/logout');?>'" />
		</div>	
		
		<?php else: ?>
			
		<form action="<?php echo U('Public/loginsubmit');?>" method="post" style="padding-left:20px;">
		 用户名 <input type="text" name="username" style="margin-bottom:10px; margin-top:10px;" /><br />
		 密&nbsp;&nbsp;&nbsp;码 <input type="password" name="password" /><br />
		 <input type="button" onclick="window.location.href='<?php echo U('Public/reg');?>'"  value="注册" style=" margin-top:10px;" />
		 <input type="submit"  value="登录" style=" margin-left:100px; margin-top:10px;" />
		</form><?php endif; ?>
		
        
      </div>
      <div class="left-contact">
        <h2><span>联系我们</span></h2>
        <?php echo ($content_4); ?>
      </div>
      <img width="240" height="59" alt="联系我们" src="../Public/images/tel.gif">
    </div>
  <div class="page-right">
   <div class="site-nav"><span>当前位置 : </span><?php echo ($location); ?></div>
   <div class="page-products">
   <div class="head-search">
  <div class="ss f_l">产品搜索：</div>
  <div class="ssk f_l">
    <form class="f_l" method="get" action="<?php echo U('Product/index',array('sid'=>$sort['id']));?>">
      <input type="text" class="txt-keyword" id="key" name="key"/>
     <!--  <input type="image" src="../Public/images/cp_ss.jpg" class="btn-search" /> -->
	  <input type="submit" style="background:url(../Public/images/cp_ss.jpg);" value="" class="btn-search" />
      </form>
    <div class="right_tb f_r">
       <ul>
          <li><a href="<?php echo ($surl); ?>"> <img src="../Public/images/lbt.jpg" /></a></li>
          <li><a href="<?php echo ($kurl); ?>"> <img src="../Public/images/slt.jpg" /></a></li>
       </ul>
    
   
    </div>
  </div>
  <div style="clear:both;"></div>
</div>
   
   
   
     <ul class="clearfix" id="ShowImages">
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>
        <div class="images_img">
         <a href="<?php echo ($item["url"]); ?>" title="<?php echo ($item["title"]); ?>"><img src="<?php echo ($site_url); ?>/<?php echo ($item["pic"]); ?>" alt="<?php echo ($item["title"]); ?>" /></a>
        </div>
        <div class="images_title"><a href="<?php echo ($item["url"]); ?>" title="<?php echo ($item["title"]); ?>"><?php echo ($item["title"]); ?></a></div>
       </li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
    <div class="page_list"><?php echo ($page); ?></div>
   </div>
  </div>

</div>
<div id="copyright"> 
test test test
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