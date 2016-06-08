<?php

namespace ongo\shared\service\cache;

interface CacheService {	
	public function get($key);	
	public function set($key, $val, $expires_in = 0);
	public function delete($key);
	public function flush();
}

?>