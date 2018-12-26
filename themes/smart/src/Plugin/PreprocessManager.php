<?php

namespace Drupal\smart\Plugin;

use Drupal\smart\Theme;

/**
 * Manages discovery and instantiation of Smart preprocess hooks.
 *
 * @ingroup plugins_preprocess
 */
class PreprocessManager extends PluginManager {
  
  /**
   * Constructs a new \Drupal\smart\Plugin\PreprocessManager object.
   *
   * @param \Drupal\smart\Theme $theme
   *  The theme to use for discovery.
   */

  
  public function __construct(\Drupal\smart\Theme $theme, $subdir, $plugin_interface = NULL, $plugin_definition_annotation_name = 'Drupal\Component\Annotation\Plugin') {
    $subdir = 'Plugin/Preprocess';
    $plugin_interface = 'Drupal\smart\Plugin\Preprocess\PreprocessInterface';
    $plugin_definition_annotation_name = 'Drupal\smart\Annotation\SmartPreprocess';
    parent::__construct($theme, $subdir, $plugin_interface, $plugin_definition_annotation_name);
  }
}