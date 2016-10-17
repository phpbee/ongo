<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\GalleryEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\exception\InvalidIdException;

final class PlaceModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }


    /**
     * @param $id
     * @return PlaceEntity
     * @throws InvalidIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select * from place where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }

    /**
     * @param $galleries
     * @return PlaceEntity[]
     * @throws \Exception
     */
    public function fromGalleries($galleries)
    {
        $ids = array_unique(array_map(function (GalleryEntity $g) {
            return $g->getPlaceId();
        }, $galleries));

        $places = array();
        foreach ($ids as $id) {
            $places[$id] = $this->findById($id);
        }

        return $places;
    }

    /**
     * @param int $limit
     * @return PlaceEntity[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function top($limit = 3)
    {
        $versions = array();
        $rs = $this->dbConn->executeQuery(
            "select * from place order by id LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $versions[] = self::entityFromRecord($row);
        }

        return $versions;
    }

    public function byCountryId($country_id)
    {
        $places = array();
        $rs = $this->dbConn->executeQuery(
            "select place.* from place WHERE city_id IN ( SELECT id from city WHERE country_id = ?) order by name",
            [$country_id], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $places[] = self::entityFromRecord($row);
        }

        return $places;
    }

    /**
     * @param $row
     * @return PlaceEntity
     */
    private static function entityFromRecord($row)
    {
        return new PlaceEntity(
            $row['id'],
            $row['name'],
            $row['city_id'],
            $row['logo'] ?: null
        );
    }
}

?>