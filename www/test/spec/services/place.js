'use strict';

describe('Service: Place', function () {

  // load the service's module
  beforeEach(module('wwwApp'));

  // instantiate service
  var Place;
  beforeEach(inject(function (_Place_) {
    Place = _Place_;
  }));

  it('should do something', function () {
    expect(!!Place).toBe(true);
  });

});
