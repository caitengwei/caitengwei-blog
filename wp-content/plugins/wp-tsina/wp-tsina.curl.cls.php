<?php
/**
 * curl发送请求
 */
define('CURLW_ERR_OK',0);
define('CURLW_ERR_NORMAL',-1);
define('CURLW_ERR_TIMEOUT',-2);
define('CURLW_ERR_TIMEOUT_RW',-3);
define('CURLW_ERR_CONNECT_REFUSED',-4);

class CurlWrapper
{
	//连接超时
	var $_tm_con = 5;
	//读写超时 
	var $_tm_rw = 5;
	//stream_select超时(ms)
	var $_tm_select = 2000000;
	//多进程
	var $_multiple = 0;
	//请求数组
	var $_req_arr = array();
	//回应数组
	var $_res_arr = array();
	//是否输出调试信息
	var $_if_debug = 0;
	//调试信息
	var $_debug = array();
	//错误信息
	var $_error = '';
	//是否安装了curl包
	var $_curl_package = 1;
	
	function CurlWrapper()
	{
		$this->checkCurlPackage();
	}
	
	/**
	 * 调试函数
	 */
	function debug($info,$newline="\n")
	{
		echo $info.$newline;
		$this->_debug[] = $info;
	}
	
	/**
	 * 监测是否安装了curl包
	 */
	function checkCurlPackage()
	{
		if( !function_exists('curl_init') )
		{
			$this->_curl_package = 0;
		}
	}
	
	/**
	 * 设置是否采用并发形式
	 */
	function setMultiple($status=0)
	{
		$this->_multiple = $status;
	}
	
	/**
	 * 设置是否输出调试信息
	 */
	function setDebug($status=0)
	{
		$this->_if_debug = $status;
	}
	
	/**
	 * 设置stream_select超时(ms)
	 */
	function setSelectTimeout($time)
	{
		$this->_tm_select = $time;
	}
	
	/**
	 * 打印debug信息
	 */
	function &getDebug()
	{
		return $this->_debug;
	}
	
	/**
	 * 获取返回结果
	 */
	function &getResult()
	{
		return $this->_res_arr;
	}
	
	/**
	 * 获取指定key的结果
	 */
	function &getResultByKey($key)
	{
		return $this->_res_arr[$key];
	}
	
	/**
	 * 获取结果状态
	 */
	function getResultStatus(&$params)
	{
		if( $params['errno'] != CURLW_ERR_OK )
		{
			$params['error'] = 'curl_error='.$params['error'].',curl_errno='.$params['errno'].',curl_code='.$params['code'];
			return false;
		}
		else if( $params['errno'] == CURLW_ERR_OK && $params['code'] != '200' )
		{
			$params['error'] = 'curl_error='.$params['error'].',curl_errno='.$params['errno'].',curl_code='.$params['code'];
			return false;
		}
		return true;
	}
	
	/**
	 * 添加一个请求
	 */
	function addRequest($params=null)
	{
		//url形式默认为get方式请求
		if( $params['url'] ) 
		{
			$url_arr = parse_url($params['url']);
			$params['method'] = $params['method'] ? $params['method'] : 'get';
			$params['host'] = $url_arr['host'];
			$params['uri'] = $url_arr['path'].'?'.$url_arr['query'];
			$params['port'] = $url_arr['port'];
		}
		
		//host
		if( !$params['host'] )
		{
			$this->debug('['.__FUNCTION__.':'.__LINE__.']host为空');
			return false;
		}
		
		//uri
		if( !$params['uri'] )
		{
			$this->debug('['.__FUNCTION__.':'.__LINE__.']uri为空');
			return false;
		}
		
		//port
		if( !$params['port'] )
		{
			$params['port'] = 80;
		}
		
		//proxy host
		if( $params['proxy_host'] )
		{
			$params['uri'] = 'http://'.$params['host'].':'.$params['port'].'/'.$params['uri'];
		}
		
		//proxy port
		if( !$params['proxy_port'] )
		{
			$params['proxy_port'] = 80;
		}
		
		//method
		$method = strtolower($params['method']);
		if( $method != 'get' && $method != 'post' && $method != 'purge' && $method != 'header' )
		{
			$params['method'] = 'get';
		}
		
		//请求内容
		$content = trim($params['content']);
		if( $method == 'post' && $content == '' )
		{
			$this->debug('['.__FUNCTION__.':'.__LINE__.']请求内容为空');
			return false;
		}
		
		//connection timeout
		if( !$params['timeout'] )
		{
			$params['timeout'] = $this->_tm_con;
		}
		
		//read,write timeout
		if( !$params['timeout_rw'] )
		{
			$params['timeout_rw'] = $this->_tm_rw;
		}
		
		if( $params['key'] ) $this->_req_arr[$params['key']] = $params;
		else $this->_req_arr[] = $params;
		if( $this->_if_debug ) print_r($this->_req_arr);
		return true;
	}
	
	function send()
	{
		if( $this->_multiple == 0 )//非并发请求
		{
			if( !$this->_curl_package )	$this->_sendRequest();
			else $this->_sendRequestByCURL();
		}
		else if( $this->_multiple == 1 )//并发请求
		{
			$this->_sendMultiRequest();
		}
	}
	
	/**
	 * 发送请求 -> 连接超时判断 -> 读写超时判断
	 */
	function _sendRequest()
	{
		foreach( $this->_req_arr as $req_key=>$req )
		{
			//初始化数据
			$errno = CURLW_ERR_OK;
			$error = "";
			$ret_arr = array('errno'=>0,'error'=>'','data'=>'','code'=>'');
			
			//调试
			if( $this->_if_debug )
			{
				$this->debug($fp);
				
				$debug_msg = '';
				foreach( $req as $req_key_debug=>$req_val_debug ) $debug_msg.= $req_key_debug.'='.$req_val_debug.",\n";
				$this->debug($debug_msg);
			}
		
			//创建句柄
			//if( $req['proxy_host'] ) $fp = @fsockopen($req['proxy_host'],$req['proxy_port'],$errno,$error,$req['timeout']);
			//else $fp = @fsockopen($req['host'],$req['port'],$errno,$error,$req['timeout']);
			if( $req['proxy_host'] )
			{
				$req['host'] = $req['proxy_host'];
				$req['port'] = $req['proxy_port'];
			}
			$fp = @fsockopen($req['host'],$req['port'],$errno,$error,$req['timeout']);
			if( !$fp )
			{
				if( $this->_if_debug ) $this->debug('['.__FUNCTION__.':'.__LINE__.']host='.$req['host'].',error='.$error);
				if( $errno == 60 ) $ret_arr['errno'] = CURLW_ERR_TIMEOUT;
				else if( $errno == 61 ) $ret_arr['errno'] = CURLW_ERR_CONNECT_REFUSED;
				else $ret_arr['errno'] = CURLW_ERR_NORMAL;
				$ret_arr['error'] = '['.$errno.']'.$error;
				$ret_arr['data'] = '';
				$ret_arr['code'] = '';
				$this->_res_arr[$req_key] = $ret_arr;
				continue;
			}
			
			//发送请求
			$reqstr = &$this->_getRequestStr($req);
			if( $this->_if_debug ) $this->debug('request='.$reqstr);
			@fwrite($fp,$reqstr,strlen($reqstr));
			
			//设置读取超时时间
			$tm_rw = isset($req['timeout_rw'])?$req['timeout_rw']:$this->_tm_rw;
			stream_set_timeout($fp,$tm_rw);
			
			//获取返回内容
			if( $retval=$this->_getResponseStr( array('fp'=>$fp,'header'=>1) ) )
			{
				$ret_arr['errno'] = CURLW_ERR_OK;
				$ret_arr['error'] = '';
				$ret_arr['data'] = trim(strstr($retval,"\r\n\r\n"));
				$ret_arr['code'] = $this->_getHTTPCode($retval);
				$this->_res_arr[$req_key] = $ret_arr;
			}
			else 
			{
				$ret_arr['errno'] = CURLW_ERR_TIMEOUT_RW;
				$ret_arr['error'] = $this->_error;
				$ret_arr['data'] = '';
				$ret_arr['code'] = '';
				$this->_res_arr[$req_key] = $ret_arr;
			}
			fclose($fp);
		}
	}
	
	/**
	 * 使用curl发送请求
	 */
	function _sendRequestByCURL()
	{
		foreach( $this->_req_arr as $req_key=>$req )
		{
			//初始化数据
			$ret_arr = array('errno'=>CURLW_ERR_OK,'error'=>'','data'=>'','code'=>'');
			if( !$req['url'] ) $req['url'] = 'http://'.$req['host'].':'.$req['port'].$req['uri'];
			if( $this->_if_debug ) $this->debug('['.__FUNCTION__.':'.__LINE__.']url='.$req['url']);
			
			//创建句柄
			$curl_handle = curl_init($req['url']);
			
			//设置选项
			if( $this->_if_debug ) curl_setopt($curl_handle,CURLOPT_VERBOSE,1);
			curl_setopt($curl_handle,CURLOPT_TIMEOUT,$req['timeout_rw']);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl_handle,CURLOPT_HEADER,1);
			if( $req['method'] == 'post' )
			{
				curl_setopt($curl_handle,CURLOPT_POST,1);
				curl_setopt($curl_handle,CURLOPT_POSTFIELDS,$req['content']);
			}else if( $req['method'] == 'header' )
			{
				curl_setopt($curl_handle, CURLOPT_NOBODY, 1); 
				curl_setopt($curl_handle, CURLOPT_HEADER, 1);
			}

			if( $req['proxy_host'] ) curl_setopt($curl_handle,CURLOPT_PROXY,$req['proxy_host'].':'.$req['proxy_port']);
			
			//发送请求,获取返回内容
			$curl_rst = curl_exec($curl_handle);
			if( $this->_if_debug ) $this->debug('[_sendRequestByCURL]'.$curl_rst);
			if( !$curl_rst )
			{
				if( curl_errno($curl_handle) == CURLE_OPERATION_TIMEOUTED )
				{
					$ret_arr['errno'] = CURLW_ERR_TIMEOUT_RW;
					$ret_arr['error'] = curl_error($curl_handle);
					$ret_arr['data'] = '';
					$ret_arr['code'] = '';
					$this->_res_arr[$req_key] = $ret_arr;
				}
			}
			else 
			{
				$ret_arr['errno'] = CURLW_ERR_OK;
				$ret_arr['error'] = '';
				if ( $req['method'] == 'header' ){
					$ret_arr['data'] = curl_getinfo( $curl_handle );
				}else {
					$ret_arr['data'] = trim(strstr($curl_rst,"\r\n\r\n"));
				}
				$ret_arr['code'] = $this->_getHTTPCode($curl_rst);
				$this->_res_arr[$req_key] = $ret_arr;
			}
			
			//关闭
			curl_close($curl_handle);
		}
	}
	
	/**
	 * 发送并发请求
	 * 连接超时有效
	 * 读写超时无效
	 * stream_select超时用来控制程序执行时间
	 */
	function _sendMultiRequest()
	{
		$fp_r = array();
		foreach( $this->_req_arr as $req_key=>$req )
		{
			$errno = 0;
			$error = "";
		
			//创建句柄
			if( $req['proxy_host'] ) $fp = @fsockopen($req['proxy_host'],$req['proxy_port'],$errno,$error,$req['timeout']);
			else $fp = @fsockopen($req['host'],$req['port'],$errno,$error,$req['timeout']);
			if( !$fp )
			{
				if( $this->_if_debug ) $this->debug('['.__FUNCTION__.':'.__LINE__.']host='.$req['host'].',error='.$error);
				continue;
			}
			$fp_r[] = $fp;
			
			if( $this->_if_debug )
			{
				$debug_msg = $fp.',host='.$req['host'].',uri='.$req['uri'].',port='.$req['port'].',timeout='.$req['timeout'];
				echo $debug_msg."\n";
				$this->_debug[] = $debug_msg;
			}
			
			//设置为非阻塞模式
			stream_set_blocking($fp,0);
			
			//发送请求
			$reqstr = &$this->_getRequestStr($req);
			@fwrite($fp,$reqstr,strlen($reqstr));
		}
		
		$stime = microtime(true);
		while( 1 )
		{
			//利用select原理,获取有效fp
			$fp_r_select = $fp_r;
			$ret_select = stream_select($fp_r_select,$fp_w_select=null,$fp_e_select=null,0,$this->_selectTimeout($this->_tm_select,$stime));
			if( $ret_select === false || $ret_select == 0 )
			{
				if( $ret_select === false ) $this->_debug[] = 'stream_select错误';
				else if( $ret_select == 0 ) $this->_debug[] = 'stream_select超时';
				break;
			}
			
			//if( $this->_if_debug ) echo '***fp_r_select:'.implode(',',$fp_r_select)."\n";
			foreach( $fp_r_select as $fp )
			{
				if( !is_resource($fp) )
				{
					if( $this->_if_debug ) echo $fp.',error!';
					continue;
				}
				
				$tmp = $this->_getResponseStr( array('fp'=>$fp,'header'=>0) );
				
				//清除不用的fp对象
				foreach( $fp_r as $fp_r_key=>$fp_r_val )
				{
					if( $fp_r_val == $fp )
					{
						$this->_res_arr[$fp_r_key] = $tmp;
						//if( $this->_if_debug ) echo $fp_r[$fp_r_key].",被关闭\n";
						if( feof($fp_r_val) ) fclose($fp_r[$fp_r_key]);
						unset($fp_r[$fp_r_key]);
					}
				}
			}
			
			//退出
			if( count($fp_r)==0 )
			{
				break;
			}
		}
	}
	
	/**
	 * 使用curl发送并发请求
	 */
	function _sendMultiRequestByCurl()
	{
		//在子类中实现
	}
	
	/**
	 * 获取返回字符串
	 */
	function _getResponseStr($params=null)
	{
		if( !$params['fp'] )
		{
			if( $this->_if_debug ) $this->debug('['.__FUNCTION__.':'.__LINE__.']fp无效');
			return false;
		}
		$fp = $params['fp'];
		
		$tmp = "";
		while( !feof($fp) )
		{
			$tmp.= @fread($fp,1024);
			$info = stream_get_meta_data($fp);
			if( $info['timed_out'] )//超时
			{
				if( $this->_if_debug ) $this->debug('['.__FUNCTION__.':'.__LINE__.']'.$fp.',获取数据超时');
				$this->_error = '获取数据超时';
				return false;
			}
		}
		//if( $this->_if_debug ) $this->debug('[_getResponseStr]服务器返回结果='.$tmp);
		
		//是否保留头信息
		$header = isset($params['header'])?$params['header']:0;
		if( !$header )
			$tmp = strstr($tmp,"\r\n\r\n");
		$str = trim($tmp);

		return $str;
	}
	
	/**
	 * 返回发送请求字符串
	 */
	function &_getRequestStr($params=null)
	{
		switch($params['method'])
		{
			case 'post':
				$reqstr = "POST ".$params['uri']." HTTP/1.0\r\n";
				$reqstr.= "Host: ".$params['host']."\r\n";
				$reqstr.= "Content-type: application/x-www-form-urlencoded\r\n";
				$reqstr.= "Content-length: ".strlen($params['content'])."\r\n";
				$reqstr.= "Connection: Close\r\n\r\n";
				$reqstr.= $params['content'];
				break;
			case 'purge':
				$reqstr = "PURGE ".$params['uri']." HTTP/1.1\n";
				$reqstr.= "Host: ".$params['host']."\n";
				$reqstr.= "Connection: Close\n\n";
				break;
			case 'get':
			case 'header':
			default:
				$reqstr = "GET ".$params['uri']." HTTP/1.0\r\n";
				$reqstr.= "Host: ".$params['host']."\r\n";
				$reqstr.= "Connection: Close\r\n\r\n";
				break;
		}
		return $reqstr;
	}
	
	/**
	 * 计算stream_select需要超时的时间
	 */
	function _selectTimeout($mtime,$stime)
	{
		$time = $mtime - ((microtime(true) - $stime) * 1000000);
		if( $time < 0 ) $time = 0;
		$time = ceil($time);
		//if( $this->_if_debug ) echo 'time='.$time."\n";
		return $time;
	}
	
	/**
	 * 获取http code
	 */
	function _getHTTPCode(&$str)
	{
		$header_line1 = substr($str,0,strpos($str,"\n"));
		$header_line1 = trim($header_line1);
		$arr = explode(' ',$header_line1);
		return $arr[1];
	}
}
?>
