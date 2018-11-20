<?php

namespace Drupal\import\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides local action definitions for entity collection page.
 */
class ImportLocalAction extends DeriverBase implements ContainerDeriverInterface {

  use StringTranslationTrait;

  /**
   * The entity_type manager
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a ImportLocalAction object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $this->derivatives = [];

    foreach ($this->entityTypeManager->getDefinitions() as $entity_type_id => $entity_type) {
      if ($link = $entity_type->getLinkTemplate('collection')) {
        $this->derivatives["import.entity_import.$entity_type_id"] = [
          'route_name' => "import.entity_import",
          'route_parameters' => ['entity_type_id' => $entity_type_id],
          'title' => $this->t('Import'),
          'options' => [
            'query' => ['destination' => $link],
          ],
          'appears_on' => ["entity.$entity_type_id.collection"],
        ];
      }
    }

    foreach ($this->derivatives as &$entry) {
      $entry += $base_plugin_definition;
    }

    return $this->derivatives;
  }

}
