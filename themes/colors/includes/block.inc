<?php

use Drupal\Core\Block\BlockPluginInterface;

/**
 * @file
 * Theme and preprocess functions for blocks.
 */

/**
 * TODO To be polished.
 */
function colors_preprocess_links__language_block(&$variables) {
  $languageManager = \Drupal::service('language_manager');
  $class = '';
  $language = $languageManager->getCurrentLanguage();
  if ($language->getId() == 'zh-hans') {
    $class = 'header-icon-lang-zh';
  }
  else if ($language->getId() == 'en') {
    $class = 'header-icon-lang-en';
  }
  $current_language = [
    'name' => $language->getName(),
    'class' => $class,
  ];
  $variables['current_language'] = $current_language;
}