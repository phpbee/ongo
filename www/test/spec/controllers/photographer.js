'use strict';

describe('Controller: PhotographerCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var PhotographerCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PhotographerCtrl = $controller('PhotographerCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(PhotographerCtrl.awesomeThings.length).toBe(3);
  //});
});
