'use strict';

/**
 * @ngdoc service
 * @name wwwApp.Session
 * @description
 * # Session
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('Session', function () {
      this.create = function (sessionId, userId, userRole) {
          console.log('Session.create');
          console.log([sessionId, userId, userRole]);
          this.id = sessionId;
          this.userId = userId;
          this.userRole = userRole;
      };
      this.destroy = function () {
          this.id = null;
          this.userId = null;
          this.userRole = null;
      };
      return this;
  })
