/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.global= {
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

      $(context).find('.header-nav-list > li').once('headernav').hover(function () {
        setNavLine.active($(this));
      }, function () {
        setNavLine.fold();
      });

      /* 主菜单“更多”的显示 */
      var $header = $('#header');
      var $nav = $header.find('.header-nav');
      var $navItems = $nav.find('ul li');
      var $navItems_notMore = $navItems.not('.header-nav-item-more');
      var $navItemMore = $navItems.filter('.header-nav-item-more');

      $(window).resize(function () {
        resetMainMenu();
      });

      resetMainMenu();

      function resetMainMenu() {
        $nav.removeClass('overflow-visible');
        $navItems_notMore.removeClass('header-nav-item-hide');
        $navItemMore.addClass('header-nav-item-hide');

        if ($nav.height() <= $navItems.height()) {
          return;
        }
        // 有菜单隐藏的情况
        $navItemMore.removeClass('header-nav-item-hide');

        hideLastNavItem($navItems_notMore);

        function hideLastNavItem($navItems_notMore) {
          if ($navItems_notMore.length === 0) return;

          $navItems_notMore.last().addClass('header-nav-item-hide');
          if ($nav.height() > $navItems.height()) {
            hideLastNavItem($navItems_notMore.not(':last'))
          }
        }

        $nav.addClass('overflow-visible');
      }



    }
  };
})(jQuery, Drupal);