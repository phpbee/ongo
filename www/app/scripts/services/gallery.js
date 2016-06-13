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
        config.api.baseURL + '/galleries'
    );
  });