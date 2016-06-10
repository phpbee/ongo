<?php

namespace ongo\shared\entity;

use ongo\shared\model\CityModel;
use ongo\shared\model\I18nVersionModel;
use Doctrine\DBAL\Connection;

final class CityEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $name;
    /** @var  int */
    private $country_id;

    /**
     * CityEntity constructor.
     * @param int $id
     * @param string $name
     * @param int $country_id
     */
    public function __construct($id, $name, $country_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->country_id = $country_id;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @param array $array
     * @param Connection $dbConn
     * @return CityEntity
     * @throws \ongo\shared\exception\InvalidIdException
     * @throws \ongo\shared\exception\MissingKeyException
     */
    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new CityModel($dbConn);
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
            'country_id' => $this->country_id,
        ];
    }
}
?>