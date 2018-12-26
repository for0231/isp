<?php

namespace Drupal\smart;

use Drupal\Component\Utility\DiffArray;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Config\Config;
use Drupal\Core\Config\StorageException;
use Drupal\Core\Theme\ThemeSettings as CoreThemeSettings;

/**
 * Provides a configuration API wrapper for runtime merged theme settings.
 *
 * This is a wrapper around theme_get_settting() since it does not inherit
 * base theme config nore handle default/overridden values very well.
 *
 * @ingroup utility
 */
class ThemeSettings extends Config {
  
  /**
   * The default settings.
   *
   * @var array
   */
  protected $defaults;
  
  /**
   * The current theme object.
   *
   * @var \Drupal\smart\Theme
   */
  protected $theme;
  
  /**
   * {@inheritdoc}
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme->getName() . '.settings', \Drupal::service('config.storage'), \Drupal::service('event_dispatcher'), \Drupal::service('config.typed'));
    $this->theme = $theme;
  
    // Retrieve cache.
    $cache = $theme->getCache('settings');
  
    // Use cached settings.
    if ($defaults = $cache->get('defaults')) {
      $this->defaults = $defaults;
      $this->initWithData($cache->get('data', []));
      return;
    }
  
    // Retrieve the global settings from configuration.
    $this->defaults = \Drupal::config('system.theme.global')->get();
  
    // Retrieve the theme setting plugin discovery defaults (code).
    foreach ($theme->getSettingPlugin() as $name => $setting) {
      $this->defaults[$name] = $setting->getDefaultValue();
    }
  
    // Retrieve the theme ancestry.
    $ancestry = $theme->getAncestry();
  
    // Remove the active theme from the ancestry.
    $active_theme = array_pop($ancestry);
  
    // Iterate and merge all ancestor theme config into the defaults.
    foreach ($ancestry as $ancestor) {
      $this->defaults = NestedArray::mergeDeepArray([$this->defaults, $this->getThemeConfig($ancestor)], TRUE);
    }
  
    // Merge the active theme config.
    // TODO
//    $this->initWithData($this->getThemeConfig($active_theme, TRUE));
  
    // Cache the data and defaults.
    $cache->set('data', $this->data);
    $cache->set('defaults', $this->defaults);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return ['rendered'];
  }
  
  /**
   * Retrieves a specific theme's stored config settings.
   *
   * @param \Drupal\smart\Theme $theme
   *   A theme object.
   * @param bool $active_theme
   *   Flag indicating whether or not $theme is the active theme.
   *
   * @return array
   *   A array diff of overridden config theme settings.
   */
  public function getThemeConfig(Theme $theme, $active_theme = FALSE) {
    $config = new CoreThemeSettings($theme->getName());
    
    // Retrieve configured theme-specific settings, if any.
    try {
      if ($theme_settings = \Drupal::config($theme->getName() . '.settings')->get()) {
        // Remove schemas if not the active theme.
        if (!$active_theme) {
          unset($theme_settings['schemas']);
        }
        $config->merge($theme_settings);
      }
    }
    catch (StorageException $e) {
    }
    
    // If the theme does not support a particular feature, override the
    // global setting and set the value to NULL.
    $info = $theme->getInfo();
    if (!empty($info['features'])) {
      foreach (_system_default_theme_features() as $feature) {
        if (!in_array($feature, $info['features'])) {
          $config->set('features.' . $feature, NULL);
        }
      }
    }
    
    // Generate the path to the logo image.
    if ($config->get('features.logo')) {
      $logo_url = FALSE;
      foreach (['svg', 'png', 'jpg'] as $type) {
        if (file_exists($theme->getPath() . "/logo.$type")) {
          $logo_url = file_create_url($theme->getPath() . "/logo.$type");
          break;
        }
      }
      if ($config->get('logo.use_default') && $logo_url) {
        $config->set('logo.url', $logo_url);
      }
      elseif (($logo_path = $config->get('logo.path')) && file_exists($logo_path)) {
        $config->set('logo.url', file_create_url($logo_path));
      }
    }
    
    // Generate the path to the favicon.
    if ($config->get('features.favicon')) {
      $favicon_url = $theme->getPath() . '/favicon.ico';
      if ($config->get('favicon.use_default') && file_exists($favicon_url)) {
        $config->set('favicon.url', file_create_url($favicon_url));
      }
      elseif ($favicon_path = $config->get('favicon.path')) {
        $config->set('favicon.url', file_create_url($favicon_path));
      }
    }
    
    // Retrieve the config data.
    $data = $config->get();
    
    // Retrieve a diff of settings that override the defaults.
    $diff = DiffArray::diffAssocRecursive($data, $this->defaults);
    
    // Ensure core features are always present in the diff. The theme settings
    // form will not work properly otherwise.
    // @todo Just rebuild the features section of the form?
    foreach (['favicon', 'features', 'logo'] as $key) {
      $arrays = [];
      $arrays[] = isset($this->defaults[$key]) ? $this->defaults[$key] : [];
      $arrays[] = isset($data[$key]) ? $data[$key] : [];
      $diff[$key] = NestedArray::mergeDeepArray($arrays, TRUE);
    }
    
    return $diff;
  }
}