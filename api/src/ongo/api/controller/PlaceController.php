<?php

namespace ongo\api\controller;

use ongo\shared\entity\CityEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\entity\SerializableEntity;
use Doctrine\DBAL\Connection;
use ongo\shared\model\CityModel;
use ongo\shared\model\CountryModel;
use ongo\shared\model\PlaceModel;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PlaceController
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
     * @param int $limit
     * @return JsonResponse
     * @throws \Exception
     */
    public function top($limit = 3)
    {
        $model = new PlaceModel($this->dbConn);
        $cityModel = new CityModel($this->dbConn);
        $countryModel = new CountryModel($this->dbConn);


        $places = $model->top($limit);
        $cities = $cityModel->fromPlaces($places);
        $countries = $countryModel->fromCities($cities);

        $ret = array_map(function (PlaceEntity $place) use ($cities, $countries) {
            /** @var CityEntity $city */
            $city = $cities[$place->getCityId()];
            $country = $countries[$city->getCountryId()];
            $placeData = $place->serialize($this->dbConn);
            $placeData['city'] = $city->serialize($this->dbConn);
            $placeData['city']['country'] = $country->serialize($this->dbConn);
            return $placeData;
        }, $places);

        return new JsonResponse($ret);

    }
}

