<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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




<script>



function submitall(type){
	 
	 var html=<?php echo ($html); ?>;
	 if(html!=1){
	 	art.dialog.alert('请选中"静态模式",然后点击“修改”按钮');
	 	return false;
	 }
	 
	 
	 
	if(type=='sort'){
		var sid=$("#sele option:selected").val();
		var data_str="op=sort&sid="+sid;
	}else{
		var data_str="op=all"
	}


	$.ajax({
	   type: "GET",
	   url: "<?php echo U('Admin/Public/dohtml');?>",
	   dataType:'json',
	   data: data_str,
	   success: function(msg){
		 
		 	var count = msg.url.length;
			var complate=0;
				if(count>0){
				
					for(var i=0;i<count;i++){
							
							$.ajax({
								   type: "GET",
								   data:'code='+msg.code,
								   url:msg.url[i],
								   success: function(){
											$('#pro_tips').attr('href',msg.url[i]);
								   			complate=complate+1;
											var per=parseInt((complate/count)*100);
											$('#process').css('width',per+'%');
											$('#pro_tips').text(per+'%');
											if(per==100){
												$.ajax({
												   type: "GET",
												   async:false,
												   url: "<?php echo U('Admin/Seo/destroy');?>",
												   success: function(){
													   
												   }
												});
												
											}			
								   }
								});
				
					}
					
				}
				
		 	
	   }
	});
	
}

function submitmode(){
	$('#html_form').attr('action',"<?php echo U('Admin/Seo/doMode');?>")
	$('#html_form').submit();
}

function check_mode(t){
	var html=<?php echo ($html); ?>
	
	if(html==1){
		art.dialog.alert('<font style="font-size:14px;color:red;">当前网站为"静态模式"，如果网站已上线请不要切换,否则静态页面将删除影响优化效果。</font><br/><br/>线上修改网站在“栏目生成”选择相应栏目生成静态页查看修改效果');
	}

}

</script>




<div class="rightCon1 fl">
     <div class="conTitle">静态管理</div>
    <div class="conNav">
       <ul>
	    <?php if($lang=='zh-cn'): ?><li <?php if(ACTION_NAME=='html'): ?>class="active"<?php endif; ?> ><a href="<?php echo U('Admin/Seo/html'); echo ($language); ?>"><span>静态管理</span></a></li><?php endif; ?>
        <li <?php if(ACTION_NAME=='setting'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Seo/setting'); echo ($language); ?>"><span>SEO设置</span></a></li>
        <li <?php if(ACTION_NAME=='link'||ACTION_NAME=='addlink'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Seo/link'); echo ($language); ?>"><span>友情链接</span></a></li>

       </ul>
</div>
	 
	 
	 <div>
	 	<form action="<?php echo U('Admin/Public/dohtml');?>" method="post" id="html_form">
<table width="100%" height="212" border="0" cellpadding="0" cellspacing="1"  class="list_table" >


	<tr>
    <td width="20%" class="title_text"><span class="span_title">网站访问模式:</span></td>
    <td width="80%" class="spacingtext3">
	<select name="url_mode" onchange="check_mode(this)">
	<option <?php if(($sef) == "1"): ?>selected="selected"<?php endif; ?> value="4">伪静态模式</option>
	<option <?php if(empty($sef)&&empty($html)&&($mode==2||$mode==1)): ?>selected="selected"<?php endif; ?> value="5">普通模式</option>
	<option <?php if(($html) == "1"): ?>selected="selected"<?php endif; ?> value="3">静态模式</option>
	
	
	</select> 
	<span style="margin-left:10px;">去掉链接的index.php:</span>
	<input type="radio" value="2" name="rewrite" <?php if(($mode) == "2"): ?>checked="checked"<?php endif; ?>/>开启 <input type="radio" value="1"  name="rewrite" <?php if(($mode) == "1"): ?>checked="checked"<?php endif; ?>/>关闭
	<input class="form-text"  type="button" value="修改" onclick="submitmode()" /></td>
   </tr>

	<tr>
    <td width="" class="title_text"><span class="span_title">一键生成:</span></td>
    <td width="" class="spacingtext3"><input  class="form-text" type="button" value="生成全站" onclick="submitall()" style="float:left;" /> </td>
   </tr>

   <tr>
    <td width="" class="title_text"><span class="span_title">栏目生成:</span></td>
    <td width="" class="spacingtext3">
	<select id="sele">
	
	<?php if(is_array($sort)): $i = 0; $__LIST__ = $sort;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>"><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select> <input class="form-text"  type="button" value="生成"  onclick="submitall('sort')" /></td>
   </tr>
   
   <tr>
    <td width="" class="title_text"><span class="span_title">进度:</span></td>
    <td width="" class="spacingtext3"><div id="pro_waper" style="border:1px solid red; float:left; width:200px; height:17px; font-size:0px;"><div id="process" style="background-color:#FF0000; width:0%;  height:100%;"></div></div><div>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="" target="_blank" id="pro_tips"> </a></div></td>
   </tr>
   <input type="hidden" name="op" value="" id="op" />
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