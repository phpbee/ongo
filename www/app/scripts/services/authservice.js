'use strict';

/**
 * @ngdoc service
 * @name wwwApp.AuthService
 * @description
 * # AuthService
 * Service in the wwwApp.
 */
angular.module('wwwApp')
    .service('AuthService', function ($http, Session, storage, config) {
        var self = {
            login: function (credentials) {
                return $http
                    .post(config.api.baseURL + '/sessions', credentials)
                    .then(function (res) {

                        var session = {token: res.data.token, user_id: res.data.user_id, role: 'user'};
                        Session.create(session.token, session.user_id, session.role);
                        storage.set('session', session)
                    });
            },
            logout: function() {
                Session.destroy();
                storage.remove('session');
            },
            isAuthenticated: function () {
                return !!Session.userId;
            },
            isAuthorized: function (authorizedRoles) {
                if (!angular.isArray(authorizedRoles)) {
                    authorizedRoles = [authorizedRoles];
                }
                return (self.isAuthenticated() &&
                authorizedRoles.indexOf(Session.userRole) !== -1);
            }
        };
        return self;
    })