/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {

  Drupal.behaviors.colorParallex = {
    attach: function (context) {
      // 01. Handle Home Content Height
      $('#home').height($(window).height());

      $(window).on('resize', function () {
        $('#home').height($(window).height());
      });

      Drupal.attachBehaviors(context);
    }
  }

})(jQuery);
