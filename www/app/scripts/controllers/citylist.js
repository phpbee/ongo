'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CityListCtrl
 * @description
 * # CityListCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CityListCtrl', function ($scope, $stateParams, City) {
        var query = {};
        query[$stateParams.query] = $stateParams.id;
        $scope.cities = City.query(query);

    });
