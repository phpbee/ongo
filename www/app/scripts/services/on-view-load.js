'use strict';

angular.module('wwwApp')
  .service('onViewLoad', function() {

      /* The main run function. Call this function to execute the onload events */
      this.run = function() {
        this.loadFoundation();
        this.toggleHeaderTransparency();
      }

      /* Load foundation */
      this.loadFoundation = function() {
        $(document).foundation();
      }

      /* toggle transparent background for the header */
      this.toggleHeaderTransparency = function () {
        if ($('.ongo-main-header').length > 0) {
            var header = $('.ongo-main-header');

            toggleTransparent();
            $(window).scroll(toggleTransparent);

            function toggleTransparent() {
                $(window).scrollTop() < 100 ? header.addClass('transparent-background') : header.removeClass('transparent-background');
            };
        }
      }
  });
