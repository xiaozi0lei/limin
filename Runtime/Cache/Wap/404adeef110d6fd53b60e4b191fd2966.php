<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="ui-mobile">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($title); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="MobileOptimized" content="240">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<link rel="apple-touch-icon" href="../Public/images/appico.png"/>
<link rel="stylesheet" href = "../Public/css/mobile_style.css">
<script type="text/javascript" src="../Public/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../Public/js/huaping.js"></script>
<script type="text/javascript" src="../Public/js/sj_function.js"></script>
</head>
<body>
<script type="text/javascript" src="../Public/js/getBodyAuto.js"></script>
<div data-role="page" id="index" class="main_box">
  <div data-role="header">
    <header>
      <div class="logo fl"><a href="#"><img src="../Public/images/logo.png"></a></div>
      <div class="download fr"><a>下载</a></div>
      <div class="search fr"><a>搜索</a></div>
      <div class="clear"></div>
    </header>
    <div class="navbox">
	    <ul class="navBody">
		<?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($m["url"]); ?>"><?php echo ($m["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
    </div>
    <section>
	      <div class="bannerTop"></div>
      <div class="scroll">
        <div class="slide_01" id="slide_01">
          <div>
            <div>
              <div class="mod_01"> <a href="#"><img class="ClientWidth" src="../Public/images/1.jpg" alt="" width="640" height="200"></a> </div>
              <div class="mod_01"> <a href="#"><img class="ClientWidth" src="../Public/images/3.jpg" alt="" width="640" height="200"></a> </div>
              <div class="mod_01"> <a href="#"><img class="ClientWidth" src="../Public/images/4.jpg" alt="" width="640"  height="200"></a> </div>
              <div class="mod_01"> <a href="#"><img class="ClientWidth" src="../Public/images/2.jpg" alt="" width="640" height="200"></a> </div>
            </div>
          </div>
        </div>
        <div class="dotModule_new w5">
          <div id="slide_01_dot"> </div>
        </div>
        <div class="sl_left" id="slide_01_left"></div>
        <div class="sl_right" id="slide_01_right"></div>
      </div>
      <script type="text/javascript" >
		if(document.getElementById("slide_01") && typeof(f_slide_01) == "undefined" ){  
    var f_slide_01 = new ScrollPic();
	  f_slide_01.scrollContId   = "slide_01"; //内容容器ID
	  f_slide_01.dotListId      = "slide_01_dot";//点列表ID
	  f_slide_01.dotOnClassName = "selected";
	  f_slide_01.arrLeftId      = "slide_01_left"; //左箭头ID
	  f_slide_01.arrRightId     = "slide_01_right";//右箭头ID
	  f_slide_01.frameWidth     = sp_getClientWidth;
	  f_slide_01.pageWidth      = sp_getClientWidth;
	  f_slide_01.upright        = false;
	  f_slide_01.speed          = 10;
	  f_slide_01.space          = 30; 
		f_slide_01.autoPlay       =true;
	  f_slide_01.initialize(); //初始化
    };
</script>
      <div class="bannerBottom"></div>
    </section>
  </div>
<div id="page_main" class="clearfix">
    <div class="page-right">
      <div class="site-nav"><span>当前位置 : </span>
	  
		<?php echo ($location); ?>
	  
	  </div>
      <div class="page-news">
      <table border="0" align="center">
      <tr>
	  <th class="news-time">日期</th>
	  <th class="news-title">职位</th>
	  <th class="news-title">工资</th>
	  <th class="news-title">人数</th>
	  <th class="news-title">应聘</th>
	  </tr>

<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr>
<td class="time-list"><span><?php echo (date("y/m/d",$li['dateline'])); ?></span></td>
<td><a href="<?php echo listurl('wap/Job/show',array('id'=>$li['id'],'sid'=>$li['sort']));?>" title="<?php echo ($li["title"]); ?>"><?php echo ($li["title"]); ?></a></td>
<td align="center"><?php echo ($li["deal"]); ?></td>
<td align="center"><?php echo ($li["num"]); ?></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>

      </table>
<div class="page_list"><?php echo ($page); ?></div>
      </div>
    </div>
    
	
	
  </div>
  <section class="copyright">
    <div> COPYRIGHT&copy;烟台莱山区弘祥食品科技有限公司 版权所有 </div>
  </section>
  <footer role="box_footer" id="box_footer">
    <ul class="footerWrap">
      <li> <a id="mobile" href="tel:0535-6900000" alt=""> <span class="icon tel"></span> <span class="text">电话</span> </a> </li>
      <li> <a id="mobile" href="<?php echo U('Wap/message/index');?>" alt=""> <span class="icon email"></span> <span class="text">留言</span> </a> </li>
      <li> <a id="mobile" href="<?php echo U('Wap/map/index');?>" alt=""> <span class="icon map"></span> <span class="text">地图</span> </a> </li>
      <li> <a id="mobile" href="<?php echo U('Wap/share/index');?>" alt=""> <span class="icon share"></span> <span class="text">分享</span> </a> </li>
    </ul>
  </footer>
</div>
<section class="DownLoadBox">
  <div id="iphonetype"  class="alertWindow" style="">
    <div class="iphoneStart"> <span class="contWrap"> <img src="../Public/images/appico.png" style="float:left; height:65px; margin-right:5px;"> 请点击此处<em class="icon"></em>，选择 <em class="textRed">添加到屏幕</em>以添加快捷方式到主屏幕，方便 <em class="textRed">从主屏幕启动本应用</em>。 </span>
      <div class="contArrow"><em>◆</em></div>
    </div>
  </div>
  <div id="androidtype"  class="alertWindow" style="">
    <div class="androidStart">
      <div class="active install" onClick="javascript:window.location.href='http://app.appcan.cn/11292481/0.1/000/android/11292481_android_0.1_000_0.apk'"> <span class="icon"></span>立即体验客户端 </div>
      <div class="later">稍后再说>></div>
    </div>
  </div>
</section>
<section class="SearchBox">
  <div class="SearchC ClientWidth">
    <div class="SearchTop">
      <ul>
        <li class="current" value="product">产品</li>
        <li value="article">资讯</li>
        <div class="clear"></div>
      </ul>
    </div>
    <div class="SearchBottom">
	  <form method="get" action="<?php echo U('Wap/search/search');?>">
      <input id="keywords" class="fd-input" placeholder="关键字" maxlength="32" name="keywords" type="text">
      <input name="SearchAction" id="SearchAction" value="product" type="hidden">
	  <input type="submit" name="Searchsubmit_btn" id="Searchsubmit_btn"   class="fd-button" value="搜索" onclick="if($('#keywords').val()=='') {alert('请输入关键词'); return false;}"/>
     
       </form>
	</div>
  </div>
</section>
</body>
</html>