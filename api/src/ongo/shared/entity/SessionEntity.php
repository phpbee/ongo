<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;
use ongo\shared\model\PartnerModel;
	
final class SessionEntity extends SerializableEntity {
	/** @var  string */
	private $user_id;
	/** @var  string */
	private $token;

	/**
	 * SessionEntity constructor.
	 * @param string $user_id
	 * @param string $token
	 */
	public function __construct($user_id, $token)
	{
		$this->user_id = $user_id;
		$this->token = $token;
	}


	public function getToken() {
		return $this->token;
	}
	
	
	public function serialize(Connection $dbConn, $deep = true) {
		$array = array(
			"user_id"   => $this->user_id,
			"token"   => $this->token,
		);
		return $array;
	}	
}	
	
