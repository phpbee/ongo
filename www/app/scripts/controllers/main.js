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

        //$scope.topCountry = Country.top();
        //$scope.topCity = City.top();
        //$scope.topPlace = Place.top();

        //$scope.photographers = Photograph.query({limit: 5});
        //$scope.places = Place.query({limit: 5});


        Gallery.top({limit: 3}, function (galleries) {
            $scope.topGalleries = galleries;
            $scope.galleries = Gallery.query({limit: 8},
                function (data) {
                    angular.forEach(data, function (row) {
                        row.date = new Date(row.created);
                        row.icons = Gallery.icons({id: row.id, limit: 10});
                    });
                }
            );
        });

    });
