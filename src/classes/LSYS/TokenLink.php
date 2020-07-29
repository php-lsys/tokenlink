<?php
/**
 * 用在如找回密码等临时连接页面创建
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
use LSYS\TokenLink\TokenItem;
use LSYS\TokenLink\Exception;
use function LSYS\TokenLink\__;
class TokenLink{
	/**
	 * @var Cache
	 */
	protected $_cache;
	protected $_prefix;
	public function __construct(Cache $cache=null,$prefix=null){
		$this->_prefix=$prefix;
	    $this->_cache=$cache==null?\LSYS\Cache\DI::get()->cache():$cache;
	}
	/**
	 * 创建一个临时链接数据
	 * @param array $data
	 * @param number $timeout
	 * @throws Exception
	 * @return \LSYS\TokenLink\TokenItem
	 */
	public function create(array $data,$timeout=604800){
		$timeout=time()+$timeout;
		$save_data=array($timeout,$data);
		$id=md5(json_encode($data).uniqid()).'-'.md5(uniqid());
		if(!$this->_cache->set($this->_prefix.$id, $save_data,$timeout)){
			throw new Exception(__("can't save token to cache"));
		}
		return new TokenItem($id, $data,$timeout);
	}
	/**
	 * 通过TOKEN查找链接数据
	 * @param string $token
	 * @throws Exception
	 * @return \LSYS\TokenLink\TokenItem
	 */
	public function find($token){
		if(preg_match("/^\w{32}-\w{32}$/",$token)){
			$data=$this->_cache->get($this->_prefix.$token);
			if (is_array($data)){
				list($timeout,$_data)=$data;
				return new TokenItem($token, $_data,$timeout);
			}
		}
		throw new Exception(__("can't find this token[:token]",array(":token"=>strip_tags($token))));
	}
	/**
	 * 清楚TOKEN数据
	 * @param string $token
	 * @return boolean
	 */
	public function clear($token){
		if ($token instanceof TokenItem)$token=strval($token);
		if(!preg_match("/^\w{32}-\w{32}$/",$token))return false;
		$this->_cache->exist($token)&&$this->_cache->delete($this->_prefix.$token);
		return true;
	}
}