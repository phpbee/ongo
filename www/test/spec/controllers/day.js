'use strict';

describe('Controller: DayCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var DayCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    DayCtrl = $controller('DayCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(DayCtrl.awesomeThings.length).toBe(3);
  //});
});
