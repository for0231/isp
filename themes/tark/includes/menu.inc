<?php
/**
 * @file
 * Theme and preprocess functions for menu.
 */

/**
 * Implements hook_preprocess_hook().
 */
function tark_preprocess_menu_local_task(array &$variables) {
  $variables['attributes']['class'] = ['nav-item'];
  $url = $variables['element']['#link']['url'];
  $url->setOption('attributes', ['class'=> ['nav-link']]);
  if ($variables['is_active'])  {
    $url->setOption('attributes', ['class' => ['active', 'nav-link', 'show']]);
  }
}


/**
 * Implements hook_preprocess_hook().
 */
function tark_preprocess_menu_local_action(array &$variables) {
  $link = $variables['element']['#link'];
  $link += [
    'localized_options' => [],
  ];
  unset($link['localized_options']['attributes']['class']);
  $link['localized_options']['attributes']['class'] = [
    'btn',
    'bg-magenta',
    'text-white',
  ];
  $link['localized_options']['set_active_class'] = TRUE;

  $variables['link'] = [
    '#type' => 'link',
    '#title' => $link['title'],
    '#options' => $link['localized_options'],
    '#url' => $link['url'],
  ];
}

/**
 * Implements hook_preprocess_hook().
 */
function tark_preprocess_menu__role_menu(array &$variables) {
  $icons = [
    'eabax_core.implementor.data_modeling' => 'fa-lg',
    'eabax_core.implementor.implementation' => 'fa-lg',
    'eabax_core.implementor.tools' => 'fa-lg',
    'eabax_core.system_administrator.system_administration' => 'fa-lg',
  ];
  _eabax_core_set_menu_items_icon($variables['items'], $icons);
}