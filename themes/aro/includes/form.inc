<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function aro_form_user_login_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#attributes']['class'] = ['container-fluid'];
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function aro_form_user_register_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#attributes']['class'] = ['container-fluid'];
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function aro_form_user_pass_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#attributes']['class'] = ['container-fluid'];
}
