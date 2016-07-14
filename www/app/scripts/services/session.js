'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Session
 * @description
 * # Session
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('Session', function (config, $resource) {
    return $resource(
        config.api.baseURL + '/sessions'
    );
  });