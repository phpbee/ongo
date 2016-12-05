<?php

namespace ongo\api\controller;

use Monolog\Logger;
use ongo\shared\entity\OrderEntity;
use ongo\shared\entity\SerializableEntity;
use ongo\shared\entity\UserEntity;
use ongo\shared\exception\NoAccessException;
use ongo\shared\exception\SessionNotFoundException;
use ongo\shared\model\OrderModel;
use Doctrine\DBAL\Connection;
use ongo\shared\model\PhotoModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class OrderController
{
    private $dbConn;
    private $logger;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
        $this->model = new OrderModel($this->dbConn);
    }


    public function create(UserEntity $user, Array $order)
    {
        $model = new OrderModel($this->dbConn);

        $order = $model->createForUser($user->getId(), $order);

        return new JsonResponse($order->serialize($this->dbConn));

    }

    public function byUserId($id)
    {
        $model = new OrderModel($this->dbConn);
        $orders = $model->byUserId($id);

        $result = SerializableEntity::serializeArray($orders, $this->dbConn);
        array_walk($result, function (&$order) {
            $order['payment_status'] = $order['status'] == 'paid' ? 'payment_approved' : 'payment_failed';
        });
        return new JsonResponse($result);
    }

    public function byIdforUserId($id, $user_id)
    {
        $order = $this->getUserOrder($id, $user_id);

        return new JsonResponse($order->serialize($this->dbConn));
    }

    public function downloadByUser($id, $photo_id, $user_id)
    {
        $order = $this->getUserOrder($id, $user_id);
        if ($order->getStatus() != 'paid') {
            throw new NoAccessException('Order not paid');
        }
        $data = $order->serialize($this->dbConn);
        $items = $data['payload']['items'];
        if (!$items || !isset($items[$photo_id])) {
            throw new NoAccessException('Photo did not ordered');
        }
        $photoModel = new PhotoModel($this->dbConn);
        $photo = $photoModel->findById($photo_id);

        return new JsonResponse(['src' => $photo->getSrc()]);

    }

    public function startYandexOrder($id, $user_id, $token, $redirect_url, UrlGenerator $url_generator)
    {
        /** @var OrderEntity $order */
        $order = $this->getUserOrder($id, $user_id);
        $this->model->setReturnUrl($order, $redirect_url);

        if ($order->getStatus() == 'paid') {
            throw new NoAccessException('Order already paid');
        }
//
//		return $tpl->render('yandex_money.twig',
//            [
//                'order'=>$order,
//                'payload'=>$order->getPayload(),
//                'token'=>$token
//            ]);


        $request = [
            "receiver" => "41001222302728",
            "formcomment" => "Ongophotos.com",
            "short-dest" => "Ongophotos.com",
            "label" => $order->getId(),
            "quickpay-form" => "donate",
            "targets" => $order->getId(),
            "sum" => $order->getTotalAmount(),
            "successURL" => $url_generator->generate('home', [], UrlGeneratorInterface::ABSOLUTE_URL) . 'api' . $url_generator->generate('yandex_return', ['id' => $order->getId(), 'token' => $token]),
            "need-fio" => "false",
            "need-email" => "false",
            "need-phone" => "false",
            "need-address" => "false",
            "paymentType" => "AC",
        ];
        $url = 'https://money.yandex.ru/quickpay/confirm.xml?' . http_build_query($request);
        return new RedirectResponse($url);

    }

    public function returnYandexOrder($id, $user_id)
    {
        $order = $this->getUserOrder($id, $user_id);
        if ($order->getStatus() != 'paid') {
            $this->model->markAsPaid($order);
        }
        return new RedirectResponse($order->getReturnUrl());
    }

    public function payOrder(OrderEntity $order)
    {
        if ($order->getStatus() == 'paid') {
            throw new NoAccessException('Order already paid');
        }
        $this->model->markAsPaid($order);
        return new RedirectResponse($order->getReturnUrl());
    }

    /**
     * @param $id
     * @param $user_id
     * @return \ongo\shared\entity\OrderEntity
     * @throws NoAccessException
     * @throws \ongo\shared\exception\OrderNotFoundException
     */
    private function getUserOrder($id, $user_id)
    {
        $order = $this->model->findById($id);

        if ($order->getUserId() !== $user_id) {
            throw new NoAccessException();
        }
        return $order;
    }
}

