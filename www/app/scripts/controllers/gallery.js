'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:GalleryCtrl
 * @description
 * # GalleryCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('GalleryCtrl', function ($scope, $stateParams, Gallery) {
        $scope.photos = Gallery.photos({id: $stateParams.id});

        $scope.$on('imgLoadedEvent', function(event, mass) { console.log(mass); });
    });
