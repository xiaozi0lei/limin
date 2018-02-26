<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

<title><?php echo ($webtitle); ?></title>
<?php if((strtolower(MODULE_NAME)=='product'&&$pdescription)||strtolower(MODULE_NAME)=='index'): ?>
<meta name="keywords" content="<?php echo ($keyword); ?>" />
<meta name="description" content="<?php echo ($desc); ?>" />

<?php endif; ?>
<link rel="stylesheet" type="text/css" href="../Public/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../Public/css/bootstrap-responsive.css"/>

<link href="../Public/css/style.css" rel="stylesheet" type="text/css" />
<!--
你的样式写到oneself.css里
-->
<link href="../Public/css/oneself.css" rel="stylesheet" type="text/css" />
<link href="../Public/css/slideshow.css" rel="stylesheet" type="text/css" />

<script>
var site_url='<?php echo U('/');?>';
var tpl_path='<?php echo (APP_TMPL_PATH); ?>';
var public = '__PUBLIC__';
var mobile = '<?php echo ($wapon); ?>';
var root_path='<?php echo (__ROOT__); ?>';
</script>
<script type="text/javascript" src="../Public/js/jquery.min.js"></script>
<script type="text/javascript" src="../Public/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
<script type="text/javascript" src="../Public/js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "MainMenu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<script type="text/javascript" src="../Public/js/superslide.2.1.js"></script>
</head>
<body>

<div class="header">
 <div class="header_nr gg">
 <div class="logo fl"><img src="../Public/images/index_03.jpg" /></div>
<div class="daohang fr">
<div class="nav-pc">
     
  
  <div class="mobile_nav " id="mnav">
  <?php echo ($menu); ?>
   </div>
  
    </div>
</div>
 <br class="clear" />
 </div>
</div>
 
</div>

  	

 

<link href="../Public/css/css.css" rel="stylesheet" type="text/css" />
<script src="../Public/js/show.js" type=text/javascript></script>
<!--<script>


$(function(){

$.ajax({
   type: "POST",
   url: "<?php echo U('Home/Public/viewNum');?>",
   data: "module=product&id=<?php echo ($id); ?>",
   success: function(msg){
   		$('#hitnum').text(msg);
   }
});

})


var pid=<?php echo ($_GET['id']); ?>;

function show_card(is_cart){

	art.dialog.open(site_url+'Public/buy/id/'+pid+'/is_cart/'+is_cart);
}


function show_search(){
	art.dialog.open("<?php echo U('Public/search');?>");
}
function show_checkout(){
	art.dialog.open("<?php echo U('Public/checkout');?>");
}

</script>-->

<?php if($current_sort['id'] == 644 ): ?><img src="../Public/images/nypro.jpg" />
  <?php elseif($current_sort['id']==643): ?>
  <img src="../Public/images/nypro1.jpg" />
<?php else: ?>
<img src="../Public/images/nypro2.jpg" /><?php endif; ?>
 <div class="nyk gg">
<div class="nynr"><p><?php echo ($current_sort['name']); ?></p></div></div>
<div class="main">


<div id="page_main" class="clearfix">
  <div class="container">
   <div class="page-right">
    <div class="lanmu">
          <div class="lmdh fl">
 <div class="listnr"><div class="ddsmoothmenu-v" id="LeftMenu">
          <?php echo ($leftmenu); ?>
          <br class="clear" />
        </div></div>
</div>
      <div class="site-nav fr"><span>当前位置 : </span>
	  
		<?php echo ($location); ?>
	  
	  </div>
      <br class="clear" />
      </div>
    <div class="page-news">
      <div id="shownews">
        <h1 class="ptitle"><?php echo ($title); ?></h1>
       
        	
        </div>
       <div class="popover-banner">
        	<div id="p_slider" class="flexslider">
        		<?php if(!empty($piclist)): ?><ul class="slides">
			    <?php if(is_array($piclist)): $i = 0; $__LIST__ = $piclist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li><div class="slide"><img src="<?php echo ($list["thumb"]); ?>" width="100%" ref="<?php echo ($list["pic"]); ?>"> </div></li><?php endforeach; endif; else: echo "" ;endif; ?>
              </ul><?php endif; ?>
                          <a class="flex-prev" href=""></a>
                          <a class="flex-next" href=""></a>
                            </div>
                            	  
                            <script type="text/javascript">
							
								$(function () {
									$('#p_slider').flexslider({
										animation : 'slide',
										controlNav : true,
										directionNav : true,
										animationLoop : true,
										slideshow :true,
										useCSS : false,
										
										slideshowSpeed: 4000,           
                                        animationDuration: 1000,
									});
									
								});
							
							</script>
    <div class="lhgw">
   	<div id="shopjg"><span>产品价格:￥<?php echo ($price); ?></span></div>
   	<div id="shop_cart">
   	</div>	
 
   </div>
   </div>
 
   
		


		 <!--
         	
          <ul id="pro_info">

          <li><span>产品名称:</span> <span class="ptitle" style="font-weight:bold;"><?php echo ($title); ?></span></li>

          <li><span>产品分类:</span> <span><?php echo ($sortname["name"]); ?></span></li>
		  <li><span>公司名称:</span> <span><?php echo ($sitename); ?></span></li>
		  <li><span>型号规格:</span> <span><?php echo ($model); ?></span></li>
		   <li><span>产品用途:</span> <span><?php echo ($purpose); ?></span></li>
          <li><span>产品价格:</span> <span id="price" style="font-weight:bold; color:#FF0000; font-size:22px;">￥<?php echo ($price); ?></span></li>
			<?php if(is_array($field)): $i = 0; $__LIST__ = $field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$f): $mod = ($i % 2 );++$i;?><li><?php echo ($f["title"]); ?>: <?php echo ($f["value"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>	
	  
		  <li><span>添加时间:</span> <span id="dateline"><?php echo (date("y/m/d",$dateline)); ?></span></li>


		  <?php if(!empty($share_button)): ?><li><span style="float:left;">分&nbsp;&nbsp;&nbsp;&nbsp;享: </span> <span>
		<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a><a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script></span> </li><?php endif; ?>


		  <?php if(!empty($qrcode)): ?><li><span>二&nbsp;维&nbsp;码:</span>

           <div style="background: #f2f2f2;display: block;width: 286px;border: 1px solid #ccc;padding: 5px;margin-top: 10px;">

              <div style="float:left;"><?php echo ($qrcode); ?></div>

              <div style="float:right;padding-right: 43px;padding-top: 30px;">

                <p style="font-size:15px; font-weight:bold; line-height:30px;">手机购</p>

                <p style="font-size:15px; font-weight:bold; line-height:30px;">更方便</p>

              </div>

              <div style=" clear:both;"></div>

              </div>

           </li><?php endif; ?>

          <li style="height:auto;"><div id="shop_cart"></div></li>

        </ul>
-->
        </ul>
		

        <div class="text editor" style="clear:both;">

          

          
          

          <div style=" height:40px; margin-bottom:20px;  background: #ddd;"> <div class="tab active" id="proinfo" onclick="javascript:tab_menu(this)">产品详情</div><div class="tab" id="message" onclick="javascript:tab_menu(this)">产品询盘</div> </div>

          <div id="proinfo_c" class="tabc"><?php echo ($content); ?> </div>

          <div id="message_c" class="page-guestbook tabc" style="display:none;">

            <form onsubmit="return check()" action="<?php echo U('Message/doSaveMessage');?>" id="guestbook" name="guestbook" method="post">

              <dl class="clearfix">

                <dt>您的姓名：</dt>

                <dd>

                  <input type="text" id="Guest_Name" name="Guest_Name">

                  <span>*</span></dd>

                <dt>邮件地址：</dt>

                <dd>

                  <input type="text" id="Guest_Email" name="Guest_Email">

                  <span>*</span></dd>

                <dt>电话：</dt>

                <dd>

                  <input type="text" id="Guest_TEL" name="Guest_TEL">

                </dd>

                <dt>传真：</dt>

                <dd>

                  <input type="text" id="Guest_FAX" name="Guest_FAX">

                </dd>

                <dt>地址：</dt>

                <dd>

                  <input type="text" id="Guest_ADD" name="Guest_ADD">

                </dd>

                <dt>邮编：</dt>

                <dd>

                  <input type="text" id="Guest_ZIP" name="Guest_ZIP">

                </dd>

                <dt>留言内容：</dt>

                <dd>

                  <textarea id="Content" class="Content" rows="" cols="" name="Content"></textarea>

                </dd>

                <dt>验证码：</dt>

                <dd>

                  <input type="text" autocomplete="off" maxlength="4" id="checkcode" name="checkcode">

                  <img id="verifyImg" src='__APP__/public/verify/' /> <span>*</span></dd>

              </dl>

              <p>

			  	<input type="hidden" name="isxunpan" value="1" />

				<input type="hidden" name="productid" value="<?php echo ($id); ?>" />

                <input type="submit" class="submit" value="提交信息" id="submit" name="submit">

              </p>

            </form>

          </div>

        </div>
		  <div class="page lhcppg" style="clear:both;">
		<span >上一个产品：<?php if(!empty($pre)): ?><a href="<?php echo ($pre['url']); ?>"><?php echo ($pre['title']); ?></a><?php else: ?>没有了<?php endif; ?></span>
		<span >下一个产品：<?php if(!empty($next)): ?><a href="<?php echo ($next['url']); ?>"><?php echo ($next['title']); ?></a><?php else: ?>没有了<?php endif; ?></a></span>
	  </div>
        <!--<div class="hits">
			<?php if(!empty($click_num)): ?>点击次数：<span id="hitnum"></span>&nbsp;&nbsp;<?php endif; ?>
			<?php if(!empty($add_time)): ?>更新时间：<?php echo (date("y/m/d H:i:m",$dateline)); ?>&nbsp;&nbsp;<?php endif; ?>
			<?php if(!empty($print_page)): ?>【<a href="javascript:window.print()">打印此页</a>】&nbsp;&nbsp;<?php endif; ?>
			<?php if(!empty($page_close)): ?>【<a href="javascript:self.close()">关闭</a>】<?php endif; ?>
		</div>-->
        
	<h4 class="related"><span style="font-weight:500;  height:30px;line-height:30px;font-size:28px; color:#e7463c; padding-left:10px; font-family:'微软雅黑'; display: block; margin-top: 20px;"><?php if(!empty($seokeyword)){echo $seokeyword.'的';} ?>相关产品</span></h4>

        <div class="related_cp">

     <ul>

     	<?php if(empty($relate)): ?>该分类暂无相关产品！

		<?php else: ?>


		  <?php if(is_array($relate)): $i = 0; $__LIST__ = $relate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$relate): $mod = ($i % 2 );++$i;?><li>

	         <a href="<?php echo ($relate['url']); ?>"><img src="<?php echo ($site_url); ?>/<?php echo ($relate["pic"]); ?>" alt="<?php echo ($relate['title']); ?>" title="<?php echo ($relate['title']); ?>"></a>

	        <p><a target="_blank" title="<?php echo ($relate["title"]); ?>" href="<?php echo ($relate['url']); ?>"><?php echo (msubstr($relate['title'],0,8)); ?></a></p>

	       </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>

	</ul>

    

   </div>

<!--  相关产品结束-->   


<!--  相关新闻

 <h4 class="related"><span style="font-weight:bold;height:30px;line-height:30px;font-size:13px; color:#fff; padding-left:10px"><?php if(!empty($seokeyword)){echo $seokeyword.'的';} ?>相关资料</span></h4>

		<ul class="related-list">

			<?php if(empty($relNew)): ?>暂无相关文章！

			 <?php else: ?>

			 <?php if(is_array($relNew)): $i = 0; $__LIST__ = $relNew;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$Arelate): $mod = ($i % 2 );++$i;?><li><a target="_blank" title="<?php echo ($Arelate["title"]); ?>" href="<?php echo ($Arelate['url']); ?>"><?php echo ($Arelate['title']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>

        </ul>

        <div class="clear"></div>

        

  相关新闻结束-->  
        
		
		
        <div class="clear"></div>
      </div></div>
  
    </div>
  </div>
  
  <script>
  	$(function(){			
	   $(".jqzoom").jqueryzoom({
			xzoom:250,
			yzoom:250,
			offset:10,
			position:"right",
			preload:1,
			lens:1
		});
		$("#spec-list").jdMarquee({
			deriction:"left",
			width:285,
			height:56,
			step:2,
			speed:4,
			delay:10,
			control:true,
			_front:"#spec-right",
			_back:"#spec-left"
		});
		$("#spec-list img").bind("mouseover",function(){
			var src=$(this).attr("src");
			var ref=$(this).attr('ref');

			$("#spec-n1 img").eq(0).attr('src',ref);
			$("#spec-n1 img").eq(0).attr('jqimg',ref);
			$(this).css({
				"border":"2px solid #ff6600",
				"padding":"1px"
			});
		}).bind("mouseout",function(){
			$(this).css({
				"border":"1px solid #ccc",
				"padding":"2px"
			});
		});				
})

  </script>
  <script>
		$.ajax({
		   type: "GET",
		   url:"<?php echo U('Public/getShop');?>",
		   dataType:'json',
		   success: function(msg){
		   
		   	if(msg.data.style=='inliine'){
			 
				$('#shop_cart').html(msg.data.content);
				
			}else{
				$('body').append(msg.data.content);
			}
			$("#inhert_cart").css({ "margin":0})
		   
			
		   }
		});
	
	</script>




<div class="footer">

 <div class="foot gg">
 
  <div class="foot_nr">
  <div class="foot_z fl"><img src="../Public/images/index_27.jpg" /></div>
  <div class="foot_y fr"><?php echo ($content_4); ?></div>
  <br class="clear" /></div>
<div class="bq">版权所有：烟台市立民红木家具有限公司  Copyright  2017  ICP 备案号：鲁ICP备16050511号</div>
  <div class="banquan "><img src="../Public/images/banquan.gif" /></div>
 </div>
</div>






<script>
//流量统计代码代码
    <!--  
function getOs()  
{  
    var OsObject = "";  
   if(navigator.userAgent.indexOf("MSIE")>0) {  
        return "MSIE";  
   }  
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){  
        return "Firefox";  
   }  
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) {  
        return "Safari";  
   }   
   if(isCamino=navigator.userAgent.indexOf("Camino")>0){  
        return "Camino";  
   }  
   if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){  
        return "Gecko";  
   }  
    
}  


var url=encodeURIComponent(window.location.href),
    referer=encodeURIComponent(document.referrer);
var url_cookie=$.cookie('url');
var cookie_str = url_cookie?url_cookie:'';
var urlcookie = url_cookie?1:0;
$.cookie('url',cookie_str+','+url, {expires: 7, path: '/'});
$.ajax({
   type: "GET",
   url: "<?php echo U('Home/Public/alexa');?>",
   data:"sid=<?php echo ($_GET['sid']); ?>&id=<?php echo ($_GET['id']); ?>&url="+url+'&referer='+referer+'&browser='+getOs()+'&urlcookie='+urlcookie,
   dataType:'json',
   success: function(msg){
   
   }
});
//在线客服代码
$.ajax({
   type: "POST",
   url: "<?php echo U('Home/Public/getOnline');?>",
   dataType:'json',
   success: function(msg){
   	
     $("body").append(msg.html);
   }
});

</script>
</body>
</html>