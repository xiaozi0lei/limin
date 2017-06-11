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

  	

 

<script src="__PUBLIC__/js/artDialog/jquery.artDialog.js?skin=<?php echo ($shop["dio"]); ?>"></script>
<script src="__PUBLIC__/js/artDialog/plugins/iframeTools.js"></script>
<script>
function show_card(pid){
	art.dialog.open(site_url+'Public/buy/id/'+pid);
}
</script>
<div id="page_main" class="n_content">
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
     <div class="n_content_right fr">
  <div class="page-right">
   <div class="n_content_right_s"><p><span>当前位置：</span><?php echo ($location); ?></p></div>
   <div class="head-search">
  <div class="ss f_l">产品搜索：</div>
  <div class="ssk f_l">
      <form class="f_l" method="get" action="<?php echo U('Product/index',array('sid'=>$sort['id']));?>">
      <input type="text" class="txt-keyword" id="key" name="key"/>
	  <input value="1" type="hidden"  name="style"/>
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


   <!--产品列表页-->
   <div class="lbtu"  >
      <ul class="lbtup">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li style="border-bottom: 1px solid #f2f2f2;"><div class="lbtu_left fl"><a href="<?php echo ($list["url"]); ?>" title="<?php echo ($list["title"]); ?>"><img src="<?php echo ($site_url); ?>/<?php echo ($list["pic"]); ?>" alt="<?php echo ($list["title"]); ?>" /></a></div>
             <ul class="lbtu_right fr">
                <li><div class="bt"><a href="<?php echo ($list["url"]); ?>" title="<?php echo ($list["title"]); ?>" ><?php echo (msubstr($list["title"],0,12)); ?></a></div>
                  <div class="wenzi"><span style=" color:#2e5457; font-weight:bold;">分类：</span><span id="sort" style="font-size:12px; line-height:22px;"><?php echo ($list['name']); ?></span></div>
                 <div class="wenzi"><a href="<?php echo ($list["url"]); ?>">[查看详情]</a></span></div>
                 </li>
                <li style="text-align:center; padding-left:60px;"><p style=" line-height:30px; height:30px;"><span style="font-weight:bold; font-size:12px;"> 价格：</span><span id="price" style="font-weight:bold; color:#FF0000; font-size:17px;">￥<?php echo ($list["price"]); ?></span></p></li>
                
				<?php if(!empty($shop['shop_swich'])): ?><li style="padding-left:75px; float:right;"> <span>
                  <input type="button" value="立即购买" style=" background:url(../Public/images/list_anniu.jpg); padding:4px;display: block;text-align: center;color: #fff;margin-top:10px; font-size:12px; width:70px;" onclick="show_card(<?php echo ($list["id"]); ?>);">
                  <input type="button" value="加入购物车" style=" background:url(../Public/images/list_anniu.jpg); padding:4px;display: block;text-align: center;color: #fff;margin-top:10px; font-size:12px; width:70px;" onclick="show_card(<?php echo ($list["id"]); ?>);">
				  
                </li><?php endif; ?>
           		
                 <div class="clear"></div>
               
             </ul>
           <div class="clear"></div>
             </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <div class="clear"></div>
  <div class="page_list"><?php echo ($page); ?></div>
</div>

  </div>
  </div>
<div class="clear"></div> 
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