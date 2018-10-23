<?php

namespace Drupal\isp_ip\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining IP type entities.
 */
interface IpTypeInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.


  /**
   * Gets the ip type's workflow ID.
   *
   * Used by the $ip->state field.
   *
   * @return string
   *   The ip type workflow ID.
   */
  public function getWorkflowId();

  /**
   * Sets the workflow ID of the ip type.
   *
   * @param string $workflow_id
   *   The workflow ID.
   *
   * @return $this
   */
  public function setWorkflowId($workflow_id);
}
