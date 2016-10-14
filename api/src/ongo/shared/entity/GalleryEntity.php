<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;

final class GalleryEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  int */
    private $created;
    /** @var  int */
    private $place_id;
    /** @var  int */
    private $photograph_id;
    /** @var  string */
    private $logo;

    /**
     * GalleryEntity constructor.
     * @param int $id
     * @param int $created
     * @param int $place_id
     * @param int $photograph_id
     * @param string $logo
     */
    public function __construct($id, $created, $place_id, $photograph_id, $logo)
    {
        $this->id = $id;
        $this->created = $created;
        $this->place_id = $place_id;
        $this->photograph_id = $photograph_id;
        $this->logo = $logo;
    }


    /**
     * @return int
     */
    public function getPlaceId()
    {
        return $this->place_id;
    }

    /**
     * @return int
     */
    public function getPhotographId()
    {
        return $this->photograph_id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param Connection $dbConn
     * @param bool $deep
     * @return array
     */
    public function serialize(Connection $dbConn, $deep = true)
    {
        return [
            'id' => $this->id,
            'created' => $this->created,
            'place_id' => $this->place_id,
            'photograph_id' => $this->photograph_id,
            'logo' => $this->logo,
        ];
    }
}
