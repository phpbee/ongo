'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PhotographerCtrl
 * @description
 * # PhotographerCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('PhotographerCtrl', function ($scope, $stateParams, Photograph) {

        $scope.photograph = Photograph.get({id: $stateParams.id});
        $scope.galleries = Photograph.galleries({id: $stateParams.id}, function (data) {
            angular.forEach(data, function (row) {
                row.date = new Date(row.created);
            });
        });

    });
