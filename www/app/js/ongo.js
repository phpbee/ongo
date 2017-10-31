function onImageLoad(scope, img, attrs) {

    if ("masonry" == attrs.imageonload) {
        $(img).closest('#container').masonry({itemSelector: '.item'});
    }


    if ("minslider" == attrs.imageonload) {
        $(img).closest('.thumbsgal').show();

        var minslider = $(img).closest('.minslider').lightSlider({
            pager: false,
            loop: true,
            controls: false,
            item: 10,
            slideMargin: 2,
            responsive: [
                {
                    breakpoint: 840,
                    settings: {
                        item: 9,
                    }
                },
                {
                    breakpoint: 750,
                    settings: {
                        item: 8,
                    }
                },
                {
                    breakpoint: 660,
                    settings: {
                        item: 7,
                    }
                },
                {
                    breakpoint: 570,
                    settings: {
                        item: 6,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        item: 5,
                    }
                },
                {
                    breakpoint: 390,
                    settings: {
                        item: 4,
                    }
                },
                {
                    breakpoint: 330,
                    settings: {
                        item: 3,
                    }
                }

            ]
        });

        $('.thumbwrap .controls .next').click(function () {
            minslider.goToNextSlide();
        });
        $('.thumbwrap .controls .prev').click(function () {
            minslider.goToPrevSlide();
        });



    }
    if ("lightSlider" == attrs.imageonload) {

        $(img).closest('li').attr('style', "background-image:url('" + $(img).attr('src') + "');");
        $("#lightSlider").lightSlider({
            item: 1,
            slideMargin: 0,
            pager: false,
            loop: true,
            controls: false,
            mode: "fade",
            auto: true,
            enableDrag: false,
            pause: 10000,
        });
    }
}

$(document).ready(function () {

    $("body").on("contextmenu", ".photo img", function(e) {
        $("#photo-copyright").css({top: e.offsetY, left: e.offsetX, position:'absolute'}).show();

        window.setTimeout(function() {
            $("#photo-copyright").hide();
        },3000);

        return false;
    });

    $(document).on("click", '.radio-list', function () {
        $(this).parents('.into').find('.radio-list').removeClass('checked');
        $(this).parents('.into').find('.radio-list').find('input[type="radio"]').prop('checked', false);
        $(this).addClass('checked');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    cityblock();

    function cityblock() {
        var heightcity0 = $('.city_block>li').eq(0).find('.cityblock span').height();
        $('.city_block>li').eq(0).find('.cityblock span').css('margin-top', -heightcity0 / 2);

        var heightcity1 = $('.city_block>li').eq(1).find('.cityblock span').height();
        $('.city_block>li').eq(1).find('.cityblock span').css('margin-top', -heightcity1 / 2);

        var heightcity2 = $('.city_block>li').eq(2).find('.cityblock span').height();
        $('.city_block>li').eq(2).find('.cityblock span').css('margin-top', -heightcity2 / 2);
    }

    $(window).resize(function () {
        cityblock();
    })

    $('.blockpadding form i').click(function () {
        $(this).parent('form').find('input').click();
    })

    /*Search*/
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substrRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({value: str});
                }
            });

            cb(matches);
        };
    };

    /*Поиск фотографов*/
    var photografer = ['Artem', 'Aleksandr', 'Aleksey', 'Anna'];

    $('.photografer.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'photografer',
            displayKey: 'value',
            source: substringMatcher(photografer)
        });

    /*Поиск города*/
    var state = ['Moskow', 'Novosibirsk', 'Omsk', 'Paris'];

    $('.state.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'state',
            displayKey: 'value',
            source: substringMatcher(state)
        });

    $('.fdatepicker').fdatepicker({
        language: 'en'
    });

});

window.ongoOnLoad = function() {

  $(document).foundation();

  // toggle transparent background for the header
  if ($('.ongo-main-header').length > 0) {
      var header = $('.ongo-main-header');
      
      toggleTransparent();
      $(window).scroll(toggleTransparent);

      function toggleTransparent() {
          $(window).scrollTop() < 100 ? header.addClass('transparent-background') : header.removeClass('transparent-background');
      };
  }
}
