'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CityCtrl
 * @description
 * # CityCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('CityCtrl', function ($scope, $stateParams, City, Gallery) {

      $scope.city = City.get({id: $stateParams.id});
      $scope.galleries = City.galleries({id: $stateParams.id}, function (data) {
        angular.forEach(data, function (row) {
          row.date = new Date(row.created);
          row.icons = Gallery.icons({id: row.id, limit: 6});
        });
      });

  });
