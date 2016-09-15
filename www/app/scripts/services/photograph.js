'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Photograph
 * @description
 * # Photograph
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('Photograph', function (config, $resource) {
        return $resource(
            config.api.baseURL + '/photograph/:id',
            {'id': '@id'},
            {
                'query': {isArray: true, url: config.api.baseURL + '/photographers'},
                'galleries': {isArray: true, url: config.api.baseURL + '/photograph/:id/galleries'},
            }
        );
    });