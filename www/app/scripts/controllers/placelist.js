'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PlaceListCtrl
 * @description
 * # PlaceListCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('PlaceListCtrl', function ($scope, $stateParams, Place) {

      var query = {};
      query[$stateParams.query] = $stateParams.id;
      $scope.places = Place.query(query);

  });