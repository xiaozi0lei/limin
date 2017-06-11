// JavaScript Document
// @SunPan
$(function() {
$("[role='Bar_Left']").click(function(){
	$("[role='Bar_Left_C']").show()
	                        .animate({left:"0px"},200);
	});
$("[role='Bar_Left_C'] .barWrap").click(function(){
	$(this).parents("[role='Bar_Left_C']").animate({left:"100%"},200,function(){
		                                     $(this).hide();
		                                     });
	});
	
	//改变正文字体大小
$(".textSizeBtn").click(function(){
	$(this).children(".textSize").slideToggle(200);	
	});
$(".textSizeBtn .cont li").click(function(){
	$(".News-articleCont").css("font-size",$(this).css("font-size"));
	$(this).siblings("li").removeClass("current");
	$(this).addClass("current");
	});
	
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
//点击显示隐藏搜索

$(".search").click(function(){
	if($(".SearchBox").css("display")=="none"){
		$("body,html").addClass("hidden");
		$(this).css("background-color","#6B0008");
		$(".SearchBox").fadeIn(100);
		$("#keywords").focus();
	}else{
		$(this).css("background-color","");
		$(".SearchBox").fadeOut(100,function(){
		$("body,html").removeClass("hidden");
		});
		}
	});

//搜索切换
  $(".SearchBox .SearchTop li").click(function(){
		$(this).siblings().removeClass("current");
		$(this).addClass("current");
		$("#SearchAction").val($(this).attr("value"));
		})
//留言页面
			
  $("#sendsubmit_btn").click(
			function() {
				var messageval = $("#message").val();
				var nameval = $("#name").val();
				var telval = $("#tel").val();
				var email = $("#email").val();
				var G_SiteID = $("#G_SiteID").val();
				var xgj = $("#xgj").val();
				if (messageval == "") {
					$("#message").focus();
					return false;
				}
				if (nameval == "") {
					$("#name").focus();
					return false;
				}
				if (telval == "" && email == "") {
					$("#tel").focus();
					return false;
				} else {
					if (telval != "") {
						if (IsTelephone(telval) == false) {
							$("#tel").focus();
					    return false;
						}
					}
					if (email != "") {
						if (emailtest(email) == false) {
							$("#email").focus();
					    return false;
						}
					}

				}
				if(xgj==0){
	                $.getJSON("http://iss.sjhl.cc/livechat.php?callback=?",{act:'getservices',siteid:G_SiteID}, function(json) {
		                 var serviceid=json.lists[0].serviceid;
	                     $.post("http://iss.sjhl.cc/livechat.php?callback=?",{act:'leavemsg',email:email,message:messageval,mobile:telval,name:nameval,serviceid:serviceid,siteid:G_SiteID});
	                 });
				};
				$.post("feedback.asp", "action=add&message=" + messageval+ "&name=" + nameval + "&tel=" + telval + "&email="+ email, function(json) {
					$("#sendcomment").empty();
					$("#commentsuccess").css("display","block");
				})
				return false;
				$("#comment").submit();
			});


	function emailtest(temp) // 验证邮箱
   {
		var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if (!myreg.test(temp)) {
			return false;
		} else {
			return true;
		}
	};
	function IsTelephone(obj)// 验证手机号
	{
		var pattern = /(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^1[3|4|5|8][0-9]\d{4,8}$)/;
		if (pattern.test(obj)) {
			return true;
		} else {
			return false;
		}
	};
	
})
	
//使浏览器全屏（模拟）
/*
window.onload=function(){ 
if(document.documentElement.scrollHeight <= document.documentElement.clientHeight) { 
bodyTag = document.getElementsByTagName('body')[0]; 
bodyTag.style.height = document.documentElement.clientWidth / screen.width * screen.height + 'px'; 
} 
setTimeout(function() { 
window.scrollTo(0, 1) 
}, 0); 
}; */
