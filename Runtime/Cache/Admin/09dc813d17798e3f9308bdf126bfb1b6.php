<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>


<script src="__PUBLIC__/js/jquery-1.4.4.min.js" type="text/javascript"></script>

</head>
<body>
<font color="red">正在生成静态页，不要关闭浏览器!! 如果浏览器无跳转点击这里..<a href="<?php if(!empty($jumpurl)){echo $jumpurl;}else{echo $_SERVER["HTTP_REFERER"];}?>" >返回 <<</a></font>
<div id="pro_waper" style="border:1px solid red; float:left; width:200px; height:17px; font-size:0px;"><div id="process" style="background-color:#FF0000; width:0%;  height:100%;"></div></div><div>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="" target="_blank" id="pro_tips"> </a></div>
<script>

	var type='<?php echo ($type); ?>'

	if(type=='sort'){
		var sid=<?php echo (($sid)?($sid):0); ?>;
		var data_str='op=sort&sid='+'<?php echo ($sid); ?>&id=<?php echo ($id); ?>';
	}else if(type=='show'){
		var data_str='op=show&id='+'<?php echo ($id); ?>'+'&module='+'<?php echo ($module); ?>';
	}else if(type=='index'){
	    var data_str='op=index&sid='+'<?php echo ($sid); ?>&id=<?php echo ($id); ?>';
	}else if(type=='home'){
	    var data_str='op=home';
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
														
															location.href = '<?php if(!empty($jumpurl)){echo $jumpurl;}else{echo $_SERVER["HTTP_REFERER"];}?>';
												   }
												});
												
											}			
								   }
								});
				
					}
					
				}
				
		 	
	   }
	});
	
	

</script>


</body>
</html>