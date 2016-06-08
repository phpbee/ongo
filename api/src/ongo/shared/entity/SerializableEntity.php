<?php

namespace ongo\shared\entity;

use ongo\shared\exception\MissingKeyException;
use Doctrine\DBAL\Connection;

abstract class SerializableEntity {
	public static function serializeArray(array $entities, Connection $dbConn, $deep = true) {
		$array = array();
		foreach ($entities as $entity) {
			if (!($entity instanceof SerializableEntity))
				throw new \Exception("Trying to serialize a wrong kind of object");
			$array[] = $entity->serialize($dbConn, $deep);
		}
		return $array;
	}

	protected static function validate(array $array, array $reqs) {
		foreach ($reqs as $key => $val) {
			$c = (is_numeric($key)) ? $val : $key;
			if (!isset($array[$c]))
				throw new MissingKeyException($c);
			if (is_array($val)) {
				self::validate($array[$c], $val);	
			}
		}
		return true;
	}

	public static function unserialize(array $array, Connection $dbConn) {
		throw new \Exception("Late static binding required");
	}

	/**
	 * @param Connection $dbConn
	 * @param bool $deep
	 * @return string
	 */
	public abstract function serialize(Connection $dbConn, $deep = true);	
}

?>