<?php

namespace ongo\api\controller;

use ongo\shared\entity\SerializableEntity;
use ongo\shared\model\PhotographerModel;
use ongo\shared\model\TextModel;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PhotographerController
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
        $model = new PhotographerModel($this->dbConn);
        $items = $model->top($limit);
        return new JsonResponse(SerializableEntity::serializeArray($items, $this->dbConn));

    }

    /**
     * @param $country_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function byCountryId($country_id)
    {
        $model = new PhotographerModel($this->dbConn);
        $places = $model->byCountryId($country_id);
        return new JsonResponse(SerializableEntity::serializeArray($places, $this->dbConn));
    }

    /**
     * @param $city_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function byCityId($city_id)
    {
        $model = new PhotographerModel($this->dbConn);
        $places = $model->byCityId($city_id);
        return new JsonResponse(SerializableEntity::serializeArray($places, $this->dbConn));
    }

    public function byPlaceId($place_id)
    {
        $model = new PhotographerModel($this->dbConn);
        $places = $model->byPlaceId($place_id);
        return new JsonResponse(SerializableEntity::serializeArray($places, $this->dbConn));
    }

    public function get($id)
    {
        $photographerModel = new PhotographerModel($this->dbConn);
        $photographer = $photographerModel->findById($id);


        $data = $photographer->serialize($this->dbConn);

        $data['stats'] = $photographerModel->getStats($id);

        return new JsonResponse($data);
    }
}

