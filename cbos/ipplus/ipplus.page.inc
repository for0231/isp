<?php

/**
 * @file
 * Contains ipplus.page.inc.
 *
 * Page callback for IP+.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for IP+ templates.
 *
 * Default template: ipplus.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_ipplus(array &$variables) {
  // Fetch Ipplus Entity Object.
  $ipplus = $variables['elements']['#ipplus'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
