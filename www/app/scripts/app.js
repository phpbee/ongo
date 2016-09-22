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
        'pascalprecht.translate',
        'angularLocalStorage',
        'ngCookies',
        'ui.bootstrap'
    ])
    .constant('AUTH_EVENTS', {
        loginSuccess: 'auth-login-success',
        loginFailed: 'auth-login-failed',
        logoutSuccess: 'auth-logout-success',
        sessionTimeout: 'auth-session-timeout',
        notAuthenticated: 'auth-not-authenticated',
        notAuthorized: 'auth-not-authorized'
    })
    .constant('USER_ROLES', {
        user: 'user'
    })
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
    // .run(function ($rootScope, $state, $http, storage, loginModal) {
    //     $rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
    //         var session = storage.get('session');
    //         if (session) {
    //             var headers = $http.defaults.headers.common;
    //             headers.Authorization = 'Ongo version=1.0 token="' + session.token + '"';
    //         } else if (toState.requireLogin) {
    //             event.preventDefault();
    //             loginModal()
    //                 .then(function () {
    //                     return $state.go(toState.name, toParams);
    //                 })
    //                 .catch(function () {
    //                     return $state.go('main');
    //                 });
    //         }
    //     });
    // })
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
            .state('index5', {
                templateUrl: 'views/index5.html'
            })
            .state('about', {
                url: '/about',
                parent: 'index4',
                templateUrl: 'views/about.html'
            })
            .state('policy', {
                url: '/policy',
                parent: 'index4',
                templateUrl: 'views/policy.html'
            })            
            .state('contacts', {
                url: '/contacts',
                parent: 'index4',
                templateUrl: 'views/contacts.html'
            })            
            .state('faq', {
                url: '/faq',
                parent: 'index4',
                templateUrl: 'views/faq.html'
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
            .state('place', {
                parent: 'index4',
                controller: 'PlaceCtrl',
                url: '/place/:id',
                templateUrl: 'views/place.html'
            })
            .state('city', {
                parent: 'index4',
                controller: 'CityCtrl',
                url: '/city/:id',
                templateUrl: 'views/city.html'
            })
            .state('country', {
                parent: 'index5',
                controller: 'CountryCtrl',
                url: '/country/:id',
                templateUrl: 'views/country.html'
            })
            .state('photographer', {
                parent: 'index5',
                controller: 'PhotographerCtrl',
                url: '/photographer/:id',
                templateUrl: 'views/photographer.html'
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
            })
            .state('login', {
                parent: 'index4',
                templateUrl: 'views/login.html',
                url: '/login',
            })
            .state('logout', {
                controller: 'LogoutCtrl',
                url: '/logout',
            })
            .state('checkout', {
                controller: 'CheckoutCtrl',
                parent: 'index4',
                url: '/checkout',
                templateUrl: 'views/checkout.html',
                data: {
                    authorizedRoles: ['user']
                }
            })
            .state('orders', {
                parent: 'index4',
                url: '/orders',
                templateUrl: 'views/orders.html',
                data: {
                    authorizedRoles: ['user']
                }
            });


    })
    .config(function ($translateProvider) {
        $translateProvider
            .registerAvailableLanguageKeys(['en', 'ru'], {
                'en*': 'en',
                'ru*': 'ru'
            })
            .useStaticFilesLoader({
                prefix: '/locales/',
                suffix: '.json'
            })
            .fallbackLanguage('en')
            .useSanitizeValueStrategy('escape')
            .useLocalStorage()
            .determinePreferredLanguage()
        ;
    });
