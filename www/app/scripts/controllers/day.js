'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:DayCtrl
 * @description
 * # DayCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('DayCtrl', function ($scope, $stateParams, Gallery) {
        var query = {
            day: $stateParams.day
        };

        if ($stateParams.country_id) {
            query.country = $stateParams.country_id;
        }

        $scope.galleries = Gallery.query(query,
            function (data) {
                angular.forEach(data, function (row) {
                    row.icons = Gallery.icons({id: row.id, limit: 10});
                });
            }
        );

    });
