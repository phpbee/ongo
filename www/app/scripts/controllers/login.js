'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('LoginCtrl', function ($scope, $state, Session, storage) {


        console.log('LoginCtrl');



        storage.bind($scope,'session');

        $scope.login = function () {
            Session.save({'email': $scope.email}, function (session) {
                storage.set('session', session);
                $state.go('main');
            });
        };

        $scope.logout = function () {
            console.log('logout');
            storage.remove('session');
            $state.go('main');
        };

    });
