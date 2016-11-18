'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:SearchCtrl
 * @description
 * # SearchCtrl
 * Controller of the wwwApp
 */

angular.module('wwwApp')
    .controller('SearchCtrl', function ($sce,$state) {
        console.log("SearchCtrl");
        var that = this;

        that.stateName = null;
        that.autoCompleteOptions = {
            minimumChars: '1',
            containerCssClass: "color-codes",
            renderItem: function (item) {
                console.log('renderItem');
                return {
                    value: item.name,
                    label: item.name,
                    __label: $sce.trustAsHtml(
                        "<span>"+ item.name + " <b>"+item.code+"</b></span>")
                };
            },
            itemSelected: function(item) {
              console.log('itemSelected');
              console.log(item.item);
              $state.go(item.item.state,{id: item.item.id});
            },
            data: function (term) {
                console.log("SearchCtrl.autoCompleteOptions");
                var termUpper = term.toUpperCase();
                console.log(termUpper);
                return [{name: "moe", state: 'photographer', id:8}, {name: "Square", state: 'place', id:3}];
                //var match = _.filter(CSS_COLORS, function (value) {
                //    return value.name.startsWith(termUpper);
                //});
                //return _.pluck(match, "name");
            }
        }

    });
