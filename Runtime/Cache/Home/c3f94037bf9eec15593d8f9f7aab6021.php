<?php if (!defined('THINK_PATH')) exit();?><style>
.mapTel {
    height: 30px;
    line-height: 30px;
    padding: 5px 0;
    width: 208px;
}
.mapTel .mapNumber {
    background-image: linear-gradient(#2096FC, #1179D3);
    display: block;
    padding: 0 0 0 10px;
}
.mapTel .mapNumber a {
	background:url(__PUBLIC__/images/common.png) no-repeat scroll -240px 4px transparent;
  color: #FFFFFF;
  display: block;
  font-size: 17px;
  font-weight: bold;
  height: 30px;
  line-height: 30px;
  overflow: hidden;
  padding: 0 0 0 30px;
  text-decoration: none;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 150px;
}  

</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=71de10dc4d8972f7efb90faa1514d931"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />

		<div class="contentHeight">
			   <div id="map" style="height:500px; width:100%"></div>
		   </div>
	
	
		<script type="text/javascript">

// 百度地图API功能
    var map = new BMap.Map('map');
    var poi = new BMap.Point(<?php echo ($lng); ?>,<?php echo ($lat); ?>);
    map.centerAndZoom(poi, 16);
    map.enableScrollWheelZoom();

    var content = '<div style="margin:0;line-height:20px;padding:2px;">'  +
							' 地址：<?php echo ($add); ?>'
							+'<p class="mapTel"><span class="mapNumber"><a href="tel:<?php echo ($phone); ?>">'+'<?php echo ($phone); ?>'+'</a></span></p>传真：<?php echo ($fax); ?><br>客服：<?php echo ($customer); ?><br>E-mail：<?php echo ($email); ?>　' +
						  '</div>';

    //创建检索信息窗口对象
    var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
			title  : "百度大厦",      //标题
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




</script>