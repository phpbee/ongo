'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:UserordersCtrl
 * @description
 * # UserordersCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('UserOrdersCtrl', function ($scope, User) {
      $scope.orders = User.orders();
  });
