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
            config.api.baseURL + '/photographers'
        );
    });