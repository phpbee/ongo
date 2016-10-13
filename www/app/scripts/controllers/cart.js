'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CartCtrl
 * @description
 * # CartCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CartCtrl', function ($state, $rootScope, cart, $filter) {

        this.removeFromCart = function (id) {
            cart.removeFromCart(id);
        };

        this.addToCart = function (id, gallery_id, resolution) {
            cart.addToCart(id, gallery_id, resolution);
        }
    });

