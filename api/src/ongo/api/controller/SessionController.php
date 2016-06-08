<?php

namespace ongo\api\controller;

use ongo\shared\service\cache\CacheService;
use ongo\shared\model\SessionModel;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SessionController {
	private $memcache;
	private $dbConn;

	public function __construct(CacheService $memcache, Connection $dbConn) {
		$this->memcache = $memcache;
		$this->dbConn = $dbConn;
	}

	public function post($apiKey, $username, $password) {
		$model = new SessionModel($this->memcache, $this->dbConn);
		$session = $model->create($apiKey, $username, $password);
		return new JsonResponse($session->serialize($this->dbConn));
	}

	public function put($token) {
		$model = new SessionModel($this->memcache, $this->dbConn);
		$session = $model->extend($token);
		return new JsonResponse($session->serialize($this->dbConn));
	}	

	public function delete($token) {
		$model = new SessionModel($this->memcache, $this->dbConn);
		$model->delete($token);
		return new Response("No content", 204);
	}
}

?>