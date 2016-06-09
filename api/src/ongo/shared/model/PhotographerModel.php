<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
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
            "select id, name from photograp where id = ?",
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
        $versions = array();
        $rs = $this->dbConn->executeQuery(
            "select id, name from photograph order by id LIMIT ?",
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
        return new PhotographerEntity(
            $row['id'],
            $row['name']
        );
    }
}

?>