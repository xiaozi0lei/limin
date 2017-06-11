<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="ui-mobile">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="MobileOptimized" content="240">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0">
<link href="../Public/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../Public/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../Public/js/index.js"></script>
<title><?php echo ($title); ?></title>
</head>
<body id="index" class="ui-mobile-viewport">
<div id="page_news_list" data-role="page" class="page_news_list ui-page ui-body-c ui-page-active current" data-url="/news_list.html" data-external-page="true" tabindex="0" style="min-height: 412px; ">
  
  <div id="box_header" data-role="header" class="ui-header ui-bar-a" role="banner">
  <div id="box_top">
    <div id="box_logo">
      <div name="LOGO">  </div>
    </div>
    <div id="box_search">
      <div name="全站搜索">
        <div class="box_search_all">
          <form name="totalSearch" id="totalSearch" action="<?php echo U('Wap/search/search');?>" method="get" target="_self">
            <span>
            <input type="text" value="" id="keywords" name="keywords" class="ui-input-text ui-body-a ui-corner-all ui-shadow-inset">
			<input name="SearchAction" id="SearchAction" value="product" type="hidden">
            <a href="javascript:void(0)" id="search" title="搜索" class="ui-link">搜索</a></span>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div name="栏目导航">
    <div class="Columns_navigation">
      <ul>
	  
	    <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><li id="columns_navigation0"><a onClick="setCurrentColumn('0');" href="<?php echo ($m["url"]); ?>"  class="ui-link"> <strong><?php echo ($m["name"]); ?></strong> </a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
</div>



  
  <div id="box_main" style="margin-bottom:35px" data-role="content" class="ui-content" role="main">
    <div>
      <div class="ComContent_list">
        <div class="menu-first"> <a href="#" title="" class="ui-link"><strong id="all"><?php echo ($current_sort['name']); ?></strong></a> 
         
          <span class="fold" id="InfoCate"><b></b><strong>更多</strong></span> 
      
          <span><a href="javascript:history.go(-1);">返回</a></span>
          
        </div>
        <div class="menu-second" id="menu-second" style="display: none;">
          <div class="col">
		  	
			<?php echo ($leftmenu); ?>
		  
          </div>
        </div>
      </div>
    </div>
<link href="../Public/js/zoom/phzoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../Public/js/zoom/phzoom.js"></script>
<script>
$(function(){

$(".piczoom").phzoom({

        prevText:'上一张',         // 上一张按钮的显示文本, 需要引号
        nextText:'下一张',         // 下一张按钮的显示文本, 需要引号
        navColor:'#FFFFFF',         // 上/下一张按钮的文本颜色, 需要引号
        capColor:'#FFFFFF'         // 大图底部标题与索引的文本颜色, 需要引号
        
  });



});
</script>
<style>
 #piclist li{
 float:left;
 margin-right:10px;
 }
</style>
<div id="page_main" class="clearfix">
    <div class="page-right">
      <div class="site-nav"><span>当前位置 : </span><?php echo ($location); ?></div>
      <div class="page-news">
        <div id="shownews">
            <h1 class="title"><?php echo ($title); ?></h1>
            <div class="text editor">
			  <div id="piclist">
			  		<ul>
					    <?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site_url); ?>/<?php echo ($pic["org"]); ?>" title="" class="piczoom"><img width="200" height="150" src="<?php echo ($site_url); ?>/<?php echo ($pic["filepath"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div style="clear:both;"></div>
			  </div>
			 

			
			<?php echo ($content); ?>
			</div>
			<div class="hits">点击次数：<span><?php echo ($hit); ?></span>&nbsp;&nbsp;更新时间：<?php echo (date("y/m/d H:i:m",$dateline)); ?>&nbsp;&nbsp;【<a href="javascript:window.print()">打印此页</a>】&nbsp;&nbsp;【<a href="javascript:self.close()">关闭</a>】</div>
            
			<div class="page">
			
			上一条：<?php if(!empty($pre)): ?><a href="<?php echo ($pre['url']); ?>"><?php echo ($pre['title']); ?></a><?php else: ?>没有了<?php endif; ?><br>
			下一条：<?php if(!empty($next)): ?><a href="<?php echo ($next['url']); ?>"><?php echo ($next['title']); ?></a><?php else: ?>没有了<?php endif; ?></a>
			
			</div>

			<h4 class="related">相关图片</h4>
			    <ul class="related-list">

					<?php if(is_array($relate)): $i = 0; $__LIST__ = $relate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$relate): $mod = ($i % 2 );++$i;?><li>•&nbsp;<a target="_blank" title="<?php echo ($relate["title"]); ?>" href="<?php echo ($relate['url']); ?>"><?php echo ($relate['title']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    

                </ul>
				<div class="clear"></div>

        </div>
      </div>
    </div>
    
	
	
  </div>
 </div>
  <div id="box_footer" data-role="footer" data-position="fixed" class="ui-footer ui-bar-a ui-footer-fixed fade ui-fixed-overlay" role="contentinfo">
    <input id="shareval" type="hidden" value="">
    <div id="elem-Toolbar_show01-001" name="下方工具条">
      <div class="Toolbar_show">
        <ul id="uldiv">
          <li class="first tel col3"><a id="mobile" href="tel:1212121" class=""><em></em><span>电话</span></a></li>
          <li class="share col3"><a id="share" href="<?php echo U('Wap/Share/index');?>"><span>分享</span></a></li>
          <li class="map col3 "><a id="map" href="<?php echo U('Wap/About/index',array('sid'=>445));?>" ><span>地图</span><em></em></a></li>
          <li class="map col3 last"><a id="map" href="<?php echo U('Wap/Message/index');?>" ><span>留言</span><em></em></a></li>
        </ul>
      </div>
    </div>
  </div>
       <script type="text/javascript">
			function submitName1() {
				var url = window.location.href;
				if (url.indexOf("?") > 0) {
					url = url + "&op=share";

				} else {
					url = url + "?op=share";
				}
				window.location.href = url;
			}
		</script>

</div>
</body>
</html>