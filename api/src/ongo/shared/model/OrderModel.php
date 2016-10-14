<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ongo\shared\entity\OrderEntity;
use ongo\shared\entity\SessionEntity;
use ongo\shared\entity\UserEntity;
use ongo\shared\exception\OrderNotFoundException;
use ongo\shared\exception\SessionNotFoundException;

final class OrderModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    /**
     * @param $id
     * @return OrderEntity
     * @throws OrderNotFoundException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, created, user_id, payload, status from `order` where id = ?", [$id]
        )->fetch())
        ) {
            throw new OrderNotFoundException($id);
        }

        return self::entityFromRecord($row);
    }


    public function byUserId($user_id)
    {
        $orders = array();
        $rs = $this->dbConn->executeQuery(
            "select id, created, user_id, payload, status from `order` where user_id  = ? order by created desc",
            array($user_id)
        );

        while ($row = $rs->fetch()) {
            array_push($orders, self::entityFromRecord($row));
        }

        return $orders;
    }

    public function createForUser($user_id, $payload)
    {
        $id = uniqid();
        $params = array(
            'id' => $id,
            'user_id' => $user_id,
            'payload' => $payload,
        );

        $query = "insert into `order`
                    (id, user_id, payload)
                    VALUES 
                    (:id, :user_id, :payload)
                    ";
        $this->dbConn->executeQuery($query, $params);

        return $this->findById($id);

    }

    /**
     * @param $row
     * @return OrderEntity
     */
    private static function entityFromRecord($row)
    {
        return new OrderEntity(
            $row['id'],
            $row['created'],
            $row['user_id'],
            $row['payload'],
            $row['status']
        );
    }
}

?>