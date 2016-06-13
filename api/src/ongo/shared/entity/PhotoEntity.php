<?php

namespace ongo\shared\entity;

use Doctrine\DBAL\Connection;
use ongo\shared\model\PhotoModel;

final class PhotoEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  int */
    private $gallery_id;
    /** @var  string */
    private $src;

    /**
     * PhotoEntity constructor.
     * @param int $id
     * @param int $gallery_id
     * @param string $src
     */
    public function __construct($id, $gallery_id, $src)
    {
        $this->id = $id;
        $this->gallery_id = $gallery_id;
        $this->src = $src;
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
            'gallery_id' => $this->gallery_id,
            'src' => $this->src,
        ];
    }

    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new PhotoModel($dbConn);
        return $model->findById($array["id"]);
    }
}
