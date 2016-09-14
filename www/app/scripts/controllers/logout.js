'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:LogoutCtrl
 * @description
 * # LogoutCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('LogoutCtrl', function ($state, $scope, AuthService ) {
        AuthService.logout();
        $state.go('main');

    });
