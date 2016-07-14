<?php

namespace ongo\api\controller;

use ongo\shared\exception\UserNotFoundException;
use ongo\shared\model\SessionModel;
use ongo\shared\model\UserModel;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SessionController {
	private $memcache;
	private $dbConn;

	public function __construct(Connection $dbConn) {
		$this->dbConn = $dbConn;
	}

//	public function post($apiKey, $username, $password) {
//		$model = new SessionModel($this->memcache, $this->dbConn);
//		$session = $model->create($apiKey, $username, $password);
//		return new JsonResponse($session->serialize($this->dbConn));
//	}
//
//	public function put($token) {
//		$model = new SessionModel($this->memcache, $this->dbConn);
//		$session = $model->extend($token);
//		return new JsonResponse($session->serialize($this->dbConn));
//	}	
//
//	public function delete($token) {
//		$model = new SessionModel($this->memcache, $this->dbConn);
//		$model->delete($token);
//		return new Response("No content", 204);
//	}

	public function login($email) 
	{
		$model = new UserModel($this->dbConn);
		try {
			$user = $model->findByEmail($email);
		} catch (UserNotFoundException $e) {
            $user = $model->create($email);
        } 
        $sessionModel = new SessionModel($this->dbConn);
        $session=$sessionModel->createForUser($user);

        return new JsonResponse($session->serialize($this->dbConn));
        
	}
}

