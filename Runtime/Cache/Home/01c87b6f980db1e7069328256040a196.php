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

  	

 

<div class="nymes">
<img src="../Public/images/mes.jpg" />    		
</div>
 <div class="nyk gg"><div class="nynr"><p><?php echo ($current_sort['name']); ?></p></div></div>
<div class="main">
<div class="gao"></div>
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
      <div class="page-guestbook">
<script type="text/javascript">
function check()
{
	if(document.guestbook.Guest_Name.value=="")
	{
		alert("请填写您的姓名");
		document.guestbook.Guest_Name.focus();
		return false
	}

	if(document.guestbook.Guest_Email.value=="")
	{
		alert("请填写邮件地址");
		document.guestbook.Guest_Email.focus();
		return false
	}
	if(document.guestbook.Content.value=="")
	{
		alert("请填写反馈内容");
		document.guestbook.Content.focus();
		return false
	}
	if(document.guestbook.checkcode.value=="")
	{
		alert("请填写验证码");
		document.guestbook.checkcode.focus();
		return false
	}
	if(document.guestbook.checkcode.value.length<4)
	{
		alert("验证码必须为4位");
		document.guestbook.checkcode.focus();
		return false;
	}
	//var re = /^[0-9]+.?[0-9]*$/;//判断字符串是否为数字
	var re = /^[1-9]+[0-9]*]*$/;//判断字符串是否为正整数
	if (!re.test(document.guestbook.checkcode.value))
	{
		alert("验证码必须是数字");
		document.guestbook.checkcode.focus();
		return false;
	}
	 
	return true;
}
</script>
      <form class="clearfix" onsubmit="return check()" action="<?php echo U('Message/doSaveMessage');?>" id="guestbook" name="guestbook" method="post">
      <dl class="lhbd clearfix lhbdfl">
      <dt><label>您的姓名：</label>
      <input type="text" id="Guest_Name" name="Guest_Name"><span style="color:#F00;">&nbsp;&nbsp;*</span></dt>
      <dt><label>联系邮件：</label>
      <input type="text" id="Guest_Email" name="Guest_Email"><span style="color:#F00;">&nbsp;&nbsp;*</span></dt>
      <dt><label>联系电话：</label>
      <input type="text" id="Guest_TEL" name="Guest_TEL"></dt>
      <dt><label>联系地址：</label>
      <input type="text" id="Guest_ADD" name="Guest_ADD"></dt>
      <!--<dt><label>传真：</label>
      <input type="text" id="Guest_FAX" name="Guest_FAX"></dt>
      
      <dt><label>邮编：</label>
      <input type="text" id="Guest_ZIP" name="Guest_ZIP"></dt>
      -->
      </dl>
      <dl class="lhbd clearfix lhbdfr">
      	<dt ><label>留言内容：</label>
      <textarea id="Content" class="Content" rows="" cols="" name="Content"></textarea></dt>
      <dt class="yzm" sty><label>验证码：</label>
      
        <input type="text" autocomplete="off" maxlength="4" id="checkcode" name="checkcode">
        <img  src='__APP__/Public/verify/' />
        <span>&nbsp;&nbsp;*点击图片刷新</span>
      </dt>
      </dl>
      <div class="clear"></div>
      <p style=" text-align: center;"><input type="submit" class="submit" value="提交" id="submit" name="submit" style=" width: 110px; display: inline-block;"><input type="reset" class="lh615" name="button" id="button" value="重置"  style="display: inline-block; width: 110px;"/></p>
      </form>
      </div></div>
      
    </div>
    

	
  </div></div>



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