<?php if (!defined('THINK_PATH')) exit();?><style>
#btn_order{
overflow:hidden;
padding-top:50px;
}

#btn_order #go{
display:block;
border:1px solid #CCCCCC;
color:#999999;
padding:3px;
font-size:13px;
text-decoration:none;
font-weight:bold;
margin-bottom:5px;
width:80px;
text-align:center;
float:left;
}

#btn_order #orderbuy{
display:block;
border:1px solid #6ABC14;
color:#6ABC14;
padding:3px;
font-size:13px;
text-decoration:none;
font-weight:bold;
width:80px;
float: right;
text-align:center;
}

</style>
<script>
var site_url='<?php echo site_url();?>';
var tpl_path='<?php echo (APP_TMPL_PATH); ?>';
var public = '__PUBLIC__';
var mobile = '<?php echo ($wapon); ?>';
</script>
<script src="__PUBLIC__/js/jquery-1.4.4.min.js"></script>
<script src="__PUBLIC__/js/common.js"></script>
<script src="__PUBLIC__/js/artDialog/jquery.artDialog.js"></script>
<script src="__PUBLIC__/js/artDialog/iframeTools.js"></script>
<script>
//购物车产品数目

$(function(){
	
	var countstr=$.cookie('count');
		var count=0
		
		if(typeof(countstr)=='object'||countstr==''){
			count=0;
		}else{
			count=countstr.split('|').length;
		}
		
		$(window.parent.document).find('#num').text(count);
	

})

</script>
<div id="shopwapper">

<div style="font-size:14px; overflow:hidden;">
<img src="../Public/images/cat.gif" style=" float:left" />
<span style="margin-left:10px;">共有<strong style="color:#FF0000"><?php echo ($count); ?></strong>件商品</span><br />
<span style="margin-left:10px;">总计<strong style="color:#FF0000"><?php echo ($price); ?></strong>元</span>
</div>
<div id="btn_order">
<a href="javascript:void(0)" id="go" onclick="art.dialog.close();">继续购物</a>
<a href="<?php echo U('Public/pay');?>" id="orderbuy">立即结算</a>
</div>

</div>