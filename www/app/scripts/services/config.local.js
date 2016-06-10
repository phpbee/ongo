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
      baseURL: 'http://192.168.99.100:8083/api',
      version: '1.0'
    };
  });
