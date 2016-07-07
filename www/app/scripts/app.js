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
                    onImageLoad(scope,element, attrs);
                });
                element.bind('error', function () {
                    //alert('image could not be loaded');
                });
            }
        };
    })
    .directive('backImg', function(){
        return function(scope, element, attrs){
            var url = attrs.backImg;
            console.log(url);
            element.css({
                'background-image': 'url(' + url +')',
                'background-size' : 'cover'
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
                templateUrl: 'views/index3.html'
            })
            .state('index3', {
                templateUrl: 'views/index2.html'
            })
            .state('about', {
                url: '/about',
                parent: 'index',
                templateUrl: 'views/about.html'
            })
            .state('main', {
                parent: 'index',
                controller: 'MainCtrl',
                url: '/',
                templateUrl: 'views/main.html'
            })
            .state('gallery', {
                parent: 'index3',
                controller: 'GalleryCtrl',
                url: '/gallery/:id',
                templateUrl: 'views/gallery.html'
            })
            .state('photo', {
                parent: 'index2',
                templateUrl: 'views/photo.html',
                controller: 'PhotoCtrl',
                url: '/gallery/:gallery_id/photo/:id',
            });
            
        
    });
