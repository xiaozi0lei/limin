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
<script type="text/javascript" charset="utf-8" src="http://api.map.baidu.com/api?v=1.5&ak=71de10dc4d8972f7efb90faa1514d931"></script>
		<script type="text/javascript" charset="utf-8" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
		<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
		<div class="contentHeight">
			   <div id="map" style="height:400px; width:100%"></div>
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