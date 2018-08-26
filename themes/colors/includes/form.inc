<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * @file
 * Theme and preprocess functions for forms
 */

/**
 * Implements hook_form_FORM_ID_alter() for \Drupal\user\UserLoginForm.
 */
function colors_form_user_login_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#theme'] = 'color_user_login_form';
  $form['name']['#attributes'] = [
    'class' => ['inputFieldBorder', 'tiny-input-text'],
    'placeholder' => t('Account/Email'),
  ];
  $form['pass']['#attributes'] = [
    'class' => ['inputFieldBorder', 'tiny-input-text'],
    'placeholder' => t('Password'),
  ];
  $form['actions']['submit']['#attributes'] = [
    'class' => ['loginBtn', 'loginBtnBg'],
  ];
  unset($form['name']['#title']);
  unset($form['name']['#description']);
  unset($form['pass']['#title']);
  unset($form['pass']['#description']);
  unset($form['actions']['submit']['#attributes']['class']);
  $form['actions']['submit']['#attributes'] = [
    'class' => ['next-btn', 'next-btn-primary', 'next-btn-large'],
  ];

}

/**
 * Implements hook_form_FORM_ID_alter() for \Drupal\user\RegisterForm.
 */
function colors_form_user_register_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $form['#theme'] = 'color_user_register_form';
  unset($form['account']['mail']['#title']);
  unset($form['account']['mail']['#description']);
  $form['account']['mail']['#placeholder'] = t('Email -- Used to receive web mail.');

  unset($form['account']['name']['#title']);
  unset($form['account']['name']['#description']);
  $form['account']['name']['#placeholder'] = t('Account -- Used to login.');

//  unset($form['account']['pass']['pass1']['#title']);
//  unset($form['account']['pass']['pass2']['#title']);
}