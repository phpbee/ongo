<?php

namespace ongo\shared\service;

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

	public function getPartner() {
		return $this->getSession()->getPartner($this->dbConn);
	}

	public function getSession() {
		if ($this->session === null) {
			$attr = $this->getAuthAttributes();
			if (!isset($attr["version"]))
				throw new MissingAuthenticationServiceVersionException();
			switch ($attr["version"]) {
			case "1.0":
				if (!isset($attr["token"]))
					throw new MissingTokenException();
				$model = new SessionModel($this->memcache, $this->dbConn);
				// throws InvalidTokenException
				$this->session = $model->findByToken($attr["token"]);
				break;
			default:
				throw new InvalidAuthenticationServiceVersionException($attr["version"]);
			}
		}
		return $this->session;
	}

	private function getAuthAttributes() {
		$attr = array();

		$header = $this->request->headers->get("Authorization");
		if (!$header && function_exists('getallheaders')) {
			$headers = getallheaders();
			if (isset($headers["Authorization"])) {
				$header = $headers["Authorization"];
			}
		}

		if ($header !== null) {
			if (preg_match("/^ongo\s+[a-zA-Z0-9_-]+\s*=\s*\".+?\"/", $header)) {
	  			preg_match_all("/([a-zA-Z0-9_-]+)\s*=\s*\"(.+?)\"/", $header, $matches);
				for ($i = 0; $i < sizeof($matches[1]); $i++) 
					$attr[$matches[1][$i]] = $matches[2][$i];
	  		}
		}
		return $attr;
	}
}

?>