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



<div class="rightCon1 fl">
     <div class="conTitle">流量概况</div>
     <div class="conNav">
       <ul>
        <li <?php if(ACTION_NAME=='summary'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Alexa/summary'); echo ($language); ?>"><span>流量概况</span></a></li>
        <li <?php if(ACTION_NAME=='eng'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Alexa/eng',array('tab'=>1)); echo ($language); ?>"><span>搜索引擎概况</span></a></li>
        <li <?php if(ACTION_NAME=='access'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Alexa/access',array('tab'=>1)); echo ($language); ?>"><span>访问分析</span></a></li>
        <li <?php if(ACTION_NAME=='referer'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Alexa/referer',array('tab'=>1)); echo ($language); ?>"><span>来源分析</span></a></li>
		</ul>
     </div>

	 <style>
	 .list_table tr td{
	 text-align:center;
	 }
	 </style>	
	 <div style="margin-left:100px;">
	<table width="704" height="280" cellpadding="0" cellspacing="1" class="list_table" style="margin-top:20px; margin-bottom:20px;" >
		  <tr class="list_tr">
			<td colspan="5"  bgcolor="#1F75B7"  style="text-align:center;"scope="row"><strong style="color:#FFFFFF">访问统计</strong></th>
	  	  </tr>
		  <tr class="list_tr">
			<td width="117"  scope="row">&nbsp;</th>
			<td width="151">PV</td>
			<td width="134">独立访客</td>
			<td width="134">IP</td>
			<td width="134">人均浏览次数</td>
		  </tr>
		  <tr class="list_tr">
			<td scope="row">今日</th>
			<td><?php echo ($visit_summary[pv]); ?></td>
			<td><?php echo ($visit_summary[alone]); ?></td>
			<td><?php echo ($visit_summary[ip]); ?></td>
			<td><?php echo ($per_visit); ?></td>
		  </tr>
		  <tr class="list_tr">
			<td  scope="row">昨日</th>
			<td><?php echo ($visit_summaryz[pv]); ?></td>
			<td><?php echo ($visit_summaryz[alone]); ?></td>
			<td><?php echo ($visit_summaryz[ip]); ?></td>
			<td><?php echo ($per_visitz); ?></td>
		  </tr>
			<tr class="list_tr">
			<td  scope="row">平均每日</th>
			<td><?php echo ($pvaver); ?></td>
			<td><?php echo ($alaver); ?></td>
			<td><?php echo ($ipaver); ?></td>
			<td>&nbsp;</td>
		  </tr>
			<tr class="list_tr">
			<td  scope="row">历史最高</th>
			  <td><?php echo ($maxpv); ?></td>
				<td><?php echo ($maxal); ?></td>
				<td><?php echo ($maxip); ?></td>
				<td>&nbsp;</td>
		  </tr>
		  <tr class="list_tr">
			<td  scope="row">历史累计</th>
			<td><?php echo ($pvaccum); ?></td>
				<td><?php echo ($alaccum); ?></td>
				<td><?php echo ($ipaccum); ?></td>
				<td>&nbsp;</td>
		  </tr>
	   </table>
		
		<table width="704" height="106" class="list_table" cellpadding="0" cellspacing="1">
		  <tr>
			<th height="30" colspan="5" bgcolor="#1F75B7" scope="row"><strong style="color:#FFFFFF">流量图</strong></th>
		  </tr>
		  <tr>
			<th colspan="5" scope="row"><div style="height:270px;" id="charttd"><div id='chartContainer'></div></div></th>
		  </tr>
		</table>
		
		<script language="JavaScript" src="__PUBLIC__/Chart/js/FusionCharts.js"></script>
		<script type="text/javascript">
			var wdth = $('#charttd').width()-20;
			var heth = '270';
		   var chart = new FusionCharts("__PUBLIC__/Chart/swf/FCF_MSLine.swf", "ChartId", wdth, heth);
		   chart.setDataURL("<?php echo U('Admin/Alexa/summaydata',array('st'=>$dtime,'et'=>$dtime));?>");		   
		   chart.render("chartContainer");
		</script>
	 
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