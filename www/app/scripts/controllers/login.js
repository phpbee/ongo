'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('LoginCtrl', function ($scope, AuthService) {


        $scope.login = function (email) {
            AuthService.login({'email': email});
        };
        
    });
