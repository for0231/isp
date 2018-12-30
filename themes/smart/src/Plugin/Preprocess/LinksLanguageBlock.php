<?php

namespace Drupal\smart\Plugin\Preprocess;

use Drupal\bootstrap\Plugin\Preprocess\Links;
use Drupal\bootstrap\Utility\Variables;

/**
 * Pre-process variables for the "links--language-block" theme hook.
 *
 * @ingroup plugins_preprocess
 *
 * @BootstrapPreprocess("links__language_block")
 */
class LinksLanguageBlock extends Links {
  
  /**
   * {@inheritdoc}
   */
  public function preprocessVariables(Variables $variables) {
    parent::preprocessVariables($variables);
    $language = \Drupal::languageManager()->getDefaultLanguage();
    $variables['current']['name'] = $language->getName();
  }
}