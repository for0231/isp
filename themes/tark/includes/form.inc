<?php

/**
 * @file
 * Theme and preprocess functions for form.
 */

/**
 * Implements hook_preprocess_form().
 */
function tark_preprocess_form(array &$variables) {
  //$variables['attributes']['novalidate'] = 'novalidate';
}

/**
 * Implements hook_preprocess_select().
 */
function tark_preprocess_select(array &$variables) {
  //$variables['attributes']['class'][] = 'select-chosen';
}


/**
 * Implements hook_preprocess_details().
 */
function tark_preprocess_details(array &$variables) {
  /*$variables['attributes']['class'][] = 'details';
  $variables['summary_attributes']['class'] = 'summary';*/
}


/**
 * Implements hook_theme_suggestions_details_alter().
 */
function tark_theme_suggestions_details_alter(array &$suggestions, array $variables) {

}

/**
 * Implement hook_preprocess_links().
 */
function tark_preprocess_links__dropbutton__operations(array &$variables) {
//  $variables['first'] =  array_shift($variables['links']);
}