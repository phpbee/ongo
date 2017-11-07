/**
 * @ngdoc filter
 * @name wwwApp.filter:randomNum
 * @function
 * @description
 * # randoNum
 * Filter in the wwwApp.
 */
angular.module('wwwApp')
    .filter('randomNum', function () {
        return function (input) {
            return Math.floor(Math.random() * input);
        };
    });
