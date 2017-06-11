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


<script src="__PUBLIC__/js/swfupload.js"></script>
<script src="__PUBLIC__/js/swfupload.queue.js"></script>
<script src="__PUBLIC__/js/fileprogress.js"></script>
<script src="__PUBLIC__/js/handlers.js"></script>
<script src="__PUBLIC__/js/swfupload.cookies.js"></script>
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					uploadJson : '<?php echo U('Admin/Picture/uploadEditerImg');?>',
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
			
				var swfu;
		window.onload = function() {
			var settings = {
				flash_url : "__PUBLIC__/images/swfupload.swf",
				upload_url: "<?php echo U('Admin/Picture/swfupload');?>",	
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "20 MB",
				file_types : "*.jpg;*.gif;*.png;*.jpeg",
				file_types_description : "选择图片",
				file_upload_limit : 30,  //配置上传个数
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "__PUBLIC__/images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "selectbutton",
				button_text: '<span class="theFont">浏览</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	
			};

			swfu = new SWFUpload(settings);
	     }
		 
function submitCheck(){
	
			
			if($('input[name="title"]').val()=='') {
				art.dialog.alert('题目不能为空！');
		
				return false;
				}
		
			
			if(editor.isEmpty()){
				art.dialog.alert('内容不能为空！');
		
				return false;
			}
			
			
	
}
	
	
	
	///删除上传图片
function deleteimage(id){
			
	art.dialog({
    title: '提示框',
	content:'确定删除吗?',
	icon:'question',
	ok:function(){
	$('#pic_'+id).remove();
	
	$.ajax({	
    	beforeSend:function(XMLHttpRequest){
	    	$("#codetips").text('正在提...请稍后')	
	    	},	
			url:"<?php echo U('Admin/Product/deleteImage');?>",
			type:"post",
			dataType:'json',
			data:{'id':id},
			success:function(msg){

				if(msg.status==0){
					alert(msg.info);
				}

			}	
		})

	
	
	},
	cancel:true,
	lock:true
});
			
	}	

function feng(imgid){
	$('.warpper').css('border','none');
	$('#pic_'+imgid).css('border','1px solid red');
	$('input[name="feng"]').val(imgid);
}			 
</script>
<style>
#imgul_list li{
position:relative;
width:100px;
height:100px;
float:left;
margin-right:5px;
margin-bottom:5px;
}
#imgul_list li a{
position:absolute;
top:0px;
right:0px;
text-decoration:none;
font-size:13px;
color:#FF0000;
}
#imgul_lis img{
width:100px;
height:100px;
}
</style>

<!--右边开始-->
   <div class="rightCon1 fl">
     <div class="conTitle">添加编辑图片</div>
     <div class="conNav">
       <ul>
	   
        <li <?php if(MODULE_NAME=='Article'): ?>class="active"<?php endif; ?> ><a href="<?php echo U('Admin/Article/articleList'); echo ($language); ?>"><span>文章管理</span></a></li>
       
		<li <?php if(MODULE_NAME=='Product'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Product/productList'); echo ($language); ?>"><span>产品管理</span></a></li>
		
		<li <?php if(MODULE_NAME=='Banner'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Banner/bannerList'); echo ($language); ?>"><span>幻灯片管理</span></a></li>
		
        <?php if(($download_downloadlist) == "1"): ?><li <?php if(MODULE_NAME=='Download'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Download/downloadList'); echo ($language); ?>"><span>下载管理</span></a></li><?php endif; ?>
		<?php if(($picture_picturelist) == "1"): ?><li <?php if(MODULE_NAME=='Picture'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Picture/pictureList'); echo ($language); ?>"><span>图片管理</span></a></li><?php endif; ?>
		<?php if(($job_joblist) == "1"): ?><li <?php if(MODULE_NAME=='Job'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Job/jobList'); echo ($language); ?>"><span>招聘管理</span></a></li><?php endif; ?>
	
		<li <?php if(MODULE_NAME=='Message'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Message/messageList'); echo ($language); ?>"><span>网站留言</span></a></li>
        <li <?php if(MODULE_NAME=='Part'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Part/index'); echo ($language); ?>"><span>局部内容管理</span></a></li>
		<li <?php if(MODULE_NAME=='Map'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Map/index'); echo ($language); ?>"><span>百度地图</span></a></li>
       </ul>
</div>
	 
	  <div id="menu_tab">
		<ul>
		<li><span <?php if(ACTION_NAME=='productlist'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Picture/pictureList');?>" >图片列表</a></span></li>
		<li><span <?php if(ACTION_NAME=='addpicture'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Picture/addPicture');?>" >添加图片</a></span> </li> 
		<li><span <?php if(ACTION_NAME=='bat'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Picture/bat');?>" >图片批量上传</a></span></li>
		
		</ul>
	</div>
	 
	 
	 <div>
	 	<form action="<?php echo U('Admin/Picture/doAddPicture');?>" method="post" onsubmit="return submitCheck()">
<table width="100%" height="854" border="0" cellpadding="0" cellspacing="1"  bgcolor="#dedfe1" class="list_table">

  
  <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("sort")); ?>:</span></td>
    <td width="824" class="spacing3">
	<select name="sort">
	<?php echo ($html); ?>
	</select></td>
   </tr>
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("atitle")); ?>:</span></td>
    <td width="824" class="spacing3"><input class="input_middle" name="title" value="<?php echo (($title)?($title):''); ?>" /></td>
   </tr>
   <tr>
    <td width="185" class="title_text"><span class="span_title">图片:</span></td>
    <td width="824" class="spacing3">
	<span id="uploadspan">
			
	   <div id="uploaddiv">
          <div style="float:left;" id="selectbutton"></div>
		  <input id="btnCancel" type="button" value="取消全部" onClick="swfu.cancelQueue();" disabled="disabled" style=" position:relative; top:-7px;margin-left: 2px; font-size: 8pt; height: 26px;" />
          <span style=" font-size:12px; line-height:35px; margin:0 15px; color: #9F9F9F; position:relative; top:-10px;">在文件列表中，您可以按住Shift多选。'jpg','gif','png',
					'jpeg'</span>
          <div style="clear:both;"></div>
        </div>
        <div id="fsUploadProgress"></div>
		
		<div id="pic_list">
        	<?php if(!empty($pics)): if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><div class="warpper"  <?php if($pic['feng']): ?>style="border:1px solid red;"<?php endif; ?> id="pic_<?php echo ($pic["id"]); ?>"><img width="100" height="100" src="__ROOT__/<?php echo ($pic["filepath"]); ?>"><textarea name="imagedes[<?php echo ($pic["id"]); ?>]"><?php echo ($pic["desc"]); ?></textarea><a class="opimg" href="javascript:feng(<?php echo ($pic["id"]); ?>)">设置为封面</a><a class="delete"  href="#" onclick="deleteimage(<?php echo ($pic["id"]); ?>);return false;">remove</a></div><?php endforeach; endif; else: echo "" ;endif; endif; ?>

        </div>
	</span>	</td>
   </tr>

   
   
   
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("attribute")); ?>:</span></td>
    <td width="824" class="spacing3"><input type="checkbox" value="1" name="top" <?php if(($top) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo (L("top")); ?></td>
   </tr>
   
   <tr>
    <td width="220" class="title_text"><span class="span_title">设为栏目:</span></td>
    <td width="869" class="spacing3"><input type="radio" value="1"  name="show_pid" <?php if(!empty($show_pid)&&$show_pid==$id): ?>checked="checked"<?php endif; ?> />是 <input type="radio" value="0" name="show_pid" <?php if(empty($show_pid)||$show_pid!=$id): ?>checked="checked"<?php endif; ?> />否 (常用于栏目分类中只有一个产品)</td>
   </tr>
   
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("order")); ?>:</span></td>
    <td width="824" class="spacing3"><input type="text" value="<?php echo (($p_order)?($p_order):0); ?>" name="order" /></td>
   </tr>
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("eiditor")); ?>:</span></td>
    <td width="824" class="spacing3"><input class="input_middle" name="user" value="<?php echo (($user)?($user):''); ?>" /></td>
   </tr>
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("date")); ?>:</span></td>
    <td width="824" class="spacing3"><input class="input_middle" name="dateline" value="<?php if(empty($dateline)){echo date('Y-m-d H:i:s',time());}else{echo date('Y-m-d H:i:s',$dateline);} ?>" /></td>
   </tr>
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("atitle")); ?>:</span></td>
    <td width="824" class="spacing3"><input class="input_middle" name="seotitle" value="<?php echo (($seotitle)?($seotitle):''); ?>" /></td>
   </tr>
   <tr>
    <td width="185" class="title_text"><span class="span_title"><?php echo (L("keyword")); ?>:</span></td>
    <td width="824" class="spacing3"><input class="input_middle" name="seokeyword" value="<?php echo (($seokeyword)?($seokeyword):''); ?>" /></td>
   </tr>
   <tr>
    <td width="185" height="71" class="title_text"><span class="span_title"><?php echo (L("desc")); ?>:</span></td>
    <td width="824" class="spacing3"><textarea name="seodesc" style="width:400px; height:50px;"><?php echo (($seodesc)?($seodesc):''); ?></textarea></td>
   </tr>
   <?php if(is_array($p_field)): $i = 0; $__LIST__ = $p_field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$f): $mod = ($i % 2 );++$i;?><tr>
		<td width="18%" height="37" class="title_text"><span class="span_title"><?php echo ($f["name"]); ?>:</span></td>
		<td width="82%" class="spacing3"><input type="text" name="field<?php echo ($f["fid"]); ?>" value="<?php echo ${field.$f['fid']} ?>" />  调用方法 列表调用: <?php echo '{'.'$item.field'.$f["fid"].'}'; ?> 内页调用: <?php echo '{'.'$field'.$f["fid"].'}'; ?></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
   <tr>
    <td width="185" height="300" class="title_text"><span class="span_title"><?php echo (L("contant")); ?>:</span></td>
    <td width="824" class="spacingtext3" valign="top"><textarea name="content" style="width:700px; height:300px;"><?php echo ($content); ?></textarea></td>
   </tr>
   <tr>
    <td width="185"><span class="span_title"></span></td>
    <td width="824"><input  class="form-text" type="submit" value="<?php echo (L("save")); ?>" /></td>
   </tr>
   <tr>
     <td class="title_text">&nbsp;</td>
     <td class="spacing3">&nbsp;</td>
   </tr>
 	<input type="hidden" value="<?php echo (($id)?($id):0); ?>"  name="id"/>
	<input type="hidden" value=""  name="feng"/>
</table>
</form>
	 
	 </div>
	 
   </div>
   <!--右边结束-->



   <div class="clear"></div>
 </div>
 <div class="clear"></div>
</center>
</div>
<div style="background:url(__PUBLIC__/images/bottom.png) left; height:6px; font-size:0px; margin:0 auto; width:1204px; clear:both; margin-bottom:50px;"></div>
</body>
</html>