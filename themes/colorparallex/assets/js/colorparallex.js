/**
 * @file
 * Custom scripts for theme.
 */
(function ($, Drupal) {

  Drupal.behaviors.colorParallex = {

    attach: function attach(context, settings) {
      // 0. add in class to page-container
      $('#page-container').addClass('in');

      // 1. #home style
      $('#home').height($(window).height());
      $(window).on('resize', function () {
        $('#home').height($(window).height());
      });

      // 2. navbar
      $(window).on('scroll load', function () {
        if ($('#header').attr('data-state-change') != 'disabled') {
          var totalScroll = $(window).scrollTop();
          var headerHeight = $('#header').height();

          if (totalScroll >= headerHeight) {
            $('#header').addClass('navbar-small');
          } else {
            $('#header').removeClass('navbar-small');
          }
        }
      });

      // Pace.on('hide', function () {
      //   $('.pace').addClass('hide');
      // });

      // 06. Handle Page Scroll Content Animation
      $('[data-scrollview="true"]').each(function () {
        var myElement = $(this);
        var elementWatcher = scrollMonitor.create(myElement, 60);

        elementWatcher.enterViewport(function () {
          $(myElement).find('[data-animation=true]').each(function () {
            var targetAnimation = $(this).attr('data-animation-type');
            var targetElement = $(this);
            if (!$(targetElement).hasClass('contentAnimated')) {
              if (targetAnimation == 'number') {
                var finalNumber = parseInt($(targetElement).attr('data-final-number'));
                $({animateNumber: 0}).animate({animateNumber: finalNumber}, {
                  duration: 1000,
                  easing: 'swing',
                  step: function () {
                    var displayNumber = handleAddCommasToNumber(Math.ceil(this.animateNumber));
                    $(targetElement).text(displayNumber).addClass('contentAnimated');
                  }
                });
              } else {
                $(this).addClass(targetAnimation + ' contentAnimated');
                setTimeout(function () {
                  $(targetElement).addClass('finishAnimated');
                }, 1500);
              }
            }
          });

        });
      });

      function handleAddCommasToNumber(value) {
        return value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      }


      // 07. Handle Header Scroll to Action

      // 08. Handle Tooltip Activation. // In theme settings.
      if ($('[data-toggle=tooltip]').length !== 0) {
        $('[data-toggle=tooltip]').tooltip();
      }


    }
  }

})(jQuery, Drupal);
