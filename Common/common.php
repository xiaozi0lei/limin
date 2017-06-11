<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * Think扩展函数库 需要手动加载后调用或者放入项目函数库
 * @category   Extend
 * @package  Extend
 * @subpackage  Function
 * @author   liu21st <liu21st@gmail.com>
 */

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    if ($slice == $str)
    {
    	$suffix = false;
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * @return string
 */
function rand_string($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
          $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
        }
    }
    return $str;
}

/**
 * 获取登录验证码 默认为4位数字
 * @param string $fmode 文件名
 * @return string
 */
function build_verify ($length=4,$mode=1) {
    return rand_string($length,$mode);
}

/**
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 * @return string
 */
function byte_format($size, $dec=2) {
	$a = array("B", "KB", "MB", "GB", "TB", "PB");
	$pos = 0;
	while ($size >= 1024) {
		 $size /= 1024;
		   $pos++;
	}
	return round($size,$dec)." ".$a[$pos];
}

/**
 * 检查字符串是否是UTF8编码
 * @param string $string 字符串
 * @return Boolean
 */
function is_utf8($string) {
    return preg_match('%^(?:
         [\x09\x0A\x0D\x20-\x7E]            # ASCII
       | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
       |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
       |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
       |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
       | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
       |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
}
/**
 * 代码加亮
 * @param String  $str 要高亮显示的字符串 或者 文件名
 * @param Boolean $show 是否输出
 * @return String
 */
function highlight_code($str,$show=false) {
    if(file_exists($str)) {
        $str    =   file_get_contents($str);
    }
    $str  =  stripslashes(trim($str));
    // The highlight string function encodes and highlights
    // brackets so we need them to start raw
    $str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

    // Replace any existing PHP tags to temporary markers so they don't accidentally
    // break the string out of PHP, and thus, thwart the highlighting.

    $str = str_replace(array('&lt;?php', '?&gt;',  '\\'), array('phptagopen', 'phptagclose', 'backslashtmp'), $str);

    // The highlight_string function requires that the text be surrounded
    // by PHP tags.  Since we don't know if A) the submitted text has PHP tags,
    // or B) whether the PHP tags enclose the entire string, we will add our
    // own PHP tags around the string along with some markers to make replacement easier later

    $str = '<?php //tempstart'."\n".$str.'//tempend ?>'; // <?

    // All the magic happens here, baby!
    $str = highlight_string($str, TRUE);

    // Prior to PHP 5, the highlight function used icky font tags
    // so we'll replace them with span tags.
    if (abs(phpversion()) < 5) {
        $str = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $str);
        $str = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $str);
    }

    // Remove our artificially added PHP
    $str = preg_replace("#\<code\>.+?//tempstart\<br />\</span\>#is", "<code>\n", $str);
    $str = preg_replace("#\<code\>.+?//tempstart\<br />#is", "<code>\n", $str);
    $str = preg_replace("#//tempend.+#is", "</span>\n</code>", $str);

    // Replace our markers back to PHP tags.
    $str = str_replace(array('phptagopen', 'phptagclose', 'backslashtmp'), array('&lt;?php', '?&gt;', '\\'), $str); //<?
    $line   =   explode("<br />", rtrim(ltrim($str,'<code>'),'</code>'));
    $result =   '<div class="code"><ol>';
    foreach($line as $key=>$val) {
        $result .=  '<li>'.$val.'</li>';
    }
    $result .=  '</ol></div>';
    $result = str_replace("\n", "", $result);
    if( $show!== false) {
        echo($result);
    }else {
        return $result;
    }
}

//输出安全的html
function h($text, $tags = null) {
	$text	=	trim($text);
	//完全过滤注释
	$text	=	preg_replace('/<!--?.*-->/','',$text);
	//完全过滤动态代码
	$text	=	preg_replace('/<\?|\?'.'>/','',$text);
	//完全过滤js
	$text	=	preg_replace('/<script?.*\/script>/','',$text);

	$text	=	str_replace('[','&#091;',$text);
	$text	=	str_replace(']','&#093;',$text);
	$text	=	str_replace('|','&#124;',$text);
	//过滤换行符
	$text	=	preg_replace('/\r?\n/','',$text);
	//br
	$text	=	preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
	$text	=	preg_replace('/<p(\s\/)?'.'>/i','[br]',$text);
	$text	=	preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
	//过滤危险的属性，如：过滤on事件lang js
	while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1],$text);
	}
	while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
	}
	if(empty($tags)) {
		$tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
	}
	//允许的HTML标签
	$text	=	preg_replace('/<('.$tags.')( [^><\[\]]*)>/i','[\1\2]',$text);
	$text = preg_replace('/<\/('.$tags.')>/Ui','[/\1]',$text);
	//过滤多余html
	$text	=	preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i','',$text);
	//过滤合法的html标签
	while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
	}
	//转换引号
	while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
	}
	//过滤错误的单个引号
	while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
	}
	//转换其它所有不合法的 < >
	$text	=	str_replace('<','&lt;',$text);
	$text	=	str_replace('>','&gt;',$text);
	$text	=	str_replace('"','&quot;',$text);
	 //反转换
	$text	=	str_replace('[','<',$text);
	$text	=	str_replace(']','>',$text);
	$text	=	str_replace('|','"',$text);
	//过滤多余空格
	$text	=	str_replace('  ',' ',$text);
	return $text;
}

function ubb($Text) {
  $Text=trim($Text);
  //$Text=htmlspecialchars($Text);
  $Text=preg_replace("/\\t/is","  ",$Text);
  $Text=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$Text);
  $Text=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$Text);
  $Text=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$Text);
  $Text=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$Text);
  $Text=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$Text);
  $Text=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$Text);
  $Text=preg_replace("/\[separator\]/is","",$Text);
  $Text=preg_replace("/\[center\](.+?)\[\/center\]/is","<center>\\1</center>",$Text);
  $Text=preg_replace("/\[url=http:\/\/([^\[]*)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\2</a>",$Text);
  $Text=preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\2</a>",$Text);
  $Text=preg_replace("/\[url\]http:\/\/([^\[]*)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\1</a>",$Text);
  $Text=preg_replace("/\[url\]([^\[]*)\[\/url\]/is","<a href=\"\\1\" target=_blank>\\1</a>",$Text);
  $Text=preg_replace("/\[img\](.+?)\[\/img\]/is","<img src=\\1>",$Text);
  $Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\\1>\\2</font>",$Text);
  $Text=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font size=\\1>\\2</font>",$Text);
  $Text=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$Text);
  $Text=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$Text);
  $Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
  $Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href='mailto:\\1'>\\1</a>",$Text);
  $Text=preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis","color_txt('\\1')",$Text);
  $Text=preg_replace("/\[emot\](.+?)\[\/emot\]/eis","emot('\\1')",$Text);
  $Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
  $Text=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$Text);
  $Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
  $Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is"," <div class='quote'><h5>引用:</h5><blockquote>\\1</blockquote></div>", $Text);
  $Text=preg_replace("/\[code\](.+?)\[\/code\]/eis","highlight_code('\\1')", $Text);
  $Text=preg_replace("/\[php\](.+?)\[\/php\]/eis","highlight_code('\\1')", $Text);
  $Text=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div class='sign'>\\1</div>", $Text);
  $Text=preg_replace("/\\n/is","<br/>",$Text);
  return $Text;
}

// 随机生成一组字符串
function build_count_rand ($number,$length=4,$mode=1) {
    if($mode==1 && $length<strlen($number) ) {
        //不足以生成一定数量的不重复数字
        return false;
    }
    $rand   =  array();
    for($i=0; $i<$number; $i++) {
        $rand[] =   rand_string($length,$mode);
    }
    $unqiue = array_unique($rand);
    if(count($unqiue)==count($rand)) {
        return $rand;
    }
    $count   = count($rand)-count($unqiue);
    for($i=0; $i<$count*3; $i++) {
        $rand[] =   rand_string($length,$mode);
    }
    $rand = array_slice(array_unique ($rand),0,$number);
    return $rand;
}

function remove_xss($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=@avascript:alert('XSS')>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}

/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 在数据列表中搜索
 * @access public
 * @param array $list 数据列表
 * @param mixed $condition 查询条件
 * 支持 array('name'=>$value) 或者 name=$value
 * @return array
 */
function list_search($list,$condition) {
    if(is_string($condition))
        parse_str($condition,$condition);
    // 返回的结果集合
    $resultSet = array();
    foreach ($list as $key=>$data){
        $find   =   false;
        foreach ($condition as $field=>$value){
            if(isset($data[$field])) {
                if(0 === strpos($value,'/')) {
                    $find   =   preg_match($value,$data[$field]);
                }elseif($data[$field]==$value){
                    $find = true;
                }
            }
        }
        if($find)
            $resultSet[]     =   &$list[$key];
    }
    return $resultSet;
}

// 自动转换字符集 支持数组转换
function auto_charset($fContents, $from='gbk', $to='utf-8') {
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
        //如果编码相同或者非字符串标量则不转换
        return $fContents;
    }
    if (is_string($fContents)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv')) {
            return iconv($from, $to, $fContents);
        } else {
            return $fContents;
        }
    } elseif (is_array($fContents)) {
        foreach ($fContents as $key => $val) {
            $_key = auto_charset($key, $from, $to);
            $fContents[$_key] = auto_charset($val, $from, $to);
            if ($key != $_key)
                unset($fContents[$key]);
        }
        return $fContents;
    }
    else {
        return $fContents;
    }
}


function site_url(){
	return 'http://'.$_SERVER['HTTP_HOST'].__ROOT__;
}

function sorturl($module_name,$id){
	
	$url=site_url();
	
	switch ($module_name){
		
		case 'article':
			 $url=U('/Article/index',array('sid'=>$id));
			 break;
		case 'product':	
			
			$url=U('/Product/index',array('sid'=>$id));
			break;
		case 'down':

			$url=U('/Download/index',array('sid'=>$id));
			break;
		case 'pic':

			$url=U('/Picture/index',array('sid'=>$id));
			break;
		case 'job':

			$url=U('/Job/index',array('sid'=>$id));
			break;
		case 'message':

			$url=U('/Message/index',array('sid'=>$id));
			break;
		case 'about':
				
			$url=U('/About/index',array('sid'=>$id));
			break;
	}
	
	return $url;
}

function input_html($data){
			$str='';
			switch ($data['type']){
		
				case 'text':
						$str='<input type="text" name="field'.$data['id'].'" >';	
				break;
				case 'textare':
					$str='<textarea name="field'.$data['id'].'"></textarea>';
					break;

				case 'radio':
							
					if(!empty($data['options'])){
						$option=unserialize($data['options']);
					}
					foreach ($option as $key=>$value){
						$str .=' <input type="radio" name="field'.$data['id'].'" value="'.$value.'" > '.$value ;
					}
							
					break;
					
					
				case 'checkbox':
					
					if(!empty($data['options'])){
						$option=unserialize($data['options']);
					}
					foreach ($option as $key=>$value){
						$str .=' <input type="checkbox" name="field'.$data['id'].'" value="'.$value.'" > '.$value ;
					}
					
					break;
					
				case 'select':
						$str='<select name="field'.$data['id'].'"><option value="">请选择</option>';
						
						if(!empty($data['options'])){
							$option=unserialize($data['options']);
						}
						foreach ($option as $key=>$value){
							$str .='<option value="'.$value.'">'.$value.'</option>';
						}
					
						$str .='</select>';
					break;
				case 'file':
						$str='<input type="file" name="field'.$data['id'].'" >';
					break;
				
			}
	
	
			
	return $str;
}

// 数组保存到文件
function arr2file($filename, $arr=''){
	if(is_array($arr)){
		$con = var_export($arr,true);
	} else{
		$con = $arr;
	}
	$con = "<?php\nreturn $con;\n?>";//\n!defined('IN_MP') && die();\nreturn $con;\n
	write_file($filename, $con);
}

//写入文件
function write_file($l1, $l2=''){
	$dir = dirname($l1);
	if(!is_dir($dir)){
		mkdirss($dir);
	}
	return @file_put_contents($l1, $l2);
}
//递归创建文件
function mkdirss($dirs,$mode=0777) {
	if(!is_dir($dirs)){
		mkdirss(dirname($dirs), $mode);
		return @mkdir($dirs, $mode);
	}
	return true;
}

function listurl($url,$parm=array()){
	
	$strurl='';
	$allow_module=$allow_action=0;
	//$sid=intval($_GET['sid'])?intval($_GET['sid']):$parm['sid'];
	//$code=$_GET['code'];
	$type=strtolower(GROUP_NAME)=='wap'?'wap/':'';
	$lang=cookie('think_language')?cookie('think_language'):'zh-cn';
	
	if($url=='Public/sitemap'){
		//网站地图
		if(C('HTML_ON')){
			$strurl=site_url().'/sitemap.html';
		}else{
			$strurl=U('Public/sitemap');
		}
	}
	
	$url_str=explode('/', $url);
	
	if(count($url_str)>=3){
		$g=$url_str[0];
		$m=$url_str[1];
		$c=$url_str[2];
	}else{
		$m=$url_str[0];
		$c=$url_str[1];
	}
	if(in_array(strtolower($m), array('index','about','article','download','job','message','picture','product'))){
		$allow_module=1;
	}
	
	if(in_array(strtolower($c), array('index','show'))){
		$allow_action=1;
	}
	
	if($url=='Index/index'){
		//主页直接添加网站链接
		$strurl=site_url();
	}elseif(!empty($parm['sid'])){
		//SEF模式
		if(C('SEF_ROUTER')&&strtolower(GROUP_NAME)!='wap'&&$allow_module&&$allow_action){
			$sort=F($lang.'path');
			$path=$sort[$parm['sid']]['path'];
			if(strpos($url, 'show')){
				$path=$type.$path.'/show'.$parm['id'];
			}
			if(strpos($url, 'index')){
				$path=$type.$sort[$parm['sid']]['path'];
			}
			$index='';
			if(C('url_model')==1){
				$index='index.php/';
			}
		
			$strurl=site_url().'/'.$index.$path;
		
		}elseif(C('HTML_ON')&&strtolower(GROUP_NAME)!='wap'&&$lang=='zh-cn'&&$allow_module&&$allow_action){
			//用来生成HTML
			$sort=F('zh-cnpath');
		
			$path=$sort[$parm['sid']]['path'];
			if(strpos($url, 'show')){
				$path=$type.$path.'/show'.$parm['id'].'.html';
			}
		
			if(strpos($url, 'index')){
				$path=$type.$sort[$parm['sid']]['path'].'/';
			}
		
			$strurl=site_url().'/'.$path;
		
		}else{
			$strurl=U($type.$url,$parm);
		}
		
	}
	
	return $strurl;
}
//内容页标题格式
function titleValue($title){
	
	$lang=cookie('think_language');
	$config_array = F( $lang.'config' );
	$longkeyword=$productcity='';
	if(empty($title)){
		$n_title=$config_array['sitename'];
	}else{
		
		if(strtolower(MODULE_NAME)=='product'){
			$longkeyword=!empty($config_array['longkeyword'])?'_'.str_replace(",", "_", $config_array['longkeyword']):'';
			$productcity=!empty($config_array['productcity'])?'('.$config_array['productcity'].')':'';
		}
		
		
		if($config_array['detailtitle']==2){
			//内容标题+网站关键词 
			$n_title=$title.$longkeyword.$config_array['keyword'].$productcity;
		}else if($config_array['detailtitle']==3){
			//内容标题+网站名称 
			$n_title=$title.$longkeyword."-".$config_array['sitename'].$productcity;
		}else if($config_array['detailtitle']==4){
			//内容标题+网站关键词+网站名称 
			$n_title=$title.$longkeyword.$config_array['keyword'].$config_array['sitename'].$productcity;
		}else{
			$n_title=$title;
		}
	}
	
	
	return $n_title;
}

/**
 * 检查是否是以手机浏览器进入(IN_MOBILE)
 */
function isMobile() {
	$mobile = array();
	static $mobilebrowser_list ='Xiaomi|Mobile|iPhone|Android|WAP|NetFront|JAVA|OperasMini|UCWEB|WindowssCE|Symbian|Series|webOS|SonyEricsson|Sony|BlackBerry|Cellphone|dopod|Nokia|samsung|PalmSource|Xphone|Xda|Smartphone|PIEPlus|MEIZU|MIDP|CLDC';
	//note 获取手机浏览器
	if(preg_match("/$mobilebrowser_list/i", $_SERVER['HTTP_USER_AGENT'], $mobile)) {
		return true;
	}else{
		if(preg_match('/(mozilla|chrome|safari|opera|m3gate|winwap|openwave)/i', $_SERVER['HTTP_USER_AGENT'])) {
			return false;
		}else{
			if($_GET['mobile'] === 'yes') {
				return true;
			}else{
				return false;
			}
		}
	}
}

function testwrite($d){
	$tfile = '_test.txt';
	$d = ereg_replace('/$','',$d);
	$fp = @fopen($d.'/'.$tfile,'w');
	if(!$fp){
		return false;
	}else{
		fclose($fp);
		$rs = @unlink($d.'/'.$tfile);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
}

function read_file($l1){
	return @file_get_contents($l1);
}

function isUrl($type,$value){
	
	$preg="/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
	if($type==2){
		$preg="/^http:\/\/[A-Za-z0-9\-]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/";
		if(substr($value,0,16)=='http://localhost' || substr($value,0,11)=='http://xn--')return true;
	}
	return preg_match($preg,$value);
	
}

function parttime($g,$value,$a,$b,$c){
	$value = explode('|',$value);
	$now = $a.'-'.$b.'-'.$c;
	for($i=0;$i<24;$i++){
		if($i==$g){
			if(!$value[$i]){
				$met.=$now;
			}else{
				$k=explode('-',$value[$i]);
				$a = $k[0]+$a;
				$b = $k[1]+$b;
				$c = $k[2]+$c;
				$met.= $a.'-'.$b.'-'.$c;
			}
		}else{
			$met.=$value[$i];
		}
		$met.= '|';
	}
	return $met;
}

function keytype($search_url){
	$config = array(
			'谷歌'=>array( "domain" => "www.google.", "kw" => "q", "charset" => "utf-8",'type' => 0 ),
			'百度'=>array( "domain" => "www.baidu.", "kw" => "wd", "charset" => "gbk",'type' => 1 ),
			'搜搜'=>array( "domain" => "soso.", "kw" => "w", "charset" => "gbk",'type' => 2 ),
			'雅虎'=>array( "domain" => "yahoo.", "kw" => "q", "charset" => "utf-8",'type' => 3 ),
			'必应'=>array( "domain" => "bing.", "kw" => "q", "charset" => "utf-8",'type' => 4  ),
			'搜狗'=>array( "domain" => "sogou.", "kw" => "query", "charset" => "gbk",'type' => 5 ),
			'有道'=>array( "domain" => "youdao.", "kw" => "q", "charset" => "utf-8",'type' => 6 ),
			'360搜索'=>array( "domain" => "so.360.", "kw" => "q", "charset" => "utf-8",'type' => 7 )
	);
	$arr_key = array();
	foreach($config as $key=>$item){
		$sh = preg_match("/\b{$item['domain']}\b/",$search_url);
		if($sh){
			$query = $item['kw']."=";
			$s_s_keyword = get_keyword($search_url,$query);
			$F_Skey=urldecode($s_s_keyword);
			$agwe=0;
			if($key=='百度'){
				$agwe=get_keyword($search_url,'ie=');
				$item['charset']=$agwe==''?$item['charset']:$agwe;
			}
			if($item['charset']!="utf-8" && (!is_utf8($F_Skey) || $agwe)){
				$F_Skey=iconv( "gb2312//IGNORE","UTF-8",$F_Skey);
			}
			$arr_key[0] = $F_Skey;
			$arr_key[1] = $item['type'];
		}
	}
	return  $arr_key;
}


function get_keyword($url,$kw_start){
	$start = stripos($url,$kw_start);
	if($start){
		$url = substr($url,$start+strlen($kw_start));
		$start = stripos($url,'&');
		if($start>0){
			if ($start>0){
				$start=stripos($url,'&');
				$s_s_keyword=substr($url,0,$start);
			}else{
				$s_s_keyword=substr($url,0);
			}
		}else{
			$s_s_keyword='';
		}
	}else{
		$s_s_keyword='';
	}
	return $s_s_keyword;
}
function statime($ymd,$day=''){
	$day=$day==''?time():strtotime($day);
	$time=strtotime(date($ymd,$day));
	return $time;
}

/*二维数组排序*/
function arraysort2($arr,$field,$sort){
	foreach($arr as $key=>$val){
		$list[$key]=$val[$field];
	}
	array_multisort($list,$sort);
	foreach($list as $key=>$val){
		foreach($arr as $key2=>$val2){
			if($key2==$key){
				$metinfo[$key]=$val2;
			}
		}
	}
	return $metinfo;
}

function enginetype($type){
	switch($type){
		case 's0':$str='谷歌';break;
		case 's1':$str='百度';break;
		case 's2':$str='搜搜';break;
		case 's3':$str='雅虎';break;
		case 's4':$str='必应';break;
		case 's5':$str='搜狗';break;
		case 's6':$str='有道';break;
		case 's7':$str='360搜索';break;
	}
	return $str;
}
//0:已处理1:待付款2:待收货3:待发货4:已发货5交易完成6:取消交易
function shopstatus($num){
	$str='未付款';
	
	switch ($num){
		
		case 1:
			$str='待付款';
			break;
		case 2:
			$str='已付款';
			break;
		case 3:
			$str='待发货';
			break;
		case 4:
			$str='已发货';
			break;
		case 5:
			$str='交易完成';
			break;
		case 6:
			$str='已取消';
			break;
		default:
			$str='未付款'	;
			break;
	}
	
	
	return $str;
}

function getfriendlink($limit){
	
	$lang=cookie('think_language')?cookie('think_language'):'zh-cn';
	$link=M('link')->where(array('lang'=>$lang))->order('l_order desc')->select();
	return $link;
}


 function getAllSorts($sortid, $stoplevel=0) {
 	$lang=cookie('think_language')?cookie('think_language'):'zh-cn';
 	$where['lang']=$lang;
 	if(strtolower(GROUP_NAME)=='home'&&strtolower(ACTION_NAME)=='index'){
 		$where['index_hidden']=0;
 	}
 	if(!empty($sortid)){
 		$where['idpath']=array('like','%'.$sortid.'-%');
 	}
 	
 	$son=M('sort')->field('id,parent_id,show_type,module,folder,name,show_pid,jump_to_son')->where($where)->order ( 'sort_order ASC,id ASC' )->select();

 	$tree = list_to_tree ( $son, 'id', 'parent_id', '_child', $sortid );
 	$html=sortsHtml($tree,$stoplevel);
 	
 	return $html;
}

function sortsHtml($menuarray,$stop_level=1,$level=0,$haschild=0){
	
	if(!empty($stop_level)){
		if ($level >= $stop_level) {
			return;
		}
	}
	
	$html = '';
	if (! empty ( $menuarray)) {
		$level ++;
		$html = '<ul>';
		foreach ( $menuarray as $key => $value ) {
			
			if(strtolower(GROUP_NAME)=='wap'){
				$show_type=2;
			}else{
				$show_type=3;
			}
			
			
			if($value['show_type']==$show_type){
				continue;
			}
			$sub = '';
			$sub = sortsHtml ( $value ['_child'],$stop_level, $level, empty ( $value ['_child'] ) ? 0 : 1 );
			
			
			if ($value ['module'] == 'Index') {
				$link = str_replace('/index.php/', '', U ( '/' ));
			} elseif ($value ['module'] == 'Link') {
				$link = $value ['folder'];
			} else {
				
				if(!empty($value['show_pid'])){
					
					$link = listurl (  $value ['module'].'/show', array (
							'sid' => $value ['id'],
							'id'=>$value['show_pid']
					) );
				}elseif(!empty($value['_child'])&&!empty($value['jump_to_son'])){
						//如果后台设置了跳转到子类则修改当前类的链接
						$link =listurl (  $value ['module'].'/index', array (
								'sid' => $value['_child'][0]['id'],
						) );
				}else{
					$link = listurl ( $value ['module'] . '/index', array (
							'sid' => $value ['id']
					) );
				}
			}
			
			$html .= '<li><a  href="' .$link . '" title="' . $value ['name'] . '">' . $value ['name'] . '</a>' . $sub . '</li>';
		}
		$html .= '</ul>';
	}
	
	return $html;
	
	
}
 function getSorts($sortid){
	
 	
 	
 	
	$list=M('sort')->field('id,parent_id,show_type,module,folder,name,img,index_hidden,show_pid,jump_to_son')->where(array('parent_id'=>intval($sortid)))->order('sort_order ASC,id ASC')->select();
	if(strtolower(GROUP_NAME)=='wap'){
		$show_type=2;
	}else{
		$show_type=3;
	}
	
	$newlist=array();
	foreach($list as $k=>$v){
		if($v['show_type']==$show_type||$v['index_hidden']==1){
			continue;
		}
		
		$newlist[$k]=$v;
		$newlist[$k]['img']=isset($v['img'])?site_url().'/'.$v['img']:'';
		
		
		if ($v ['module'] == 'Index') {
			$link = str_replace('/index.php/', '', U ( '/' ));
		} elseif ($v ['module'] == 'Link') {
			$link = $v ['folder'];
		} else {
			if(!empty($v['show_pid'])){
				$link = listurl (  $v ['module'].'/show', array (
						'sid' => $v ['id'],
						'id'=>$v['show_pid']
				) );
			}elseif(!empty($v['jump_to_son'])){
						//如果后台设置了跳转到子类则修改当前类的链接
						$son=M('sort')->where(array('parent_id'=>$v['id']))->order('sort_order ASC,id ASC')->select();
						if(!empty($son)){
							$link =listurl (  $son [0]['module'].'/index', array (
									'sid' => $son[0]['id'],
							) );
						}else{
							$link =listurl (  $v ['module'].'/index', array (
									'sid' => $v['id'],
							) );
						}
			}else{
				$link = listurl ( $v ['module'] . '/index', array (
						'sid' => $v ['id']
				) );
			}
		}
		
		$newlist[$k]['url'] = $link;
		
	}
	
	
	return $newlist;
}

function getBanner(){
	$lang=cookie('think_language')?cookie('think_language'):'zh-cn';
	$banner=F($lang.'banner');
	
	if(!empty($banner)){
		foreach($banner as $k=>$v){
			$banner[$k]['pic']=site_url().'/'.$v['pic'];
			$banner[$k]['blink']='http://'.$v['blink'];
		}
		
	}
	
	return $banner;
}
 

function getItems($sortid,$limit,$istop){
	
	$sort=M('sort')->field('id,parent_id,show_type,module,folder,name,img,idpath')->where(array('id'=>$sortid))->find();
	if(empty($sort)){
		return false;
	}
	$sortids[]=$sort['id'];
	if(!in_array($sort['module'], array('Product','Article','Picture','Download','Job'))){
		return false;
	}else{
		
		//因为不同模块的排序字段不同特殊处理下
		switch ($sort['module']){
			case 'Product':$order_field='p_order ASC,';break;
			case 'Article':$order_field='a_order ASC,';break;
			case 'Picture':$order_field='p_order ASC,';break;
			case 'Download':$order_field='d_order ASC,';break;
			case 'Job':$order_field='j_order ASC,';break;
			default:$order_field='';
		}
		$son=M('sort')->field('id,parent_id,show_type,module,folder,name,img,idpath')->where(array('idpath'=>array('like','%'.$sort['id'].'-%')))->select();
		
		if(!empty($son)){
			foreach($son as $sk=>$sv){
				$sortids[]=$sv['id'];
			}
		}
		$where['sort']=array('in',$sortids);
		if($istop){
			$where['top']=1;
		}elseif(strtolower(MODULE_NAME)=='index'&&in_array($sort['module'], array('Product','Article'))){
			$where['home_show']=1;
		}
		
		$list=M($sort['module'])->where($where)->limit($limit)->order('top DESC,'.$order_field.'dateline DESC')->select();
	
		if(!empty($list)){
			
			foreach($list as $k=>$v){
				
				$list[$k]['dateline']=date('Y-m-d',$v['dateline']);
				$list[$k]['pic']=isset($v['pic'])?site_url().'/'.$v['pic']:'';
				$list[$k]['filepath']=isset($v['filepath'])?site_url().'/'.$v['filepath']:'';
				$list[$k]['url'] = listurl ( $sort['module'].'/show', array (
						'sid' => $v ['sort'],
						'id' => $v ['id']
				) );
				
			}	
		}
		
		
		 return $list;
	}
	
}



function downimg($content){
	$newcontent=$content;
	preg_match_all('/img[\s\S]*?src=\"http:\/\/([\s\S]*?)\"/', $content, $imgarray);
	

	if(!empty($imgarray[1])){
		foreach($imgarray[1] as $k=>$v){
			
			$oimg=$imgarray[0][$k];
			$localimgpath=imgdowning('http://'.$v);
			$re=preg_replace('/src=\"([\s\S]*?)\"/i','src="'.$localimgpath.'"',$imgarray[0][$k]);
			$newcontent=str_replace($oimg,$re,$newcontent);
			
		}
		
	}
	
	
	return $newcontent;
}

function delcontentimg($content){
	
	preg_match_all('/src=\"([\s\S]*?)\"/', $content, $imgarray);
	
	if(!empty($imgarray[1])){
		
		foreach($imgarray[1] as $k=>$v){
			@unlink('./'.$v);
			//删除批量上传编辑器内的原图
			$oth=str_replace('thumb_', '', $v);
			@unlink('./'.$oth);
		}
		
	}
	
}

function imgdowning($imgurl){
	$chr=strrchr($imgurl,".");//后缀
	$imgUrl=uniqid();//文件名
	$filename='Upload/'.$imgUrl.$chr;//路径
	$get_file=getfile($imgurl);
	if(!empty($get_file)){
		write_file($filename,$get_file);
	}

	return $filename;

}

function getfile($url){
	if(function_exists('curl_init')){
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
		$content = curl_exec($ch);
		curl_close($ch);
		if($content){return $content;}else{return false;}
	}else{
		for($i=0;$i<3;$i++){$content=@file_get_contents($url);if($content) break;}
		if(false == $content){return false;}else{return $content;}
	}
}

function dereplace($content){
	$base   =__ROOT__.'/';
	$protocols = '[a-zA-Z0-9]+:';
	$regex     = '#(src)="(?!/|' . $protocols . '|\#|\')([^"]*)"#m';
	$content    = preg_replace($regex, "$1=\"$base\$2\"", $content);
	
	
	return $content;
}

function replacesrc($content){
	//用于替换图片目录的二级路径
	$base=__ROOT__.'/';

	if($base!=='/'){
		$base_reg=__ROOT__.'/';
	}
	$regex     = '#(src)="'.$base.'(.*?)"#m';
	$content    = preg_replace($regex, "$1=\"\$2\"", $content);

	$newcontent=downimg($content);//下载图片

	return $newcontent;
}

function callback_pre_extract($v,$info){
	
	
	if($info['folder']==false){
		if(file_exists($info['filename'])){
			@unlink($info['filename']);
		}
	}
	
	return 1;
}





function dostrslashes(){
	
	if (get_magic_quotes_gpc())
	{
		if (!empty($_GET))
		{
			$_GET  = strslashes_deep($_GET);
		}
		if (!empty($_POST))
		{
			$_POST = strslashes_deep($_POST);
		}
	
		$_COOKIE   = strslashes_deep($_COOKIE);
		$_REQUEST  = strslashes_deep($_REQUEST);
	}
	
}


function strslashes_deep($value)
{
	if (empty($value))
	{
		return $value;
	}
	else
	{
		return is_array($value) ? array_map('strslashes_deep', $value) : stripslashes($value);
	}
}

function isChinese($sInBuf)//正确的函数
        {
            if (preg_match("/^[\x7f-\xff]+$/", $sInBuf)) { //兼容gb2312,utf-8
                 
                return true;
            }
            else
            {
                return false;
            }
        }
