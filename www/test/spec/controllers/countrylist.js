'use strict';

describe('Controller: CountryListCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var CountryListCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CountryListCtrl = $controller('CountryListCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(CountryListCtrl.awesomeThings.length).toBe(3);
  //});
});
