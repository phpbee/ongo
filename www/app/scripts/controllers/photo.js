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
        $scope.gallery = Gallery.get({id: $stateParams.gallery_id});

        $scope.photo = Gallery.photo(
            {id: $stateParams.gallery_id, photo_id: $stateParams.id},
            function (photo) {
                $scope.thumbnails = Gallery.photos({id: $stateParams.gallery_id},
                    function (photos) {
                        var min_photo = photos.reduce(function (min, photo) {
                            return photo.id < min || min == -1 ? photo.id : min;
                        }, -1);
                        var max_photo = photos.reduce(function (max, photo) {
                            return photo.id > max ? photo.id : max;
                        }, 0);

                        $scope.prev_photo = Math.max(photo.id - 1, min_photo);
                        $scope.next_photo = Math.min(photo.id + 1, max_photo);
                    }
                );
            }
        );
    });
