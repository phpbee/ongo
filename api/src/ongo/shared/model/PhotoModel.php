<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\PhotoEntity;
use ongo\shared\exception\InvalidIdException;

final class PhotoModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }


    /**
     * @param $id
     * @return PhotoEntity
     * @throws InvalidIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, src, thumb, gallery_id from photo where id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidIdException($id);
        }

        return self::entityFromRecord($row);
    }



    public function fromGalleryID($id, $limit = 100)
    {
        $photos = array();
        $rs = $this->dbConn->executeQuery(
            "select id, gallery_id, src, thumb from photo where gallery_id = :id order by id LIMIT :limit",
            ['id' => $id, 'limit' => $limit],
            ['limit'=>\PDO::PARAM_INT]
        );

        while ($row = $rs->fetch()) {
            $photos[] = self::entityFromRecord($row);
        }

        return $photos;
    }

    /**
     * @param $row
     * @return PhotoEntity
     */
    private static function entityFromRecord($row)
    {
        return new PhotoEntity(
            intval($row['id']),
            intval($row['gallery_id']),
            $row['src'],
            $row['thumb']
        );
    }
}

?>