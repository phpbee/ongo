'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Search
 * @description
 * # Search
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('Search', function (config, $resource) {
    return $resource(
        config.api.baseURL + '/search/',
        {},
        {
          'byPlaceOrPhotographer': {cache: true, isArray: true, url: config.api.baseURL + '/search/byPlaceOrPhotographer'},
        }
    );
  });