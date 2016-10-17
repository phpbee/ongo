<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\GalleryEntity;
use ongo\shared\entity\PhotographerEntity;
use ongo\shared\exception\InvalidIdException;

final class PhotographerModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }


    /**
     * @param $id
     * @return PhotographerEntity
     * @throws InvalidIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select * from photograph where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }

    /**
     * @param int $limit
     * @return array PhotographerEntity
     * @throws \Doctrine\DBAL\DBALException
     */
    public function top($limit = 3)
    {
        $photographers = array();
        $rs = $this->dbConn->executeQuery(
            "select * from photograph order by id LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $photographers[] = self::entityFromRecord($row);
        }

        return $photographers;
    }

    public function byCountryId($country_id)
    {
        $photographers = array();
        $rs = $this->dbConn->executeQuery(
            "select * from photograph
              WHERE ID IN (
               SELECT DISTINCT photograph_id from gallery WHERE place_id IN (
                SELECT DISTINCT id from place WHERE city_id IN (
                  SELECT DISTINCT id from city WHERE country_id = ?
                )
              )
            ) order by name ",
            [$country_id], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $photographers[] = self::entityFromRecord($row);
        }

        return $photographers;
    }

    /**
     * @param $galleries
     * @return PhotographerEntity[]
     */
    public function fromGalleries($galleries)
    {
        $ids = array_unique(array_map(function (GalleryEntity $g) {
            return $g->getPhotographId();
        }, $galleries));

        $photographers = array();
        foreach ($ids as $id) {
            $photographers[$id] = PhotographerEntity::unserialize(['id' => $id], $this->dbConn);
        }

        return $photographers;
    }

    public function getStats($id) 
    {
        $galleries = $this->dbConn->executeQuery(
            "select count(*) as count from gallery where photograph_id = ?",
            array($id))->fetch();

        $places = $this->dbConn->executeQuery(
            "select count(distinct place_id) as count from gallery where photograph_id = ?",
            array($id))->fetch();

        $photos = $this->dbConn->executeQuery(
            "select count(*) as count from photo where gallery_id in (select distinct id from gallery where photograph_id = ?)",
            array($id))->fetch();

        return [
            'galleries' => $galleries['count'],
            'places' => $places['count'],
            'photos' => $photos['count'],
            'views' => $photos['count'],
            ];
    }
    
    /**
     * @param $row
     * @return PhotographerEntity
     */
    private static function entityFromRecord($row)
    {
        return new PhotographerEntity(
            $row['id'],
            $row['name'],
            $row['photo'] ?: null
        );
    }
}

?>