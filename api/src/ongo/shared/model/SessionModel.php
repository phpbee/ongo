<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ongo\shared\entity\SessionEntity;
use ongo\shared\exception\InvalidTokenException;
use ongo\shared\service\cache\CacheService;

final class SessionModel {
	const EXPIRE_TIME = 86400; // seconds
	private $memcache;
	private $dbConn;

	public function __construct(CacheService $memcache, Connection $dbConn) {
		$this->memcache = $memcache;
		$this->dbConn = $dbConn;
	}

	public function findByToken($token) {
		if (($session = $this->memcache->get($token)) === false)
			throw new InvalidTokenException($token);
		if ($session->hasExpired())
			throw new InvalidTokenException($token);
		return $session;
	}

	/**
	 * @param $apiKey
	 * @param $username
	 * @param $password
	 * @return SessionEntity
	 * @throws InvalidUsernameException
	 * @throws \ongo\shared\exception\InvalidPasswordException
	 */
	public function create($apiKey, $username, $password) {
		$partnerApiUserModel = new PartnerApiUserModel($this->dbConn);
		// throws InvalidApiKeyException, InvalidUsernameException and InvalidPasswordException
		$user = $partnerApiUserModel->findByApiKeyAndUsernameAndPassword($apiKey, $username, $password);
		$created = time();	
		$expires = (self::EXPIRE_TIME == 0) ? null : $created + self::EXPIRE_TIME;
		while (true) {
			$token = self::createToken();
			try {
				$this->findByToken($token);
			} catch (InvalidTokenException $e) {
				$session = new SessionEntity($token, $user->getPartnerId(), $created, $expires); 
				$this->memcache->set($token, $session, self::EXPIRE_TIME);
				return $session;
			}
		}
	}

	public function extend($token) {
		$session = $this->findByToken($token);
		$session->setExpires(time() + self::EXPIRE_TIME);
		$this->memcache->set($token, $session, self::EXPIRE_TIME);
		return $session;
	}	

	public function delete($token) {
		$this->findByToken($token);
		$this->memcache->delete($token);
	}

	private static function createToken() {
		return bin2hex(openssl_random_pseudo_bytes(16));
	}
}

?>