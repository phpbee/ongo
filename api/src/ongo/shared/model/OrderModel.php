<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\OrderEntity;
use ongo\shared\exception\OrderNotFoundException;

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

    public function createForUser($user_id, Array $payload)
    {
        $id = uniqid();
        $params = array(
            'id' => $id,
            'user_id' => $user_id,
            'payload' => serialize($payload),
        );

        $query = "insert into `order`
                    (id, user_id, payload)
                    VALUES 
                    (:id, :user_id, :payload)
                    ";
        $this->dbConn->executeQuery($query, $params);

        return $this->findById($id);

    }

    public function markAsPaid(OrderEntity $order)
    {
        $this->dbConn->executeQuery(
            "UPDATE `order` set status= ? where id  = ?",
            array('paid', $order->getId())
        );
    }

    public function setReturnUrl(OrderEntity $order, $return_url) {
        $order->setReturnUrl($return_url);

        $this->dbConn->executeQuery(
            "UPDATE `order` set payload = ? where id  = ?",
            array(serialize($order->getPayload()), $order->getId())
        );
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
            unserialize($row['payload']) ?: [],
            $row['status']
        );
    }
}

?>