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
   
   
   <!--右边开始-->
   <div class="rightCon1 fl">
   <div style="margin: 20px 50px;">
     <div class="fuwurexian">
      
       <div  style="background-color:#FCF7E3; border:1px solid #CAB276; padding:10px 20px; color:#CAB276;">
         <strong>&nbsp;&nbsp;服务热线：</strong>商务部：0535-6232222 打尽部：0535-6687233   客服部：0535-6687200 运营部：0535-6687333
       </div>
     
       <div class="clear"></div>
     </div>
	 	 <div class="liuliang" style="clear:both;padding-top:50px">
<img src='http://www.sjhl.cn/Tpl/Home/default/Public/images/sjhl-logo.png'/>
	 </div>
     <div class="message">
       <ul>
         <li>
		 	<a href="<?php echo U('Admin/Message/messageList',array('xunpan'=>0));?>" style="display:block;  height:86px;">
           <div class="messageIcon fl"><img src="__PUBLIC__/images/main11.jpg" /></div>
           <div class="messageText fl">
             <div class="messTitle">留言</div>
             <div class="messView"><?php echo ($pmcount); ?></div>
           </div>
		   </a>
         </li>
         <li>
		   <a href="<?php echo U('Admin/shop/orderAll');?>" style="display:block; height:86px;">
           <div class="messageIcon fl"><img src="__PUBLIC__/images/main12.jpg" /></div>
           <div class="messageText fl">
             <div class="messTitle">订单</div>
             <div class="messView"><?php echo ($ordercount); ?></div>
           </div>
		    </a>
         </li>
         <li>
		   <a href="<?php echo U('Admin/Message/messageList',array('xunpan'=>1));?>" style="display:block;  height:86px;">
           <div class="messageIcon fl"><img src="__PUBLIC__/images/main13.jpg" /></div>
           <div class="messageText fl">
             <div class="messTitle">网站询盘</div>
             <div class="messView"><?php echo ($xuncount); ?></div>
           </div>
		   </a>
         </li>
         <li>
		   <a href="<?php echo U('Admin/member/listMember');?>" style="display:block;  height:86px;">
           <div class="messageIcon fl"><img src="__PUBLIC__/images/main14.jpg" /></div>
           <div class="messageText fl">
             <div class="messTitle">会员</div>
             <div class="messView"><?php echo ($membercount); ?></div>
           </div>
		   </a>
         </li>
         <div class="clear"></div>
       </ul>
     </div>
	 	 	 <div class="liuliang" style="clear:both;padding-top:150px">

	 </div>

    <!-- <div class="liuliang">
       <div class="liuliangTitle" style="clear:both;">新闻列表</div>
	   
	  <div>
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
		  <tr>
			
			<th  scope="col">id</th>
			<th scope="col"><?php echo (L("order")); ?></th>
			<th  scope="col">分类</th>
			<th  scope="col">推荐</th>
			<th  scope="col"><?php echo (L("date")); ?></th>
	
		  </tr>
		  
		  
		  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr class="list_tr">
			
			<td class="list_td"><?php echo ($li["id"]); ?></td>
			<td class="list_td"><input type="text"  name="order[<?php echo ($li["id"]); ?>]" value="<?php echo ($li["a_order"]); ?>"  class="bind_change" /></td>
			<td class="list_td" style="text-align:center; "><a href="<?php echo U('Admin/Article/articleList',array('sortid'=>$li['sort']));?>"><?php echo ($li["sortname"]); ?></a></td>
			<td class="list_td" style="text-align:center;"><a href="<?php echo U('Home/Article/show',array('id'=>$li['id']));?>" target="_blank"><?php echo ($li["title"]); ?></a></td>
			
			<td class="list_td"><?php if(($li["top"]) == "1"): ?><a href="javascript:void(0)" onclick="op_one(this,'<?php echo U('Admin/Article/doTop');?>')" class="access_allow"></a><?php endif; if(($li["top"]) == "0"): ?><a href="javascript:void(0)" onclick="op_one(this,'<?php echo U('Admin/Article/doTop');?>')" class="access_disallow"></a><?php endif; ?></td>
			<td class="list_td"><?php echo date('Y-m-d H:i',$li['dateline']); ?></td>
			
		  </tr><?php endforeach; endif; else: echo "" ;endif; ?>  
		</table>
		</div>
	  
	   
	  <div style="clear:both;"></div>
     </div>-->
   <!--  <div class="liuliang" style="clear:both;">
       <div class="liuliangTitle">产品列表</div>

	   <div>
	   <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="list_table">
		  <tr>
			<th scope="col">ID</th>
			<th scope="col"><?php echo (L("order")); ?></th>
			<th scope="col">分类</th>
			<th scope="col"><?php echo (L("atitle")); ?></th>
			<th scope="col">缩略图</th>
			<th scope="col">推荐</th>
			<th scope="col"><?php echo (L("date")); ?></th>
			
		  </tr>
		  
		  
		  <?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr class="list_tr">
			<td class="list_td"><?php echo ($li["id"]); ?></td>
			<td class="list_td"><input type="text" name="order[<?php echo ($li["id"]); ?>]" value="<?php echo ($li["p_order"]); ?>"  class="bind_change" /></td>
			<td class="list_td"><a href="<?php echo U('Admin/Product/productList',array('sortid'=>$li['sort']));?>"><?php echo ($li["sortname"]); ?></a></td>
			<td class="list_td"><a href="<?php echo U('Home/Product/show',array('id'=>$li['id']));?>" target="_blank"><?php echo ($li["title"]); ?></a></td>
			<td class="list_td"><img src="<?php echo ($li['img']); ?>" width="38" height="23" /></td>
			<td class="list_td"><?php if(($li["top"]) == "1"): ?><a href="javascript:void(0)" onclick="op_one(this,'<?php echo U('Admin/Product/doTop');?>')" class="access_allow"></a><?php endif; if(($li["top"]) == "0"): ?><a href="javascript:void(0)" onclick="op_one(this,'<?php echo U('Admin/Product/doTop');?>')" class="access_disallow"></a><?php endif; ?></td>
			<td class="list_td"><?php echo date('Y-m-d H:i',$li['dateline']); ?></td>
			
		  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	
		
		
		</table>
	   
	   
	   </div>
	  <div style="clear:both;"></div>
     </div>-->
	 <div style="clear:both;"></div>
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