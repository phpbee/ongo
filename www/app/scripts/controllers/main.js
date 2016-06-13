'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('MainCtrl', function ($scope, Photograph, Place, City, Country, Gallery) {

        $scope.topCountry = Country.top();
        $scope.topCity = City.top();
        $scope.topPlace = Place.top();

        $scope.photographers = Photograph.query({limit: 10});
        $scope.places = Place.query({limit: 10});
        $scope.galleries = Gallery.query({limit: 10},
            function (data) {
                angular.forEach(data, function (row) {
                    row.date = new Date(row.created);
                });
                return data;
            }
        );

    });
