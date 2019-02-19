<?php

/**
 * @file
 * Theme and preprocess functions for form.
 */

use Drupal\Core\Form\FormStateInterface;

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

//function tark_preprocess_input__submit(&$variables) {
//  $variables['attributes']['class'][] = 'btn';
//  $variables['attributes']['class'][] = 'btn-primary';
//  $variables['attributes']['class'][] = 'btn-sm';
//}

/**
 * Implements hook_form_alter().
 */
function tark_form_alter(&$form, FormStateInterface $form_state, $form_id) {

  if (isset($form['actions']['delete'])) {
    $form['actions']['delete']['#attributes']['class'] = [
      'btn',
      'btn-danger',
      'btn-sm'
    ];
  }
  if (isset($form['actions']['cancel'])) {
    $form['actions']['cancel']['#attributes']['class'] = [
      'btn',
      'btn-warning',
      'btn-sm'
    ];
  }
  if (isset($form['actions']['edit-add-block'])) {
    $form['actions']['edit-add-block']['#attributes']['class'] = [
      'btn',
      'btn-warning',
      'btn-sm'
    ];
  }

  if (isset($form['header']['bulk_form'])) {
    $form['header']['bulk_form']['#attributes']['class'] = 'form--inline clearfix';
  }
}