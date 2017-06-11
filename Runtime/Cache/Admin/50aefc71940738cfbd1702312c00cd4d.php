<?php if (!defined('THINK_PATH')) exit();?>   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head noleavemsg="true">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/admin.css" />
<title>管理后台</title>

<script src="__PUBLIC__/js/jquery-1.4.4.min.js"></script>
<script src="__PUBLIC__/js/common.js"></script>
<script src="__PUBLIC__/js/artDialog/jquery.artDialog.js?skin=default"></script>
<script src="__PUBLIC__/js/artDialog/plugins/iframeTools.js"></script>
<script>
var root_path='__ROOT__';
function submit_form(form_url){
	$('#form_id').attr('action',form_url);
	$('#form_id').submit();

}

function select_all(){
	
	$('.check_all').attr('checked',$('#checkbox_all').attr('checked'));
	
}

$(function(){


	$('.bind_change').change( function() {
	  	$(this).parent().parent().find('td').first().find('input').attr('checked','checked');
	});

})


function del_one(t,form_url){
	if(confirm('<?php echo (L("sure")); ?>')){
		op_one(t,form_url);
	}
	
	
}

function del(url){
	if($('.check_all:checked').length==0){
		alert('<?php echo (L("selectitem")); ?>');
		return false;
	}
	
	submit_form(url);
}


function op_one(t,form_url){

		$(t).parent().parent().find('td').first().find('input').attr('checked','checked');
		$('#form_id').attr('action',form_url);
		$('#form_id').submit();
}



$(function(){


var menustr=$.cookie('active');

	if(menustr==null){
		$('.pc').addClass('active');
		$('.cpmenu').css('display','none');
		$('#pc_cp').css('display','');
		var li=$('#pc_cp').find('li');
			$(li[0]).addClass('visited')
	}else{
		$('.mainmenu').removeClass('active');
		var str=menustr.split('-');
			$('#'+str[0]).css('display','');
			var li=$('#'+str[0]).find('li');
			$('#'+menustr).addClass('visited')
			
			$('.'+str[0]).addClass('active');
	}


$(".list_table tr:odd").addClass('odd');
$(".list_table .list_tr").hover(
  function () {
    $(this).addClass("hover");
  },
  function () {
    $(this).removeClass("hover");
  }
);

/*
var noheader=parseInt(document.body.clientHeight)-80;
var rightdiv=parseInt($('.rightCon1').css('height'));
if(rightdiv>noheader){
$('.center').css('height',parseInt($('.rightCon1').css('height'))+80);
}*/
})

function changemenu(t,idstr){
	var h=$('center').css('height');
	$('.mainmenu').removeClass('active');
	$(t).addClass('active');
	$('.cpmenu').css('display','none');	
	$('#'+idstr).css('display','');
	$('center').css('height',h);
	
	
}

function submenu(t,str){
	$.cookie('active',str,{expires: 0, path: '/'});
	$('.subli').removeClass('visited');
	$(t).addClass('visited');
	
}


</script>

</head>

<body style="background:url(__PUBLIC__/images/1.jpg);">

<div style="width:1206px;  margin:0 auto; position: relative;left:50%; margin-left:-603px; margin-top:50px;">
<div style="background:url(__PUBLIC__/images/top.png) left no-repeat; width:1206px; margin:0 auto; height:6px;"></div>
<center>
 <div class="center" style="width:1200px; margin:0 auto;">
  <!--头部开始-->
   <div class="head">
     <div class="logo fl"><img src="__PUBLIC__/images/logo.jpg" /></div>
     <div class="home fr">
       <ul>
         <li><font style="font-size:14px; font-weight:bold;"><?php echo ($space["username"]); ?></font></li>
         <li class="homePic"><a href="<?php echo U('Admin/Index/logout');?>"><img src="__PUBLIC__/images/main04.jpg" /></a></li>
         <li class="homePic"><a href="<?php echo site_url();?>" target="_blank"><img src="__PUBLIC__/images/main05.jpg" /></a></li>
       </ul>
     </div>
     <div class="search fr">
      <form action="<?php echo U('Admin/product/search');?>" method="get" >
        <div class="searchInput fl"> 
          <div class="searchLeft fl"><img src="__PUBLIC__/images/main02.jpg" /></div>
          <input onfocus="javascirpt:if(this.value=='请输入相关产品关键字'){this.value=''}" onblur="if(this.value==''){this.value='请输入相关产品关键字'}" type="text" name="searchtext" value="请输入相关产品关键字"  style=" background:url(__PUBLIC__/images/main022.jpg) repeat-x;
              width:192px; height:29px; border:none;line-height:29px; _height:29px; color:#a7bacc; padding-left:10px;"/>
        </div>
        <div class="searchButton fl">
               <input type="submit" id="submitform"  value="" name="button" style="width:35px; height:29px; background:url(__PUBLIC__/images/main03.jpg) no-repeat; border:none; cursor:pointer;"/>
        </div>
       </form>
     </div>
     <div class="clear"></div>
   </div>
   <!--头部结束-->

   ﻿   <style>
   .leftNavR li a{
   display:block;
   }
   </style>
   <!--左边开始-->
   <div class="leftNav fl">
     <div class="leftNavL fl">
       <ul>
        <li class="pc  mainmenu pc_cp" onClick="changemenu(this,'pc_cp')">&nbsp;</li>
        <li class="tel mainmenu m_cp" onClick="changemenu(this,'m_cp')">&nbsp;</li>
        <li class="peizhi mainmenu config_cp" onClick="changemenu(this,'config_cp')">&nbsp;</li>
       </ul>
     </div>
     <div class="leftNavR fl">
       <ul>
	     <div style=" display:none;" id="pc_cp" class="cpmenu">
		 <div class="leftNavRTitle">电脑端</div>
		 <li class="subli" id="pc_cp-0" onClick="submenu(this,'pc_cp-0')"><a href="<?php echo U('Admin/Index/index'); echo ($language); ?>">管理主页</a></li>
         <li class="subli" id="pc_cp-1" onClick="submenu(this,'pc_cp-1')"><a href="<?php echo U('Admin/Article/articleList'); echo ($language); ?>">内容管理</a></li>
		 <li class="subli" id="pc_cp-3" onClick="submenu(this,'pc_cp-3')"><a href="<?php if(empty($_SESSION['sorturl'])): echo U('Admin/Sort/sortList'); echo ($language); else: echo ($_SESSION['sorturl']); endif; ?>" >栏目分类</a></li>
		 <?php if(($style_index) == "1"): ?><li class="subli" id="pc_cp-2" onClick="submenu(this,'pc_cp-2')"><a href="<?php echo U('Admin/Style/index'); echo ($language); ?>" >样式设置</a></li><?php endif; ?>
		 <li class="subli" id="pc_cp-4" onClick="submenu(this,'pc_cp-4')"><a href="<?php echo U('Admin/field/productField'); echo ($language); ?>" >字段设置</a></li>
		 <li class="subli" id="pc_cp-12" onClick="submenu(this,'pc_cp-12')"><a href="<?php echo U('Admin/Rank/index'); echo ($language); ?>" >排名查询</a></li>
		 <?php if(($seo_static) == "1"): ?><li class="subli" id="pc_cp-5" onClick="submenu(this,'pc_cp-5')"><a href="<?php echo U('Admin/Seo/html'); echo ($language); ?>" >SEO设置</a></li><?php endif; ?>
		 <li class="subli" id="pc_cp-6" onClick="submenu(this,'pc_cp-6')"><a href="<?php echo U('Admin/Member/listMember'); echo ($language); ?>" >会员管理</a></li>
	
		
		 <li class="subli" id="pc_cp-9" onClick="submenu(this,'pc_cp-9')"><a href="<?php echo U('Admin/Shop/orderAll',array('type'=>0,'tab'=>1)); echo ($language); ?>" >购物</a></li>
		 <li class="subli" id="pc_cp-10" onClick="submenu(this,'pc_cp-10')"><a href="<?php echo U('Admin/Qrcode/config'); echo ($language); ?>" >二维码</a></li>
		 <li class="subli" id="pc_cp-11" onClick="submenu(this,'pc_cp-11')"><a href="<?php echo U('Admin/Update/index'); echo ($language); ?>" >更新</a></li>
		 </div> 
		 
		 <div style=" display:none;" id="m_cp" class="cpmenu">
         <div class="leftNavRTitle">手机端</div>
		 <li class="subli" id="m_cp-0" onClick="submenu(this,'m_cp-0')"><a href="<?php echo U('Admin/Wap/config'); echo ($language); ?>">手机配置</a></li>
		 <li class="subli" id="m_cp-1" onClick="submenu(this,'m_cp-1')"><a href="<?php echo U('Admin/Wap/home'); echo ($language); ?>">主页配置</a></li>
		 <li class="subli" id="m_cp-2" onClick="submenu(this,'m_cp-2')"><a href="<?php echo U('Admin/Wap/lists'); echo ($language); ?>">列表配置</a></li>

		
		 </div>	
		 
		 <div style=" display:none;" id="config_cp" class="cpmenu">
         <div class="leftNavRTitle">系统设置</div>
		
		  <?php if(($config_mail) == "1"): ?><li class="subli" id="config_cp-1" onClick="submenu(this,'config_cp-1')"><a href="<?php echo U('Admin/Config/mail'); echo ($language); ?>" ><?php echo (L("mailconfig")); ?></a></li><?php endif; ?>
		  <?php if(($config_lang) == "1"): ?><li class="subli" id="config_cp-2" onClick="submenu(this,'config_cp-2')"><a href="<?php echo U('Admin/Config/lang'); echo ($language); ?>"><?php echo (L("langconfig")); ?></a></li><?php endif; ?>
		  <?php if(($config_pic) == "1"): ?><li class="subli" id="config_cp-3" onClick="submenu(this,'config_cp-3')"><a href="<?php echo U('Admin/Config/pic'); echo ($language); ?>"><?php echo (L("picconfig")); ?></a></li><?php endif; ?>
		  
		 </div>
       </ul>
</div>
     <div class="clear"></div>
   </div>
 <!--左边结束-->


<script>
function grouptab(t){

	var check=$("input[type='checkbox']");


	if(t==1){
		var ban=[];
		$('#gname').val('系统管理员');
	}
	if(t==2){
	
		var ban=['group[config_basic]','group[config_lang]','group[config_footer]','group[style_index]','group[style_lists]','group[style_lists]','group[style_details]','group[style_customer]','group[seo_static]','group[member_group]','group[update]'];
		$('#gname').val('内容管理员');
	}
	if(t==3){
		var ban=['group[config_basic]','group[config_mail]','group[style_index]','group[style_lists]','group[style_details]','group[style_customer]','group[download_downloadlist]','group[picture_picturelist]','group[job_joblist]','group[member_group]','group[update]'];
		
		$('#gname').val('优化推广员');
	}

	if(t==4){
		
		for(var i=0;i<check.length;i++){
				
				$(check[i]).attr('disabled',false);
		}
		
		$('#gname').val('');
		return ;
	}


	
		
		for(var i=0;i<check.length;i++){
				
				var current=$(check[i]).attr('name');
				var c=$(check[i]).attr('checked');
				if(c){
					$(check[i]).attr('checked','');
				}
				
				
				if(jQuery.inArray(current, ban)==-1){
					//没有
					$(check[i]).attr('checked','checked');
				}
				

		}
		


}



$(function(){
		grouptab(2);
		var ck=$("input[name='grouptype']")[1];
		$(ck).attr('checked','checked');
	
})
</script>



<div class="rightCon1 fl">
     <div class="conTitle">用户组添加</div>
     <div class="conNav">
       <ul>
        <li <?php if(ACTION_NAME=='listmember'): ?>class="active"<?php endif; ?> ><a href="<?php echo U('Admin/Member/listMember'); echo ($language); ?>"><span>用户管理</span></a></li>
        <li <?php if(ACTION_NAME=='group'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Member/group'); echo ($language); ?>"><span>用户组管理</span></a></li>
        <li <?php if(ACTION_NAME=='myinfo'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Member/myInfo'); echo ($language); ?>"><span>我的信息</span></a></li>

       </ul>
     </div>
	 
	 
	 <div>
	 	<form action="<?php echo U('Admin/Member/doSaveGroup');?>" method="post">
<table width="100%" height="335"  border="0" cellpadding="0" cellspacing="1"  class="list_table">

	<tr>
    <td width="15%" class="title_text"><span class="span_title">名称:</span></td>
    <td width="85%"  class="spacing3">
	<input   name="gname" id="gname"  >

	</td>
   </tr>


	<tr>
    <td width="" class="title_text"><span class="span_title">组类型:</span></td>
    <td width="" class="spacing3">
	<input value="1" type="radio" name="grouptype" onclick="grouptab($(this).val())">系统管理员
	<input value="2" type="radio" name="grouptype" onclick="grouptab($(this).val())">内容管理员
	<input value="3" type="radio" name="grouptype" onclick="grouptab($(this).val())">优化推广员
	<input value="4" type="radio" name="grouptype" onclick="grouptab($(this).val())">自定义
	</td>
   </tr>

   <tr>
    <td width="" class="title_text"><span class="span_title">系统配置:</span></td>
    <td width="" class="spacing3">
	
	<label><input type="checkbox" value="1" class="radio" name="group[config_login]">&nbsp;管理登录</label>
	<label><input type="checkbox" value="1" class="radio" name="group[config_basic]" >&nbsp;基本设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[config_mail]">&nbsp;系统邮箱设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[config_lang]">&nbsp;语言设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[config_file]">&nbsp;文件管理器</label>
	<label><input type="checkbox" value="1" class="radio" name="group[config_pic]">&nbsp;图片设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[config_footer]">&nbsp;底部内容设置</label>
	
	</td>
   </tr>
   <tr>
    <td width="" class="title_text"><span class="span_title">样式设置:</span></td>
    <td width="" class="spacing3">
	
	<label><input type="checkbox" value="1" class="radio" name="group[style_index]">&nbsp;首页设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[style_lists]">&nbsp;列表页设置设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[style_details]">&nbsp;内容页设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[style_customer]">&nbsp;客服设置</label>
	
	</td>
   </tr>
   
   <tr>
    <td width="" class="title_text"><span class="span_title">内容管理:</span></td>
    <td width="" class="spacing3">
	
	<label><input type="checkbox" value="1" class="radio" name="group[artical_articallist]">&nbsp;文章管理</label>
	<label><input type="checkbox" value="1" class="radio" name="group[product_productlist]">&nbsp;产品管理</label>
	<label><input type="checkbox" value="1" class="radio" name="group[download_downloadlist]">&nbsp;下载管理</label>
	<label><input type="checkbox" value="1" class="radio" name="group[picture_picturelist]">&nbsp;图片管理</label>
	<label><input type="checkbox" value="1" class="radio" name="group[job_joblist]">&nbsp;招聘管理</label>
	<label><input type="checkbox" value="1" class="radio" name="group[message_messagelist]">&nbsp;网站留言</label>
	
	</td>
   </tr>
   
   <tr>
    <td width="" class="title_text"><span class="span_title">SEO:</span></td>
    <td width="" class="spacing3">
	
	<label><input type="checkbox" value="1" class="radio" name="group[seo_static]">&nbspSEO模块</label>
	<!-- <label><input type="checkbox" value="1" class="radio" name="group[seo_map]">&nbsp;网站地图</label>
	<label><input type="checkbox" value="1" class="radio" name="group[seo_setting]">&nbsp;SEO设置</label>
	<label><input type="checkbox" value="1" class="radio" name="group[seo_link]">&nbsp;友情链接管理</label> -->
	</td>
   </tr>
   
   <tr>
    <td width="" class="title_text"><span class="span_title">会员管理:</span></td>
    <td width="" class="spacing3">
	
	<label><input type="checkbox" value="1" class="radio" name="group[member_listmember]">&nbsp;会员管理</label>
	<label><input type="checkbox" value="1" class="radio" name="group[member_group]">&nbsp;组管理</label>
	</td>
   </tr>
   

   
   <tr>
    <td width="" class="title_text"><span class="span_title">网站更新:</span></td>
    <td width="" class="spacing3">
	<label><input type="checkbox" value="1" class="radio" name="group[update]" <?php if(($per["update"]) == "1"): ?>checked="checked"<?php endif; ?>>&nbsp;更新</label>
	</td>
   </tr>
   <tr>
    <td width="" class="title_text">&nbsp;</td>
    <td width="" class="spacing3"><input class="form-text" type="submit" value="保存" /></td>
   </tr>
</table>
</form>
	 
	 </div>
	 
   </div>

   <div class="clear"></div>
 </div>
 <div class="clear"></div>
</center>
</div>
<div style="background:url(__PUBLIC__/images/bottom.png) left; height:6px; margin:0 auto; width:1204px; clear:both; margin-bottom:50px;"></div>
</body>
</html>