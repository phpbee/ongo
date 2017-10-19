<?php

namespace ongo\api\controller;

use ongo\shared\entity\CityEntity;
use ongo\shared\entity\CountryEntity;
use ongo\shared\entity\GalleryEntity;
use ongo\shared\entity\PhotoEntity;
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


    public function get($id)
    {
        $model = new GalleryModel($this->dbConn);
        $gallery = $model->findById($id);
        $photographerModel = new PhotographerModel($this->dbConn);
        $photographer = $photographerModel->findById($gallery->getPhotographId());
        $placeModel = new PlaceModel($this->dbConn);
        $place = $placeModel->findById($gallery->getPlaceId());
        $cityModel = new CityModel($this->dbConn);
        $city = $cityModel->findById($place->getCityId());
        $countryModel = new CountryModel($this->dbConn);
        $country = $countryModel->findById($city->getCountryId());

        $data = $gallery->serialize($this->dbConn);
        $data['photographer'] = $photographer->serialize($this->dbConn);
        $data['place'] = $place->serialize($this->dbConn);
        $data['city'] = $city->serialize($this->dbConn);
        $data['country'] = $country->serialize($this->dbConn);

        return new JsonResponse($data);
    }


    public function byDayAndCountry(\DateTime $day, $country_id)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->byDayAndCountry($day, $country_id);

        return new JsonResponse($this->result($galleries));
    }
    public function byDay(\DateTime $day)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->byDay($day);

        return new JsonResponse($this->result($galleries));
    }

    public function byPhotograph($photograph_id)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->byPhotograph($photograph_id);

        return new JsonResponse($this->result($galleries));
    }


    public function byCountry($country_id)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->byCountry($country_id);

        return new JsonResponse($this->result($galleries));
    }

    public function byCity($id)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->byCity($id);

        return new JsonResponse($this->result($galleries));
    }

    public function byPlace($id)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->byPlace($id);

        return new JsonResponse($this->result($galleries));
    }

    /**
     * @param int $limit
     * @return JsonResponse
     * @throws \Exception
     */
    public function top($limit = 3)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->top($limit);

        return new JsonResponse($this->result($galleries));

    }

    /**
     * @param int $limit
     * @return JsonResponse
     * @throws \Exception
     */
    public function topLogos($limit = 5)
    {
        $model = new GalleryModel($this->dbConn);
        $galleries = $model->topLogos($limit);

        return new JsonResponse($this->result($galleries));
    }

    private function result($galleries)
    {

        $photographerModel = new PhotographerModel($this->dbConn);
        $placeModel = new PlaceModel($this->dbConn);
        $cityModel = new CityModel($this->dbConn);
        $countryModel = new CountryModel($this->dbConn);


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

        return $ret;
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
     * @param int $gallery_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function thumbnails($gallery_id)
    {
        $model = new PhotoModel($this->dbConn);
        $photos = $model->fromGalleryID($gallery_id);
        $thumbnails = array_map(function (PhotoEntity $p) {
            return ['id' => $p->getId(), 'gallery_id' => $p->getGalleryId(), 'thumb' => $p->getThumb()];
        }, $photos);
        return new JsonResponse($thumbnails);
    }

    /**
     * @param int $gallery_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function icons($gallery_id, $limit)
    {
        $model = new PhotoModel($this->dbConn);
        $photos = $model->fromGalleryID($gallery_id, $limit);
        $icons = array_map(function (PhotoEntity $p) {
            return ['id' => $p->getId(), 'gallery_id' => $p->getGalleryId(), 'ico' => $p->getIco()];
        }, $photos);
        return new JsonResponse($icons);
    }

}
