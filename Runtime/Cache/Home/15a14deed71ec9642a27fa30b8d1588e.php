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
<div class="header_s">
 <div class="header_snr gg"></div>
</div>
<div class="header gg">
 <div class="logo fl"><img src="../Public/images/index_06.jpg" /></div>
<div class="tel fr"><img src="../Public/images/index_03.jpg" /></div>
 <br class="clear" />
</div>
 <div class="daohang"><div class="daohang_nr gg"><div class="glable_nav">
  <div id="nav-menu">
    <div class="container">
      <div class="outerbox">
        <div class="innerbox clearfixmenu">
          <ul class="menu">
            <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('Index/index',array('sid'=>530));?>" class="xialaguang" title="首页" style=" background-color:#318dde; color:#000;"><span>首页</span></a></div>
            </li>
            <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('About/index',array('sid'=>533));?>" class="xialaguang" title="关于我们"><span>关于我们</span></a></div>
              <ul class="children clearfixmenu pngFix">
                <div class="daohang_left">
                  <dl>
				  
				        <dd><a href="<?php echo listurl('About/index',array('sid'=>602));?>"  title="公司简介">公司简介</a></dd>
	   		        <dd><a href="<?php echo listurl('About/index',array('sid'=>637));?>"  title="企业文化">企业文化</a></dd>
	   		        <dd><a href="<?php echo listurl('About/index',array('sid'=>638));?>"  title="加入我们">荣誉资质</a></dd>
                  </dl>
                </div>
                <div class="daohang_right"><a href="<?php echo listurl('About/index',array('sid'=>668));?>" title="关于我们"><img src="../Public/images/dht.jpg" width="175" height="90" alt="关于我们" /></a></div>
              </ul>
            </li>

            <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('Product/index',array('sid'=>629));?>" class="xialaguang" title="主营业务"><span>主营业务</span></a></div>
              <ul class="children clearfixmenu pngFix">
                <div class="daohang_left">
                  <dl>
				  
				    <dd><a href="<?php echo listurl('Product/index',array('sid'=>630));?>"  title="金矿物流">金矿物流</a></dd>
	   		        <dd><a href="<?php echo listurl('Product/index',array('sid'=>631));?>"  title="韩日订舱">韩日订舱</a></dd>
	   		        <dd><a href="<?php echo listurl('Product/index',array('sid'=>632));?>"  title="国际运输">国际运输</a></dd>
                    <dd><a href="<?php echo listurl('Product/index',array('sid'=>633));?>"  title="报关报检">报关报检</a></dd>
	   		        <dd><a href="<?php echo listurl('Product/index',array('sid'=>634));?>"  title="矿机物流">矿机物流</a></dd>
	   		        <dd><a href="<?php echo listurl('Product/index',array('sid'=>635));?>"  title="散货船进出口">散货船进出口</a></dd>
                  </dl>
                </div>
                <div class="daohang_right"><a href="<?php echo listurl('About/index',array('sid'=>668));?>" title="主营业务"><img src="../Public/images/ywdht.jpg" width="175" height="90" alt="主营业务"  style="margin-top:55px;"/></a></div>
              </ul>
            </li>
                <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('Picture/index',array('sid'=>532));?>" class="xialaguang" title="工程案例"><span>工程案例</span></a></div>
            </li>
                        <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('Article/index',array('sid'=>601));?>" class="xialaguang" title="行业动态"><span>行业动态</span></a></div>
                           <ul class="children clearfixmenu pngFix">
                <div class="daohang_left">
                  <dl>
				  
				    <dd><a href="<?php echo listurl('Article/index',array('sid'=>603));?>"  title="公司新闻">公司新闻</a></dd>
	   		        <dd><a href="<?php echo listurl('Article/index',array('sid'=>639));?>"  title="货运百科">货运百科</a></dd>
	   		        <dd><a href="<?php echo listurl('Article/index',array('sid'=>604));?>"  title="行业资讯">行业资讯</a></dd>

                  </dl>
                </div>
                <div class="daohang_right"><a href="<?php echo listurl('About/index',array('sid'=>668));?>" title="主营业务"><img src="../Public/images/xwdht.jpg" width="175" height="90" alt="主营业务" ></a></div>
              </ul>
            </li>
            <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('Message/index',array('sid'=>536));?>" class="xialaguang" title="在线留言"><span>在线留言</span></a></div>
            </li>
            <!--11111-->
            <li class="stmenu">
              <div class="nav01"><a href="<?php echo listurl('About/index',array('sid'=>537));?>" class="xialaguang" title="联系我们"><span>联系我们</span></a></div>
            </li>
            <!--11111-->
          </ul>
          <script type="text/javascript">
$('#nav-menu .menu > li').hover(function() {
$(this).find('.children').animate({ opacity:'show', height:'show' },200);
$(this).find('.xialaguang').addClass('navhover');
}, function() {
$('.children').stop(true,true).hide();
$('.xialaguang').removeClass('navhover');
}
).slice(-1,-3).find('.children').addClass('sleft');
</script> 
        </div>
      </div>
    </div>
  </div>
  <!-- END 页脚包含 --> 
  <!--导航代码结束--> 
  
  </div>
    </div>
    </div>
</div>

  	

 

<link href="../Public/js/zoom/phzoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../Public/js/zoom/phzoom.js"></script>
<script>
$(function(){

$(".piczoom").phzoom({

        prevText:'上一张',         // 上一张按钮的显示文本, 需要引号
        nextText:'下一张',         // 下一张按钮的显示文本, 需要引号
        navColor:'#FFFFFF',         // 上/下一张按钮的文本颜色, 需要引号
        capColor:'#FFFFFF'         // 大图底部标题与索引的文本颜色, 需要引号
        
  });



});
</script>
<style>
 #piclist li{
 float:left;
 margin-right:10px;
 }
</style>

<div class="nyban"><img src="../Public/images/pro.jpg"></div>
<div class="main">
<div class="gao"></div>

<div id="page_main" class="clearfix">
    <div class="container">
      <div class="page-right">
      <div class="site-nav"><span>当前位置 : </span><?php echo ($location); ?></div>
      <div class="page-news">
        <div id="shownews">
            <h1 class="title"><?php echo ($title); ?></h1>
			<?php echo ($qrcode); ?>
            <div class="text editor">
			  <div id="piclist" class="product-nav">
			  		<!--<ul>
					    <?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site_url); ?>/<?php echo ($pic["org"]); ?>" title="<?php echo ($pic["desc"]); ?>" class="piczoom"><img width="200"  src="<?php echo ($site_url); ?>/<?php echo ($pic["filepath"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>-->
					<div style="clear:both;"></div>
			  </div>
			 

			
			<?php echo ($content); ?>
			</div>
			<div class="hits">更新时间：<?php echo (date("y/m/d H:i:m",$dateline)); ?>&nbsp;&nbsp;【<a href="javascript:window.print()">打印此页</a>】&nbsp;&nbsp;【<a href="javascript:self.close()">关闭</a>】</div>
            
			<div class="page">
			
			上一条：<?php if(!empty($pre)): ?><a href="<?php echo ($pre['url']); ?>"><?php echo ($pre['title']); ?></a><?php else: ?>没有了<?php endif; ?><br>
			下一条：<?php if(!empty($next)): ?><a href="<?php echo ($next['url']); ?>"><?php echo ($next['title']); ?></a><?php else: ?>没有了<?php endif; ?></a>
			
			</div>

			<h4 class="related">相关图片</h4>
			    <ul class="related-list">

					<?php if(is_array($relate)): $i = 0; $__LIST__ = $relate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$relate): $mod = ($i % 2 );++$i;?><li><a target="_blank" title="<?php echo ($relate["title"]); ?>" href="<?php echo ($relate['url']); ?>"><?php echo ($relate['title']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    

                </ul>
				<div class="clear"></div>

        </div>
      </div>
     
 </div>
   <div class="ny-l fl">
<div class="ny-lnr">
<div class="list">
 <div class="listbt">
 <img src="../Public/images/nydh.jpg" />
</div>
 <div class="listnr"><div class="ddsmoothmenu-v" id="LeftMenu">
          <?php echo ($leftmenu); ?>
        </div></div>
       
</div>

</div>
 <div class="dianhua"><!--<img src="../Public/images/dh.jpg" />--></div>
      
</div>
    <br class="clear" />
    </div>
    
	
  </div>
 <div class="main_d">
 <div class="main_dnr gg">
 <div class="main_dz fl"><?php echo ($content_4); ?></div>
 <div class="main_dy fr">
 <ul>
  <li>
  <p>关于我们</p>
  <span><a href="<?php echo listurl('About/index',array('sid'=>602));?>">公司简介</a></span>
  <span><a href="<?php echo listurl('About/index',array('sid'=>637));?>">企业文化</a></span>
  <span><a href="<?php echo listurl('About/index',array('sid'=>638));?>">资质荣誉</a></span>

  <span><a href="<?php echo listurl('About/index',array('sid'=>537));?>">联系我们</a></span>
  </li>
    <li>
  <p>主营业务</p>
  <span><a href="<?php echo listurl('Product/index',array('sid'=>630));?>" >金矿物流</a></span>
  <span><a href="<?php echo listurl('Product/index',array('sid'=>631));?>" >韩日订舱</a></span>
  <span><a href="<?php echo listurl('Product/index',array('sid'=>632));?>" >国际运输</a></span>
  <span><a href="<?php echo listurl('Product/index',array('sid'=>633));?>" >报关报检</a></span>
  <span><a href="<?php echo listurl('Product/index',array('sid'=>634));?>" >矿机物流</a></span>
  <span><a href="<?php echo listurl('Product/index',array('sid'=>635));?>" >散货船进出口</a></span>
  </li>
  <li>
  <p>新闻资讯</p>
  <span><a href="<?php echo listurl('Article/index',array('sid'=>603));?>">公司新闻</a></span>
  <span><a href="<?php echo listurl('Article/index',array('sid'=>639));?>">货运百科</a></span>
  <span><a href="<?php echo listurl('Article/index',array('sid'=>604));?>">行业资讯</a></span>
  <span><a href="<?php echo listurl('Message/index',array('sid'=>536));?>">在线留言</a></span>

  </li>
 </ul>
 </div>
 <br class="clear" />
  
 </div>
</div>


<div class="footer">

 <div class="foot gg1">
 
  <div class="foot_nr">鲁ICP备16032492号-1  Copyright © 2016山东骏达国际货运代理有限公司</div>
<?php if(empty($GLOBALS['_city_name'])): ?><div class="link clear">友情链接：<?php if(is_array($flink)): $i = 0; $__LIST__ = $flink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><a href="http://<?php echo ($l["url"]); ?>"><?php echo ($l["linkkeyword"]); ?></a>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?></div><?php endif; ?>
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