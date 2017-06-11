<?php if (!defined('THINK_PATH')) exit();?>   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/admin.css" />
<title>管理后台</title>
<script>
var mobile = '<?php echo ($wapon); ?>';
</script>
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

<div style="width:1206px;   margin:0 auto; position: relative;left:50%; margin-left:-603px; margin-top:50px;">
<div style="background:url(__PUBLIC__/images/top.png) left no-repeat; width:1206px; margin:0 auto; height:6px; font-size:0px;"></div>
<center>
 <div class="center" style="width:1200px; margin:0 auto;">
  <!--头部开始-->
   <div class="head">
     <div class="logo fl"><img src="__PUBLIC__/images/logo.jpg" align="middle" style="float:left;" /><div style="color: #FFFFFF; font-weight:bold;float: left; margin-top:25px;"><?php if($lang=='zh-cn'): ?>(中文站管理)<?php else: ?>(英文站管理)<?php endif; ?></div></div>
     <div class="home fr" style="padding-top:20px;">
       
         <font style="font-size:14px; font-weight:bold; color:#FFFFFF;"><?php echo ($space["username"]); ?></font>
         <a href="<?php echo U('Admin/Index/logout');?>" style=" padding:0px 20px;"><img src="__PUBLIC__/images/main04.jpg" /></a>
         <a href="<?php if($lang!='zh-cn'): echo site_url();?>/index.php?l=<?php echo ($lang); else: echo site_url(); endif; ?>" target="_blank"><img src="__PUBLIC__/images/main05.jpg" /></a>
       
     </div>
     <div style="padding-top:20px; float:right; padding-right:30px;">
      <form action="<?php echo U('Admin/product/search');?>" method="get" >
        <div > 
       
          <input onfocus="javascirpt:if(this.value=='请输入相关产品关键字'){this.value=''}" onblur="if(this.value==''){this.value='请输入相关产品关键字'}" type="text" name="searchtext" value="请输入相关产品关键字"  style=" background:url(__PUBLIC__/images/main022.jpg) repeat-x;
              width:192px; height:29px; border:none;line-height:29px; color:#a7bacc; padding-left:10px; float:left;"/>
      	 <input type="submit" id="submitform"  value="" name="button" style="width:35px; height:29px; background:url(__PUBLIC__/images/main03.jpg) no-repeat; border:none; cursor:pointer; float:left;"/>
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
   <div  style="float:left; ">
     <div   style="float:left; padding:0px; margin:0px;">
       <ul>
        <li class="pc  mainmenu pc_cp" id="pc_id" onClick="changemenu(this,'pc_cp')">&nbsp;</li>
        <li class="tel mainmenu m_cp " id="m_id" onClick="changemenu(this,'m_cp')">&nbsp;</li>
        <li class="peizhi mainmenu config_cp" id="config_id" onClick="changemenu(this,'config_cp')">&nbsp;</li>
       </ul>
     </div>
     <div class="leftNavR" style=" float:left;">
       <ul>
	     <div style=" display:none;" id="pc_cp" class="cpmenu">
		 <div class="leftNavRTitle">电脑端</div>
		 <li class="subli" id="pc_cp-0" onClick="submenu(this,'pc_cp-0')"><a href="<?php echo U('Admin/Index/index'); echo ($language); ?>">管理主页</a></li>
         <li class="subli" id="pc_cp-1" onClick="submenu(this,'pc_cp-1')"><a href="<?php echo U('Admin/Article/articleList'); echo ($language); ?>">内容管理</a></li>
		 <li class="subli" id="pc_cp-3" onClick="submenu(this,'pc_cp-3')"><a href="<?php if(empty($_SESSION['sorturl'])): echo U('Admin/Sort/sortList'); echo ($language); else: echo ($_SESSION['sorturl']); endif; ?>" >栏目分类</a></li>
		 <?php if(($style_index) == "1"): ?><li class="subli" id="pc_cp-2" onClick="submenu(this,'pc_cp-2')"><a href="<?php echo U('Admin/Style/index'); echo ($language); ?>" >样式设置</a></li><?php endif; ?>
		 <li class="subli" id="pc_cp-4" onClick="submenu(this,'pc_cp-4')"><a href="<?php echo U('Admin/field/productField'); echo ($language); ?>" >字段设置</a></li>

		 <?php if(($seo_static) == "1"): ?><li class="subli" id="pc_cp-5" onClick="submenu(this,'pc_cp-5')"><a href="<?php if($lang=='zh-cn'): echo U('Admin/Seo/html'); echo ($language); else: echo U('Admin/Seo/setting'); echo ($language); endif; ?>" >SEO设置</a></li><?php endif; ?>
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


<link rel="stylesheet" type="text/css" href="__PUBLIC__/kindeditor/themes/default/default.css" />
<script src="__PUBLIC__/kindeditor/kindeditor-min.js"></script>
<script src="__PUBLIC__/kindeditor/lang/zh_CN.js"></script>
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('.editor_textarea', {
					filterMode : false,
					uploadJson : '<?php echo U('Admin/Sort/uploadArticalImg');?>',
					allowFileManager : false,
					items:[
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
]
				});
				
			});
		</script>

<div class="rightCon1 fl">
     <div class="conTitle">栏目编辑</div>
     <div class="conNav">
       <ul>
        <li <?php if(ACTION_NAME=='sortlist'): ?>class="active"<?php endif; ?> ><a href="<?php echo U('Admin/Sort/sortList'); echo ($language); ?>"><span>栏目管理</span></a></li>
        <li <?php if(ACTION_NAME=='config'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Sort/config'); echo ($language); ?>"><span>栏目设置</span></a></li>
       
       </ul>
     </div>
	 
	 
	 <div>
	 	<form action="<?php echo U('Admin/Sort/doEditSort');?>" method="post" enctype="multipart/form-data">
	<table width="100%" height="564"   border="0" cellpadding="0" cellspacing="1"  class="list_table" >
	  <tr>
		<td width="20%" class="title_text"><span class="span_title"><?php echo (L("name")); ?>:</span></td>
		<td width="80%" class="spacing3"><input class="input_middle" name="name" value="<?php echo (($sort["name"])?($sort["name"]):''); ?>" /></td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title">父类:</span></td>
		<td width="" class="spacing3">
		
		<select name="parent_id">
			<option value="0">顶级分类</option>
			<?php echo ($html); ?>
		</select>
		
		</td>
	   </tr>
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title"><?php echo (L("order")); ?>:</span></td>
		<td width="" class="spacing3"><input class="input_middle" name="sort_order" value="<?php echo (($sort["sort_order"])?($sort["sort_order"]):0); ?>" /></td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title">所属模块:</span></td>
		<script>
		function change_module(t){
		
			if($(t).val()=='Link'){
				$('#foldername_span').text('链接:');
				
				$('#foldername').val('');	
			}else{
				$('#foldername_span').text('目录:');
				$('#linktr').css('display','none');
			}
		
		}
		
		</script>
		<td width="" class="spacing3">
			<select name="module_name" onchange="change_module(this)">
				<option value="Index"  <?php if(($sort["module"]) == "Index"): ?>selected="selected"<?php endif; ?> >主页</option>
				<option value="Article" <?php if(($sort["module"]) == "Article"): ?>selected="selected"<?php endif; ?>>文章</option>
				<option value="Product" <?php if(($sort["module"]) == "Product"): ?>selected="selected"<?php endif; ?>>产品</option>
				<option value="Download" <?php if(($sort["module"]) == "Download"): ?>selected="selected"<?php endif; ?>>下载</option>
				<option value="Picture" <?php if(($sort["module"]) == "Picture"): ?>selected="selected"<?php endif; ?>>图片</option>
				<option value="Job" <?php if(($sort["module"]) == "Job"): ?>selected="selected"<?php endif; ?>>招聘</option>
				<option value="Message" <?php if(($sort["module"]) == "Message"): ?>selected="selected"<?php endif; ?>>留言</option>
				<option value="About" <?php if(($sort["module"]) == "About"): ?>selected="selected"<?php endif; ?>>单页简介</option>
				<option value="Link" <?php if(($sort["module"]) == "Link"): ?>selected="selected"<?php endif; ?>>链接</option>
			</select>
		</td>
	   </tr>
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title" id="foldername_span"><?php if($sort['module']=='Link'): ?>链接<?php else: ?>目录<?php endif; ?>:</span></td>
		<td width="" class="spacing3"><input class="input_middle" id="foldername" name="folder" value="<?php echo (($sort["folder"])?($sort["folder"]):''); ?>" /></td>
	   </tr>
	   
	   <?php if(!in_array($sort['module'],array('About','Index','Message'))): ?><tr>
		<td width="" class="title_text"><span class="span_title">列表页模板名:</span></td>
		<td width="" class="spacing3"><input  type="text" value="<?php echo (($sort["index_tpl"])?($sort["index_tpl"]):'index'); ?>" name="index_tpl" /></td>
	   </tr><?php endif; ?>
	   <?php if(!in_array($sort['module'],array('Index','About','Message'))): ?><tr>
		<td width="" class="title_text"><span class="span_title">内页模板名:</span></td>
		<td width="" class="spacing3"><input  type="text" value="<?php echo (($sort["show_tpl"])?($sort["show_tpl"]):'show'); ?>"  name="show_tpl"/></td>
	   </tr><?php endif; ?>
	   <?php if(in_array($sort['module'],array('Message','About'))): ?><tr>
		<td width="" class="title_text"><span class="span_title">模板名:</span></td>
		<td width="" class="spacing3"><input  type="text" value="<?php echo (($sort["index_tpl"])?($sort["index_tpl"]):'index'); ?>"  name="index_tpl"/></td>
	   </tr><?php endif; ?>
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title">链接到第一个子类:</span></td>
		<td width="" class="spacing3"><input type="radio" value="1" name="jump_to_son" 
		  <?php if(($sort["jump_to_son"]) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo (L("yes")); ?> <input type="radio" value="0"  <?php if(($sort["jump_to_son"]) == "0"): ?>checked="checked"<?php endif; ?>  name="jump_to_son"/><?php echo (L("no")); ?></td>
	   </tr>
	   
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title">主页隐藏:</span></td>
		<td width="" class="spacing3"><input type="radio" value="1" name="index_hidden" 
		  <?php if(($sort["index_hidden"]) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo (L("yes")); ?> <input type="radio" value="0"  <?php if(($sort["index_hidden"]) == "0"): ?>checked="checked"<?php endif; ?>  name="index_hidden"/><?php echo (L("no")); ?></td>
	   </tr>
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title">主导航隐藏:</span></td>
		<td width="" class="spacing3"><input type="radio" value="1" name="hidden" 
		  <?php if(($sort["hidden"]) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo (L("yes")); ?> <input type="radio" value="0"  <?php if(($sort["hidden"]) == "0"): ?>checked="checked"<?php endif; ?>  name="hidden"/><?php echo (L("no")); ?></td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title">栏目图片:</span></td>
		<td width="" class="spacing3">
		<script>
			function editimg(){
				
				$('#sortimg').html('<input type="file" name="img"/>')
			}
		</script>
		
		<span id="sortimg"><?php if(!empty($sort['img'])): ?><img src="<?php echo ($site_url); ?>/<?php echo ($sort['img']); ?>" width="100" height="80" /> <a href="javascript:void(0)" onclick="editimg()">修改</a><?php else: ?><input type="file" name="img" /><?php endif; ?></span></td>
	   </tr>
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title"><?php echo (L("title")); ?>:</span></td>
		<td width="" class="spacing3"><input class="input_middle" name="title" value="<?php echo (($sort["title"])?($sort["title"]):''); ?>"/></td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title">手机站导航名称:</span></td>
		<td width="" class="spacing3"><input class="input_middle" name="mobiletitle" value="<?php echo (($sort["mobiletitle"])?($sort["mobiletitle"]):''); ?>"/></td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title">主导航显示方式:</span></td>
		<td width="" class="spacing3"><input type="radio" value="2" name="show_type"  <?php if(empty($sort['show_type'])||$sort['show_type']==2): ?>checked="checked"<?php endif; ?> />PC <input name="show_type"  type="radio" value="1" <?php if($sort['show_type']==1): ?>checked="checked"<?php endif; ?>/>都显示 <input name="show_type" type="radio" value="3" <?php if($sort['show_type']==3): ?>checked="checked"<?php endif; ?>/>手机端</td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title"><?php echo (L("keyword")); ?>:</span></td>
		<td width="" class="spacing3"><input class="input_middle" name="keyword" value="<?php echo (($sort["keyword"])?($sort["keyword"]):''); ?>"/></td>
	   </tr>
	   <tr>
		<td width="" class="title_text"><span class="span_title"><?php echo (L("desc")); ?>:</span></td>
		<td width="" class="spacingtext3"><textarea name="desc"><?php echo (($sort["desc"])?($sort["desc"]):''); ?></textarea></td>
	   </tr>
	   
	   <!--模块特殊字段-->
	   <?php switch($sort['module']): case "About": ?><tr>
			<td width="" class="title_text"><span class="span_title">内容:</span></td>
			<td width="" class="spacingtext3"><font color="red">百度地图添加方法：在内容里添加{$map}</font><textarea class="editor_textarea" name="extend[content]" style="width:670px; height:400px;"><?php echo ($sort['extend']['content']); ?></textarea></td>
		   </tr><?php break; endswitch;?>
	
	   
	   
	   
	   
	   <tr>
		<td width="" class="title_text"><span class="span_title"></span></td>
		<td width="" class="spacing3"><input class="form-text" type="submit" value="<?php echo (L("save")); ?>" /></td>
	   </tr>
		<input type="hidden" value="<?php echo ($sort["id"]); ?>" name="id" />
	</table>
	</form>
	 
	 </div>
	 
   </div>


   <div class="clear"></div>
 </div>
 <div class="clear"></div>
</center>
</div>
<div style="background:url(__PUBLIC__/images/bottom.png) left; height:6px; font-size:0px; margin:0 auto; width:1204px; clear:both; margin-bottom:50px;"></div>
</body>
</html>