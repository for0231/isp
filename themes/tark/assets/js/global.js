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
    }
  };
}) (jQuery, Drupal, drupalSettings);