<?php
/**
 * lsys token link
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\TokenLink;
class TokenItem{
	private $_token;
	private $_timeout;
	private $_data;
	public function __construct($token,array &$data,$timeout){
		$this->_token=$token;
		$this->_data=$data;
		$this->_timeout=$timeout;
	}
	public function get($key,$default=null){
		return isset($this->_data[$key])?$this->_data[$key]:$default;
	}
	public function timeout($format=true){
		if ($format==true)return date("Y-m-d H:i:s",$this->_timeout);
		return $this->_timeout;
	}
	public function __toString(){
		return $this->_token;
	}
	
}