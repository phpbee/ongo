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
      $scope.galleries = Gallery.query({place: $stateParams.id});

  });
