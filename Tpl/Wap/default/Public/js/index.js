jQuery(function($) {
	$("#InfoCate").click(function() {
		var classvalue = $("#InfoCate").attr("class");
		if (classvalue == 'fold') {
			$("#menu-second").attr("style", "display:block");
			$("#InfoCate").attr("class", "expand")
		} else {
			$("#menu-second").attr("style", "display:none");
			$("#InfoCate").attr("class", "fold")
		}

	});
	var sharesel=$("#shareval").val();
	if(sharesel=='share')
	{
		$("#share").attr("class","click");
		$("#share").attr("href","javascript:return fasle");
	}

	var resetfooter = function() {
		var visiablelength = window.innerHeight;
		var hidelength = window.scrollY;
		var sHeight = $('#box_footer').outerHeight();
		var length = visiablelength*1 + hidelength*1 - sHeight*1;
		
		$("#box_footer").css({"top":length+'px'}).fadeIn('fast');

	};
	resetfooter();
	$('#page_index, #page_news_list').live('touchmove', function(){
		$("#box_footer").hide();
	}).live('touchend', function(){
		resetfooter();
	}).live('touchstart', function(){
		$("#box_footer").hide();
	});
	$(window).scroll(function() {
		resetfooter();
	});

	$("#search").click(function() {
		$("#totalSearch").submit();
	});

	$("#message").focusout(function() {
		$("#messageerror").attr("style", "display:none");
	});
	$("#name").focusout(function() {
		$("#nameerror").attr("style", "display:none");
	});
	$("#tel").focusout(function() {
		$("#telerror").attr("style", "display:none");
	});
	$("#email").focusout(function() {
		$("#telerror").attr("style", "display:none");
	});

	$("#sendsubmit_btn").click(
			function() {
				var messageval = $("#message").val();
				var nameval = $("#name").val();
				var telval = $("#tel").val();
				var email = $("#email").val();
				var G_SiteID = $("#G_SiteID").val();
				var xgj = $("#xgj").val();
				if (messageval == "") {
					$("#messageerror").attr("style", "display:block");
					return false;
				}
				if (nameval == "") {
					$("#nameerror").attr("style", "display:block");
					return false;
				}
				if (telval == "" && email == "") {
					$("#telerror").attr("style", "display:block");
					var a = document.getElementById("telerror");
					a.innerHTML = "电话不能为空";
					return false;
				} else {
					if (telval != "") {
						if (IsTelephone(telval) == false) {
							$("#telerror").attr("style", "display:block");
							var a = document.getElementById("telerror");
							a.innerHTML = "请输入正确的电话号码";
							return false;
						}
					}
					if (email != "") {
						if (emailtest(email) == false) {
							$("#emailerror").attr("style", "display:block");
							var a = document.getElementById("emailerror");
							a.innerHTML = "请输入正确的邮箱";
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

	$("#getmore").click(function(){
		        var page = $("#pageno").val();
				var BigClassName = $("#BigClassName").val();
				var searchkeywords = $("#searchkeywords").val();
                $.get("inc/showmore.asp","action=news&page=" + page + "&BigClassName=" + BigClassName + "&searchkeywords=" + searchkeywords,function(data){
					  if (data=="") {
						  $("#getmore").attr("style", "display:none");
					  }
					  else{
                       $("#listtable").append(data);
					   page++;
				       $("#pageno").val(page);
					  }
                         })
				
		})
		$("#getmoreproduct").click(function(){
		        var page = $("#pageno").val();
				var BigClassName = $("#BigClassName").val();
				var searchkeywords = $("#searchkeywords").val();
                $.get("inc/showmore.asp","action=product&page=" + page + "&BigClassName=" + BigClassName + "&searchkeywords=" + searchkeywords,function(data){
					  if (data=="") {
						  $("#getmoreproduct").attr("style", "display:none");
					  } 
					  else{
                       $("#listtable").append(data);
					   page++;
				       $("#pageno").val(page);
					  }
                         })
				
		})
	function emailtest(temp) {

		// 对电子邮件的验证
		var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if (!myreg.test(temp)) {
			return false;
		} else {
			return true;
		}
	}
	function IsTelephone(obj)// 正则判断
	{
		var pattern = /(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^1[3|4|5|8][0-9]\d{4,8}$)/;
		if (pattern.test(obj)) {
			return true;
		} else {
			return false;
		}
	}

});
