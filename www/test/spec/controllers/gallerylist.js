'use strict';

describe('Controller: GalleryListCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var GalleryListCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    GalleryListCtrl = $controller('GalleryListCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  //it('should attach a list of awesomeThings to the scope', function () {
  //  expect(GalleryListCtrl.awesomeThings.length).toBe(3);
  //});
});
