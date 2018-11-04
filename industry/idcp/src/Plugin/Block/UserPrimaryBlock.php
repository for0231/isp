<?php

namespace Drupal\idcp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'UserPrimaryBlock' block.
 *
 * @Block(
 *  id = "user_primary_block",
 *  admin_label = @Translation("User Primary Block"),
 * )
 */
class UserPrimaryBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /** @var \Drupal\Core\Entity\EntityTypeManagerInterface */
  protected $entityTypeManager;

  /** @var \Drupal\Core\Routing\RouteMatchInterface */
  protected $routeMatch;
  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_route_match')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['menus' => ''];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $entities = $this->entityTypeManager->getStorage('menu')->loadMultiple();

    $menus = array_map(function($item) {
      return $item->label();
    }, $entities);


    $form['menus'] = [
      '#type' => 'select',
      '#title' => $this->t('Menus'),
      '#description' => $this->t('Select the menus for display for user page.'),
      '#options' => $menus,
      '#multiple' => TRUE,
      '#size' => min(12, count($menus)),
      '#default_value' => $this->configuration['menus'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['menus'] = $form_state->getValue('menus');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $routeName = $this->routeMatch->getRouteObject();
    $build['user_primary_block']['#markup'] = $this->configuration['menus'];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
