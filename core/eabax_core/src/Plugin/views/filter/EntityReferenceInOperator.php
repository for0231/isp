<?php

namespace Drupal\eabax_core\Plugin\views\filter;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\views\FieldAPIHandlerTrait;
use Drupal\views\Plugin\views\filter\InOperator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @ViewsFilter("entity_reference_in_operator")
 */
class EntityReferenceInOperator extends InOperator {

  use FieldAPIHandlerTrait;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    if (!isset($this->valueOptions)) {
      $entity_type_id = $this->getFieldDefinition()->getItemDefinition()->getSetting('target_type');
      $entities = \Drupal::entityTypeManager()->getStorage($entity_type_id)->loadMultiple();
      $options = array_map(function ($entity) {
        return $entity->label();
      }, $entities);
      asort($options);

      $this->valueOptions = $options;
    }

    return $this->valueOptions;
  }

}
