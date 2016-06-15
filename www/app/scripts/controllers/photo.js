'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PhotoCtrl
 * @description
 * # PhotoCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('PhotoCtrl', function ($scope, $stateParams, Gallery) {
        $scope.photo = Gallery.photo({id: $stateParams.gallery_id, photo_id: $stateParams.id});
    });
