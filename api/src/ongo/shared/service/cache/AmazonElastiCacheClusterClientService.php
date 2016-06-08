<?php

namespace ongo\shared\service\cache;

final class AmazonElastiCacheClusterClientService implements CacheService {
	private static $PORT = 11211;
	private $memcache;
	private $keyPrefix;

	public function __construct($endPoint, $keyPrefix = null) {
		$this->memcache = new \Memcached();
		$this->memcache->setOption(\Memcached::OPT_CLIENT_MODE, \Memcached::DYNAMIC_CLIENT_MODE);
		$this->memcache->addServer($endPoint, self::$PORT);
		$this->keyPrefix = ($keyPrefix !== null && mb_strlen($keyPrefix) > 0) ? $keyPrefix : "";	
	}
	
	public function get($key) {
		if (($val = @$this->memcache->get($this->keyPrefix . $key)))
			return $val;
		return false;
	}
	
	public function set($key, $val, $expires_in = 0) {
		if (@$this->memcache->set($this->keyPrefix . $key, $val, $expires_in))
			return true;
		return false;
	}		
	
	public function delete($key) {
		return $this->memcache->delete($this->keyPrefix . $key);
	}

	public function flush() {
		$this->memcache->flush();
	}	
}

?>