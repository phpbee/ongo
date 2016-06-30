<?php

namespace ongo\api\controller;

use ongo\shared\entity\CityEntity;
use ongo\shared\entity\CountryEntity;
use ongo\shared\entity\GalleryEntity;
use ongo\shared\entity\PhotographerEntity;
use ongo\shared\entity\PlaceEntity;
use ongo\shared\entity\SerializableEntity;
use Doctrine\DBAL\Connection;
use ongo\shared\exception\InvalidIdException;
use ongo\shared\model\CityModel;
use ongo\shared\model\CountryModel;
use ongo\shared\model\GalleryModel;
use ongo\shared\model\PhotographerModel;
use ongo\shared\model\PhotoModel;
use ongo\shared\model\PlaceModel;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GalleryController
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
        $model = new GalleryModel($this->dbConn);
        $photographerModel = new PhotographerModel($this->dbConn);
        $placeModel = new PlaceModel($this->dbConn);
        $cityModel = new CityModel($this->dbConn);
        $countryModel = new CountryModel($this->dbConn);

        $galleries = $model->top($limit);

        $photographers = $photographerModel->fromGalleries($galleries);
        $places = $placeModel->fromGalleries($galleries);
        $cities = $cityModel->fromPlaces($places);
        $countries = $countryModel->fromCities($cities);

        $ret = array_map(function (GalleryEntity $gallery) use ($photographers, $places, $cities, $countries) {
            /** @var PhotographerEntity $photographer */
            $photographer = $photographers[$gallery->getPhotographId()];
            /** @var PlaceEntity $place */
            $place = $places[$gallery->getPlaceId()];
            /** @var CityEntity $city */
            $city = $cities[$place->getCityId()];
            /** @var CountryEntity $country */
            $country = $countries[$city->getCountryId()];
            $data = $gallery->serialize($this->dbConn);
            $data['photographer'] = $photographer->serialize($this->dbConn);
            $data['place'] = $place->serialize($this->dbConn);
            $data['city'] = $city->serialize($this->dbConn);
            $data['country'] = $country->serialize($this->dbConn);
            return $data;
        }, $galleries);

        return new JsonResponse($ret);

    }

    public function photo($id, $gallery_id)
    {
        $model = new PhotoModel($this->dbConn);
        $photo = $model->findById($id);
        if ($photo->getGalleryId() !== $gallery_id) {
            throw new InvalidIdException($id);
        }
        return new JsonResponse($photo->serialize($this->dbConn));
    }

    /**
     * @param int $gallery_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function photos($gallery_id)
    {
        $model = new PhotoModel($this->dbConn);
        $photos = $model->fromGalleryID($gallery_id);
        return new JsonResponse(SerializableEntity::serializeArray($photos, $this->dbConn));
    }

    /**
     * @param int $limit
     * @return JsonResponse
     * @throws \Exception
     */
    public function topItem($limit = 5)
    {
        $model = new GalleryModel($this->dbConn);
        $photoModel = new PhotoModel($this->dbConn);

        $galleries = $model->top(1);
        /** @var GalleryEntity $gallery */
        $gallery = reset($galleries);
        $ret = $gallery->serialize($this->dbConn);
        $ret['photos'] = SerializableEntity::serializeArray(
            $photoModel->fromGalleryID($gallery->getId(), $limit),
            $this->dbConn
        );

        return new JsonResponse($ret);

    }
}

