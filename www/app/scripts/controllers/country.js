'use strict';


angular.module('wwwApp')
    .controller('CountryCtrl', function ($scope, $stateParams, Country) {

        $scope.country = Country.get({id: $stateParams.id});
        $scope.galleries = Country.galleries({id: $stateParams.id}, function (data) {
            angular.forEach(data, function (row) {
                row.date = new Date(row.created);
            });
        });

    });
