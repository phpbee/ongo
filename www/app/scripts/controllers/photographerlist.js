'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PhotographerListCtrl
 * @description
 * # PhotographerListCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('PhotographerListCtrl', function ($scope, $stateParams, Photograph) {

      var query = {};

      query[$stateParams.query] = $stateParams.id;
      $scope.photographers = Photograph.query(query);

  });