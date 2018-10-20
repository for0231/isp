<?php

namespace Drupal\isp_ip\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Inet IP.
 *
 * @ingroup isp_ip
 */
interface InetInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Inet IP name.
   *
   * @return string
   *   Name of the Inet IP.
   */
  public function getName();

  /**
   * Sets the Inet IP name.
   *
   * @param string $name
   *   The Inet IP name.
   *
   * @return \Drupal\isp_ip\Entity\InetInterface
   *   The called Inet IP entity.
   */
  public function setName($name);

  /**
   * Gets the Inet IP creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Inet IP.
   */
  public function getCreatedTime();

  /**
   * Sets the Inet IP creation timestamp.
   *
   * @param int $timestamp
   *   The Inet IP creation timestamp.
   *
   * @return \Drupal\isp_ip\Entity\InetInterface
   *   The called Inet IP entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Inet IP published status indicator.
   *
   * Unpublished Inet IP are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Inet IP is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Inet IP.
   *
   * @param bool $published
   *   TRUE to set this Inet IP to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\isp_ip\Entity\InetInterface
   *   The called Inet IP entity.
   */
  public function setPublished($published);

}
