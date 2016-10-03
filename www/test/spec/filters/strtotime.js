'use strict';

describe('Filter: strtotime', function () {

  // load the filter's module
  beforeEach(module('wwwApp'));

  // initialize a new instance of the filter before each test
  var strtotime;
  beforeEach(inject(function ($filter) {
    strtotime = $filter('strtotime');
  }));
});
