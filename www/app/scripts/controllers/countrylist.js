'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CountryListCtrl
 * @description
 * # CountryListCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('CountryListCtrl', function ($scope, $stateParams, Country) {
      var query = {};
      query[$stateParams.query] = $stateParams.id;
      $scope.countries = Country.query(query);

  });
