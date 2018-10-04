/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.bootstrap_barrio = {
    attach: function (context, settings) {

      var DELAY_NAV = 300;
      var LOW_DELAY_NAV = 150;
      var mainNavDebounce = debounce(DELAY_NAV);// 主导航菜单防抖
      var $navLine = $('.header-nav-hover-line');
      /* 主菜单“更多”的显示 */
      var $header = $('#header');
      var $nav = $header.find('.header-nav');
      var $navItems = $nav.find('>ul>li');
      var $navItems_notMore = $navItems.not('.header-nav-item-more');
      var $navItemMore = $navItems.filter('.header-nav-item-more');

      var setNavLine = {
        active: function ($activeNavItem) {
          if($activeNavItem.length === 0 || !$activeNavItem.is(':visible')) {
              this.fold();
              return
          }
          var left = $activeNavItem.position().left;
          var width = $activeNavItem.width();

          $activeNavItem.addClass('active').siblings().removeClass('active');

          $navLine.css({
              left: left,
              width: width
          });
        },
      };


      $navItems.once('header_bottom').hover(function() {
        var $this = $(this);
        $this.addClass('hover');
        $nav.addClass('item-hover');

        setNavLine.active($this);
      }, function() {
        var $this = $(this);
        console.log('fdasfdaf');
      });



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