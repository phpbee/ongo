'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CheckoutCtrl
 * @description
 * # CheckoutCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CheckoutCtrl', function ($scope, storage, Gallery, $filter) {
        console.log('CheckoutCtrl');
        angular.forEach($scope.cart.items, function (item) {
            item.photo = Gallery.photo({id: item.gallery_id, photo_id: item.photo_id});
            item.gallery = Gallery.get({id: item.gallery_id});

        });
    });
