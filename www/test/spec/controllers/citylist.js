'use strict';

describe('Controller: CityListCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var CityListCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CityListCtrl = $controller('CityListCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(CityListCtrl.awesomeThings.length).toBe(3);
  //});
});
