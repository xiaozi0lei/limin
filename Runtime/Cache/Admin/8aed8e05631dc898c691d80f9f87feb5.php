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
<script src="__PUBLIC__/js/ajaxfileupload.js"></script>

<script src="__PUBLIC__/js/swfupload.js"></script>
<script src="__PUBLIC__/js/swfupload.queue.js"></script>
<script src="__PUBLIC__/js/fileprogress.js"></script>
<script src="__PUBLIC__/js/handlers.js"></script>
<script src="__PUBLIC__/js/swfupload.cookies.js"></script>
<script>
	
	
	var editor;		
	var swfu;
		window.onload = function() {
			var settings = {
				flash_url : "__PUBLIC__/images/swfupload.swf",
				upload_url: "<?php echo U('Admin/Product/swfupload');?>",	
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>","bat":1},
				file_size_limit : "2 MB",
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
				button_image_url: "__PUBLIC__/images/browupload.jpg",
				button_width: "192",
				button_height: "32",
				button_placeholder_id: "selectbutton",
				button_text: '<span class="theFont"></span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				button_window_mode:'transparent',
				
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadBatSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	
			};

			swfu = new SWFUpload(settings);
	     }

	
	
		function addcontent(imgid){
			
			var myDialog = art.dialog({
			
				title:'内容',
				ok: function () {
				    var content=editor.html();	
					$.ajax({
					   type: "POST",
					   url: "<?php echo U('Admin/product/saveBatContent');?>",
					   data: {'content':content,'imgid':imgid},
					   success: function(msg){
					   		//$('#op_'+imgid).html('<a href="editcontent('+imgid+')">编辑</a>');
							$('#a_'+imgid).text('编辑');
					   }
					});
					return true;
				},
				cancelVal: '关闭',
				cancel: true //为true等价于function(){}
			
			});
			$.ajax({
			   type: "GET",
			   url: "<?php echo U('Admin/product/batcontent');?>",
			   data: "imgid="+imgid,
			   success: function(msg){
				  myDialog.content(msg);// 填充对话框内容
				editor=KindEditor.create('textarea[name="content"]', {
					uploadJson : '<?php echo U('Admin/Product/uploadEditerImg');?>',
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
			   }
			});
		
		}
		
			///删除上传图片
function deleteimage(id){
			
	art.dialog({
    title: '提示框',
	content:'确定删除吗?',
	icon:'question',
	ok:function(){
	$('#'+id).remove();
	
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
	
function dosubmit(){
	
	$('#uploadsave').attr('disabled','disabled');
	
	if($('input[name="nametype"]:checked').val()==2){
		var title_f=$('input[name="title_fix[]"]:checked');
		var pic=$('.ptitle');
		
		if(pic.length==0){
			alert('请上传商品图片');
			$('#uploadsave').attr('disabled','');
			return false;
		}
		
		
		if(title_f.length==0){
			alert('请选择个题目后缀标签');
			$('#uploadsave').attr('disabled','');
			return false;
		}
		
		
		
		
	}
	
	return true;
}	
	
</script>
<style>
.temp_list{
float:left;
height:120px;
width:370px;
}
.temp_left{
float:left;
}
.temp_right{
float:left;
width:200px;

}
.temp_right p{
margin-bottom:5px;
}
#pic_list div{
background:none;
padding:0px;
}
#pic_list a.delete{
top:4px;
}

#pic_list{
width:auto;
}
table tr td{
text-align:left;
}
</style>


<!--右边开始-->
   <div class="rightCon1 fl">
     <div class="conTitle">产品批量上传</div>
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
		<li><span <?php if(ACTION_NAME=='productlist'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Product/productList');?>" >产品列表</a></span></li>
		<li><span <?php if(ACTION_NAME=='bat'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Product/bat');?>" >产品批量上传</a></span> </li> 
		<li><span <?php if(ACTION_NAME=='addproduct'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Product/addProduct');?>" >添加产品</a></span></li>
		
		</ul>
	</div>
	 
	 <div>
	 	<form action="<?php echo U('Admin/Product/saveBatProduct');?>" method="post" onsubmit="return dosubmit()">
<table width="100%" height="176" cellpadding="0" cellspacing="1"  bgcolor="#dedfe1" class="list_table" >
  <tr>
    <td width="141" height="50" class="title_textx"><span class="span_title"><?php echo (L("sort")); ?>:</span></td>
    <td width="941" id="sorttd">
	<select name="parent_id"  id="sort" style="float:left;">
		<?php echo ($html); ?>
	</select>	</td>
   </tr>
   
   
   <tr>
    <td width="141" height="50" class="title_textx"><span class="span_title">产品名称:</span></td>
    <td width="941"><input type="radio"  checked="checked" name="nametype" value="1" onclick="javascript:$('#title_tr').css('display','none')"/>取文件名为产品名 <input type="radio" name="nametype" value="2"  onclick="javascript:$('#title_tr').css('display','')" />取分类名加产品题目后缀为产品名</td>
   </tr>
   
   <tr id="title_tr" style="display:none;">
    <td width="141" height="50" class="title_textx"><span class="span_title">题目后缀:</span></td>
    <td width="941"><input type="checkbox" name="title_fix[]" value="供应" />供应 <input type="checkbox" name="title_fix[]" value="厂家" />厂家 <input type="checkbox" name="title_fix[]" value="价格" />价格 <input type="checkbox" name="title_fix[]" value="销售" />销售 <input type="checkbox" name="title_fix[]" value="服务" />服务 <input type="checkbox" name="title_fix[]" value="批发" />批发 <input type="checkbox" name="title_fix[]" value="图片" />图片 <input type="checkbox" name="title_fix[]" value="报价" />报价 <input type="checkbox" name="title_fix[]" value="型号" />型号 <input type="checkbox" name="title_fix[]" value="规格" />规格 <input type="checkbox" name="title_fix[]" value="生产商" />生产商 <input type="checkbox" name="title_fix[]" value="生产厂家" />生产厂家 <input type="checkbox" name="title_fix[]" value="品牌" />品牌 <input type="checkbox" name="title_fix[]" value="供应商" />供应商 <input type="checkbox" name="title_fix[]" value="质量" />质量  <input type="checkbox" name="title_fix[]" value="采购" />采购   <input type="checkbox" name="title_fix[]" value="选型" />选型 <input type="checkbox" name="title_fix[]" value="视频" />视频 <input type="checkbox" name="title_fix[]" value="方案" />方案</td>
   </tr>
   
   
   <tr>
    <td width="141" height="60" class="title_textx"><span class="span_title"><?php echo (L("pic")); ?>:</span></td>
    <td width="941" align="left" valign="top">
	<span id="uploadspan" >
	
	<div id="uploaddiv">
          <div style="float:left;" id="selectbutton"></div> <span style=" position:relative; margin-left:10px; top:-12px; height:20px; line-height:20px;font-size:12px;   color: #9F9F9F;"> 在文件列表中，您可以按住Shift多选。'jpg','gif','png',
					'jpeg'</span><br /><br />
        </div>
        <div id="fsUploadProgress"></div>
	</span>	</td>
   </tr>
   <tr>
    <td width="141" class="title_textx"><span class="span_title"></span></td>
    <td width="941">
	
	<div id="pic_list"></div>	</td>
   </tr>
   <tr>
    <td width="141" class="title_textx"><span class="span_title"></span></td>
    <td width="941" align="left"><input type="submit" value=" " id="uploadsave" />
		  <input id="btnCancel" class="btnCancel"  type="button" value=" " onClick="swfu.cancelQueue();" disabled="disabled" /></td>
   </tr>
   <tr>
     <td class="title_textx">&nbsp;</td>
     <td align="left">&nbsp;</td>
   </tr>
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