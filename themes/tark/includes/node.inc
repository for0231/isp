<?php

/**
 * @file
 * Theme and preprocess functions for node.
 */

/**
 * Implements hook_theme_suggestions_node_alter().
 */
function tark_theme_suggestions_node_alter(array &$suggestions, array $variables) {
  /*$node = $variables['elements']['#node'];

  if ($variables['elements']['#view_mode'] == "full") {

  }*/
}


/**
 * Implements hook_preprocess_node().
 */
function tark_preprocess_node(array &$variables) {
  // Default to turning off byline/submitted.
  //$variables['display_submitted'] = FALSE;
}