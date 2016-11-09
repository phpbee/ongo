<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ongo\shared\entity\SessionEntity;
use ongo\shared\entity\UserEntity;
use ongo\shared\exception\InvalidTokenException;
use ongo\shared\exception\SessionNotFoundException;
use ongo\shared\service\cache\CacheService;

final class SessionModel {
	private $dbConn;

	public function __construct(Connection $dbConn) {
		$this->dbConn = $dbConn;
	}

	/**
	 * @param $token
	 * @return SessionEntity
	 * @throws DBALException
	 * @throws SessionNotFoundException
	 */
	public function findByToken($token)
	{
		if (!($row = $this->dbConn->executeQuery(
			"select * from session where token = ?",[$token]
		)->fetch())
		) {
			throw new SessionNotFoundException($token);
		}

		return self::entityFromRecord($row);
	}

	/**
	 * @param UserEntity $user
	 * @return SessionEntity
	 * @throws DBALException
	 * @throws SessionNotFoundException
	 */
	public function createForUser(UserEntity $user)
	{
		$token = uniqid();
		$params = array(
			'user_id' => $user->getId(),
			'token' => $token,
		);

		$query = "insert into session
                    (user_id, token)
                    VALUES 
                    (:user_id, :token)
                    ";
		$this->dbConn->executeQuery($query, $params);

		return $this->findByToken($token);
	}

	/**
	 * @param $row
	 * @return SessionEntity
	 */
	private static function entityFromRecord($row)
	{
		return new SessionEntity(
			$row['user_id'],
			$row['token']
		);
	}
}

?>