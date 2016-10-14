'use strict';

describe('Controller: PlaceListCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var PlaceListCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PlaceListCtrl = $controller('PlaceListCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(PlaceListCtrl.awesomeThings.length).toBe(3);
  //});
});
