'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:SearchCtrl
 * @description
 * # SearchCtrl
 * Controller of the wwwApp
 */

angular.module('wwwApp')
    .controller('SearchCtrl', function ($sce, $state, $q, Search) {
        var that = this;

        that.stateName = null;
        that.autoCompleteOptions = {
            minimumChars: '1',
            containerCssClass: "color-codes",
            renderItem: function (item) {
                return {
                    value: item.name,
                    label: item.name,
                    __label: $sce.trustAsHtml(
                        "<span>" + item.name + "</span>")
                };
            },
            itemSelected: function (item) {
                var state;
                switch  (item.item.class) {
                    case 'place':
                        state = 'place';
                        break;
                    case 'photograph':
                        state = 'photographer';
                        break;
                }
                $state.go(state, {id: item.item.id});
            },
            data: function (q) {
                var deferred = $q.defer();
                Search.byPlaceOrPhotographer({q: q},
                    function (response) {
                        deferred.resolve(response);
                    },
                    function (response) {
                        deferred.reject(response);
                    }
                );
                return deferred.promise;
            }
        }

    });
