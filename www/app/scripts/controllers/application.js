'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('ApplicationCtrl', function ($rootScope, $scope, $stateParams, $state, $translate, AuthService, Session, storage) {

        $scope.changeLanguage = function (key) {
            $scope.activeLanguage = key;
            $translate.use(key);
        };

        $scope.activeLanguage = $translate.use() ||
            $translate.storage().get($translate.storageKey()) ||
            $translate.preferredLanguage();


        $rootScope.currentUser = null;
        $rootScope.isAuthorized = AuthService.isAuthorized;
        $rootScope.$state = $state;

        $rootScope.requireAuth = function($state, role) {
            var roles = $state.$current.data && $state.$current.data.authorizedRoles ? $state.$current.data.authorizedRoles : [];
            if (!angular.isArray(roles)) {
                roles = [roles];
            }
            var b = roles.indexOf(role) !== -1;
            return b;
        };


        var session = storage.get('session');
        if (session) {
            Session.create(session.token, session.user_id, session.role);
        }
    });
