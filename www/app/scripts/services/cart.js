'use strict';

/**
 * @ngdoc service
 * @name wwwApp.cart
 * @description
 * # cart
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('cart', function (config, $resource) {
    return $resource(
        config.api.baseURL + '/cart',
        {},
        {
          'add': {method: 'POST'},
          'save': {method: 'PUT'}
        }
    );
  });