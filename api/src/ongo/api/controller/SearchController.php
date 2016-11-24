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
use ongo\api\service\SearchService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SearchController
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
     * @param $q
     * @param int $limit
     * @return JsonResponse
     * @throws \Exception
     */
    public function byPlaceOrPhotographer($q, $limit = 10)
    {
        $service = new SearchService($this->dbConn);
        $results = $service->findPlacesAndPhotographersByName($q, $limit);

        return new JsonResponse($results);

    }



}

