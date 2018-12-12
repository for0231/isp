<?php

namespace Drupal\eabax_workflows\Plugin\views\filter;

use Drupal\views\FieldAPIHandlerTrait;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\ManyToOne;
use Drupal\views\ViewExecutable;
use Drupal\workflows\Entity\Workflow;

/**
 * @ViewsFilter("entity_status")
 */
class EntityStatus extends ManyToOne {

  use FieldAPIHandlerTrait;

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);

    $field_storage = $this->getFieldStorageDefinition();
    // The default_document_status workflow configuration will not exist during the document module install.
    if ($workflow = Workflow::load($field_storage->getSetting('workflow'))) {
      $states = $workflow->getTypePlugin()->getStates();
      $this->valueOptions = array_map(function ($state) {
        return $state->label();
      }, $states);
    }
  }
}
