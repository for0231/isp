<?php

namespace Drupal\sip\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Sip type entity.
 *
 * @ConfigEntityType(
 *   id = "sip_type",
 *   label = @Translation("Sip type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\sip\SipTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\sip\Form\SipTypeForm",
 *       "edit" = "Drupal\sip\Form\SipTypeForm",
 *       "delete" = "Drupal\sip\Form\SipTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\sip\SipTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "sip_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "sip",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/idcp/sip_type/{sip_type}",
 *     "add-form" = "/admin/idcp/sip_type/add",
 *     "edit-form" = "/admin/idcp/sip_type/{sip_type}/edit",
 *     "delete-form" = "/admin/idcp/sip_type/{sip_type}/delete",
 *     "collection" = "/admin/idcp/sip_type"
 *   }
 * )
 */
class SipType extends ConfigEntityBundleBase implements SipTypeInterface {

  /**
   * The Sip type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Sip type label.
   *
   * @var string
   */
  protected $label;

}
