'use strict';

describe('Filter: strtotime', function () {

  // load the filter's module
  beforeEach(module('wwwApp'));

  // initialize a new instance of the filter before each test
  var strtotime;
  beforeEach(inject(function ($filter) {
    strtotime = $filter('strtotime');
  }));

  it('should return the input prefixed with "strtotime filter:"', function () {
    var text = '03-Oct-2016 13:48:33';
    expect(strtotime(text)).toBe('1475491713');
  });

});
