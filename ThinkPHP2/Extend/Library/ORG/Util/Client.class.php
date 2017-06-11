<?php
class Client {
	
	/**
	 * 请求模块 URL
	 * 
	 * @var string
	 */
	public $url;
	
	/**
	 * 请求主机
	 * 
	 * @var string
	 */
	public $host = 'http://127.0.0.1/rest/';
	
	/**
	 * 请求超时时间
	 * 
	 * @var int
	 */
	public $timeout = 30;
	
	
	public $connecttimeout = 30;
	
	/**
	 * 返回数据类型
	 * 
	 * @var stirng
	 */
	public $format = 'json';
	
	
	public static $boundary = '';
	
	public $debug=true;
	
	
	public function get($url, $params=array()) {
		$response = $this->oAuthRequest ( $url, 'GET', $params );
		return $response;
	}
	
	
	
	public function post($url, $parameters = array(), $multi = false) {
		
		$response = $this->oAuthRequest($url, 'POST', $parameters, $multi );
		return $response;
	}
	
	
	
	
	public function oAuthRequest($url, $method, $params,$multi=false) {
		if (strrpos ( $url, 'http://' ) !== 0 && strrpos ( $url, 'https://' ) !== 0) {
			$url = "{$this->host}{$url}/";
		}
		
		switch ($method) {
			case 'GET' :
				$url = $url . $this->bulid_query($params) ;
				return $this->http ( $url, 'GET' );
			default :
				$headers = array ();
				if (!$multi&&(is_array ( $params ) || is_object ( $params ))) {
					$body = http_build_query ( $params );
				}else{
					
					$body = self::build_http_query_multi($params);
					$headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
				}
				return $this->http ( $url, $method, $body, $headers );
		}
	}
	
	
	public static function build_http_query_multi($params) {
		if (!$params) return '';

		uksort($params, 'strcmp');
		$pairs = array();
		
		self::$boundary = $boundary = uniqid('------------------');
		$MPboundary = '--'.$boundary;
		$endMPboundary = $MPboundary. '--';
		$multipartbody = '';

		foreach ($params as $parameter => $value) {

			if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
				$url = ltrim( $value, '@' );
				$content = file_get_contents( $url );
				$array = explode( '?', basename( $url ) );
				$filename = $array[0];

				$multipartbody .= $MPboundary . "\r\n";
				$multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
				$multipartbody .= "Content-Type: image/unknown\r\n\r\n";
				$multipartbody .= $content. "\r\n";
			} else {
				$multipartbody .= $MPboundary . "\r\n";
				$multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
				$multipartbody .= $value."\r\n";
			}

		}

		$multipartbody .= $endMPboundary;
		return $multipartbody;
	}
	
	
	public function bulid_query($params){
		
		if(!is_array($params)) return ;
		$parms_key_value=array();
		
		$params_str='';
		if(!empty($params)){
			foreach($params as $key=>$value){
				$parms_key_value[]=$key.'/'.$value;
			}
		}			
		if(!empty($parms_key_value)){
			$params_str=implode('/', $parms_key_value);
		}
		
		return $params_str;
		
	}
	
	
	
	
	public function http($url, $method, $postfields = NULL, $headers = array()) {
		$this->http_info = $rs=array ();
		$ci = curl_init ();
		/* Curl settings */
		curl_setopt ( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
		curl_setopt ( $ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout );
		curl_setopt ( $ci, CURLOPT_TIMEOUT, $this->timeout );
		curl_setopt ( $ci, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ci, CURLOPT_ENCODING, "" );
		
		switch ($method) {
			case 'POST' :
				curl_setopt ( $ci, CURLOPT_POST, TRUE );
				if (! empty ( $postfields )) {
					curl_setopt ( $ci, CURLOPT_POSTFIELDS, $postfields );
				}
		}
		
		
		curl_setopt ( $ci, CURLOPT_URL, $url );
		curl_setopt ( $ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ci, CURLINFO_HEADER_OUT, TRUE );
		
		$response = curl_exec ( $ci );
		$this->http_code = curl_getinfo ( $ci, CURLINFO_HTTP_CODE );
		$this->http_info = array_merge ( $this->http_info, curl_getinfo ( $ci ) );
		$this->url = $url;
		
		if ($this->debug) {
			
			$rs=array('postfields'=>$postfields,'response'=>$response,'info'=>curl_getinfo ( $ci ));
		}
		curl_close ( $ci );
		return $rs;
	}
}


