<?php

namespace Drupal\isp_room\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Room type entity.
 *
 * @ConfigEntityType(
 *   id = "isp_room_type",
 *   label = @Translation("Room type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\isp_room\RoomTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\isp_room\Form\RoomTypeForm",
 *       "edit" = "Drupal\isp_room\Form\RoomTypeForm",
 *       "delete" = "Drupal\isp_room\Form\RoomTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\isp_room\RoomTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "type",
 *   admin_permission = "administer rooms",
 *   bundle_of = "isp_room",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/isp/config/isp_room_type/{isp_room_type}",
 *     "add-form" = "/admin/isp/config/isp_room_type/add",
 *     "edit-form" = "/admin/isp/config/isp_room_type/{isp_room_type}/edit",
 *     "delete-form" = "/admin/isp/config/isp_room_type/{isp_room_type}/delete",
 *     "collection" = "/admin/isp/config/isp_room_type"
 *   }
 * )
 */
class RoomType extends ConfigEntityBundleBase implements RoomTypeInterface {

  /**
   * The Room type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Room type label.
   *
   * @var string
   */
  protected $label;

}
