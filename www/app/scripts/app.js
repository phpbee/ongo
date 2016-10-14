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
        'ui.bootstrap',
        'angularMoment'
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
    .run(function($rootScope, cart, $translate, amMoment, $http) {

        cart.initialize();


        $rootScope.keys = Object.keys;

        $rootScope.$on('$translateChangeSuccess', function () {
            amMoment.changeLocale($translate.use());
            $http.defaults.headers.common.Translation = $translate.use();
            console.log($translate.use());
        });


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
                parent: 'index5',
                controller: 'PlaceCtrl',
                url: '/place/:id',
                templateUrl: 'views/place.html'
            })
            .state('city', {
                parent: 'index5',
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
            .state('countryList', {
                parent: 'index5',
                controller: 'CountryListCtrl',
                url: '/countries',
                templateUrl: 'views/country_list.html'
            })
            .state('cityList', {
                parent: 'index5',
                controller: 'CityListCtrl',
                url: '/cities',
                templateUrl: 'views/city_list.html'
            })
            .state('placeList', {
                parent: 'index5',
                controller: 'PlaceListCtrl',
                url: '/places',
                templateUrl: 'views/place_list.html'
            })
            .state('photographerList', {
                parent: 'index5',
                controller: 'PhotographerListCtrl',
                url: '/photographers',
                templateUrl: 'views/photographer_list.html'
            })
            .state('galleryList', {
                parent: 'index5',
                controller: 'GalleryListCtrl',
                url: '/galleries',
                templateUrl: 'views/gallery_list.html'
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


            .state('user', {
                controller: 'UserCtrl',
                templateUrl: 'views/user.html',
                url: '/user',
                data: {
                    authorizedRoles: ['user']
                }
            })
            .state('checkout', {
                parent: 'index4',
                controller: 'CheckoutCtrl',
                url: '/checkout',
                templateUrl: 'views/checkout.html',
                data: {
                    authorizedRoles: ['user']
                }
            })
            .state('user.orders', {
                url: '/orders',
                controller: 'UserOrdersCtrl',
                templateUrl: 'views/user.orders.html'
            })
            .state('order', {
                parent: 'user',
                controller: 'OrderCtrl',
                url: '/order/:id',
                templateUrl: 'views/order.html'
            })
            .state('order.success', {
                url: '/success',
                templateUrl: 'views/order.success.html'
            })
        ;


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
