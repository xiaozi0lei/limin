/*gaotd 2012-12-14*/
$(function(){
	var yunx;       // 定义动画变量
	var Time = 2000;      // 自动播放间隔时间 毫秒
	var num = 1000;       // 切换图片间隔的时间 毫秒
	var page = 0;         // 定义变量
	var len = $( ".zfb_datu_ul li" ).length;     // 获取图片的数量
	$( ".zfb_datu_ul li" ).css( "opacity", 0 );   // 设置全部的图片透明度为0
	$( ".zfb_datu_ul li:first" ).css( "opacity", 1 ); // 设置默认第一张图片的透明度为1
	$(".btnBg").css("opacity",0.5);
	$(".xiaod_div span").css("opacity",0.4);
	function fun(){      // 封装
		$( ".xiaod_div span" ).eq( page ).css("opacity",1).siblings().css("opacity",0.4);       // 切换小点
		$( ".zfb_datu_ul li" ).eq( page ).animate({ "opacity" : 1 }, num ).siblings().animate( { "opacity" : 0 }, num );     // 切换图片
	}
	function run(){         // 封装
		if( !$(".zfb_datu_ul li" ).is( ":animated" )){    // 判断li是否在动画
			if( page == len - 1 ){ // 当图片切换到了最后一张的时候
				page = 0;    // 把page设置成0 又重新开始播放动画
				fun();
			}else{     // 继续执行下一张
				page++;
				fun();
			}
		}
	}
	$(".xiaod_div span").click( function(){  // 点击小点
		if( !$( ".zfb_datu_ul li" ).is( ":animated" ) ){   // 判断li是否在动画
			var index = $( ".xiaod_div span" ).index( this );   // 获取点击小点的位置
			page = index;    // 同步于page
			fun();
		}
	});
	$( ".zhifub" ).hover( function(){    // 鼠标放上去图片的时候清除动画
		clearInterval( yunx );
	}, function(){     // 鼠标移开图片的时候又开始执行动画
		yunx = setInterval( run, Time );
	}).trigger( "mouseleave" );
	
	// 登录框
	$( "#bg_bno" ).css( { "width" : $( "#bg_bno1" ).width(), "height" : $( "#bg_bno1" ).height() + 20, "opacity" : "0.3" } );    
	$( "#bg_bno1 h3 span" ).css( { "opacity" : 0.6 } );
	$( ".btn_dengl" ).hover(function(){
		$( this ).addClass( "btn_d1" );
	},function(){
		$( this ).removeClass( "btn_d1" );
	});
	$( "#bg_bno1 h3 span" ).click(function(){
		$( this ).addClass( "h3_span" ).siblings().removeClass( "h3_span" );
		if( $( "#bg_bno1 h3 span:first" ).hasClass( "h3_span" ) ){
			$( "#sui_a" ).show();
		}else{
			$( "#sui_a" ).hide();
		}
	});
});















































