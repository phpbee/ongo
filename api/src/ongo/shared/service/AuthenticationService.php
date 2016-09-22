<?php

namespace ongo\shared\service;

use ongo\shared\entity\SessionEntity;
use ongo\shared\model\UserModel;
use ongo\shared\service\cache\CacheService;
use Doctrine\DBAL\Connection;
use ongo\shared\exception\InvalidAuthenticationServiceVersionException;
use ongo\shared\exception\MissingAuthenticationServiceVersionException;
use ongo\shared\exception\MissingTokenException;
use ongo\shared\model\SessionModel;
use Symfony\Component\HttpFoundation\Request;

final class AuthenticationService {
	private $memcache;
	private $dbConn;
	private $request;
	/** @var  SessionEntity */
	private $session;

	public function __construct(CacheService $memcache, Connection $dbConn) {
		$this->memcache = $memcache;
		$this->dbConn = $dbConn;
	}

	public function setRequest(Request $request) {
		$this->request = $request;
	}

	public function authenticate() {
		$this->getSession();
		return true;
	}

	public function getUser() {
		$model = new UserModel($this->dbConn);
		return $model->findById($this->getSession()->getUserId());
	}

	public function getSession() {
		if ($this->session === null) {
			$version = $this->request->headers->get("Authorization");
			switch ($version) {
			case "Ongo 1.0":
				$token = $this->request->headers->get("Token");
				$model = new SessionModel($this->dbConn);
				$this->session = $model->findByToken($token);
				break;
			default:
				throw new InvalidAuthenticationServiceVersionException($version);
			}
		}
		return $this->session;
	}
}
