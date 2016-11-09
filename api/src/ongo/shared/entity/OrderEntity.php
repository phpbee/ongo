<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;
use ongo\shared\model\PartnerModel;

final class OrderEntity extends SerializableEntity
{
    /** @var  string */
    private $id;
    /** @var  int */
    private $created;
    /** @var  string */
    private $user_id;
    /** @var  string */
    private $payload;
    /** @var  string */
    private $status;

    /**
     * OrderEntity constructor.
     * @param $id
     * @param $created
     * @param $user_id
     * @param $payload
     * @param $status
     */
    public function __construct($id, $created, $user_id, $payload, $status)
    {
        $this->id = $id;
        $this->created = strtotime($created);
        $this->user_id = $user_id;
        $this->payload = $payload;
        $this->status = $status;
    }


    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }



    public function serialize(Connection $dbConn, $deep = true)
    {
        $array = array(
            "id" => $this->id,
            "created" => $this->created,
            "user_id" => $this->user_id,
            "payload" => unserialize($this->payload),
            "status" => $this->status,
        );
        return $array;
    }
}	
	
