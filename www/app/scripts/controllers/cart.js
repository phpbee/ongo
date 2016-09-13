'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:CartCtrl
 * @description
 * # CartCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('CartCtrl', function ($state, $scope,storage, cart) {

        //storage.remove('cart');

        storage.bind($scope,'cart');
        //console.log($scope.cart);

        $scope.addToCart = function (id, resolution) {

            //cart.add({photo:id, resolution: resolution});
            if (!$scope.cart) {
                $scope.cart={};
            }
            $scope.cart[id] = {photo:id, resolution: resolution};
            storage.set('cart',$scope.cart);
            cart.save($scope.cart);
            $state.go('checkout');

        }
    });
