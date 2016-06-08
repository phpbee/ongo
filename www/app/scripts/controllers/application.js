'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('ApplicationCtrl', function ($scope) {
    $scope.$on('$viewContentLoaded', function () {
      scopeUpdated($scope);
    });
  });
