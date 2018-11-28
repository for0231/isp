<?php

/**
 * @file
 * Contains sip.page.inc.
 *
 * Page callback for Sip entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Sip templates.
 *
 * Default template: sip.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_sip(array &$variables) {
  // Fetch Sip Entity Object.
  $sip = $variables['elements']['#sip'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
