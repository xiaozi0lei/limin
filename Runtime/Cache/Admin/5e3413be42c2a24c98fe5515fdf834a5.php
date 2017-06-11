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
.list_table td{
text-align:center;
font-size:14px;
}

</style>
<script>

function docheck(t,quick){
	
	var keytype=$("input[name='keytype']:checked");
	var chk_value ="";
	var eng='';
	$('.datalist').remove();
	
	$("input[name='keytype']:checked").each(function(){
               chk_value += $(this).val()+",";    
     });
	
	if(chk_value==''){
		alert('请选择关键词类');
		return false;
	}
	
	
	$("input[name='eng']:checked").each(function(){
               eng += $(this).val()+",";    
     });
	
	if(eng==''){
		alert('请选择搜索引擎');
		return false;
	}

	
	$('.b_docheck').attr('disabled','disabled');
	$.ajax({
	  type: "GET",
	  url: "<?php echo U('Admin/Rank/getword');?>",
	  data:{'init':1,'keytype':chk_value},
	  dataType: "json",
	  success: function(data){
			$('#wordcout').html(data.count);
			$('#current_word').text(data.first_word);
			$('#current').text(1);
			$('#now_find').css('display','')			
			dorank(data.count,eng,quick)
			
	  }

	});

}

function getnum(keytype){

	$.ajax({
	  type: "GET",
	  url: "<?php echo U('Admin/Rank/getword');?>",
	  data:{'init':1,'keytype':keytype},
	  dataType: "json",
	  async:'false',
	  success: function(data){
			$('#wordcout').html(data.count);
						
	  }

	});

}

function stoprank(){
	$.ajax({
	  type: "GET",
	  url: "<?php echo U('Admin/Rank/stoprank');?>",
	  dataType: "json",
	  success: function(data){}

	});
	

}
function dorank(count,eng,quick){


	$.ajax({
	  type: "GET",
	  url: "<?php echo U('Admin/Rank/dorank');?>",
	  dataType: "json",
	  data:{'total_count':count,'eng':eng},
	  timeout: 60000,
	  success: function(rs){
	  
	  		if(rs.status==1){
				if(rs.error==1){
					alert('错误');
				}
				
				var data_list_count=$('.datalist').length;
				var hasrank=0;
				for(var key in rs.data.eng){
				
					if(rs.data.eng[key].rank!=0){
						hasrank=1;
						break;
					}
				
				}
				
				
				
				if(hasrank){
				
					$('.list_table').append('<tr class="datalist"><th colspan="2" scope="col">'+rs.data.keyword+'</th><th scope="col" class="baidu" id="engbaidu_'+data_list_count+'"></th><th scope="col" class="360" id="eng360_'+data_list_count+'" style="display:none"></th><th scope="col" class="soso" id="engsoso_'+data_list_count+'" style="display:none"></th><th scope="col" class="sogou" id="engsogou_'+data_list_count+'" style="display:none"></th><th scope="col" class="youdao" id="engyoudao_'+data_list_count+'" style="display:none"></th><th scope="col" class="bing" id="engbing_'+data_list_count+'" style="display:none"></th></tr>');
					
				
				}
				
				
				
				
				for(var key in rs.data.eng){
			
					$('#'+key+'_'+data_list_count).html('<a target="_blank" href="'+rs.data.eng[key].url+'">'+rs.data.eng[key].page+' - '+rs.data.eng[key].rank+'</a>');
					$('#'+key+'_'+data_list_count).css('display','');
					
					
					
					if(quick!=1){
						
						if(key=='engbaidu'&&rs.data.eng['engbaidu'].hasban==1){
					
							art.dialog.alert('由于搜索引擎屏蔽机制限制，20分钟后继续查询，请不要关闭浏览器当前页面');
							setTimeout('dorank('+count+',\''+eng+'\','+quick+')',1500000);
							return false;
						}
					
					}
					
				}

				$('#current').text(rs.data.current_num);
				$('#current_word').text(rs.data.next_keyword);
				

				setTimeout('dorank('+count+',\''+eng+'\','+quick+')',10)
			
				
				
			    
				
			
			}else{
				
				
				$('.b_docheck').attr('disabled','');
				
				
				alert('查询完毕');
				$('#now_find').css('display','none')
			}
	  
			
	  },
	  error: function(XMLHttpRequest, textStatus, errorThrown){
	        //超时重试
      		setTimeout('dorank('+count+',\''+eng+'\','+quick+')',10000)
	  }

	});

}

function changetitle(t){
		
		if(!$(t).attr('checked')){
			$('#'+$(t).val()).css('display','none');
			$('#eng'+$(t).val()).css('display','none');
			$('.'+$(t).val()).css('display','none');
		}else{
			$('#'+$(t).val()).css('display','');
			$('#eng'+$(t).val()).css('display','');
			$('.'+$(t).val()).css('display','');
		}
		

}

</script>
<div class="rightCon1 fl" >
     <div class="conTitle">链接管理</div>
     <div class="conNav">
       <ul>
		<li <?php if(ACTION_NAME=='rank'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Admin/Rank/index'); echo ($language); ?>"><span>排名查询</span></a></li> 
       </ul>
    </div>
	 
	 
	 	<form id="form_id" action="<?php echo U('Admin/Style/doSaveStyleCustomer');?>" method="post">
	 <div style=" width:800px;float:left; padding:10px;">
	 
	 <div style=" color:red; font-size:13px; padding:10px;">由于搜索引擎具有屏蔽机制,搜索量过高易被屏蔽,只能检索到部分排名结果,一天内请不要频繁查询，否则会被屏蔽</div>
	 
	 <div style="float:left;">关键词类: <input type="checkbox"  value="mainkey"  name="keytype" checked="checked"/>主词 <input type="checkbox" value="arekey" name="keytype"/>地区词 <input type="checkbox" value="longkey" name="keytype"/>长尾词</div>
	 <div style="clear:both; float:left;">搜索引擎: 
	 <input type="checkbox"  name="eng" checked="checked" value="baidu" iname="百度" onclick="changetitle(this)" />百度  
	 <input type="checkbox" name="eng" value="360" onclick="changetitle(this)" iname="360"/>360 
	 <!--<input type="checkbox" name="eng" value="google" iname="谷歌" onclick="changetitle(this)"/>谷歌 -->
	 <input type="checkbox" name="eng"  value="soso" iname="搜搜" onclick="changetitle(this)"/>搜搜  
	 <input type="checkbox" name="eng" value="sogou" iname="搜狗" onclick="changetitle(this)"/>搜狗 
	 <input type="checkbox" name="eng" value="youdao" onclick="changetitle(this)" iname="有道"/>有道 
	 <input type="checkbox" name="eng"  value="bing" onclick="changetitle(this)" iname="必应"/>必应
	 </div>
	 <div style="float:right;"><input style="float:right; margin-left:10px;vertical-align:middle; height:25px;" type="button" onclick="docheck(this)" class="b_docheck" value="普通查询"  /><input style="float:right; margin-left:50px;vertical-align:middle; height:25px;" type="button" onclick="docheck(this,1)" class="b_docheck" value="快速查询"  /><input style="float:right;vertical-align:middle; height:25px;" type="button" value="停止查询" onclick="stoprank()" /> <input type="button" style="float:right;vertical-align:middle; height:25px;" onclick="window.location.href='<?php echo U('Admin/Rank/export');?>'" value="导出查询" /></div>
	 <div style="height:25px; clear:both; line-height:25px; font-size:14px; font-weight:bold; margin-right:50px;">
	 
	 <span id="now_find" style=" display:none;">正在查询关键词: <span id="current_word" style="font-weight:bold; color:red;"></span> </span>
	 <span id="current">0</span><span>/</span><span id="wordcout">0</span>
	 
	 
 	   </div>
	 </div>
<style>
.list_table a{
color: red;
text-decoration:underline;
}
</style>	 
<table width="100%" border="0" cellpadding="0" cellspacing="1"  class="list_table"  >


   
   <tr id="title_eng">
    <th colspan="2" scope="col">关键词</th>
	<th scope="col" id="baidu">百度</th>
	<th scope="col" id="360" style="display:none">360</th>
	<!--<th scope="col" id="google" style="display:none">谷歌</th>-->
	<th scope="col" id="soso" style="display:none">搜搜</th>
	<th scope="col" id="sogou" style="display:none">搜狗</th>
	<th scope="col" id="youdao" style="display:none">有道</th>
	<th scope="col" id="bing" style="display:none">必应</th>
  </tr>
  
  <tr>
    <th colspan="2" scope="col"></th>
	<th scope="col" id="engbaidu"></th>
	<th scope="col" id="eng360" style="display:none"></th>
    <!--<th scope="col" id="enggoogle" style="display:none"></th>-->
    <th scope="col" id="engsoso" style="display:none"></th>
	<th scope="col" id="engsogou" style="display:none"></th>
	<th scope="col" id="engyoudao" style="display:none"></th>
	<th scope="col" id="engbing" style="display:none"></th>
  </tr>

  
  
</table>

</form>
	 
	 </div>
	 



   <div class="clear"></div>
 </div>
 <div class="clear"></div>
</center>
</div>
<div style="background:url(__PUBLIC__/images/bottom.png) left; height:6px; font-size:0px; margin:0 auto; width:1204px; clear:both; margin-bottom:50px;"></div>
</body>
</html>