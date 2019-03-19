/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.tark = {
    attach: function (context, settings) {
      $('#block-rolemenublock').metisMenu();

      $('<table class="sticky-header"/>').onLoad(function () {
        $(this).css({
          top: '48px',
        });
      });
    }
  };
}) (jQuery, Drupal, drupalSettings);