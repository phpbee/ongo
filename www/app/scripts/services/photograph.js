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
                'query': {cache : true, isArray: true, url: config.api.baseURL + '/photographers'},
                'galleries': {cache : true, isArray: true, url: config.api.baseURL + '/photograph/:id/galleries'},
            }
        );
    });