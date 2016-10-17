'use strict';

/**
 * @ngdoc service
 * @name wwwApp.City
 * @description
 * # City
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('City', function (config, $resource) {
        return $resource(
            config.api.baseURL + '/city/:id',
            {},
            {
                'query': {cache : true, isArray: true, url: config.api.baseURL + '/cities'},
                'top': {cache : true, method: 'GET', url: config.api.baseURL + '/top/city'},
                'galleries': {cache : true, isArray: true, url: config.api.baseURL + '/city/:id/galleries'}

            }
        );
    });