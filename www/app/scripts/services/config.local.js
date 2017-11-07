'use strict';

/**
 * @ngdoc service
 * @name wwwApp.config
 * @description
 * # config
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('config', function () {
    this.api = {
      baseURL: 'http://localhost:8083/api',
      version: '1.0'
    };
  });
