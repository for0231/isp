<?php

namespace Drupal\property\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Property entity.
 *
 * @ingroup property
 *
 * @ContentEntityType(
 *   id = "property",
 *   label = @Translation("Property"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\property\PropertyListBuilder",
 *     "views_data" = "Drupal\property\Entity\PropertyViewsData",
 *     "translation" = "Drupal\property\PropertyTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\property\Form\PropertyForm",
 *       "add" = "Drupal\property\Form\PropertyForm",
 *       "edit" = "Drupal\property\Form\PropertyForm",
 *       "delete" = "Drupal\property\Form\PropertyDeleteForm",
 *     },
 *     "access" = "Drupal\property\PropertyAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\property\PropertyHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "property",
 *   data_table = "property_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer property",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/property/{property}",
 *     "add-form" = "/property/add",
 *     "edit-form" = "/property/{property}/edit",
 *     "delete-form" = "/property/{property}/delete",
 *     "collection" = "/property",
 *   },
 *   field_ui_base_route = "property.settings"
 * )
 */
class Property extends ContentEntityBase implements PropertyInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Property entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
