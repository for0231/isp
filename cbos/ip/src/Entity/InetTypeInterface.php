<?php

namespace Drupal\isp_ip\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Inet IP type entities.
 */
interface InetTypeInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the inet type's workflow ID.
   *
   * Used by the $inet->state field.
   *
   * @return string
   *   The inet type workflow ID.
   */
  public function getWorkflowId();

  /**
   * Sets the workflow ID of the inet type.
   *
   * @param string $workflow_id
   *   The workflow ID.
   *
   * @return $this
   */
  public function setWorkflowId($workflow_id);
}
