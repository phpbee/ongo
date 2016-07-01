'use strict';

describe('Controller: PhotoCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var PhotoCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PhotoCtrl = $controller('PhotoCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

});
