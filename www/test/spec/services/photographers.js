'use strict';

describe('Service: Photographers', function () {

  // load the service's module
  beforeEach(module('wwwApp'));

  // instantiate service
  var Photographers;
  beforeEach(inject(function (_Photographers_) {
    Photographers = _Photographers_;
  }));

  it('should do something', function () {
    expect(!!Photographers).toBe(true);
  });

});
