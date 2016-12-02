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
                switch (item.class) {
                    case 'place':
                        var icon = "fi-mountains";
                        break;
                    case 'photograph':
                        var icon = "fi-torso";
                        break;
                }
                return {
                    value: item.name,
                    __label: item.name,
                    label: $sce.trustAsHtml("<i class=\""+icon+"\"></i> "+item.name)
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
