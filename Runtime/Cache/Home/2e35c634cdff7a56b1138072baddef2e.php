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
<div class="header gg">
 <div class="logo fl"><img src="../Public/images/index_05.jpg" /></div>
 <div class="y fr"><div class="tel"><img src="../Public/images/index_09.jpg" /></div><div class="sousuo"><form action="<?php echo U('Home/search/search');?>" method="post" id="sitesearch" name="sitesearch">
          <p style="display:none;">
            <select name="searchid" id="searchid">
              <option value="product">产品展示</option>
            </select>
          </p>
		  <div class="sskuang fl">

            <input name="searchtext" type="text" id="searchtext" class="txt-keyword" value="请输入要搜索的内容"  />
</div>
		  <div class="anniuk fl">

            <input name="searchbutton" class="anniu" type="submit" id="searchbutton" value=""  style="background:url(../Public/images/fdj.jpg); width:29px; height:25px;"/>
</div><br class="clear" />
        </form></div></div>
 <br class="clear" />
</div>
 <div class="haohang"><div class="daohang_nr gg"><div class="nav-pc">
     
  
  <div class="mobile_nav " id="mnav">
  <?php echo ($menu); ?>
   </div>
  
    </div>
    
    <br class="clear" />
    </div>
    
    </div>
</div>

  	

 

<style>
.page-guestbook dl dd input{
width:auto;
vertical-align:middle;
}
</style>
<div class="nyban"><img src="../Public/images/pro.jpg"></div>
<div class="main">
<div class="gao"></div>
<div id="page_main" class="clearfix">
  <div class="container">
    <div class="page-right">
      <div class="site-nav"><span>当前位置 : </span>
	  
		<?php echo ($location); ?>
	  
	  </div>
      <div class="page-news">
      <table border="0" align="center">
      <tr><th class="news-time">日期</th><th class="news-title">标题</th></tr>

		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr>
		<td class="time-list"><span><?php echo (date("y/m/d",$li['dateline'])); ?></span></td><td><a href="<?php echo ($li["url"]); ?>" title="<?php echo ($li["title"]); ?>"><?php echo ($li["title"]); ?></a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		
			  </table>
		<div class="page_list"><?php echo ($page); ?></div>
      </div>
    </div>
    
	 <div class="ny-l fl">
<div class="ny-lnr">
<div class="list">
 <div class="listbt">
    		
        	<img src="../Public/images/nydh.jpg" /></div>
 <div class="listnr"><div class="ddsmoothmenu-v" id="LeftMenu">
          <?php echo ($leftmenu); ?>
        </div></div>
       
</div>

</div>
 <div class="dianhua"><img src="../Public/images/dh.jpg" /></div>
      
</div>
    <br class="clear" />
 </div>

  </div>
 <div class="footer gg">
 <div class="foot">
  <div class="footz fl"><?php echo ($content_4); ?></div>
  <div class="footy fr"><img src="../Public/images/index_32.jpg" /></div>
  <div class="banquan clear"><img src="../Public/images/banquan.gif" /></div>
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