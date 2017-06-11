
function check()
{
	if(document.guestbook.Guest_Name.value=="")
	{
		alert("姓名不能为空");
		document.guestbook.Guest_Name.focus();
		return false
	}
	if(document.guestbook.Guest_Email.value=="")
	{
		alert("邮箱不能为空");
		document.guestbook.Guest_Email.focus();
		return false
	}
	if(document.guestbook.Content.value=="")
	{
		alert("内容不能为空");
		document.guestbook.Content.focus();
		return false
	}
	if(document.guestbook.checkcode.value=="")
	{
		alert("验证码不能为空");
		document.guestbook.checkcode.focus();
		return false
	}


	 
	return true;
}

function tab_menu(t){
	$('.tabc').css('display','none');
	var ids=$(t).attr('id');
	$('#'+ids+'_c').css('display','block');
	$('.tab').attr('class','tab');
	$(t).addClass('active');
}
function showproduct(showid){
	$.ajax({
		   type: "GET",
		   data:'pid='+showid,	 
		   url: site_url+"Product/getProduct",
		   dataType:'json',
		   success: function(msg){
		   
				$('.ptitle').text(msg.data.title);
				$('#sort').text(msg.data.sort);
				$('#price').text(msg.data.price);
				$('#proinfo_c').html(msg.data.content);
				pid=msg.data.id;
		   }
		});


}