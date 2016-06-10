'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('MainCtrl', function ($scope, Photograph, Place) {

    $scope.photographers=Photograph.query({limit: 10});
    $scope.places=Place.query({limit: 10});

  });
