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


<div id="index_main" class="clearfix">
    <div class="index-left">
      <div class="index-newproducts">
        <h2><span>推荐产品</span><a href="products.html"><img src="../Public/images/more.gif" width="32" height="5" alt="产品展示" /></a></h2>
        <!--滚动产品开始-->
        <div class="productsroll">
          <div id="LeftArr1"></div>
          <div id="RightArr1"></div>
          <ul id="ScrollBox" class="clearfix">
		  	<!--sortid为栏目ID ，limit为显示条数,  istop为是否置顶推荐-->
			<?php $_list=getItems(587,'8',1);if(!empty($_list)){foreach($_list as $k=>$item){?><li><a href="<?php echo ($item["url"]); ?>" title="<?php echo ($item["title"]); ?>"><img src="<?php echo ($item["pic"]); ?>" alt="<?php echo ($item["title"]); ?>" width="140" height="100" /><span><?php echo ($item["title"]); ?></span></a></li><?php }}?>
		  
			
          </ul>
          <script language="javascript" type="text/javascript">
			<!--//--><![CDATA[//><!--
			var scrollPic_01 = new ScrollPic();
			scrollPic_01.scrollContId   = "ScrollBox"; //内容容器ID
			scrollPic_01.arrLeftId      = "LeftArr1";//左箭头ID
			scrollPic_01.arrRightId     = "RightArr1"; //右箭头ID
			scrollPic_01.frameWidth     = 648;//显示框宽度
			scrollPic_01.pageWidth      = 162; //翻页宽度
			scrollPic_01.speed          = 10; //移动速度(单位毫秒，越小越快)
			scrollPic_01.space          = 5; //每次移动像素(单位px，越大越快)
			scrollPic_01.autoPlay       = true; //自动播放
			scrollPic_01.autoPlayTime   = 3; //自动播放间隔时间(秒)
			scrollPic_01.initialize(); //初始化
			//--><!]]>
		  </script>
        </div>
        <!--滚动产品结束-->
      </div>
      <div class="index-news">
        <h2><span>新闻中心</span><a href="news.html"><img src="../Public/images/more.gif" width="32" height="5" alt="新闻中心" /></a></h2>
         <!--新闻开始-->
		
		 
        <ul>
		  <!--sortid为栏目ID ，limit为显示条数-->
		  <?php $_list=getItems(427,'8',0);if(!empty($_list)){foreach($_list as $k=>$item){?><li><a href="<?php echo ($item["url"]); ?>" title="<?php echo ($item["title"]); ?>"><span><?php echo ($item['dateline']); ?></span>-　<?php echo ($item["title"]); ?></a> </li><?php }}?>
		        
        </ul>
         <!--新闻结束-->
      </div>
      <div class="index-about">
        <h2><span>关于我们</span><a href="single.html"><img src="../Public/images/more.gif" width="32" height="5" alt="关于我们" /></a></h2>
        <!--公司简介开始-->
        <?php echo ($content_1); ?>
        <!--公司简介结束-->
      </div>
      <div class="index-products">
        <h2><span>产品展示</span><a href="products.html"><img src="../Public/images/more.gif" width="32" height="5" alt="产品展示" /></a></h2>
        <!--产品多行显示开始-->
        <ul class="clearfix">
		 <?php $_list=getItems(429,'8',0);if(!empty($_list)){foreach($_list as $k=>$item){?><li><a href="<?php echo ($item["url"]); ?>" title="<?php echo ($item["title"]); ?>"><img src="<?php echo ($item["pic"]); ?>" alt="<?php echo ($item["title"]); ?>" width="140" height="100" /><span><?php echo ($item["title"]); ?></span></a></li><?php }}?>
        </ul>
        <!--产品多行显示结束-->
      </div>
    </div>
    <div class="index-right">
      <div class="index-search">
        <h2><span>站内搜索</span></h2>
        <!--站内搜索开始-->
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
        <!--站内搜索结束-->
      </div>
      <div class="index-jobs">
        <h2><span>招聘信息</span><a href="jobs.html"><img src="../Public/images/more.gif" width="32" height="5" alt="招聘信息" /></a></h2>
        <!--招聘信息开始-->
        <ul>
          <?php if(is_array($job)): $i = 0; $__LIST__ = $job;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($jo["url"]); ?>" title="<?php echo ($jo["title"]); ?>"><span>　-　<?php echo ($jo["title"]); ?></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!--招聘信息结束-->
      </div>
	  
	  <item sortid="job" limit="1">
	  </item>
	  
      <div class="index-contact">
        <h2><span>联系我们</span></h2>
        <?php echo ($content_4); ?>
      </div>
      <img src="../Public/images/tel.gif" width="240" height="59" alt="联系我们" /> </div>
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