<?php

namespace ongo\shared\entity;

use ongo\shared\model\CountryModel;
use Doctrine\DBAL\Connection;

final class CountryEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $logo;

    /**
     * CountryEntity constructor.
     * @param int $id
     * @param string $name
     * @param string $logo
     */
    public function __construct($id, $name, $logo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
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
            'logo' => $this->logo,
        ];
    }
}
?>