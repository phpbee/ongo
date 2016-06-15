'use strict';

/**
 * @ngdoc overview
 * @name wwwApp
 * @description
 * # wwwApp
 *
 * Main module of the application.
 */
angular
    .module('wwwApp', [
        'ngAnimate',
        'ngCookies',
        'ngResource',
        'ui.router',
        'ngSanitize',
        'ngTouch'
    ])
    .directive('onFinishRender', function ($timeout) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit('ngRepeatFinished');
                    });
                }
            }
        }
    })
    .config(function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('/');
        $stateProvider
            .state('main', {
                controller: 'MainCtrl',
                url: '/',
                templateUrl: 'views/main.html'
            })
            .state('gallery', {
                controller: 'GalleryCtrl',
                url: '/gallery/:id',
                templateUrl: 'views/gallery.html'
            })
            .state('photo', {
                templateUrl: 'views/photo.html',
                controller: 'PhotoCtrl',
                url: '/gallery/:gallery_id/photo/:id',
            });
    });
