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
<script type="text/javascript" src="../Public/js/jquery.min.js"></script>
<script type="text/javascript" src="../Public/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
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

  	

 


	<div class="banner clearfix">
		<img style="max-width:100%; text-align:center;" src="../Public/images/1.jpg"/>
		<ul>
			<li style="opacity: 1;">
				<img src="../Public/images/1.jpg"/>
			</li>
			<li >
				<img src="../Public/images/2.jpg"/>
			</li>
			<li >
				<img src="../Public/images/3.jpg"/>
			</li>
		</ul>
	</div>
		<script>
			$(function(){
				var swiper = $(".banner ul li");
				var iSize = swiper.size();
				var iNow = 0;
				
				
				timer = setInterval(function(){
						iNow++;
						if(iNow>iSize-1) iNow=0;
						move();
					},3500)
				function move(){
					swiper.eq(iNow).siblings().animate({
						opacity:0
					},1200).find("div").animate({
						opacity:0,
						top:170
					});
					swiper.eq(iNow).animate({
						opacity:1
					},1200).find("div").animate({
						opacity:1,
						top:150
					});
				}
			})
		</script>
<div class="main_s">
 <div class="main_snr gg">
  <div class="pro_nr">
  <ul class="clearfix">
		 <?php $_list=getItems(532,10,0);if(!empty($_list)){foreach($_list as $k=>$item){?><li><a href="<?php echo ($item["url"]); ?>" title="<?php echo ($item["title"]); ?>"><p><img src="<?php echo ($item["pic"]); ?>" alt="<?php echo ($item["title"]); ?>" width:"260" height="181" /></p><span><?php echo ($item["title"]); ?></span></a></li><?php }}?>
        </ul>
  </div>
  <div class="gengduo"><a href="<?php echo listurl('Product/index',array('sid'=>532));?>">查看更多+</a></div>
 </div>
</div>
<div class="celiang"></div>
<div class="main_m">
 <div class="main_mnr gg"><div class="main_mk">
  <div class="about_k">
   <div class="about_p fl"><p><img src="../Public/images/index_11.jpg" /></p></div>
   <div class="about fr">
    <div class="about_bt"><img src="../Public/images/about_bt.jpg" /></div>
    <div class="about_nr"><?php echo ($content_1); ?></div>
    <div class="rongyu"><img src="../Public/images/index_14.jpg" /></div>
   </div>
   <br class="clear" />
  </div>
 
 </div></div>
</div>
<div class="main_x">
<div class="ge"></div>
  <div class="main_xk gg">
   <div class="xinwen_z fl">
    <ul>
     <li><a href="<?php echo listurl('Article/index',array('sid'=>604));?>">行业新闻</a></li>
     <li><a href="<?php echo listurl('Article/index',array('sid'=>603));?>">立民资讯</a></li>
     <li><a href="<?php echo listurl('Article/index',array('sid'=>639));?>">精彩活动</a></li>
     <li><a href="<?php echo listurl('Message/index',array('sid'=>536));?>">在线留言</a></li>
     <li><a href="<?php echo listurl('About/index',array('sid'=>537));?>">联系我们</a></li>
    </ul>
   </div>
   <div class="xinwen_y fr">
    <div class="hangye fl">
     <div class="hangye_p">
      <img src="../Public/images/index_19.jpg" />
     </div>
     <div class="hangye_nr">
            <ul>
  <?php $_list=getItems(603,1,0);if(!empty($_list)){foreach($_list as $k=>$item){?><li><span>
			<p class="xwbt"><a  href="<?php echo ($item['url']); ?>"><?php echo msubstr($item['title'],0,15);?></a></p>
			<p style="padding-top:20px; line-height:22px;"><?php echo msubstr(strip_tags($item['content']),0,50);?></p>
            <p><a class="xwa"  href="<?php echo ($item['url']); ?>">查看更多</a></p>
		</span>
        </li>
        <br class="clear" /><?php }}?>
</ul>
      </div>
    </div>
     <div class="shuxian fl"></div>
    <div class="news fr">
    <ul>
   <?php $_list=getItems(601,3,0);if(!empty($_list)){foreach($_list as $k=>$item){?><li>
		<span class="new_pic"><img src="<?php echo ($item['pic']); ?>"/></span>
		
		<span class="fr new_wz">
			<p><a href="<?php echo ($item['url']); ?>"><?php echo msubstr($item['title'],0,25);?></a></p>
			<p style="padding-top:5px; line-height:22px;"><?php echo msubstr(strip_tags($item['content']),0,50);?></p>
		</span>
        <br class="clear" />
        </li><?php }}?>
        </ul>
    </div>
    <br class="clear" />
   </div>
   <br class="clear" />
  </div>
</div>
<div class="anli_bt"> <img src="../Public/images/index_23.jpg" /></div>
<div class="anli_k">
<div class="anli gg">
 <div class="anli_wz"><img src="../Public/images/kaiti.jpg" /></div>
 <div class="anli_nr">
 <img src="../Public/images/pic.jpg" />
 </div>
</div>
</div>
<div class="link">
<div class="link_n gg">
<?php if(empty($GLOBALS['_city_name'])): ?><div id="friendlink">
友情链接：
<?php if(is_array($flink)): $i = 0; $__LIST__ = $flink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><a href="http://<?php echo ($l["url"]); ?>" target="_blank"><?php echo ($l["linkkeyword"]); ?></a>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
</div><?php endif; ?>
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