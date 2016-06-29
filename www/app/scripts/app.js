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
    .directive('imageonload', function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.bind('load', function () {
                    onImageLoad(scope,element);
                });
                element.bind('error', function () {
                    //alert('image could not be loaded');
                });
            }
        };
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
