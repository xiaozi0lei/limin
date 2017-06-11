<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0  "><!--响应式站必须用的meta标签，如果不需要响应 追加 user-scalable=no 即可禁止-->
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

<script>
var site_url='<?php echo U('/');?>';
var tpl_path='<?php echo (APP_TMPL_PATH); ?>';
var public = '__PUBLIC__';
var mobile = '<?php echo ($wapon); ?>';
</script>
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
</head>
<body>

  <div class="header container">
  
  <div class="logo "> <A href="#"><img src="../Public/images/logo.jpg"  /></A><p class="visible-desktop">专业从事<b>聚氨酯建筑节能</b>系列产品研发、生产和销售的企业
致力于为客户提供最理<b>建筑节能</b>解决方案</p></div>
<div class="head-top-r">
		<div class="guangwang">欢迎进入公司官网：<a href="http://www.wanhuaib.com/" target="_blank">www.wanhuaib.com</a></div>
		<div class="tel">
		<a href="tel:4000591116">
			<img src="../Public/images/tel.jpg"/>
		</a>
		</div>
		<div class="e-mail">Email:linaE@whchem.com</div>
	</div>
</div>	
  <div class="nav-box" >
  <div class="nav-pc">
    <div class="hidden-desktop hamburger hamburger--emphatic-r">
	<div class="hamburger-box">
	  <div class="hamburger-inner"></div>
	</div>
  </div> 
  
  <div class="mobile_nav " id="mnav">
  <?php echo ($menu); ?>
   </div>
   <div class="lh68 hidden-desktop" style="padding-left: 50px; height:50px ; overflow: hidden;"><?php echo ($menu); ?></div>
    </div>
   
  
  
  </div>
  <!--手机导航-->
  <script>
	var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

	var hamburgers = document.querySelectorAll(".hamburger");
	if (hamburgers.length > 0) {
	  forEach(hamburgers, function(hamburger) {
		hamburger.addEventListener("click", function() {
		  this.classList.toggle("is-active");
		  $(this).toggleClass("lhcd")
		 $(".mobile_nav").slideToggle(300)
		}, false);
		//document.getElementById("mnav").addEventListener("click", function(){
// hamburger.classList.toggle("is-active");
 // $(".hamburger").toggleClass("lhcd")
		// $(this).slideToggle()
//});
	  });
	}
  </script>
 
  <div class="banner">
  
 

  <div id="home_slider" class="flexslider">
                            	<ul class="slides">
                                	
                                    <li>
                                    	<div class="slide">
                                            <img src="../Public/images/1.jpg" alt=""  />
                                           
                                        </div>
                                    </li>
                                    
                                    <li style=" display:none">
                                    	<div class="slide">
                                            <img src="../Public/images/2.jpg" alt=""  />
                                            
                                        </div>
                                    </li>
                                    
                                   <li style=" display:none">
                                    	<div class="slide">
                                            <img src="../Public/images/3.jpg" alt=""  />
                                            
                                        </div>
                                    </li>
                                    
                                    
                                </ul>
                            </div>
                            	  
                            <script type="text/javascript">
							
								$(function () {
									$('#home_slider').flexslider({
										animation : 'fade',
										controlNav : true,
										directionNav : true,
										animationLoop : true,
										slideshow :true,
										useCSS : false,
										slideshowSpeed: 4000,           
                                        animationDuration: 1000,
									});
									
								});
							</script>
   
   </div>

   
<div id="page_main" class="clearfix">
 <div class="container">
   <div class="site-nav"><span>当前位置 : </span><?php echo ($location); ?></div>
   <div class="page-news">
    <div id="shownews">
      <h1 class="title"><?php echo ($title); ?></h1>
	  
      <div class="text editor">
		<ul class="download clearfix">
          <li class="downloadLeft">文件名称：<?php echo ($title); ?> </li>
          <li class="downloadLeft">上传时间：<?php echo (date("y/m/d",$dateline)); ?> </li>
          <li class="downloadLeft">下载地址：<a href="<?php echo U('Download/doDownload',array('id'=>$id));?>">下载</a> </li>
         
        </ul>	
		<?php echo ($content); ?>
	  </div>
	  <div class="clear"></div>
     </div>
   </div>
 </div>

</div>
<div id="copyright"> 
<div class="foot container">
<div class="foot-logo"><img src="../Public/images/foot-logo.jpg"></div>
<div class="foot-content">
万华节能科技（烟台）有限公司|版权所有 鲁ICP备15008065号-1  <br /> 本站部分图片和内容来源于网络，版权归原作者或原公司所有，如果您认为我们侵犯了您的版权请告知我们将立即删除
</div></div>
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