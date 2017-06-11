
//jquery cookie
jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1;}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000));}else{date=options.expires;}expires='; expires='+date.toUTCString();}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break;}}}return cookieValue;}};


function showlogin(fangshi)
{
	document.getElementById("login").style.display = fangshi;
}
$(document).ready(function(){
  $("#hlogin").mouseover(function(){
    $("#login").slideDown("slow");
  });
  $("#submit").click(function(){
  	var username = $("input[name='username']").val();
	var password = $("input[name='userpassword']").val();
	if (username == "")
	{
		alert("请输入账户名");
		return false;
	}
	$.post("{:U('Public/loginsubmit?jump=2')}",{"username":username,"password":password},function(json){
		if (json.status == 1)
		{
			alert("登录成功");
			$("#hlogin").html("【退出】");
			$("#login").slideUp("slow");
			$("#hlogin").unbind("mouseover");
			$("#hlogin").attr("href","{:U('Public/logout')}");
			$("#hlogin").attr("id","exit");
		} 
		else
			alert("用户名或密码错误，请检查");
	});
	
  });
	$("#login").mouseup(function() {
				return false
			});
	$(document).mouseup(function() {
	
		$("#login").hide();
	
	});	

});