'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CheckoutCtrl
 * @description
 * # CheckoutCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CheckoutCtrl', function ($scope, $state, storage, Gallery, Order) {
        console.log('CheckoutCtrl');
        angular.forEach($scope.cart.items, function (item) {
            item.photo = Gallery.photo({id: item.gallery_id, photo_id: item.photo_id});
            item.gallery = Gallery.get({id: item.gallery_id});

        });

        $scope.checkout = function (cart) {
            console.log(cart);
            Order.create({cart:cart}, function(data) {
                /** TODO: refactor CartCtrl to Service **/
                //CartCtrl.emptyCart();
               $state.go('orders', data);
            });
        }
    });
