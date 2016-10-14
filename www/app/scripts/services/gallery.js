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
                'get': {cache : true},
                'query': {cache : true, isArray: true, url: config.api.baseURL + '/galleries'},
                'photos': {cache : true, isArray: true, url: config.api.baseURL + '/gallery/:id/photos'},
                'thumbnails': {cache : true, isArray: true, url: config.api.baseURL + '/gallery/:id/thumbnails'},
                'icons': {cache : true, isArray: true, url: config.api.baseURL + '/gallery/:id/icons'},
                'photo': {cache : true, isArray: false, url: config.api.baseURL + '/gallery/:id/photo/:photo_id'},
                'top': {cache : true, isArray: true, method: 'GET', url: config.api.baseURL + '/top/gallery'}
            }
        );
    });