<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\PhotographerEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\exception\InvalidIdException;

final class PlaceModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }



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


    public function top($limit = 3)
    {
        $versions = array();
        $rs = $this->dbConn->executeQuery(
            "select id, name, city_id from place order by id LIMIT ?",
            [$limit], [\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $versions[] = self::entityFromRecord($row);
        }

        return $versions;
    }

    /**
     * @param $row
     * @return PhotographerEntity
     */
    private static function entityFromRecord($row)
    {
        return new PlaceEntity(
            $row['id'],
            $row['name'],
            $row['city_id']
        );
    }
}

?>