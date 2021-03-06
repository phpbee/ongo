<?php

namespace ongo\shared\entity;

use ongo\shared\model\I18nVersionModel;
use Doctrine\DBAL\Connection;
use ongo\shared\model\PhotographerModel;

final class PhotographerEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $photo;

    /**
     * PhotographerEntity constructor.
     * @param int $id
     * @param string $name
     * @param string $photo
     */
    public function __construct($id, $name, $photo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->photo = $photo;
    }


    /**
     * @param array $array
     * @param Connection $dbConn
     * @return PhotographerEntity
     * @throws \ongo\shared\exception\InvalidIdException
     */
    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new PhotographerModel($dbConn);
        return $model->findById($array["id"]);
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
            'name' => $this->name,
            'photo' => $this->photo,
        ];
    }
}
?>