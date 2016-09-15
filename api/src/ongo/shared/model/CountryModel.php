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
            "select id, name, logo, flag from country where id = ?",
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
            "select id, name, logo, flag from country order by id LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $countries[] = self::entityFromRecord($row);
        }

        return $countries;
    }

    /**
     * @param $id
     * @return array
     */
    public function getStats($id)
    {
        $galleries = $this->dbConn->executeQuery(
            "select count(*) as count from gallery where place_id in (select DISTINCT id from place where city_id in (select DISTINCT id from city where country_id = ?))",
            array($id))->fetch();

        $cities = $this->dbConn->executeQuery(
            "select count(*) as count from city where country_id = ?",
            array($id))->fetch();

        $places = $this->dbConn->executeQuery(
            "select count(*) as count from place where city_id  in ( select DISTINCT id from city where country_id = ?) ",
            array($id))->fetch();

        $photos = $this->dbConn->executeQuery(
            "select count(*) as count from photo where gallery_id in (select distinct id from gallery where place_id in (select DISTINCT id from place where city_id in (select DISTINCT id from city where country_id = ?)))",
            array($id))->fetch();

        $photographers = $this->dbConn->executeQuery(
            "select count(distinct photograph_id) as count from gallery where place_id in (select DISTINCT id from place where city_id in (select DISTINCT id from city where country_id = ?))",
            array($id))->fetch();

        return [
            'galleries' => $galleries['count'],
            'places' => $places['count'],
            'photos' => $photos['count'],
            'cities' => $cities['count'],
            'photographers' => $photographers['count'],
        ];
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
            isset($row['logo']) ? $row['logo'] : null,
            isset($row['flag']) ? $row['flag'] : null
        );
    }
}

