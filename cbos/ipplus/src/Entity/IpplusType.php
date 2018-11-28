<?php

namespace Drupal\ipplus\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the IP+ type entity.
 *
 * @ConfigEntityType(
 *   id = "ipplus_type",
 *   label = @Translation("IP+ type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ipplus\IpplusTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ipplus\Form\IpplusTypeForm",
 *       "edit" = "Drupal\ipplus\Form\IpplusTypeForm",
 *       "delete" = "Drupal\ipplus\Form\IpplusTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ipplus\IpplusTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ipplus_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "ipplus",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/idcp/ipplus_type/{ipplus_type}",
 *     "add-form" = "/admin/idcp/ipplus_type/add",
 *     "edit-form" = "/admin/idcp/ipplus_type/{ipplus_type}/edit",
 *     "delete-form" = "/admin/idcp/ipplus_type/{ipplus_type}/delete",
 *     "collection" = "/admin/idcp/ipplus_type"
 *   }
 * )
 */
class IpplusType extends ConfigEntityBundleBase implements IpplusTypeInterface {

  /**
   * The IP+ type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The IP+ type label.
   *
   * @var string
   */
  protected $label;

}
