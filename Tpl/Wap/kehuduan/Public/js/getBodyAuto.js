// JavaScript Document


//获取浏览器可见区域 sp_getClientWidth
if(typeof(sp_getClientWidth) == "undefined"){
	var sp_getClientWidth;
	};
sp_getClientWidth=document.body.clientWidth;
if(sp_getClientWidth>640){sp_getClientWidth=640};


var sp_visiablelength = window.innerHeight;
var sp_length = sp_visiablelength*1  - 88;

document.write("<style type='text/css'>.ClientWidth{ width:" + sp_getClientWidth + "px;}.main_box{ min-height:" + sp_visiablelength + "px;}</style>");
document.write("<style type='text/css'>.contentHeight{ height:" + sp_length + "px;}</style>");


