<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;
use ongo\shared\model\PartnerModel;
	
final class OrderEntity extends SerializableEntity {
	/** @var  string */
	private $id;
	/** @var  string */
	private $user_id;
	/** @var  string */
	private $payload;

	/**
	 * OrderEntity constructor.
	 * @param sring $id
	 * @param string $user_id
	 * @param string $payload
	 */
	public function __construct($id, $user_id, $payload)
	{
		$this->id = $id;
		$this->user_id = $user_id;
		$this->payload = $payload;
	}


	public function getPayload() {
		return $this->payload;
	}
	
	
	public function serialize(Connection $dbConn, $deep = true) {
		$array = array(
			"id"   => $this->id,
			"user_id"   => $this->user_id,
			"payload"   => $this->payload,
		);
		return $array;
	}	
}	
	
