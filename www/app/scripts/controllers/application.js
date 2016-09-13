'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('ApplicationCtrl', function ($scope, $translate, $http, storage) {

        console.log('ApplicationCtrl');
        
        $scope.changeLanguage = function (key) {
            $scope.activeLanguage = key;
            $translate.use(key);
        };

        $scope.activeLanguage = $translate.use() ||
            $translate.storage().get($translate.storageKey()) ||
            $translate.preferredLanguage();


        var session=storage.get('session');
        if (session) {
            var headers = $http.defaults.headers.common;
            headers.Authorization = 'Ongo version=1.0 token="' + session.token + '"';
        }


    });
