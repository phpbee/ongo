<?php

namespace ongo\shared\entity;

use ongo\shared\model\CountryModel;
use ongo\shared\model\I18nVersionModel;
use Doctrine\DBAL\Connection;

final class CountryEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $name;

    /**
     * PhotographerEntity constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param array $array
     * @param Connection $dbConn
     * @return CountryEntity
     * @throws \ongo\shared\exception\InvalidIdException
     * @throws \ongo\shared\exception\MissingKeyException
     */
    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new CountryModel($dbConn);
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
        ];
    }
}
?>