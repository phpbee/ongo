'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PlaceCtrl
 * @description
 * # PlaceCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('PlaceCtrl', function ($scope, $stateParams, Place, Gallery) {

      $scope.place = Place.get({id: $stateParams.id});
      $scope.galleries = Place.galleries({id: $stateParams.id}, function (data) {
          angular.forEach(data, function (row) {
            row.icons = Gallery.icons({id: row.id, limit: 6});
          });
      });

  });
