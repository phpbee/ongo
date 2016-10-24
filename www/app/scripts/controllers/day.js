'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:DayCtrl
 * @description
 * # DayCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('DayCtrl', function ($scope, $stateParams, Gallery) {
      var day = $stateParams.day;
      $scope.galleries = Gallery.query({day: day},
          function (data) {
              angular.forEach(data, function (row) {
                  row.icons = Gallery.icons({id: row.id, limit: 10});
              });
          }
      );

  });
