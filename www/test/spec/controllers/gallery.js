'use strict';

describe('Controller: GalleryCtrl', function () {

  // load the controller's module
  beforeEach(module('wwwApp'));

  var GalleryCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    GalleryCtrl = $controller('GalleryCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(GalleryCtrl.awesomeThings.length).toBe(3);
  });
});
