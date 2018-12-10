<?php

namespace Drupal\ip_plus;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;

class IPStorageSchema extends SqlContentEntityStorageSchema {
  
  protected function getEntitySchema(ContentEntityTypeInterface $entity_type, $reset = FALSE) {
    $schema = parent::getEntitySchema($entity_type, $reset);
    
//    if ($data_table = $this->storage->getDataTable()) {
//      $schema[$data_table]['indexes'] += [
//        // Add indexes for server id and ip type for inet.
//        'ip__server_type' => []
//      ];
//    }
    
    return $schema;
  }
}