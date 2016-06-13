'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Gallery
 * @description
 * # Gallery
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('Gallery', function (config, $resource) {
        return $resource(
            config.api.baseURL + '/gallery/:id',
            {'id': '@id'},
            {
                'query': {isArray: true, url: config.api.baseURL + '/galleries'},
                'photos': {isArray: true, url: config.api.baseURL + '/gallery/:id/photos'},
                'top': {method: 'GET', url: config.api.baseURL + '/top/gallery'}
            }
        );
    });