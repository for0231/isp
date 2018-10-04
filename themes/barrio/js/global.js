/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.global= {
    attach: function (context, settings) {
    }
  };
})(jQuery, Drupal);
/* 函数防抖 */
var debounce = function (defaultTime) {
  var timeoutIndex;
  return function (callback, time) {
    if (typeof time !== 'number') {
      time = defaultTime;
    }

    if (typeof timeoutIndex === 'number') {
      clearTimeout(timeoutIndex);
    }

    timeoutIndex = setTimeout(callback, time);
  }
};