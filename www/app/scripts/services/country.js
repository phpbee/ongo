'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Country
 * @description
 * # Country
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('Country', function (config, $resource) {
        return $resource(
            config.api.baseURL + '/country/:id',
            {},
            {
                'query': {isArray: true, url: config.api.baseURL + '/countries'},
                'top': {method: 'GET', url: config.api.baseURL + '/top/country'},
                'galleries': {isArray: true, url: config.api.baseURL + '/country/:id/galleries'},

            }
        );
    });