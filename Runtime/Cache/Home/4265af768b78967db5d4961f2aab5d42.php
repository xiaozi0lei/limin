<?php if (!defined('THINK_PATH')) exit();?><style>
#inhert_cart{
margin-top:20px;
}
#btn_buy{
 	background: url(__PUBLIC__/images/moban_btn.gif) repeat scroll 0 -68px transparent;
    height: 36px;
    width: 142px;
	border: medium none;
    cursor: pointer;
}

#btn_incart{
	background: url(__PUBLIC__/images/moban_btn.gif) repeat scroll 0 -104px transparent;
    height: 36px;
    margin-left: 10px;
    width: 142px;
	border: medium none;
    cursor: pointer;
}


#cart{
width:110px;
height:42px;
z-index:999999;
right:10px;
bottom:0px;
background: url(__PUBLIC__/images/moban_btn.gif) repeat scroll 0 -216px transparent;
position:fixed;
}
#cart_a{

height:42px;
width:50px;
float:left;
display:block;
}
#order_a{

height:42px;
width:50px;
display:block;
float:left;
}
#num{
position:absolute;
left:33px;
font-size:11px;
top:2px;
color:#FFFFFF;
}
</style>
<script>

	   	$('body').append('<div id="cart"><b id="num">0</b><a href="javascript:void(0)" onclick="show_checkout()" id="cart_a"></><a href="javascript:void(0)" onclick="show_search()" id="order_a"></a></div>');
		
		var countstr=$.cookie('count');
		var count=0
		
		if(typeof(countstr)=='object'||countstr==''){
			count=0;
		}else{
			count=countstr.split('|').length;
		}

		$('#num').text(count);

</script>
<div id="inhert_cart">
<input type="button"  title="立即购买" id="btn_buy" onclick="show_card(0)"> 
<input type="button" title="加入购物车" id="btn_incart" onclick="show_card(1)">
</div>