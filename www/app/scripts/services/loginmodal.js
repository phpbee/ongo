'use strict';

/**
 * @ngdoc service
 * @name wwwApp.loginmodal
 * @description
 * # loginmodal
 * Service in the wwwApp.
 */
angular.module('wwwApp')
  .service('loginModal', function ($uibModal, $rootScope, storage) {

    function assignCurrentUser (session) {
      //storage.set('session',session);
      return session;
    }

    return function() {
      var instance = $uibModal.open({
        templateUrl: 'views/loginModal.html',
        controller: 'LoginCtrl',
        controllerAs: 'LoginCtrl',
          windowClass: "modal loginDialog"
      })

      return instance.result.then(assignCurrentUser);
    };

  });
