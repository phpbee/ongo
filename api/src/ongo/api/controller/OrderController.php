<?php

namespace ongo\api\controller;

use ongo\shared\entity\UserEntity;
use ongo\shared\model\OrderModel;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class OrderController {
	private $dbConn;

	public function __construct(Connection $dbConn) {
		$this->dbConn = $dbConn;
	}

	public function create(UserEntity $user, Array $order)
	{
		$model = new OrderModel($this->dbConn);

		$order = $model->createForUser($user->getId(), serialize($order));

        return new JsonResponse($order->serialize($this->dbConn));
        
	}
}

