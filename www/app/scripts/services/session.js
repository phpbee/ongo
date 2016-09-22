'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Session
 * @description
 * # Session
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('Session', function ($http) {
      this.create = function (sessionId, userId, userRole) {
          console.log('Session.create');
          console.log([sessionId, userId, userRole]);
          this.id = sessionId;
          this.userId = userId;
          this.userRole = userRole;

          var headers = $http.defaults.headers.common;
          headers['Authorization'] = 'Ongo 1.0';
          headers['Token'] = sessionId;

      };
      this.destroy = function () {
          this.id = null;
          this.userId = null;
          this.userRole = null;
      };
      return this;
  })
