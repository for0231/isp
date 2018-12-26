<?php

namespace Drupal\smart;

use Drupal\Core\Extension\ThemeHandlerInterface;

/**
 * Thre primary class for the Drupal Smart base theme.
 *
 * Provides many helper methods.
 *
 * @ingroup utility
 */
class Smart {
  
  /**
   * Tag used to invalidate caches.
   *
   * @var string
   */
  const CACHE_TAG = 'theme_registry';
  
  /**
   * Append a callback.
   *
   * @var int
   */
  const CALLBACK_APPEND = 1;
  
  /**
   * Initializes the active theme.
   */
  final public static function initialize() {
    static $initialized = FALSE;
    if (!$initialized) {
      // Initialize the active theme.
      $active_theme = self::getTheme();
      
      // Include deprecated functions.
      foreach ($active_theme->getAncestry() as $ancestor) {
        if ($ancestor->getSetting('include_deprecated')) {
          $files = $ancestor->fileScan('/^deprecated\.php$/');
          if ($file = reset($files)) {
            $ancestor->includeOnce($file->uri, FALSE);
          }
        }
      }
      
      $initialized = TRUE;
    }
  }
  
  /**
   * Retrieves a theme instance of \Drupal\bootstrap.
   *
   * @param string $name
   *   The machine name of a theme. If omitted, the active theme will be used.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler object.
   *
   * @return \Drupal\smart\Theme
   *   A theme object.
   */
  public static function getTheme($name = NULL, ThemeHandlerInterface $theme_handler = NULL) {
    // Immediately return if theme passed is already instantiated.
    if ($name instanceof Theme) {
      return $name;
    }
  
    static $themes = [];
  
    // Retrieve the active theme.
    // Do not statically cache this as the active theme may change.
    if (!isset($name)) {
      $name = \Drupal::theme()->getActiveTheme()->getName();
    }
  
    if (!isset($theme_handler)) {
      $theme_handler = self::getThemeHandler();
    }
  
    if (!isset($themes[$name])) {
      $themes[$name] = new Theme($theme_handler->getTheme($name), $theme_handler);
    }
  
    return $themes[$name];
  }
  
  /**
   * Retrieves the theme handler instance.
   *
   * @return \Drupal\Core\Extension\ThemeHandlerInterface
   *   The theme handler instance.
   */
  public static function getThemeHandler() {
    static $theme_handler;
    if (!isset($theme_handler)) {
      $theme_handler = \Drupal::service('theme_handler');
    }
    return $theme_handler;
  }
  
}