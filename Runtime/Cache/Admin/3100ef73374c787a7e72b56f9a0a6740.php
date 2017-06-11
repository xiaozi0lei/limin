<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="__PUBLIC__/css/edit.css" rel="stylesheet" type="text/css">
<title>聚合营销管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" />
<link href="__PUBLIC__/css/style1.css" rel="stylesheet" type="text/css" />
<script>
var public_path='__PUBLIC__';
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/index.js"></script>
<script type="text/javascript" src="__PUBLIC__/images/index.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bigpicroll.js"></script>

<script type="text/javascript">

<!--
function SetCookie(name,value)//两个参数，一个是cookie的名子，一个是值 
	{
	    var Days = 7; //此 cookie 将被保存 30 天
	    var exp = new Date();    //new Date("December 31, 9998");
	    exp.setTime(exp.getTime() + Days*24*60*60*1000);
	    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}
function CheckForm()
{
	if(document.Login.username.value=="")
	{
		alert("请输入用户名！");
		document.Login.username.focus();
		return false;
	}
	if(document.Login.password.value == "")
	{
		alert("请输入密码！");
		document.Login.password.focus();
		return false;
	}
	if (document.Login.s.value==""){
       alert ("请输入您的验证码！");
       document.Login.s.focus();
       return(false);
    }
    if (document.Login.isguanjia.value!="no"){
    	var New=document.getElementsByName("type");  //获取radio的值
        var strNew;
        for(var i=0;i<New.length;i++){
    		if(New.item(i).checked){
	    		strNew=New.item(i).getAttribute("value");  
                break;
            }
    	}
	    if (document.Login.SavePwd.checked){
	    	SetCookie("AdminUserName2",document.Login.username.value);
	    	SetCookie("AdminUserPwd2",document.Login.password.value);
		    SetCookie("AdminUserType",strNew);
	    	}
	    if (!document.Login.SavePwd.checked){
	    	SetCookie("AdminUserName2","");
	    	SetCookie("AdminUserPwd2","");
	    	SetCookie("AdminUserType","service");
	    	}
	    }
    }
//-->
</script>
</head>
<body>

<center>
<div class="login-header">
  <div class="login-head">
     <div class="logo fl"><img src="__PUBLIC__/images/login-logo.jpg" /></div>
     <div class="help fr"> <a href="#">系统介绍</a> | <a href="http://www.0535.cc/aboutus.php?fid=8">联系我们</a></div>
     <div class="clear"></div>
  </div>
</div>

  <!-- 代码 开始 -->
<div class="hdwrap">
  <div class="hdflash f_list">
  <div class="flashlist">
    <div class="f_out">
      <a href="#">
        <img src="__PUBLIC__/images/banner1.jpg"  width="100%" height="482" />
      </a>
      
    </div>
    <div class="f_out">
      <a href="#" >
        <img src="__PUBLIC__/images/banner2.jpg" alt="钢铁侠3Iron Man 3 (2013)" title="钢铁侠3Iron Man 3 (2013)"
        width="100%" height="482" />
      </a>
      
    </div>
    <div class="f_out">
      <a href="#" >
        <img src="__PUBLIC__/images/banner3.jpg" width="100%" height="482" />
      </a>
      
    </div>
    <div class="f_out">
      <a href="#" >
        <img src="__PUBLIC__/images/banner4.jpg" width="100%" height="482" />
      </a>
      
    </div>
    <div class="f_out">
      <a href="#" >
        <img src="__PUBLIC__/images/banner5.jpg"  width="100%" height="482"/>
      </a>
      
    </div>
    
  </div>
  <div class="flash_tab">
    <div class="tabs f_tabs" style="width:170px;">
      <ul>
        <li class="f_tab opdiv">
          <a href="javascript:void(0);">
          </a>
        </li>
        <li class="f_tab opdiv">
          <a href="javascript:void(0);">
          </a>
        </li>
        <li class="f_tab opdiv">
          <a href="javascript:void(0);">
          </a>
        </li>
        <li class="f_tab opdiv">
          <a href="javascript:void(0);">
          </a>
        </li>
        <li class="f_tab opdiv">
          <a href="javascript:void(0);">
          </a>
        </li>
      </ul>
    </div>
  </div>

  <script type="text/javascript">
    FeatureList(".f_list", {
      "onclass": "noopdiv",
      "offclass": "opdiv",
      "pause_on_act": "mouseover",
      "interval": 5000,
      "speed": 5
    });
  </script>
</div>
</div>
<!-- 代码 结束 -->
<div class="banner">
<div class="yun">
 <div class="yun1">
 <div class="yun-login">
  <div id="xweb_login" class="cert221 fl">聚合营销管理系统 </div>
  
  <div class="clear"></div>
  <form id="Login" onsubmit="return CheckForm();" action="<?php echo U('Admin/Login/loginsubmit');?>" method="post" target="_parent">

   <div class="cert3">
     <div class="cert33">
         <input type="text" id="login_name" name="username" value=""  
         style="width:245px;height:36px; border:1px solid #ddd; padding-left:10px;
         background:url(__PUBLIC__/images/login_01.jpg) no-repeat 0 0 #fff; color:#555; line-height:36px;" />
         <input type="password" id="login_password" name="password" value=""  style="width:255px; height:36px; border:1px solid #ddd ;text-indent:10px;
         background:url(__PUBLIC__/images/login_02.jpg) no-repeat 0 0 #fff; color:#555; margin-top:10px;line-height:36px;" />
         
		 <div class="cert331"> 
           <div style="float:left; padding-left:70px;">选择语言:</div>
            <div style=" color:#fff; text-align:right;">
            <input name="lang" type="radio" style="margin-top:2px;&gt;margin-top:-2px; position:absolute; padding-left:11px; "  checked="checked"  id="lang" value="zh-cn"   />
           <span style="margin-left:23px; color:#fff;">中文</span>
            <input name="lang" type="radio" style="margin-top:2px;&gt;margin-top:-2px; position:absolute; "  id="lang" value="en-us"   /> <span style="margin-left:22px; color:#fff;">English</span></div>
            </div>
             
             
         </div>
		 
		 
         <div class="cert332">
            <div style="float:left;"><!--<input name="remeber" type="checkbox" style="margin-top:5px;&gt;margin-top:-2px; position:absolute; float:left;" value="yes"   />
           <span style="margin-left:19px; color:#fff;"><?php echo (L("remember")); ?></span>--></div>
            <span style="float:right; color:#fff;"><a href="" onclick="alert('请您与客服联系！')" >忘记密码？</a></span>
         </div>
         <div class="login-button">
           <input type="submit" name="button" value="登录" style="background: #2faeec; border:none; width:255px;
             height:35px; line-height:35px; text-align:center;font-size:14px; color:#fff; font-weight:bold; cursor:pointer;" />
         </div>
       <div class="cert333">注意：1、请不要在公用电脑上保存登录信息。<br />
      2、为保证您的账号安全，退出系统时请注销登录。</div>
     </div>
     <div class="clear">
     </div>
</form>
</div>
</div>
</div>
</div>
<div class="yun-bottom">
   <div class="yun-pc fl" style=" margin-left:65px;_margin-left:45px;">
      <div class="yun-pic fl"><img src="__PUBLIC__/images/login-one.jpg" /></div>
      <div class="fl" style="width:122px;">
          <p class="yun-name">PC云平台</p>
          <p class="yun-info">外观精美，操作简单的电脑端网站，商品、厂房、景点360度展示</p>
      </div>
      <div class="clear"></div>
   </div>
   
   <div class="yun-pc fl" style="width:290px; margin-left:65px;_margin-left:65px;">
      <div class="yun-pic fl"><img src="__PUBLIC__/images/login-two.jpg" /></div>
      <div class="fl" style="width:175px;">
          <p class="yun-name">手机客户端+二维码</p>
          <p class="yun-info">二维码扫描技术与手机官网的完美结合，浏览方便，视觉效果好360度展示</p>
      </div>
      <div class="clear"></div>
   </div>
   <div class="yun-pc fl"  style="width:240px;margin-left:50px;_margin-left:50px;">
      <div class="yun-pic fl"><img src="__PUBLIC__/images/login-three.jpg" /></div>
      <div class="fl" style="width:122px;">
          <p class="yun-name">微官网</p>
          <p class="yun-info">依据用户个性化的需求，定制成手机移动版网页，建立自己的移动互联门户。</p>
      </div>
      <div class="clear"></div>
   </div>
   <div class="clear"></div>
</div>
<div class="login-footer">
  <div class="login-foot">
     <div class="fl"><a href="http://www.0535.cc/aboutus.php?fid=20">声明</a>&nbsp;|&nbsp;
     <a href="http://mail.0535.cc/">邮局</a>&nbsp;|&nbsp;<a href="http://www.0535.cc/aboutus.php?fid=84">合作伙伴</a>
     &nbsp;|&nbsp;<a href="http://www.0535.cc/aboutus.php?fid=22">支付方式</a>
     &nbsp;|&nbsp;<a href="http://www.0535.cc/aboutus.php?fid=8">联系我们</a>&nbsp;|&nbsp;
     <a href="http://www.0535.cc/aboutus.php?fid=8">seo</a>&nbsp;|</div>
     <div class="fr">商机互联 版权所有 © 2004-2011 鲁ICP备07005956号</div>
  </div>
</div>
</center>
</body>
</html>