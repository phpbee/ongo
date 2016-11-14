'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CheckoutCtrl
 * @description
 * # CheckoutCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CheckoutCtrl', function ($scope, $state, cart, Gallery, Order) {
        angular.forEach($scope.cart.items, function (item) {
            item.photo = Gallery.photo({id: item.gallery_id, photo_id: item.photo_id});
            item.gallery = Gallery.get({id: item.gallery_id});

        });

        $scope.checkout = function (c) {
            console.log(c);
            Order.create({cart: c}, function (data) {
                cart.emptyCart();
                $state.go('order.success', {id: data.id});
            });
        }
    });
