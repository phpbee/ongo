'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PhotoCtrl
 * @description
 * # PhotoCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('OrderCtrl', function ($scope, $stateParams, Order) {

        Order.get({id: $stateParams.id}, function (order) {
            $scope.order = order;
            $scope.payload = order.payload
        });

        $scope.download = function (order_id, id) {
            Order.download({id: order_id, photo_id: id}, function (data) {
                window.location.href=data.src;
            });
        }

    });
