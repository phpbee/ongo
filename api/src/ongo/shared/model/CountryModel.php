<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\CityEntity;
use ongo\shared\entity\CountryEntity;
use ongo\shared\entity\PhotographerEntity;
use ongo\shared\exception\InvalidIdException;

final class CountryModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, name from country where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }


    /**
     * @param $cities CityEntity[]
     * @return CityEntity[]
     */
    public function fromCities($cities)
    {
        $ids = array_unique(array_map(function (CityEntity $c) {
            return $c->getCountryId();
        }, $cities));

        $countries = array();
        foreach ($ids as $id) {
            $countries[$id] = CountryEntity::unserialize(['id' => $id], $this->dbConn);
        }

        return $countries;
    }

    /**
     * @param int $limit
     * @return CountryEntity[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function top($limit = 3)
    {
        $countries = array();
        $rs = $this->dbConn->executeQuery(
            "select id, name, logo from country order by id LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $countries[] = self::entityFromRecord($row);
        }

        return $countries;
    }

    /**
     * @param $row
     * @return CountryEntity
     */
    private static function entityFromRecord($row)
    {
        return new CountryEntity(
            $row['id'],
            $row['name'],
            isset($row['logo']) ? $row['logo'] : null
        );
    }
}

