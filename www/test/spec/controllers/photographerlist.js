'use strict';

describe('Controller: PhotographerListCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var PhotographerListCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PhotographerListCtrl = $controller('PhotographerListCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(PhotographerListCtrl.awesomeThings.length).toBe(3);
  //});
});
