'use strict';

/**
 * @ngdoc service
 * @name wwwApp.User
 * @description
 * # User
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('User', function (config, $resource) {
    return $resource(
        config.api.baseURL + '/user',
        {},
        {
          'orders': {method: 'GET', url: config.api.baseURL + '/user/orders', isArray: true}
        }
    );
  });