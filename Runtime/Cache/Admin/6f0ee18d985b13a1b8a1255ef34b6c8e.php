<?php if (!defined('THINK_PATH')) exit();?><div>
<table width="376" height="102" style="font-size:13px;">
  <tr>
    <th width="112" scope="row">收货人:</th>
    <td width="253"><?php echo ($order["username"]); ?></td>
    </tr>
  <tr>
    <th scope="row">联系电话:</th>
    <td><?php echo ($order["phone"]); ?></td>
    </tr>
  <tr>
    <th scope="row">收货地址:</th>
    <td><?php echo ($order["address"]); ?></td>
   </tr>

</table>
<div style="border:1px dashed #CCCCCC; float: left; margin-top:20px; padding-bottom:10px; padding-top:10px;">
<script>
function changetype(t){
	
	if($(t).val()=='快递/物流'){
		$('#num_tr').css('display','');
	}else{
		$('#num_tr').css('display','none');
	}
}

function checkform(){
	if($('#sender').val()==''){
		art.dialog({
			icon: 'error',
			content: '请选择物流公司'
		});
		
		return false;
	}
	
	if($("input[name='wuliu']").val()=='快递/物流'&&$('#order_num').val()==''){
		art.dialog({
			icon: 'error',
			content: '请填写单号'
		});
		return false;
	}
	
	
	return true;


}

</script>
<form method="post" action="<?php echo U('Admin/shop/dosend');?>" id="send_form">
<table width="376" height="100" style="font-size:13px;">
  <tr>
    <th width="112" scope="row"></th>
    <td width="253">
	<input type="radio"  name="wuliu" value="快递/物流" checked="checked" onclick="changetype(this)"/>快递/物流
	 <input value="买家自提" name="wuliu" type="radio" name="wuliu" onclick="changetype(this)"/>买家自提
	  <input value="送货上门" name="wuliu" type="radio" name="wuliu" onclick="changetype(this)"/>送货上门</td>
    </tr>
  <tr>
    <th scope="row">物流公司:</th>
    <td><select style="height:24px;" name="sender" id="sender">
			  <option value="">请选择物流公司</option>
			  
			  <option value="顺丰">顺丰</option>
			  
			  <option value="中邮物流">中邮物流</option>
			  
			  <option value="中通速递">中通速递</option>
			  
			  <option value="中铁快运">中铁快运</option>
			  
			  <option value="宅急送">宅急送</option>
			  
			  <option value="韵达快运">韵达快运</option>
			  
			  <option value="圆通速递">圆通速递</option>
			  
			  <option value="鑫飞鸿物流快递">鑫飞鸿物流快递</option>
			  
			  <option value="民航快递">民航快递</option>
			  
			  <option value="龙邦物流">龙邦物流</option>
			  
			  <option value="联昊通物流">联昊通物流</option>
			  
			  <option value="快捷速递">快捷速递</option>
			  
			  <option value="加运美速递">加运美速递</option>
			  
			  <option value="急先达物流">急先达物流</option>
			  
			  <option value="京品快递">京品快递</option>
			  
			  <option value="佳吉快运">佳吉快运</option>
			  
			  <option value="京广速递">京广速递</option>
			  
			  <option value="金大物流">金大物流</option>
			  
			  <option value="华夏龙物流">华夏龙物流</option>
			  
			  <option value="恒路物流">恒路物流</option>
			  
			  <option value="汇通快运">汇通快运</option>
			  
			  <option value="广东邮政物流">广东邮政物流</option>
			  
			  <option value="港中能达物流">港中能达物流</option>
			  
			  <option value="凤凰快递">凤凰快递</option>
			  
			  <option value="飞康达物流">飞康达物流</option>
			  
			  <option value="FedEx">FedEx</option>
			  
			  <option value="速快递">D速快递</option>
			  
			  <option value="DHL">DHL</option>
			  
			  <option value="德邦物流">德邦物流</option>
			  
			  <option value="大田物流">大田物流</option>
			  
			  <option value="长宇物流">长宇物流</option>
			  
			  <option value="中国东方">中国东方（COE）</option>
			  
			  <option value="希伊艾斯快递">希伊艾斯快递</option>
			  
			  <option value="彪记快递">彪记快递</option>
			  
			  <option value="安信达快递">安信达快递</option>
			  
			  <option value="安捷快递">安捷快递</option>
			  
			  <option value="全球专递">AAE全球专递</option>
			  
			  <option value="其他">其他</option>
		</select></td>
    </tr>
  <tr id="num_tr">
    <th height="23" scope="row">运单号:</th>
    <td><input type="text" value="" name="order_num" id="order_num" /></td>
   </tr>	
</table>
<input type="hidden" name="id" value="<?php echo ($order["id"]); ?>" />
</form>
</div>


</div>