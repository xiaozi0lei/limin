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
      <!--<div class="download fr"><a>下载</a></div>-->
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
              <div class="mod_01"> <a href="#"><img class="ClientWidth" src="../Public/images/2.jpg" alt="" width="640" height="200"></a> </div>
              <div class="mod_01"> <a href="#"><img class="ClientWidth" src="../Public/images/3.jpg" alt="" width="640"  height="200"></a> </div>
             
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
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=71de10dc4d8972f7efb90faa1514d931"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
<div class="contentHeight">
       <div id="map" style="height:100%;-webkit-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;"></div>
   </div>
   
   
   <script type="text/javascript">
    var map = new BMap.Map('map');
    var poi = new BMap.Point(<?php echo ($lng); ?>,<?php echo ($lat); ?>);
    map.centerAndZoom(poi, 18);
    map.enableScrollWheelZoom();

    var content = '<div style="margin:0;line-height:20px;padding:2px;">'  +
							' 地址：<?php echo ($add); ?>'
							+'<p class="mapTel"><span class="mapNumber"><a href="tel:<?php echo ($phone); ?>">'+'<?php echo ($phone); ?>'+'</a></span></p>传真：<?php echo ($fax); ?><br>客服：<?php echo ($customer); ?><br>E-mail：<?php echo ($email); ?>　' +
						  '</div>';

	/* var content = '<div style="margin:0;line-height:20px;padding:2px;">'  +
                    ' 地址：烟台市芝罘区青年南路鲁东大学东校门往南700米烟台市大学生创业孵化基地<br/>电话：(010)59928888<br/>简介：百度大厦位于北京市海淀区西二旗地铁站附近，为百度公司综合研发及办公总部。' +
                  '</div>';*/

    //创建检索信息窗口对象
    var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
			title  : "<?php echo ($cname); ?>",      //标题
			width  : 290,             //宽度
			height : 150,              //高度
			panel  : "panel",         //检索结果面板
			enableAutoPan : true,     //自动平移
			searchTypes   :[
				BMAPLIB_TAB_SEARCH,   //周边检索
				BMAPLIB_TAB_TO_HERE,  //到这里去
				BMAPLIB_TAB_FROM_HERE //从这里出发
			]
		});
    var marker = new BMap.Marker(poi); //创建marker对象
    marker.enableDragging(); //marker可拖拽
    marker.addEventListener("click", function(e){
	    searchInfoWindow.open(marker);
    })
    map.addOverlay(marker); //在地图中添加marker
    searchInfoWindow.open(marker); //在marker上打开检索信息串口
	map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
	
    map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
    map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
    map.enableKeyboard();//启用键盘上下左右键移动地图

    map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //右上角，仅包含平移和缩放按钮

	//样式1
var searchInfoWindow1 = new BMapLib.SearchInfoWindow(map, "信息框1内容", {
    title: "信息框1", //标题
    panel : "panel", //检索结果面板
    enableAutoPan : true, //自动平移
    searchTypes :[
        BMAPLIB_TAB_FROM_HERE, //从这里出发
        BMAPLIB_TAB_SEARCH   //周边检索
    ]
});
function openInfoWindow1() {
    searchInfoWindow1.open(new BMap.Point(116.319852,40.057031));
}

//样式2
var searchInfoWindow2 = new BMapLib.SearchInfoWindow(map, "信息框2内容", {
    title: "信息框2", //标题
    panel : "panel", //检索结果面板
    enableAutoPan : true, //自动平移
    searchTypes :[
        BMAPLIB_TAB_SEARCH   //周边检索
    ]
});
function openInfoWindow2() {
    searchInfoWindow2.open(new BMap.Point(116.324852,40.057031));
}

//样式3
var searchInfoWindow3 = new BMapLib.SearchInfoWindow(map, "信息框3内容", {
    title: "信息框3", //标题
    width: 290, //宽度
    height: 40, //高度
    panel : "panel", //检索结果面板
    enableAutoPan : true, //自动平移
    searchTypes :[
    ]
});
function openInfoWindow3() {
    searchInfoWindow3.open(new BMap.Point(116.328852,40.057031)); 
}

 var isPanelShow = false;
    //显示结果面板动作
    $("showPanelBtn").onclick = function(){
        if (isPanelShow == false) {
            isPanelShow = true;
            $("showPanelBtn").style.right = "300px";
            $("panelWrap").style.width = "300px";
            $("map").style.marginRight = "300px";
            $("showPanelBtn").innerHTML = "隐藏检索结果面板<br/>>";
        } else {
            isPanelShow = false;
            $("showPanelBtn").style.right = "0px";
            $("panelWrap").style.width = "0px";
            $("map").style.marginRight = "0px";
            $("showPanelBtn").innerHTML = "显示检索结果面板<br/><";
        }
    }

</script>


   <section class="copyright">
    <div> COPYRIGHT&copy;烟台市立民红木家具有限公司 版权所有 </div>
  </section>
  <footer role="box_footer" id="box_footer">
    <ul class="footerWrap">
      <li> <a id="mobile" href="tel:0535-4326056" alt=""> <span class="icon tel"></span> <span class="text">电话</span> </a> </li>
      <li> <a id="mobile" href="<?php echo U('Wap/message/index');?>" alt=""> <span class="icon email"></span> <span class="text">留言</span> </a> </li>
      <li> <a id="mobile" href="<?php echo U('Wap/map/index');?>" alt=""> <span class="icon map"></span> <span class="text">地图</span> </a> </li>
      <li> <a id="mobile" href="<?php echo U('Wap/share/index');?>" alt=""> <span class="icon share"></span> <span class="text">分享</span> </a> </li>
    </ul>
  </footer>
</div>
<!--<section class="DownLoadBox">
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
</section>-->
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