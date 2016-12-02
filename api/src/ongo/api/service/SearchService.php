<?php

namespace ongo\api\service;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\GalleryEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\exception\InvalidIdException;

final class SearchService
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    /**
     * @param $q
     * @param int $limit
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findPlacesAndPhotographersByName($q, $limit = 10)
    {
        $l="%$q%";

        $rs = $this->dbConn->executeQuery(

        "select
            'place' as class, place.id, concat(place.`name`,', ',city.`name`,', ',country.`name`) as `name`
            from place left join city on city.id = place.city_id left join country on country.id = city.country_id
              having `name` like ? LIMIT ?
         UNION
         select 'photograph' as class, id, `name`
            from photograph
              where `name` like ? LIMIT ?
         ",

            [
                $l, $limit,
                $l, $limit
            ],
            [
                \PDO::PARAM_STR, \PDO::PARAM_INT,
                \PDO::PARAM_STR, \PDO::PARAM_INT,
            ]
        );

        $results = array();

        while ($row = $rs->fetch()) {
            $results[] = $row;
        }

        return $results;
    }


}
