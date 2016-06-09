'use strict';

describe('Service: Photograph', function () {

  // load the service's module
  beforeEach(module('wwwApp'));

  // instantiate service
  var Photograph;
  beforeEach(inject(function (_Photograph_) {
    Photograph = _Photograph_;
  }));

  it('should do something', function () {
    expect(!!Photograph).toBe(true);
  });

});
