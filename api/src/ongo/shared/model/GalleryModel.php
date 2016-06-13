<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\GalleryEntity;
use ongo\shared\entity\PhotographerEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\exception\InvalidIdException;

final class GalleryModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    /**
     * @param $id
     * @return GalleryEntity
     * @throws InvalidIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, created, place_id, photograph_id from gallery where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }


    public function top($limit = 3)
    {
        $versions = array();
        $rs = $this->dbConn->executeQuery(
            "select id, created, place_id, photograph_id from gallery order by id desc LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $versions[] = self::entityFromRecord($row);
        }

        return $versions;
    }

    /**
     * @param $row
     * @return GalleryEntity
     */
    private static function entityFromRecord($row)
    {
        return new GalleryEntity(
            $row['id'],
            $row['created'],
            $row['place_id'],
            $row['photograph_id']
        );
    }
}

?>