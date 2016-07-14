'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:LogoutCtrl
 * @description
 * # LogoutCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('LogoutCtrl', function ($state, $scope, storage) {
        storage.remove('session');
        $state.go('main');

    });
