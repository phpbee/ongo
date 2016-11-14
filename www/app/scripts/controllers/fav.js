'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CheckoutCtrl
 * @description
 * # CheckoutCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('FavCtrl', function ($scope, $state, Gallery, fav) {

        angular.forEach($scope.fav.items, function (item) {
            item.photo = Gallery.photo({id: item.gallery_id, photo_id: item.photo_id});
            item.gallery = Gallery.get({id: item.gallery_id});
        });

        $scope.emptyFav = fav.emptyFav;
        $scope.removeFromFav = fav.removeFromFav;
    });
