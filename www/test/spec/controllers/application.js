'use strict';

describe('Controller: ApplicationCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var ApplicationCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ApplicationCtrl = $controller('ApplicationCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(ApplicationCtrl.awesomeThings.length).toBe(3);
  });
});
