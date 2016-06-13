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
            "select id, name, city_id from place where id = ?",
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
            "select id, name, city_id, logo from place order by id LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $versions[] = self::entityFromRecord($row);
        }

        return $versions;
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
            isset($row['logo']) ? $row['logo'] : null
        );
    }
}

?>