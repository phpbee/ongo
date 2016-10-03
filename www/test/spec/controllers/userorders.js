'use strict';

describe('Controller: UserordersCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var UserordersCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    UserordersCtrl = $controller('UserordersCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));
  //
  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(UserordersCtrl.awesomeThings.length).toBe(3);
  //});
});
