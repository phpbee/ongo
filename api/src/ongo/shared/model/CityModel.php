<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\CityEntity;
use ongo\shared\entity\PhotographerEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\exception\InvalidIdException;

final class CityModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    /**
     * @param $id int
     * @return CityEntity
     * @throws InvalidIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, name, country_id from city where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }

    /**
     * @param $places PlaceEntity[]
     * @return CityEntity[]
     */
    public function fromPlaces($places)
    {
        $ids = array_unique(array_map(function (PlaceEntity $p) {
            return $p->getCityId();
        }, $places));

        $cities = array();
        foreach ($ids as $id) {
            $cities[$id] = CityEntity::unserialize(['id' => $id], $this->dbConn);
        }

        return $cities;
    }

    /**
     * @param $row array
     * @return CityEntity
     */
    private static function entityFromRecord($row)
    {
        return new CityEntity(
            $row['id'],
            $row['name'],
            $row['country_id']
        );
    }
}

