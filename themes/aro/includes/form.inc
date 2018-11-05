<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function aro_form_user_login_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#attributes']['class'] = ['container-fluid'];
  $form['#theme'] = 'aro_user_login_form';
  $form['name']['#placeholder'] = t('Name/eMail');
  $form['pass']['#placeholder'] = t('Password');
  $form['name']['#attributes'] = [
    'class' => [
      'tiny-input-text',
    ],
  ];
  $form['pass']['#attributes'] = [
    'class' => [
      'tiny-input-text',
    ],
  ];
  unset($form['name']['#title']);
  unset($form['pass']['#title']);
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function aro_form_user_register_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#attributes']['class'] = ['container-fluid'];
  $form['#theme'] = 'aro_user_register_form';
  $form['account']['name']['#placeholder'] = t('Name');
  $form['account']['mail']['#placeholder'] = t('Email');
  $form['account']['name']['#attributes'] = [
    'class' => [
      'tiny-input-text',
    ],
  ];
  $form['account']['mail']['#attributes'] = [
    'class' => [
      'tiny-input-text',
    ],
  ];
  unset($form['account']['name']['#title']);
  unset($form['account']['mail']['#title']);
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function aro_form_user_pass_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#attributes']['class'] = ['container-fluid'];
  $form['#theme'] = 'aro_user_pass';
  $form['name']['#placeholder'] = t('Name');
  $form['name']['#attributes'] = [
    'class' => [
      'tiny-input-text',
    ],
  ];
  unset($form['name']['#title']);
}
