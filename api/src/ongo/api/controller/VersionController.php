<?php

namespace ongo\api\controller;

use ongo\shared\entity\SerializableEntity;
use ongo\shared\model\I18nVersionModel;
use ongo\shared\model\TextModel;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;

final class VersionController {
	/** @var Connection  */
	private $dbConn;

	/**
	 * TextController constructor.
	 * @param Connection $dbConn
	 */
	public function __construct(Connection $dbConn) {
		$this->dbConn = $dbConn;
	}

	/**
	 * @param $id int
	 * @return JsonResponse
	 */
	public function get($id) {
		$versionModel = new I18nVersionModel($this->dbConn);
		$version = $versionModel->findById($id);
		return new JsonResponse($version->serialize($this->dbConn));
	}

	/**
	 * @return JsonResponse
	 */
	public function query() {
		$versionModel = new I18nVersionModel($this->dbConn);
		$versions = $versionModel->query();
		return new JsonResponse(SerializableEntity::serializeArray($versions, $this->dbConn));

	}
}

?>