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
        config.api.baseURL + '/cities',
        {},
        {
          'top': {method: 'GET', url: config.api.baseURL + '/top/city'}
        }
    );
  });