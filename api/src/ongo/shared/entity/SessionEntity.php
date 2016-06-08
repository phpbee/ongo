<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;
use ongo\shared\model\PartnerModel;
	
final class SessionEntity extends SerializableEntity {
	private $token;
	private $partnerId;
	private $partner;
	private $created;
	private $expires;
	
	public function __construct($token, $partnerId, $created, $expires = null) {
		$this->token = $token;
		$this->partnerId = $partnerId;
		$this->created = $created;
		$this->expires = $expires;
	}
	
	public function getToken() {
		return $this->token;
	}
	
	public function getPartner(Connection $dbConn) {
		if ($this->partner === null) {
			$model = new PartnerModel($dbConn);
			$this->partner = $model->findById($this->partnerId);
		}
		return $this->partner;
	}

	public function hasExpired() {
		if ($this->expires != null && $this->expires < time());
	}

	public function setExpires($expires) {
		$this->expires = $expires;
	}
	
	public function serialize(Connection $dbConn, $deep = true) {
		$array = array(
			"token"   => $this->token,
			"expires" => date("c", $this->expires)
		);
		if ($deep)
			$array["partner"] = $this->getPartner($dbConn)->serialize($dbConn, false);
		return $array;
	}	
}	
	
?>