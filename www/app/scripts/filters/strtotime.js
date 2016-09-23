'use strict';

/**
 * @ngdoc filter
 * @name wwwApp.filter:strtotime
 * @function
 * @description
 * # strtotime
 * Filter in the wwwApp.
 */
angular.module('wwwApp')
    .filter('strtotime', function () {
        return function (input) {
            return isNaN(input) ? new Date(input) : new Date(input * 1000);
        };
    });
