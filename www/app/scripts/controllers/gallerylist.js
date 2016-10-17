'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:GalleryListCtrl
 * @description
 * # GalleryListCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('GalleryListCtrl', function ($scope, $stateParams, Gallery) {

        var query = {};

        query[$stateParams.query] = $stateParams.id;
        $scope.galleries = Gallery.query(query, function (data) {
            angular.forEach(data, function (row) {
                row.icons = Gallery.icons({id: row.id, limit: 6});
            });
        });
    });