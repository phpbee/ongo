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
        'ngTouch',
        'pascalprecht.translate'
    ])
    .directive('imageonload', function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.bind('load', function () {
                    onImageLoad(scope, element, attrs);
                });
                element.bind('error', function () {
                    //alert('image could not be loaded');
                });
            }
        };
    })
    .directive('backImg', function () {
        return function (scope, element, attrs) {
            var url = attrs.backImg;
            console.log(url);
            element.css({
                'background-image': 'url(' + url + ')',
                'background-size': 'cover'
            });
        };
    })
    .config(function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/');
        $stateProvider
            .state('index', {
                templateUrl: 'views/index.html'
            })
            .state('index2', {
                templateUrl: 'views/index2.html'
            })
            .state('index3', {
                templateUrl: 'views/index3.html'
            })
            .state('index4', {
                templateUrl: 'views/index4.html'
            })
            .state('about', {
                url: '/about',
                parent: 'index4',
                templateUrl: 'views/about.html'
            })
            .state('photographers-registration', {
                url: '/signup/photographers',
                parent: 'index4',
                templateUrl: 'views/photographers-registration.html'
            })
            .state('main', {
                parent: 'index',
                controller: 'MainCtrl',
                url: '/',
                templateUrl: 'views/main.html'
            })
            .state('gallery', {
                parent: 'index2',
                controller: 'GalleryCtrl',
                url: '/gallery/:id',
                templateUrl: 'views/gallery.html'
            })
            .state('photo', {
                parent: 'index3',
                templateUrl: 'views/photo.html',
                controller: 'PhotoCtrl',
                url: '/gallery/:gallery_id/photo/:id',
            });


    })
    .config(function ($translateProvider) {
        $translateProvider
            .useStaticFilesLoader({
                prefix: '/locales/',
                suffix: '.json'
            })
            .fallbackLanguage('en')
            .useSanitizeValueStrategy('escape')
            .useLocalStorage()
            .preferredLanguage()
        ;
    });
