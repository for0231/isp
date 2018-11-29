<?php

namespace Drupal\ip_plus\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the IP type entity.
 *
 * @ConfigEntityType(
 *   id = "ip_type",
 *   label = @Translation("IP type"),
 *   label_collection = @Translation("IP type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ip_plus\IPTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ip_plus\Form\IPTypeForm",
 *       "edit" = "Drupal\ip_plus\Form\IPTypeForm",
 *       "delete" = "Drupal\ip_plus\Form\IPTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ip_plus\IPTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "ip",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/ip/type/{ip_type}",
 *     "add-form" = "/ip/type/add",
 *     "edit-form" = "/ip/type/{ip_type}/edit",
 *     "delete-form" = "/ip/type/{ip_type}/delete",
 *     "collection" = "/ip/type"
 *   }
 * )
 */
class IPType extends ConfigEntityBundleBase implements IPTypeInterface {

  /**
   * The IP type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The IP type label.
   *
   * @var string
   */
  protected $label;

}
