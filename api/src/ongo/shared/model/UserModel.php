<?php

namespace ongo\shared\model;

use Doctrine\DBAL\Connection;
use ongo\shared\entity\UserEntity;
use ongo\shared\exception\InvalidIdException;
use ongo\shared\exception\UserNotFoundException;

final class UserModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    /**
     * @param $id string
     * @return UserEntity
     * @throws InvalidIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, email from user where id = ?",
            array($id))->fetch())
        ) {
            throw new UserNotFoundException($id);
        }

        return self::entityFromRecord($row);
    }

    /**
     * @param string $email
     * @return UserEntity
     * @throws UserNotFoundException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByEmail($email)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select id, email from user where email = ?",[$email]
            )->fetch())
        ) {
            throw new UserNotFoundException($email);
        }

        return self::entityFromRecord($row);
    }

    /**
     * @param $email
     * @return UserEntity
     * @throws UserNotFoundException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create($email)
    {
        $id = uniqid();
        $params = array(
            'id' => $id,
            'email' => $email
        );

        $query = "insert into user
                    (id, email)
                    VALUES 
                    (:id, :email)
                    ";
            $this->dbConn->executeQuery($query, $params);

        return $this->findById($id);
    }


    /**
     * @param array $row
     * @return UserEntity
     */
    private static function entityFromRecord($row)
    {
        return new UserEntity(
            $row['id'],
            $row['email']
        );
    }
}

