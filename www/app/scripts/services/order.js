'use strict';

/**
 * @ngdoc service
 * @name wwwApp.cart
 * @description
 * # cart
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('Order', function (config, $resource) {
    return $resource(
        config.api.baseURL + '/order/:id',
        {},
        {
          'create': {url:config.api.baseURL + '/order/', method: 'POST'},
          'download': {url:config.api.baseURL + '/order/:id/download/:photo_id'}
        }
    );
  });