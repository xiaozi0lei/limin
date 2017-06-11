<?php if (!defined('THINK_PATH')) exit();?><style>
#btn_order{
margin-top:50px;
}
#title_ul{
height: 25px;
margin: 15px 10px 25px;
list-style:none;
padding:0px;
}
#title_ul li{
float: left;
    font-size: 14px;
    font-weight: bold;
    height: 25px;
    line-height: 25px;
}
#title_ul span{
    display: block;
    height: 25px;
}
#title_ul .one{
background: url(../Public/images/tab.gif) repeat scroll 0 -200px transparent;
}
#title_ul .one span{
background: url(../Public/images/tab.gif) repeat scroll right -175px transparent;
    color: #FFFFFF;
    margin-left: 12px;
}
#title_ul .two{
 background: url(../Public/images/tab.gif) repeat scroll 0 -100px transparent;
    margin-left: -8px;
}
#title_ul .two span{
   background: url(../Public/images/tab.gif) repeat scroll right -75px transparent;
    margin-left: 12px;
    padding-left: 10px;
}
#title_ul .three{
  background: url(../Public/images/tab.gif) repeat scroll 0 -100px transparent;
    margin-left: -8px;
}
#title_ul .three span{
      background: url(../Public/images/tab.gif) repeat scroll right -125px transparent;
    margin-left: 12px;
    padding-left: 10px;
}
.qing_title{
border-bottom: 2px solid #D9D9D9;
    height: 22px;
    margin: 0 10px 10px;
}
.qing_title span{
    background: url(../Public/images/ico.gif) no-repeat scroll 0 1px transparent;
    color: #E95925;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    padding-left: 8px;
    vertical-align: middle;
}
.list td{
border: 1px solid #D9D9D9;
    height: 30px;
}
.list_title{
 color: #666666;
 font-weight:bold;
 background: url(../Public/images/bg_2.gif) repeat scroll 0 0 transparent;
 text-align:center;
   
}
.ttable{
border-collapse: collapse;
    border-spacing: 0;
	font-size: 12px;
	margin-left:10px;
}
#total_order{
text-align:right;
}
#total_order span{
font-size:12px;
}
#total_order b{

    color: #E02C2C;
    font-size: 24px;
    margin: 0 5px;
	}
.Order_jian{
    background: url(../Public/images/ico_4.gif) repeat scroll 0 -13px transparent;
    cursor: pointer;
    font-size: 0;
    height: 13px;
    width: 13px;
	display: inline-block;
    vertical-align: middle;
}
.num_input{
    border: 1px solid #8AB5E0;
    color: #666666;
    font-weight: bold;
    height: 17px;
    margin: 0 2px;
    text-align: center;
    width: 34px;
}

.Order_jia {
	display: inline-block;
    vertical-align: middle;
    background: url(../Public/images/ico_4.gif) repeat scroll 0 0 transparent;
    cursor: pointer;
    font-size: 0;
    height: 13px;
    width: 13px;
}

.go{
display:block;
border:1px solid #CCCCCC;
color:#999999;
padding:3px;
font-size:13px;
text-decoration:none;
font-weight:bold;
margin-bottom:5px;
height:19px;
line-height:19px;
}

.orderbuy{
display:block;
border:1px solid #6ABC14;
color:#6ABC14;
padding:3px;
font-size:13px;
text-decoration:none;
font-weight:bold;
float:right;
}
	
</style>
<script>
var site_url='<?php echo U('/');?>';
var tpl_path='<?php echo (APP_TMPL_PATH); ?>';
var public = '__PUBLIC__';
var mobile = '<?php echo ($wapon); ?>';
</script>

<script src="__PUBLIC__/js/jquery-1.4.4.min.js"></script>
<script src="__PUBLIC__/js/common.js"></script>
<script src="__PUBLIC__/js/artDialog/jquery.artDialog.js?skin=<?php echo ($shop["dio"]); ?>"></script>
<script src="__PUBLIC__/js/artDialog/iframeTools.js"></script>
<div id="shopwapper" style="width:680px;">
 <form action="<?php echo U('Public/doOrder');?>" method="post">

  <ul id="title_ul">
    <li style="width:215px; " class="one"><span>1.填写收货地址</span></li>
    <li style="width:215px; " class="two"><span>2.付款给商家</span></li>
    <li style="width:215px; " class="three"><span>3.下单成功</span></li>
  </ul>
  <h2 class="qing_title"><span>商品清单</span></h2>
  <table width="660" class="ttable">
    <tbody  class="list">
      <tr class="list_title">
        <td>商品信息</td>
        <td width="75">单价(元)</td>
        <td width="95">数量</td>
        <td width="75">小计(元)</td>
        <td width="55">操作</td>
      </tr>
	  
	  <script>
			function inputchange(t){
				
				
				var tr=$(t).parents("tr");
				var num_input=tr.find('.num_input')
				var price=parseFloat(tr.find('#price').text()).toFixed(2);
				var num=$(t).val();;
				
				if(num < 1){
					num=1;
				}
				
				num_input.val(num);
				var item_total=price*num_input.val();
				tr.find('.item_total').text(item_total.toFixed(2));
				total_num();	
			
			}
			function downnum(t,oid){
				
				
				var count_str=$.cookie('count');
				var price_str=$.cookie('price');
				var id_str=$.cookie('id');
				var prices=price_str.split('|');
				var counts=count_str.split('|');
				var ids=id_str.split('|');
				
				var index=0;
				for(var i=0;i<ids.length;i++){
						
						if(ids[i]==oid){
							index=i;
						}
				}
				
				
				
				var tr=$(t).parents("tr");
				var num_input=tr.find('.num_input')
				var price=parseFloat(tr.find('#price').text()).toFixed(2);
				var num=num_input.val();
				
				if(num!=1){
					num_input.val(parseInt(num)-1);
					var item_total=price*num_input.val();
					tr.find('.item_total').text(item_total.toFixed(2));
					total_num();
					
					counts[index] =parseFloat(counts[index])-1;
					prices[index] =(parseFloat(prices[index])-parseFloat(price)).toFixed(2);
					
					$.cookie('price',prices.join('|'),{expires:7, path:'/'});
					$.cookie('count',counts.join('|'),{expires:7, path:'/'});
					
				}
				
				
				
				
			}
		
		function upnum(t,oid){
		
				var count_str=$.cookie('count');
				var price_str=$.cookie('price');
				var id_str=$.cookie('id');
				var prices=price_str.split('|');
				var counts=count_str.split('|');
				var ids=id_str.split('|');
				var index=0;
				for(var i=0;i<ids.length;i++){
						
						if(ids[i]==oid){
							index=i;
						}
				}
				
				
				
				var tr=$(t).parents("tr");
				var num_input=tr.find('.num_input')
				var price=parseFloat(tr.find('#price').text()).toFixed(2);
				var num=num_input.val();
				
				num_input.val(parseInt(num)+1);
				var item_total=price*num_input.val();
				tr.find('.item_total').text(item_total.toFixed(2));	
				
				
				counts[index] =parseFloat(counts[index])+1;
				prices[index] =(parseFloat(prices[index])+parseFloat(price)).toFixed(2);
				
				$.cookie('price',prices.join('|'),{expires:7, path:'/'});
				$.cookie('count',counts.join('|'),{expires:7, path:'/'});
				
				total_num();
		
		}
		
		function total_num(){


			var total=$('.item_total');
			var t=0;
			for(var i=0;i<total.length;i++){
				var jia=parseFloat($(total[i]).text());
				t +=jia;
			}
			
			
			
			$('#total_order').find('b').text(parseFloat(t).toFixed(2));
	
			
		}
		
		function delteitem(t,oid){
			var tr=$(t).parents("tr");
			tr.remove();
			total_num();
			var id_str=$.cookie('id');
			var count_str=$.cookie('count');
			var price_str=$.cookie('price');
			
			
			var prices=price_str.split('|');
			var counts=count_str.split('|');
			var ids=id_str.split('|');
			var index=0;
			for(var i=0;i<ids.length;i++){
					
					if(ids[i]==oid){
						index=i;
					}
			}
			ids.splice(index,1);
			prices.splice(index,1);
			counts.splice(index,1);
			var idstr=ids.join('|'),
			    pricestr=prices.join('|'),
				countstr=counts.join('|');
				

				$.cookie('id',idstr,{expires:7, path:'/'});
				$.cookie('price',pricestr,{expires:7, path:'/'});
				$.cookie('count',countstr,{expires:7, path:'/'});
			
			var a=$('#num',window.parent.document).text();
				$('#num',window.parent.document).text(a-1);

			

		}
		
		</script>
	  
     
	  
	  <?php if(is_array($pro)): $i = 0; $__LIST__ = $pro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
        <td><div  style="width:250px" class="Order_a"><?php echo ($order["title"]); ?></div></td>
        <td width="75" ><div id="price" style="text-align:center;"><?php echo ($order["price"]); ?></div></td>
        <td width="95" >
		<div style="text-align:center;"> 
		<span onclick="downnum(this,<?php echo ($order["id"]); ?>);" id="downNum" class="Order_jian"></span>
            <input type="text" onchange="inputchange(this,<?php echo ($order["id"]); ?>)" value="<?php echo ($order["count"]); ?>" name="ids[<?php echo ($order["id"]); ?>]" class="num_input" >
        <span onclick="upnum(this,<?php echo ($order["id"]); ?>)" id="upNum" class="Order_jia"></span> 
		</div></td>
        <td width="75" id="" class="fontcolor2"><div style="text-align:center;"> <strong> <span class="item_total"><?php echo ($order["list_price"]); ?></span> </strong> </div></td>
        <td width="55" align="center" ><a style="cursor:pointer;" onclick="delteitem(this,<?php echo ($order["id"]); ?>)" id="delect" href="javascript:;">删除</a></td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	  
    </tbody>
  </table>
  {__TOKEN__}
  
  <div style=" margin-left:10px;background-color:#F1F5F6;  width:616px; padding-top:5px; font-size:13px;padding-right:10px; padding-bottom:10px;"><div style="float:right;">备注:<textarea style="float:right; height:30px; " name="beizhu"></textarea></div><div style="clear:both;"></div></div>

<div id="total_order">
<span>商品总价(不含运费)：</span>
<b><?php echo ($total); ?></b>
<span>元</span>
</div>
<Div style="margin-top:60px;">
<a href="javascript:void(0)" class="go" style="float:left;" onclick="art.dialog.close();">继续购物</a>
<input type="submit" value="下一步" class="orderbuy"  />
</Div>

</form>
</div>