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
            "select * from gallery where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }


    public function byPhotograph($photograph_id)
    {
        $galleries = array();
        $rs = $this->dbConn->executeQuery(
            "select * from gallery where photograph_id = ? order by id desc",
            array($photograph_id)
        );

        while ($row = $rs->fetch()) {
            $galleries[] = self::entityFromRecord($row);
        }

        return $galleries;
    }

    public function byCountry($country_id)
    {
        $galleries = array();
        $rs = $this->dbConn->executeQuery(
            "select * from gallery where place_id in 
                ( select DISTINCT id from place where city_id in ( SELECT DISTINCT id from city where country_id = ?)) 
              order by id desc",
            array($country_id)
        );

        while ($row = $rs->fetch()) {
            $galleries[] = self::entityFromRecord($row);
        }

        return $galleries;
    }
    
    public function byCity($id)
    {
        $galleries = array();
        $rs = $this->dbConn->executeQuery(
            "select * from gallery where place_id in 
                ( select DISTINCT id from place where city_id = ?)
              order by id desc",
            array($id)
        );

        while ($row = $rs->fetch()) {
            $galleries[] = self::entityFromRecord($row);
        }

        return $galleries;
    }

    public function byPlace($id)
    {
        $galleries = array();
        $rs = $this->dbConn->executeQuery(
            "select * from gallery where place_id = ?
              order by id desc",
            array($id)
        );

        while ($row = $rs->fetch()) {
            $galleries[] = self::entityFromRecord($row);
        }

        return $galleries;
    }

    public function top($limit = 3)
    {
        $galleries = array();
        $rs = $this->dbConn->executeQuery(
            "select * from gallery order by id desc LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $galleries[] = self::entityFromRecord($row);
        }

        return $galleries;
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