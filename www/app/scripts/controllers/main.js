'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('MainCtrl', function ($scope, Photograph, Place, Gallery) {

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
