<?php

namespace Drupal\isp_server\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Server type entity.
 *
 * @ConfigEntityType(
 *   id = "isp_server_type",
 *   label = @Translation("Server type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\isp_server\ServerTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\isp_server\Form\ServerTypeForm",
 *       "edit" = "Drupal\isp_server\Form\ServerTypeForm",
 *       "delete" = "Drupal\isp_server\Form\ServerTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\isp_server\ServerTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "type",
 *   admin_permission = "administer servers",
 *   bundle_of = "isp_server",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "label",
 *     "id",
 *     "workflow",
 *   },
 *   links = {
 *     "canonical" = "/admin/isp/config/isp_server_type/{isp_server_type}",
 *     "add-form" = "/admin/isp/config/isp_server_type/add",
 *     "edit-form" = "/admin/isp/config/isp_server_type/{isp_server_type}/edit",
 *     "delete-form" = "/admin/isp/config/isp_server_type/{isp_server_type}/delete",
 *     "collection" = "/admin/isp/config/isp_server_type"
 *   }
 * )
 */
class ServerType extends ConfigEntityBundleBase implements ServerTypeInterface {

  /**
   * The Server type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Server type label.
   *
   * @var string
   */
  protected $label;

  /**
   * The server type workflow ID.
   * @var string
   */
  protected $workflow;


  /**
   * {@inheritdoc}
   */
  public function getWorkflowId() {
    return $this->workflow;
  }

  /**
   * {@inheritdoc}
   */
  public function setWorkflowId($workflow_id) {
    $this->workflow = $workflow_id;
    return $this;
  }
}
