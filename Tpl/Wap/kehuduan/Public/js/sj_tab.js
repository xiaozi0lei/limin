/* 
 ѡ�Ч��
 author:SunPan

*/
$(function() {
	//ѡ����Ч��
$("[role='tablist']>ul>li").click(function(){
	var Dom_tabpanel=$(this).parents("[role='tablist']").next("[role='tabpanel']").children("ul").children();
	var Dom_link=$(this).parents("[role='tablist']").find("[role='link']"); //�����Ҳࡾ���ࡿ���ӵ�DOM
	var thisIndex=$(this).index();
	$(this).siblings("li").removeClass("current");
	$(this).addClass("current");
	Dom_tabpanel.hide();
	Dom_tabpanel.eq(thisIndex).show();
	Dom_link.attr("link",$(this).attr("link")); 
	});
	//[role='link'] �����ת
$("[role='link']").click(function(){
	location.href=$(this).attr("link");
	});
	
//�ײ�����
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


//��ҳ����
var sp_phoneDom;
var showDownload = function() {
  $("body,html").addClass("hidden");
var browser={
versions:function(){
var u = navigator.userAgent, app = navigator.appVersion;
return {
trident: u.indexOf('Trident') > -1, //IE�ں�
presto: u.indexOf('Presto') > -1, //opera�ں�
webKit: u.indexOf('AppleWebKit') > -1, //ƻ�����ȸ��ں�
gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //����ں�
mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //�Ƿ�Ϊ�ƶ��ն�
ios: !!u.match(/(i[^;]+\;(U;)? CPU.+Mac OS X)/), //ios�ն�
android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android�ն˻���uc�����
iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //�Ƿ�ΪiPhone����QQHD�����
iPad: u.indexOf('iPad') > -1, //�Ƿ�iPad
webApp: u.indexOf('Safari') == -1 //�Ƿ�webӦ�ó���û��ͷ����ײ�
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
//�״ε�¼�ж�
//дcookies
var setCookie = function (name,value) 
{ 
 var Days = 2; 
 var exp = new Date(); 
 exp.setTime(exp.getTime() + Days*24*60*60*1000); 
 document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
}
//��ȡcookies 
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
     //�����ʾ����
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