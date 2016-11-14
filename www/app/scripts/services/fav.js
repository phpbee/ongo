'use strict';

/**
 * @ngdoc service
 * @name wwwApp.fav
 * @description
 * # Fav
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('fav', function ($rootScope, storage) {
        this.save = function (c) {
            storage.set('fav', c);
        };

        this.updateFav = function (c) {
                that.save(c);
        };

        this.emptyFav = function () {
            $rootScope.fav = {items: {}};
            that.updateFav($rootScope.fav);
        };


        this.removeFromFav = function (id) {
            delete $rootScope.fav.items[id];
            that.updateFav($rootScope.fav);
        };

        this.addToFav = function (id, gallery_id) {
            var item = {photo_id: id, gallery_id: gallery_id};
            $rootScope.fav.items[id] = item;
            that.updateFav($rootScope.fav);
        };

        var that = this;


        return {
            initialize: function () {
                storage.bind($rootScope, 'fav');
                if (!$rootScope.fav) {
                    $rootScope.fav = {items: {}};
                }
            },
            refresh: function() {
                that.updateFav($rootScope.fav);
            },
            save: this.save,
            addToFav: this.addToFav,
            removeFromFav: this.removeFromFav,
            emptyFav: this.emptyFav
        }

    });