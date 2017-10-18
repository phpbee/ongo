'use strict';


angular.module('wwwApp')
    .controller('CountryCtrl', function ($scope, $stateParams, Country, Gallery) {

        $scope.country = Country.get({id: $stateParams.id}, function(country) {
            $scope.rootItem = country.id;
        });
        $scope.galleries = Country.galleries({id: $stateParams.id}, function (data) {
          angular.forEach(data, function (row) {
            row.date = new Date(row.created);
            row.icons = Gallery.icons({id: row.id, limit: 6});
          });
        });

    });
