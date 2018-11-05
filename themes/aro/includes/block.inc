<?php
/**
 * @file
 * Theme and preprocess functions for block.
 */

function aro_preprocess_links__language_block(&$variables) {
  // TODO translate current language
  $current_language = \Drupal::languageManager()->getCurrentLanguage();
  $tag_lang = '';
  switch ($current_language->getId()) {
    case 'en':
      $tag_lang = 'header-icon-lang-en';
      break;
    case 'zh-hans':
      $tag_lang = 'header-icon-lang-zh';
      break;
  }
  $current_language_array = [
    'id' => $current_language->getId(),
    'name' => $current_language->getName(),
    'icon' => $tag_lang,
  ];
  $variables['current'] = $current_language_array;
}

