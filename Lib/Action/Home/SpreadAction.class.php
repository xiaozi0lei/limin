<?php

/**
 * Created by PhpStorm.
 * 网站友链管理API
 * User: storm
 * Date: 2016-12-29
 * Time: 19:34
 */
class SpreadAction extends HomeInitAction
{
    private $url = 'www.abc.com';
    private $ip = '';
    private $local_ip;
    private $code = 'YTsjhl2016';
    private $key = 'SJHL123456';


    /**
     * ApiAction constructor.
     * 错误编码
     * 域名错误
     * IP错误
     * token错误
     * 正常返回
     * 200
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->local_ip = $_SERVER["SERVER_ADDR"];
	 
//
        # 验证域名
//        $url = parse_url($_SERVER['HTTP_HOST']);
//        if ($url['path'] != $this->url) {
//            exit($this->json_error('101'));
//        }
        # 验证ip
//        if ($_SERVER['SERVER_ADDR'] != $this->ip) {
//            exit($this->json_error('102'));
//        }
        # 验证token
        if (isset($_GET['token'])) {
            $this->checktoken($_GET['token']);
        }
//        dump($_SERVER['SERVER_ADDR']);
//        dump($url);
//        dump(base64_encode('SJHL001'));
//        dump(base64_decode('U0pITDAwMQ=='));
//        exit;
    }

    public function index()
    {
        $this->error('该页不存在', '/');
        exit;
    }

    /**
     * 返回Token
     *
     */
    public function gettoken()
    {
        $encrypt = $this->passport_encrypt($this->code, $this->key);
        echo urlencode($encrypt) ;
    }
    /**
     * 返回友情链接和数量
     */
    public function getspread()
    {
   
        $link = D('link')->select();
        $count = count($link);
        echo $count . '|' . $this->local_ip;
        exit;
    }

    /**
     * 设置友情链接
     * add操作
     *
     */
    public function setspread()
    {
        $this->checktoken($_GET['token']);
        $data['name'] = $_GET['title'];
        $data['linkkeyword'] = $_GET['title'];
        $data['url'] =$_GET['url'];
        $data['l_order'] = 0;
        $data['lang'] = 'zh-cn';
        $data['dateline'] = time();
		$link= D('link')->where(array('url'=>$_GET['url']))->find();
		if(!empty($link['name'])){
			exit('URL is exist!');
		}
        D('link')->data($data)->add();
        $link = D('link')->select();
        $count = count($link);
 	    if(C( 'HTML_ON' )){
		$html=file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/index.php');
		file_put_contents(APP_PATH."index.html",$html);
		}
        exit("$count|ok");
    }
    /**
     * 删除友情链接
     *
     */
    public function delspread()
    {   
        $this->checktoken($_GET['token']);
        D('link')->where(array('url' => $_GET['url']))->delete();
        $link = D('link')->select();
        $count = count($link);
		if(C( 'HTML_ON' )){
		$html=file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/index.php');
		file_put_contents(APP_PATH."index.html",$html);
		}
        exit("$count|ok");
    }

    /**
     *功能：对字符串进行加密处理
     *参数一：需要加密的内容
     *参数二：密钥
     */
    function passport_encrypt($str, $key)
    { //加密函数
        srand((double)microtime() * 1000000);
        $encrypt_key = md5(rand(0, 32000));
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $encrypt_key[$ctr] . ($str[$i] ^ $encrypt_key[$ctr++]);
        }
        return base64_encode($this->passport_key($tmp, $key));
    }

    /**
     *功能：对字符串进行解密处理
     *参数一：需要解密的密文
     *参数二：密钥
     */
    function passport_decrypt($str, $key)
    { //解密函数
	
        $str = $this->passport_key(base64_decode($str), $key);
        $tmp = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $md5 = $str[$i];
            $tmp .= $str[++$i] ^ $md5;
        }
        return $tmp;
    }

    /**
     *
     * 验证token
     */
    public function checktoken($token)
    {
		$token=stripslashes($token);
	   // echo $token;exit;
        $decrypt = $this->passport_decrypt($token, $this->key);
	
        if ($decrypt != $this->code) {
            exit('Token not exist!');
        }
    }

    /**
     * 辅助函数
     */
    function passport_key($str, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $str[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }
}