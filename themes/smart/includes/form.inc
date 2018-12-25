<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_alter().
 */
function colors_form_alter(&$form, FormStateInterface $form_state, $form_id) {

  if (isset($form['actions']['delete'])) {
    $form['actions']['delete']['#attributes']['class'] = [
      'btn',
      'btn-danger',
    ];
  }
  if (isset($form['actions']['cancel'])) {
    $form['actions']['cancel']['#attributes']['class'] = [
      'btn',
      'btn-warning',
    ];
  }
  if (isset($form['actions']['edit-add-block'])) {
    $form['actions']['edit-add-block']['#attributes']['class'] = [
      'btn',
      'btn-warning',
    ];
  }
  
  if (isset($form['header']['bulk_form'])) {
    $form['header']['bulk_form']['#attributes']['class'] = 'form--inline clearfix';
  }
}

function colors_preprocess_input__submit(&$variables) {
  $variables['attributes']['class'][] = 'btn';
  $variables['attributes']['class'][] = 'btn-primary';
}