<?php

namespace ongo\api;


use ongo\api\controller\BannerController;
use ongo\api\controller\CityController;
use ongo\api\controller\CountryController;
use ongo\api\controller\DeeplinkController;
use ongo\api\controller\EmailController;
use ongo\api\controller\GalleryController;
use ongo\api\controller\OrderController;
use ongo\api\controller\PartnerController;
use ongo\api\controller\PartnerDeepLinkController;
use ongo\api\controller\PartnerPaymentInfoController;
use ongo\api\controller\PartnerPaymentsController;
use ongo\api\controller\PhotographerController;
use ongo\api\controller\PlaceController;
use ongo\api\controller\SessionController;
use ongo\api\controller\PartnerConversionController;
use ongo\api\controller\PartnerSummaryController;
use ongo\api\controller\PartnerUserController;
use ongo\api\controller\TextController;
use ongo\api\controller\VersionController;
use ongo\api\exception\AccessDelegationNotSupportedException;
use ongo\api\exception\InvalidDateException;
use ongo\shared\entity\PartnerEntity;
use ongo\shared\entity\UserEntity;
use ongo\shared\exception\InvalidApiKeyException;
use ongo\shared\exception\InvalidApiUserIdException;
use ongo\shared\exception\InvalidApiUserPasswordException;
use ongo\shared\exception\InvalidValueException;
use ongo\shared\exception\InvalidAuthenticationServiceVersionException;
use ongo\shared\exception\InvalidPartnerIdException;
use ongo\shared\exception\NotUniqueValueException;
use ongo\shared\exception\InvalidPartnerNameException;
use ongo\shared\exception\PartnerNameNotUniqueException;
use ongo\shared\exception\InvalidPartnerPaymentIdException;
use ongo\shared\exception\InvalidPasswordException;
use ongo\shared\exception\InvalidTokenException;
use ongo\shared\exception\InvalidUsernameException;
use ongo\shared\exception\MissingAuthenticationServiceVersionException;
use ongo\shared\exception\MissingKeyException;
use ongo\shared\exception\MissingTokenException;
use ongo\shared\exception\PartnerUsernameNotUniqueException;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


final class ControllerProvider implements ControllerProviderInterface
{
    const MAX_LIMIT = 1000;

    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];
        $controllers->get("/", function (Application $app, Request $request) {
            return new Response("OK", 200);
        });
//        $controllers->get("/versions", function (Application $app) {
//            $controller = new VersionController($app["db"]);
//            return $controller->query();
//        });
//        $controllers->get("/versions/{id}", function (Application $app, $id) {
//            /** @var PartnerEntity $partner */
//            $partner = $app["auth"]->getPartner();
//
//            if ($partner->getI18nVersionId() != $id) {
//                throw new AccessDelegationNotSupportedException();
//            }
//            $controller = new VersionController($app["db"]);
//            return $controller->get($id);
//        });
//        $controllers->post("/sessions", function (Application $app, Request $request) {
//            $controller = new SessionController($app["cache"], $app["db"]);
//            return $controller->post($request->get("apikey"), $request->get("username"), $request->get("password"));
//        });
//        $controllers->get("/sessions/{token}", function (Application $app, Request $request, $token) {
//            $session = $app["auth"]->getSession();
//            if ($session->getToken() != $token)
//                throw new AccessDelegationNotSupportedException();
//            return new JsonResponse($session->serialize($app["db"]));
//        });
//        $controllers->put("/sessions/{token}", function (Application $app, Request $request, $token) {
//            $session = $app["auth"]->getSession();
//            if ($session->getToken() != $token)
//                throw new AccessDelegationNotSupportedException();
//            $controller = new SessionController($app["cache"], $app["db"]);
//            return $controller->put($token);
//        });
//        $controllers->delete("/sessions/{token}", function (Application $app, Request $request, $token) {
//            $session = $app["auth"]->getSession();
//            if ($session->getToken() != $token)
//                throw new AccessDelegationNotSupportedException();
//            $controller = new SessionController($app["cache"], $app["db"]);
//            return $controller->delete($token);
//        });


        $controllers->get("/user/orders", function (Application $app) {
            /** @var UserEntity $user */
            $user = $app["auth"]->getUser();
            $controller = new OrderController($app["db"]);
            return $controller->byUserId($user->getId());
        });
        $controllers->get("/order/{id}", function (Application $app, $id) {
            /** @var UserEntity $user */
            $user = $app["auth"]->getUser();
            $controller = new OrderController($app["db"]);
            return $controller->byIdforUserId($id, $user->getId());
        });
        $controllers->get("/order/{id}/download/{photo_id}", function (Application $app, $id, $photo_id) {
            /** @var UserEntity $user */
            $user = $app["auth"]->getUser();
            $controller = new OrderController($app["db"]);
            return $controller->downloadByUser($id, $photo_id, $user->getId());
        });
        $controllers->post("/order", function (Application $app, Request $request) {
            $user = $app["auth"]->getUser();
            $controller = new OrderController($app["db"]);
            return $controller->create($user, $request->get("cart"));
        });
        $controllers->post("/sessions", function (Application $app, Request $request) {
            $controller = new SessionController($app["db"]);
            return $controller->login($request->get("email"));
        });
        $controllers->get("/photographers", function (Application $app, Request $request) {
            $controller = new PhotographerController($app["db"]);
            if ($request->get('country')) {
                return $controller->byCountryID(intval($request->get('country')));
            }
            if ($request->get('city')) {
                return $controller->byCityId(intval($request->get('city')));
            }
            if ($request->get('place')) {
                return $controller->byPlaceId(intval($request->get('place')));
            }
            return $controller->top(min(self::MAX_LIMIT, intval($request->get("limit", self::MAX_LIMIT))));
        });
        $controllers->get("/photograph/{id}", function (Application $app, $id) {
            $controller = new PhotographerController($app["db"]);
            return $controller->get(intval($id));
        });
        $controllers->get("/photograph/{id}/galleries", function (Application $app, $id) {
            $controller = new GalleryController($app["db"]);
            return $controller->byPhotograph(intval($id));
        });
        $controllers->get("/country/{id}", function (Application $app, $id) {
            $controller = new CountryController($app["db"]);
            return $controller->get(intval($id));
        });
        $controllers->get("/country/{id}/galleries", function (Application $app, $id) {
            $controller = new GalleryController($app["db"]);
            return $controller->byCountry(intval($id));
        });
        $controllers->get("/cities", function (Application $app, Request $request) {
            $controller = new CityController($app["db"]);
            if ($request->get('country')) {
                return $controller->byCountryID(intval($request->get('country')));
            }
            return $controller->top(min(self::MAX_LIMIT, intval($request->get("limit", self::MAX_LIMIT))));
        });
        $controllers->get("/countries", function (Application $app, Request $request) {
            $controller = new CountryController($app["db"]);
            return $controller->top(min(self::MAX_LIMIT, intval($request->get("limit", self::MAX_LIMIT))));
        });
        $controllers->get("/city/{id}", function (Application $app, $id) {
            $controller = new CityController($app["db"]);
            return $controller->get(intval($id));
        });
        $controllers->get("/city/{id}/galleries", function (Application $app, $id) {
            $controller = new GalleryController($app["db"]);
            return $controller->byCity(intval($id));
        });
        $controllers->get("/place/{id}", function (Application $app, $id) {
            $controller = new PlaceController($app["db"]);
            return $controller->get(intval($id));
        });
        $controllers->get("/places", function (Application $app, Request $request) {
            $controller = new PlaceController($app["db"]);
            if ($request->get('country')) {
                return $controller->byCountryID(intval($request->get('country')));
            }
            if ($request->get('city')) {
                return $controller->byCityID(intval($request->get('city')));
            }
            if ($request->get('photographer')) {
                return $controller->byPhotographID(intval($request->get('photographer')));
            }
            return $controller->top(min(self::MAX_LIMIT, intval($request->get("limit", self::MAX_LIMIT))));

        });
        $controllers->get("/galleries", function (Application $app, Request $request) {
            $controller = new GalleryController($app["db"]);
            if ($request->get('country')) {
                return $controller->byCountry(intval($request->get('country')));
            }
            if ($request->get('city')) {
                return $controller->byCity(intval($request->get('city')));
            }
            if ($request->get('place')) {
                return $controller->byPlace(intval($request->get('place')));
            }
            if ($request->get('photographer')) {
                return $controller->byPhotograph(intval($request->get('photographer')));
            }
            if ($request->get('day')) {
                return $controller->byDay(new \DateTime($request->get('day')));
            }
            return $controller->top(min(self::MAX_LIMIT, intval($request->get("limit", self::MAX_LIMIT))));
        });
        $controllers->get("/gallery/{id}", function (Application $app, $id) {
            $controller = new GalleryController($app["db"]);
            return $controller->get(intval($id));
        });
        $controllers->get("/gallery/{id}/photos", function (Application $app, $id) {
            $controller = new GalleryController($app["db"]);
            return $controller->photos(intval($id));
        });
        $controllers->get("/gallery/{id}/thumbnails", function (Application $app, $id) {
            $controller = new GalleryController($app["db"]);
            return $controller->thumbnails(intval($id));
        });
        $controllers->get("/gallery/{id}/icons", function (Application $app, $id, Request $request) {
            $controller = new GalleryController($app["db"]);
            return $controller->icons(intval($id), $request->get("limit") ? intval($request->get("limit")) : null );
        });
        $controllers->get("/gallery/{id}/photo/{photo_id}", function (Application $app, $id, $photo_id) {
            $controller = new GalleryController($app["db"]);
            return $controller->photo(intval($photo_id), intval($id));
        });
        $controllers->get("/top/country", function (Application $app) {
            $controller = new CountryController($app["db"]);
            return $controller->topItem();
        });
        $controllers->get("/top/city", function (Application $app) {
            $controller = new CityController($app["db"]);
            return $controller->topItem();
        });
        $controllers->get("/top/place", function (Application $app) {
            $controller = new PlaceController($app["db"]);
            return $controller->topItem();
        });
        $controllers->get("/top/gallery", function (Application $app, Request $request) {
            $controller = new GalleryController($app["db"]);
            return $controller->topLogos(intval($request->get("limit")));
        });
        $app->error(function (NotUniqueValueException $e) {
            return new Response("Not unique value", 409);
        });
        $app->error(function (InvalidValueException $e) {
            return new Response("Invalid value", 400);
        });

        return $controllers;
    }
}

?>
