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
    public function __construct($id, $created, $user_id, Array $payload, $status)
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

    protected function addPayload($key,$value)
    {
        $this->payload[$key]=$value;
    }

    public function setReturnUrl($return_url)
    {
        $this->addPayload('return_url',$return_url);
    }

    public function getTotalAmount()
    {
        if (!isset($this->payload['total'])) {
           throw new  \OutOfBoundsException('Can not get total amount for order');
        }
        return $this->payload['total'];
    }
    public function getReturnUrl()
    {
        if (!isset($this->payload['return_url'])) {
           throw new  \OutOfBoundsException('Can not get return url for order');
        }
        return $this->payload['return_url'];
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
            "payload" => $this->payload,
            "status" => $this->status,
        );
        return $array;
    }
}	
	
