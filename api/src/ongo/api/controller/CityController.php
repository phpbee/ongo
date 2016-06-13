<?php

namespace ongo\api\controller;

use ongo\shared\entity\CityEntity;
use ongo\shared\entity\CountryEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\entity\SerializableEntity;
use Doctrine\DBAL\Connection;
use ongo\shared\model\CityModel;
use ongo\shared\model\CountryModel;
use ongo\shared\model\PlaceModel;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CityController
{
    /** @var Connection */
    private $dbConn;

    /**
     * TextController constructor.
     * @param Connection $dbConn
     */
    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    /**
     * @return JsonResponse
     */
    public function topItem()
    {
        $model = new CityModel($this->dbConn);

        $cities = $model->top(1);
        /** @var CountryEntity $city */
        $city = reset($cities);

        return new JsonResponse($city->serialize($this->dbConn));

    }
}

