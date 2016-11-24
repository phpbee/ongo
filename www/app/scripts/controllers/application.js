'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
    .controller('ApplicationCtrl', function ($rootScope, $scope, $stateParams, $state, $translate, AuthService, Session, storage, cart, fav) {

        $scope.$state = $state;

        $scope.changeLanguage = function (key) {
            $translate.use(key);
            cart.refresh();
        };

        $rootScope.$on('$translateChangeSuccess', function () {
            $rootScope.activeLanguage = $translate.use();
        });


        $scope.removeFromCart = cart.removeFromCart;
        $scope.addToCart = cart.addToCart;
        $scope.removeFromFav = fav.removeFromFav;
        $scope.addToFav = fav.addToFav;


        
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
