/**
 * @file
 * Custom scripts for theme.
 */
(function ($, Drupal) {

  Drupal.behaviors.colorParallex = {
    attach: function attach(context) {
      // 01. Handle Home Content Height
      $('#home').height($(window).height());
      $(window).on('resize', function () {
        $('#home').height($(window).height());
      });

      // 02. Handle Header Navigation State
      // $(window).on('scroll load', function () {
      //   if ($('#header').attr('data-state-change') != 'disabled') {
      //     var totalScroll = $(window).scrollTop();
      //     var headerHeight = $('#header').height();
      //
      //     if (totalScroll >= headerHeight) {
      //       $('#header').addClass('navbar-small');
      //     } else {
      //       $('#header').removeClass('navbar-small');
      //     }
      //   }
      // });

      Drupal.attachBehaviors(context);
    }
  }

})(jQuery, Drupal);
