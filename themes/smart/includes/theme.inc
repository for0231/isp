<?php

/**
 * Implements hook_preprocess_HOOK() for links.
 */

function colors_preprocess_links__language_block(array &$variables) {
  $language = \Drupal::languageManager()->getDefaultLanguage();
  $variables['current']['name'] = $language->getName();
}
