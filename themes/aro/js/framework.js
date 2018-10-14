/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.framework= {
    attach: function (context, settings) {
      var $navLine = $('.header-nav-hover-line');
      var setNavLine = {
        // 按对应菜单激活下划线
        active: function ($activeNavItem) {
          var left = $activeNavItem.position().left;
          var width = $activeNavItem.width();
          $navLine.css({
            left: left,
            width: width
          });
        },
        // 折叠下划线
        fold: function () {
          $navLine.css({
            width: 0
          });
        }
      };

      $(context).find('ul.menu--main > li').once('headernav').hover(function () {
        setNavLine.active($(this));
      }, function () {
        setNavLine.fold();
      });


    }
  };
})(jQuery, Drupal);