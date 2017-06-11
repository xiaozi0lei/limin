/* 
 选项卡效果
 author:SunPan

*/
$(function() {
	//选项卡点击效果
$("[role='tablist']>ul>li").click(function(){
	var Dom_tabpanel=$(this).parents("[role='tablist']").next("[role='tabpanel']").children("ul").children();
	var Dom_link=$(this).parents("[role='tablist']").find("[role='link']"); //设置右侧【更多】链接的DOM
	var thisIndex=$(this).index();
	$(this).siblings("li").removeClass("current");
	$(this).addClass("current");
	Dom_tabpanel.hide();
	Dom_tabpanel.eq(thisIndex).show();
	Dom_link.attr("link",$(this).attr("link")); 
	});
	//[role='link'] 点击跳转
$("[role='link']").click(function(){
	location.href=$(this).attr("link");
	});
	
//底部滚动
	var resetfooter = function() {
		var visiablelength = window.innerHeight;
		var hidelength = window.scrollY;
		var sHeight = $("[role='box_footer']").outerHeight();
		var length = visiablelength*1 + hidelength*1 - sHeight*1;
		$("[role='box_footer']").css({"top":length+'px'}).fadeIn('fast');
	};
  $(document).delegate("[data-role='page']","touchmove",function(){
	  $("[role='box_footer']").hide();
	});
  $(document).delegate("[data-role='page']","touchend",function(){
	  resetfooter();
	});
  $(document).delegate("[data-role='page']","touchstart",function(){
	  $("[role='box_footer']").hide();
	});
	$(window).scroll(function() {
		resetfooter();
	});	
	//resetfooter();


//主页下载
var sp_phoneDom;
var showDownload = function() {
  $("body,html").addClass("hidden");
var browser={
versions:function(){
var u = navigator.userAgent, app = navigator.appVersion;
return {
trident: u.indexOf('Trident') > -1, //IE内核
presto: u.indexOf('Presto') > -1, //opera内核
webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //是否为移动终端
ios: !!u.match(/(i[^;]+\;(U;)? CPU.+Mac OS X)/), //ios终端
android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
iPad: u.indexOf('iPad') > -1, //是否iPad
webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
};
}(),
language:(navigator.browserLanguage || navigator.language).toLowerCase()
}		
    if( browser.versions.mobile && browser.versions.android ){
		sp_phoneDom=$("#androidtype");
		}else{
		sp_phoneDom=$("#iphonetype");
		}
		sp_phoneDom.show();
	$(".DownLoadBox").fadeIn(200);
	};
//首次登录判断
//写cookies
var setCookie = function (name,value) 
{ 
 var Days = 2; 
 var exp = new Date(); 
 exp.setTime(exp.getTime() + Days*24*60*60*1000); 
 document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
}
//读取cookies 
var getCookie = function (name) 
{ 
 var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 if(arr=document.cookie.match(reg))
  return unescape(arr[2]); 
 else 
  return null; 
}
if(!getCookie("isFirst")){
	showDownload();
	setCookie("isFirst","true");
	}
     //点击显示隐藏
$(".download").click(function(){
	showDownload();
	});
$("#iphonetype,#androidtype .later").click(function(){
	$(".DownLoadBox").fadeOut(100,function(){
		sp_phoneDom.hide();
		});
	$("body,html").removeClass("hidden");
	});


}); 