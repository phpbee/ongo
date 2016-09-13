'use strict';

describe('Service: loginmodal', function () {

  // load the service's module
  beforeEach(module('wwwApp'));

  // instantiate service
  var loginmodal;
  beforeEach(inject(function (_loginmodal_) {
    loginmodal = _loginmodal_;
  }));

  it('should do something', function () {
    expect(!!loginmodal).toBe(true);
  });

});
