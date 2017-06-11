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
<style>
#container{ height:400px; width:100%; float:left; margin-top:20px;}

.mapTel {
    height: 30px;
    line-height: 30px;
    width: 208px;
	background:url(__PUBLIC__/images/bbg_line.png)
}
.mapTel .mapNumber {
    height:30px;
    display: block;
    padding: 0 0 0 10px;
	background:url(__PUBLIC__/images/bphone.png) no-repeat 10px;
}
.mapTel .mapNumber a {
	
  color: #FFFFFF;
  display: block;
  font-size: 17px;
  font-weight: bold;
  height: 30px;
  line-height: 30px;
  overflow: hidden;
  padding: 0 0 0 30px;
  text-decoration: none;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 150px;
}    
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=71de10dc4d8972f7efb90faa1514d931"></script>
<script type="text/javascript" charset="utf-8" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />



<div class="rightCon1 fl">
     <div class="conTitle">百度地图</div>
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
	 
	 
	 <div>
	 <style>
	 	#container{
		margin-top:0px;
		}
	 </style>
	 	<div id="container"></div>
<div id="container"  class="list_table">

<form action="<?php echo U('Admin/Map/search');?>" method="post">
<table width="100%" height="40" border="0" cellpadding="0" cellspacing="1"  >
  
   <tr>
    <td width="" class="title_text"><span class="span_title" style="padding-left:19px;">搜素城市:</span></td>
    <td width="" class="spacing3"><input type="text" name="searchname" value="<?php echo (($searchname)?($searchname):""); ?>" /> <input type="submit" value="搜索" /></td>
   </tr>


</table>
</form>

<form action="<?php echo U('Admin/Map/saveform');?>" method="post">
<table width="100%" height="302" border="0" cellpadding="0" cellspacing="1"  >
  
  
   <tr>
    <td width="" class="title_text"><span class="span_title">公司名称:</span></td>
    <td width="" class="spacing3"><input type="text" name="cname" value="<?php echo (($cname)?($cname):""); ?>" /> </td>
   </tr>
   <tr>
    <td width="" class="title_text"><span class="span_title">公司地址:</span></td>
    <td width="" class="spacing3"><input type="text" name="add" value="<?php echo (($add)?($add):""); ?>" /> </td>
   </tr>
   <tr>
    <td width="" class="title_text"><span class="span_title">电话:</span></td>
    <td width="" class="spacing3"><input type="text" name="phone" value="<?php echo (($phone)?($phone):""); ?>" /> </td>
   </tr>
   <tr>
    <td width="" class="title_text"><span class="span_title">传真:</span></td>
    <td width="" class="spacing3"><input type="text" name="fax" value="<?php echo (($fax)?($fax):""); ?>" /> </td>
   </tr>
   <tr>
    <td width="" class="title_text"><span class="span_title">客服:</span></td>
    <td width="" class="spacing3"><input type="text" name="customer" value="<?php echo (($customer)?($customer):""); ?>" /> </td>
   </tr>
   <tr>
    <td width="" class="title_text"><span class="span_title">email:</span></td>
    <td width="" class="spacing3"><input type="text" name="email" value="<?php echo (($email)?($email):""); ?>" /> </td>
   </tr>

   <tr>
    <td width="" class="title_text">&nbsp;</td>
    <td width="" class="spacing3"><input  type="submit" class="form-text" value="保存" /></td>
   </tr>
</table>
</form>

<script type="text/javascript"> 
    var map = new BMap.Map("container");          // 创建地图实例
	
	<?php if(!empty($lng)&&!empty($lat)): ?>var point = new BMap.Point(<?php echo ($lng); ?>,<?php echo ($lat); ?>);
		 map.centerAndZoom(point, 9);                 // 初始化地图，设置中心点坐标和地图级别
		 var marker = new BMap.Marker(point);
		 map.addOverlay(marker);
	<?php else: ?>
		  map.centerAndZoom('山东', 8);                 // 初始化地图，设置中心点坐标和地图级别<?php endif; ?>
	    
   
	map.enableScrollWheelZoom();
	map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
	
    map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
    map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
    map.enableKeyboard();//启用键盘上下左右键移动地图
	map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //右上角，仅包含平移和缩放按钮	
	map.addEventListener("click", function(e){
			map.clearOverlays(); 
			var point = new BMap.Point(e.point.lng, e.point.lat);
			var marker = new BMap.Marker(point);
			
			
			map.addOverlay(marker);
			
			$.ajax({
			   type: "POST",
			   url: "<?php echo U('Admin/Map/savePosition');?>",
			   data: 'lng='+e.point.lng+'&lat='+e.point.lat,
			   success: function(msg){
				 
			   }
			});
			     
	});
	
	                                 // 开启标注工具     
	<?php if(!empty($searchname)): ?>var local = new BMap.LocalSearch(map, {
	  renderOptions:{map: map}
	});
	local.search("<?php echo ($searchname); ?>");<?php endif; ?>
	
	
	
	var content = '<div style="margin:0;line-height:20px;padding:2px;">'  +
                    ' 地址：<?php echo ($add); ?>'
					+'<p class="mapTel"><span class="mapNumber"><a href="tel:<?php echo ($phone); ?>">'+'<?php echo ($phone); ?>'+'</a></span></p>传真：<?php echo ($fax); ?><br>QQ客服：<?php echo ($customer); ?><br>E-mail：<?php echo ($email); ?>　' +
                  '</div>';
	//创建检索信息窗口对象
    var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
			title  : "<?php echo ($cname); ?>",      //标题
			width  : 290,             //宽度
			height : 150,              //高度
			panel  : "panel",         //检索结果面板
			enableAutoPan : true,     //自动平移
			searchTypes   :[
				BMAPLIB_TAB_SEARCH,   //周边检索
				BMAPLIB_TAB_TO_HERE,  //到这里去
				BMAPLIB_TAB_FROM_HERE //从这里出发
			]
		});
	
	 searchInfoWindow.open(marker); //在marker上打开检索信息串口
	
</script>
</div>
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