<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;
use ongo\shared\model\PartnerModel;
	
final class OrderEntity extends SerializableEntity {
	/** @var  string */
	private $id;
	/** @var  int */
	private $created;
	/** @var  string */
	private $user_id;
	/** @var  string */
	private $payload;

	/**
	 * OrderEntity constructor.
	 * @param string $id
	 * @param int $created
	 * @param string $user_id
	 * @param string $payload
	 */
	public function __construct($id, $created, $user_id, $payload)
	{
		$this->id = $id;
		$this->created = strtotime($created);
		$this->user_id = $user_id;
		$this->payload = $payload;
	}


	public function getPayload() {
		return $this->payload;
	}
	
	
	public function serialize(Connection $dbConn, $deep = true) {
		$array = array(
			"id"   => $this->id,
			"created"   => $this->created,
			"user_id"   => $this->user_id,
			"payload"   => $this->payload,
		);
		return $array;
	}	
}	
	
