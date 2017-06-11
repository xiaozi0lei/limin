<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
$(document).ready(function(){

	$("#floatShow").bind("click",function(){
	
		$("#onlineService").animate({width:"show", opacity:"show"}, "normal" ,function(){
			$("#onlineService").show();
		});
		
		$("#floatShow").attr("style","display:none");
		$("#floatHide").attr("style","display:block");
		
		return false;
	});
	
	$("#floatHide").bind("click",function(){
	
		$("#onlineService").animate({width:"hide", opacity:"hide"}, "normal" ,function(){
			$("#onlineService").hide();
		});
		
		$("#floatShow").attr("style","display:block");
		$("#floatHide").attr("style","display:none");
		
		return false;
	});
  
});
</script>


<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}

/* online */
#online_qq_tab a,.onlineMenu h3,.onlineMenu li.tli,.newpage{background:url(../Public/images/float_s.gif) no-repeat;}
#onlineService.blue{  border:1px solid #0066FF;}
#onlineService.red{  border:1px solid red;}

#online_qq_tab a{ background:none;}
#online_qq_layer{z-index:9999;position:fixed;right:0px;top:0;margin:150px 0 0 0;}
*html #online_qq_layer{position:absolute;top:expression(eval(document.documentElement.scrollTop));}

#online_qq_tab{width:28px;float:left;margin:120px 0 0 0;position:relative;z-index:9;}


#online_qq_tab a.blue{display:block; padding:6px; text-decoration:none; font-size:13px;overflow:hidden;         color:#FFFFFF; background-color:#0066FF;}
#online_qq_tab a.red{display:block; padding:6px; text-decoration:none; font-size:13px;overflow:hidden;         color:#FFFFFF; background-color: #FF0000;}


#online_qq_tab a#floatShow{background-position:-30px -374px;}
#online_qq_tab a#floatHide{background-position:0 -374px;}

#onlineService{display:inline;margin-left:-1px;float:left;width:130px;display:none;background-position:0 0;padding:10px 0 0 0; background-color:#FFFFFF;}
.onlineMenu{background-position:-262px 0;background-repeat:repeat-y;padding:0 15px;}
.onlineMenu h3{height:36px;line-height:999em;overflow:hidden;border-bottom:solid 1px #ACE5F9;}
.onlineMenu h3.tQQ{background-position:0 10px;}
.onlineMenu h3.tele{background-position:0 -47px;}
.onlineMenu li{height:36px;line-height:36px;border-bottom:solid 1px #E6E5E4;text-align:center;}
.onlineMenu li.tli{padding:0 0 0 28px;font-size:12px;text-align:left;}
.onlineMenu li.zixun{background-position:0px -131px;}
.onlineMenu li.fufei{background-position:0px -190px;}
.onlineMenu li.phone{background-position:0px -244px;}
.onlineMenu li a.newpage{display:block;height:36px;line-height:999em;overflow:hidden;background-position:5px -100px;}
.onlineMenu li img{margin:8px 0 0 0;}
.onlineMenu li.last{border:0;}

.wyzx{padding:8px 0 0 5px;height:57px;overflow:hidden;}

.btmbg{height:12px;overflow:hidden;background-position:-131px 0;}
</style>

<div id="online_qq_layer">
	<div id="online_qq_tab">
		<a id="floatShow" class="<?php echo ($customer_color); ?>" style="display:block;" href="javascript:void(0);">在线客服</a> 
		<a id="floatHide" class="<?php echo ($customer_color); ?>" style="display:none;" href="javascript:void(0);">在线客服</a>
	</div>
	<div id="onlineService" class="<?php echo ($customer_color); ?>">
		<div class="onlineMenu">
			<h3 class="tQQ">QQ在线客服</h3>
			<ul>
				<li class="tli zixun">在线咨询</li>
				
				<?php if(is_array($customer["qq"])): $i = 0; $__LIST__ = $customer["qq"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qq): $mod = ($i % 2 );++$i;?><li><a href="tencent://message/?uin=<?php echo ($qq); ?>&Site=&Menu=yes" title="QQ<?php echo ($qq); ?>"><img src="__PUBLIC__/images/qq/qq_<?php echo ($customer_qq); ?>.jpg" width="74" height="22"  /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(is_array($customer["msn"])): $i = 0; $__LIST__ = $customer["msn"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$msn): $mod = ($i % 2 );++$i;?><li><a href="msnim:chat?contact=<?php echo ($msn); ?>"><img src="__PUBLIC__/images/msn/msn_<?php echo ($customer_msn); ?>.jpg" width="74" height="22"  /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(is_array($customer["taobao"])): $i = 0; $__LIST__ = $customer["taobao"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$taobao): $mod = ($i % 2 );++$i;?><li><a href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo ($taobao); ?>&site=cntaobao&s=2&charset=utf-8" target="_blank"><img src="__PUBLIC__/images/taobao/taobao_<?php echo ($customer_taobao); ?>.jpg" width="74" height="22"  /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				
				<?php if(is_array($customer["alibaba"])): $i = 0; $__LIST__ = $customer["alibaba"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$alibaba): $mod = ($i % 2 );++$i;?><li><a href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo ($alibaba); ?>" target="_blank"><img src="__PUBLIC__/images/alibaba/alibaba_<?php echo ($customer_alibaba); ?>.jpg" width="74" height="22"  /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			
				
			</ul>
			
		</div>
		<div class="wyzx">
			<?php echo ($customer_bottomer); ?>
		</div>
		
		<div class="btmbg"></div>
	</div>
</div>