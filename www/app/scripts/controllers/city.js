'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CityCtrl
 * @description
 * # CityCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('CityCtrl', function ($scope, $stateParams, City) {

      $scope.city = City.get({id: $stateParams.id});
      $scope.galleries = City.galleries({id: $stateParams.id});

  });
