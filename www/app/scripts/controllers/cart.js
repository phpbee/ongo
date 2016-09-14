'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CartCtrl
 * @description
 * # CartCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CartCtrl', function ($state, $rootScope, storage, cart, $filter) {

        //storage.remove('cart');


        this.updateCart = function (cart) {
            console.log('updateCart');
            var total = 0;

            angular.forEach(cart.items, function (item) {
                total += parseFloat($filter('translate')('PRICE.' + item.resolution));
            });

            cart.total = total;
            console.log(cart);
        }


        this.removeFromCart = function (id) {
            delete $rootScope.cart.items[id];
            this.updateCart($rootScope.cart);
        };

        this.addToCart = function (id, gallery_id, resolution) {

            //cart.add({photo:id, resolution: resolution});
            if (!$rootScope.cart) {
                $rootScope.cart = {items: {}};
            }
            $rootScope.cart.items[id] = {photo_id: id, gallery_id: gallery_id, resolution: resolution};
            this.updateCart($rootScope.cart);

            storage.set('cart', $rootScope.cart);
            cart.save($rootScope.cart);

        }
    });

