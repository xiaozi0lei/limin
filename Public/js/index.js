/**
 * @author SunPan@sjhl.cc
 * For     zxtx/*.*
 */
jQuery(function($) {
	// Login.asp=========START
	$("#xweb_login").click(function() {
		$(this).attr("class", "cert221");
		$("#kehu_login").attr("class", "cert222");
		$(".logintype1").css("display","none");
		$("[name='isguanjia']").val("no");
		$("[name='username']").val($("[name='AdminUserName1']").val());
		$("[name='password']").val($("[name='AdminUserPwd2']").val());
		if($("[name='AdminUserName1']").val()==""){
			$("[name='SavePwd']").attr("checked",false);
			}
		else{
			$("[name='SavePwd']").attr("checked",true);
			}
		}
	);
	$("#kehu_login").click(function() {
		$(this).attr("class", "cert221 f1");
		$("#xweb_login").attr("class", "cert223");
		$(".logintype1").css("display","block");
		$("form#Login").attr("action","http://iss.sjhl.cc/hl/index.php?mod=core&act=login&do=check_login");
		$("[name='isguanjia']").val("yes");
		$("[name='username']").val($("[name='AdminUserName2']").val());
		$("[name='password']").val($("[name='AdminUserPwd2']").val());
		if($("[name='AdminUserName2']").val()==""){
			$("[name='SavePwd']").attr("checked",false);
			}
		else{
			$("[name='SavePwd']").attr("checked",true);
			}
		if($("[name='istype']").val()=="admin"){
			$("#typeadmin").attr("checked",true);
			}
		else{
			$("#typeservice").attr("checked",true);
			}
		}
	);
	$("#login_name").focus(function(){
		    $(this).css("background-image",'url('+public_path+'/images/login_04.jpg)');
		})
		.blur(function(){
		var login_nameval=$("#login_name").val();
		if(login_nameval==""){
			$("#login_name").css("background-image",'url('+public_path+'/images/login_01.jpg)');
			}else{
				$("#login_name").css("background-image",'url('+public_path+'/images/login_04.jpg)');
				};
			});
   $("#login_password").focus(function(){
		    $(this).css("background-image",'url('+public_path+'/images/login_04.jpg)');
		}).blur(function(){
		var login_password=$("#login_password").val();
		if(login_password==""){
			$("#login_password").css("background-image",'url('+public_path+'/images/login_02.jpg)');
			}else{
				$("#login_password").css("background-image",'url('+public_path+'/images/login_04.jpg)');
				};
	});
   $("#login_s").focus(function(){
		    $(this).css("background-image",'url('+public_path+'/login_04.jpg)');
		}).blur(function(){
		var login_s=$("#login_s").val();
		if(login_s==""){
			$("#login_s").css("background-image",'url('+public_path+'/login_03.jpg)');
			}else{
				$("#login_s").css("background-image",'url('+public_path+'/images/login_04.jpg)');
				};
	});
	//判断默认背景
	if($("#login_name").val()!=""){
			$("#login_name").css("background-image",'url('+public_path+'/images/login_04.jpg)');
			};
	if($("#login_password").val()!=""){
			$("#login_password").css("background-image",'url('+public_path+'/images/login_04.jpg)');
	    };
	if($("#login_s").val()!=""){
			$("#login_s").css("background-image",'url('+public_path+'/images/login_04.jpg)');
			};
	// Login.asp=========END
	// Menu.asp=========START
	$('.menu_0').bind('click', function() {
		$('.menu_0_1 a').css("background-image",'url('+public_path+'/images/index_r17.jpg)');
		$('.menu_0').find('span').css("background-image",'url('+public_path+'/images/index_r17.jpg)');
		$('.menu_0').find('ul').css("display","none");
	 	$(this).find('span').css("background-image",'url('+public_path+'/images/visited.jpg)');
		$(this).find('ul').css("display","block");
	});
	
	
	$('.menu_0_1').bind('click', function() {
		$('.menu_0_1 a').css("background-image",'url('+public_path+'/images/index_r17.jpg)');
		$('.menu_0').find('span').css("background-image",'url('+public_path+'/images/index_r17.jpg)');
		$('.menu_0').find('ul').css("display","none");
	 	$(this).find('a').css("background-image",'url('+public_path+'/images/visited.jpg)');
	});
	$("#xweb_pc_top").click(function(){
		$("#xweb_pc").slideToggle(400);
		if($(this).attr("class")=="cer11 fl"){ 
		    $(this).attr("class","cer11s fl");
		    }
		else{
			$(this).attr("class","cer11 fl");
		    }
		});
	$("#xweb_3g_top").click(function(){
		$("#xweb_3g").slideToggle(200);
		if($(this).attr("class")=="cer11 fl"){ 
		    $(this).attr("class","cer11s fl");
		    }
		else{
			$(this).attr("class","cer11 fl");
		    }
		});
	// Menu.asp=========END
});