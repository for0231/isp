<?php

namespace Drupal\isp_ip\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Inet IP type entity.
 *
 * @ConfigEntityType(
 *   id = "isp_inet_type",
 *   label = @Translation("Inet IP type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\isp_ip\InetTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\isp_ip\Form\InetTypeForm",
 *       "edit" = "Drupal\isp_ip\Form\InetTypeForm",
 *       "delete" = "Drupal\isp_ip\Form\InetTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\isp_ip\InetTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "inet_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "isp_inet",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/isp/config/isp_inet_type/{isp_inet_type}",
 *     "add-form" = "/admin/isp/config/isp_inet_type/add",
 *     "edit-form" = "/admin/isp/config/isp_inet_type/{isp_inet_type}/edit",
 *     "delete-form" = "/admin/isp/config/isp_inet_type/{isp_inet_type}/delete",
 *     "collection" = "/admin/isp/config/isp_inet_type"
 *   }
 * )
 */
class InetType extends ConfigEntityBundleBase implements InetTypeInterface {

  /**
   * The Inet IP type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Inet IP type label.
   *
   * @var string
   */
  protected $label;

}
