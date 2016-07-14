<?php

namespace ongo\shared\entity;

use ongo\shared\model\UserModel;
use Doctrine\DBAL\Connection;

final class UserEntity extends SerializableEntity
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $email;

    /**
     * UserEntity constructor.
     * @param string $id
     * @param string $email
     */
    public function __construct($id, $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $array
     * @param Connection $dbConn
     * @return CityEntity
     * @throws \ongo\shared\exception\InvalidIdException
     */
    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new UserModel($dbConn);
        return $model->findById($array["id"]);
    }

    /**
     * @param Connection $dbConn
     * @param bool $deep
     * @return array
     */
    public function serialize(Connection $dbConn, $deep = true)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }
}

?>