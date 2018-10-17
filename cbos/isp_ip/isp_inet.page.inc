<?php

/**
 * @file
 * Contains isp_inet.page.inc.
 *
 * Page callback for Inet IP.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Inet IP templates.
 *
 * Default template: isp_inet.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_isp_inet(array &$variables) {
  // Fetch Inet Entity Object.
  $isp_inet = $variables['elements']['#isp_inet'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
