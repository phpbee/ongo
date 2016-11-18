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
        "autoCompleteModule",
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
    .run(function ($rootScope, cart, fav, $translate, amMoment, $http) {
        $rootScope.keys = Object.keys;
        cart.initialize();
        fav.initialize();
        $rootScope.$on('$translateChangeSuccess', function () {
            amMoment.changeLocale($translate.use());
            $http.defaults.headers.common.Translation = $translate.use();
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
            .state('list', {
                abstract: 'true',
                parent: 'index4',
                templateUrl: 'views/list.html'
            })
            .state('list.countries', {
                url: '/countries',
                controller: 'CountryListCtrl',
                templateUrl: 'views/list.countries.html'
            })
            .state('list.cities', {
                url: '/cities',
                controller: 'CityListCtrl',
                templateUrl: 'views/list.cities.html'
            })
            .state('list.places', {
                url: '/places',
                controller: 'PlaceListCtrl',
                templateUrl: 'views/list.places.html'
            })
            .state('list.photographers', {
                url: '/photographers',
                controller: 'PhotographerListCtrl',
                templateUrl: 'views/list.photographers.html'
            })
            .state('place', {
                parent: 'index5',
                controller: 'PlaceCtrl',
                url: '/place/:id',
                templateUrl: 'views/place.html'
            })
            .state('place.photographers', {
                url: '/photographers',
                controller: 'PhotographerListCtrl',
                params: { 'query': 'place'},
                templateUrl: 'views/list.photographers.html'
            })
            .state('place.galleries', {
                url: '/galleries',
                controller: 'GalleryListCtrl',
                params: { 'query': 'place'},
                templateUrl: 'views/list.galleries.html'
            })
            .state('city', {
                parent: 'index5',
                controller: 'CityCtrl',
                url: '/city/:id',
                templateUrl: 'views/city.html'
            })
            .state('city.places', {
                url: '/places',
                controller: 'PlaceListCtrl',
                params: { 'query': 'city'},
                templateUrl: 'views/list.places.html'
            })
            .state('city.photographers', {
                url: '/photographers',
                controller: 'PhotographerListCtrl',
                params: { 'query': 'city'},
                templateUrl: 'views/list.photographers.html'
            })
            .state('city.galleries', {
                url: '/galleries',
                controller: 'GalleryListCtrl',
                params: { 'query': 'city'},
                templateUrl: 'views/list.galleries.html'
            })
            .state('country', {
                parent: 'index5',
                controller: 'CountryCtrl',
                url: '/country/:id',
                templateUrl: 'views/country.html'
            })
            .state('country.cities', {
                url: '/cities',
                controller: 'CityListCtrl',
                params: { 'query': 'country'},
                templateUrl: 'views/list.cities.html'
            })
            .state('country.places', {
                url: '/places',
                controller: 'PlaceListCtrl',
                params: { 'query': 'country'},
                templateUrl: 'views/list.places.html'
            })
            .state('country.photographers', {
                url: '/photographers',
                controller: 'PhotographerListCtrl',
                params: { 'query': 'country'},
                templateUrl: 'views/list.photographers.html'
            })
            .state('country.galleries', {
                url: '/galleries',
                controller: 'GalleryListCtrl',
                params: { 'query': 'country'},
                templateUrl: 'views/list.galleries.html'
            })
            .state('photographer', {
                parent: 'index5',
                controller: 'PhotographerCtrl',
                url: '/photographer/:id',
                templateUrl: 'views/photographer.html'
            })
            .state('photographer.places', {
                url: '/places',
                controller: 'PlaceListCtrl',
                params: { 'query': 'photographer'},
                templateUrl: 'views/list.places.html'
            })
            .state('photographer.galleries', {
                url: '/galleries',
                controller: 'GalleryListCtrl',
                params: { 'query': 'photographer'},
                templateUrl: 'views/list.galleries.html'
            })
            .state('gallery', {
                parent: 'index2',
                controller: 'GalleryCtrl',
                url: '/gallery/:id',
                templateUrl: 'views/gallery.html'
            })
            .state('day', {
                parent: 'index4',
                url: '/day/:day?:country_id',
                controller: 'DayCtrl',
                templateUrl: 'views/day.html'
            })
            .state('photo', {
                parent: 'index3',
                templateUrl: 'views/photo.html',
                controller: 'PhotoCtrl',
                url: '/gallery/:gallery_id/photo/:id'
            })
            .state('login', {
                parent: 'index4',
                templateUrl: 'views/login.html',
                url: '/login'
            })
            .state('logout', {
                controller: 'LogoutCtrl',
                url: '/logout'
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
            .state('user', {
                parent: 'index4',
                controller: 'UserCtrl',
                templateUrl: 'views/user.html',
                url: '/user',
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
                parent: 'index4',
                controller: 'OrderCtrl',
                url: '/order/:id',
                templateUrl: 'views/order.html',
                data: {
                    authorizedRoles: ['user']
                }
            })
            .state('order.success', {
                url: '/success',
                templateUrl: 'views/order.success.html'
            })
            .state('order.pay', {
                url: '/pay',
                templateUrl: 'views/order.pay.html'
            })

            .state('favourites', {
                parent: 'index4',
                controller: 'FavCtrl',
                url: '/favourites',
                templateUrl: 'views/favourites.html',
                data: {
                    authorizedRoles: ['user']
                }
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
