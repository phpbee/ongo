'use strict';

/**
 * @ngdoc service
 * @name wwwApp.cart
 * @description
 * # cart
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('cart', function ($rootScope, storage, $translate) {
        //return $resource(
        //    config.api.baseURL + '/cart',
        //    {},
        //    {
        //      'add': {method: 'POST'},
        //      'save': {method: 'PUT'}
        //    }
        //);

        console.log('CartService');


        this.save = function (c) {
            storage.set('cart', c);
        };

        this.updateCart = function (c) {
            console.log('updateCart');
            $translate(['PRICE.best', 'PRICE.web', 'CURRENCY', 'CURRENCY_SYMBOL']).then(function (tr) {
                var total = 0;
                angular.forEach(c.items, function (item) {
                    item.price = parseFloat(tr['PRICE.' + item.resolution]);
                    item.currency = tr['CURRENCY'];
                    item.currency_symbol = tr['CURRENCY_SYMBOL'];
                    total += item.price;
                });
                c.total = total;
                c.currency = tr['CURRENCY'];
                c.currency_symbol = tr['CURRENCY_SYMBOL'];
                that.save(c);
            });

        };

        this.emptyCart = function () {
            $rootScope.cart = {items: {}};
            that.updateCart($rootScope.cart);
        };


        this.removeFromCart = function (id) {
            delete $rootScope.cart.items[id];
            that.updateCart($rootScope.cart);
        };

        this.addToCart = function (id, gallery_id, resolution) {
            var item = {photo_id: id, gallery_id: gallery_id, resolution: resolution};
            $rootScope.cart.items[id] = item;
            that.updateCart($rootScope.cart);
        };

        var that = this;


        return {
            initialize: function () {
                storage.bind($rootScope, 'cart');
                if (!$rootScope.cart) {
                    $rootScope.cart = {items: {}};
                }
            },
            refresh: function() {
                that.updateCart($rootScope.cart);
            },
            save: this.save,
            addToCart: this.addToCart,
            removeFromCart: this.removeFromCart,
            emptyCart: this.emptyCart
        }

    });