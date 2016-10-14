'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:PhotoCtrl
 * @description
 * # PhotoCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('PhotoCtrl', function ($scope, $stateParams, Gallery, $http) {

        console.log('PhotoCtrl');


        $scope.gallery = Gallery.get({id: $stateParams.gallery_id});

        $scope.photo = Gallery.photo(
            {id: $stateParams.gallery_id, photo_id: $stateParams.id},
            function (photo) {
                photo.resolution = "best";
                $scope.thumbnails = Gallery.photos({id: $stateParams.gallery_id},
                    function (photos) {
                        var min_photo = photos.reduce(function (min, photo) {
                            return photo.id < min || min == -1 ? photo.id : min;
                        }, -1);
                        var max_photo = photos.reduce(function (max, photo) {
                            return photo.id > max ? photo.id : max;
                        }, 0);

                        var prevPhoto = Math.max(photo.id - 1, min_photo);
                        var nextPhoto = Math.min(photo.id + 1, max_photo);

                        $scope.prev_photo = prevPhoto;
                        $scope.next_photo = nextPhoto;

                        var f = function (cachedPhoto) {
                            console.log('cachedPhoto');
                            console.log(cachedPhoto);
                            var i = new Image();
                            i.src = cachedPhoto.src;

                        };
                        Gallery.photo({id: $stateParams.gallery_id, photo_id: nextPhoto}, f);
                        Gallery.photo({id: $stateParams.gallery_id, photo_id: prevPhoto}, f);
                    }
                );
            }
        );

        $scope.setResolution = function (resolution) {
            $scope.photo.resolution = resolution;
        };

    });
