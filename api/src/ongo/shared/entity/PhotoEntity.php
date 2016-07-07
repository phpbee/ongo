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
    /** @var  string */
    private $thumb;
    /** @var  string */
    private $ico;

    /**
     * PhotoEntity constructor.
     * @param int $id
     * @param int $gallery_id
     * @param string $src
     * @param string $thumb
     */
    public function __construct($id, $gallery_id, $src, $thumb, $ico)
    {
        $this->id = $id;
        $this->gallery_id = $gallery_id;
        $this->src = $src;
        $this->thumb = $thumb;
        $this->ico = $ico;
    }

    /**
     * @return int
     */
    public function getGalleryId()
    {
        return $this->gallery_id;
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
            'thumb' => $this->thumb,
            'ico' => $this->ico,
        ];
    }

    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new PhotoModel($dbConn);
        return $model->findById($array["id"]);
    }


}
