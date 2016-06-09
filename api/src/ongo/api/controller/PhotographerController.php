<?php

namespace ongo\api\controller;

use ongo\shared\entity\SerializableEntity;
use ongo\shared\model\I18nVersionModel;
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
}

?>