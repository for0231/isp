<?php

namespace Drupal\eabax_core\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection as DefaultSelectionBase;

/**
 * Extend core DefaultSelection for conditions.
 */
class DefaultSelection extends DefaultSelectionBase {

  /**
   * {@inheritdoc}
   */
  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS') {
    $configuration = $this->getConfiguration();
    $target_type = $configuration['target_type'];
    $entity_type = $this->entityManager->getDefinition($target_type);

    $query = $this->entityManager->getStorage($target_type)->getQuery();

    // If 'target_bundles' is NULL, all bundles are referenceable, no further
    // conditions are needed.
    if (is_array($configuration['target_bundles'])) {
      // If 'target_bundles' is an empty array, no bundle is referenceable,
      // force the query to never return anything and bail out early.
      if ($configuration['target_bundles'] === []) {
        $query->condition($entity_type->getKey('id'), NULL, '=');
        return $query;
      }
      else {
        $query->condition($entity_type->getKey('bundle'), $configuration['target_bundles'], 'IN');
      }
    }

    // Filter by conditions settings
    if (isset($configuration['conditions']) && is_array($configuration['conditions'])) {
      foreach ($configuration['conditions'] as $key => $value) {
        $query->condition($key, $value);
      }
    }

    if (isset($match)) {
      // Filter by match_fields settings
      if (is_array($configuration['match_fields'])) {
        $or = $query->orConditionGroup();
        foreach ($configuration['match_fields'] as $field) {
          $or->condition($field, $match, $match_operator);
        }
        $query->condition($or);
      }
      elseif ($label_key = $entity_type->getKey('label')) {
        $query->condition($label_key, $match, $match_operator);
      }
    }

    // Add entity-access tag.
    $query->addTag($target_type . '_access');

    // Add the Selection handler for system_query_entity_reference_alter().
    $query->addTag('entity_reference');
    $query->addMetaData('entity_reference_selection_handler', $this);

    // Add the sort option.
    if ($configuration['sort']['field'] !== '_none') {
      $query->sort($configuration['sort']['field'], $configuration['sort']['direction']);
    }

    return $query;
  }

}
