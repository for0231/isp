<?php

namespace Drupal\isp_server\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Server type entities.
 */
interface ServerTypeInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the server type's workflow ID.
   *
   * Used by the $server->state field.
   *
   * @return string
   *   The server type workflow ID.
   */
  public function getWorkflowId();

  /**
   * Sets the workflow ID of the server type.
   *
   * @param string $workflow_id
   *   The workflow ID.
   *
   * @return $this
   */
  public function setWorkflowId($workflow_id);
}
