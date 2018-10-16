<?php

/**
 * @file
 * Contains isp_room.page.inc.
 *
 * Page callback for Room entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Room templates.
 *
 * Default template: isp_room.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_isp_room(array &$variables) {
  // Fetch Room Entity Object.
  $isp_room = $variables['elements']['#isp_room'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
