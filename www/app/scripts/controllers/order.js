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

        $scope.order = Order.get({id: $stateParams.id});

    });
