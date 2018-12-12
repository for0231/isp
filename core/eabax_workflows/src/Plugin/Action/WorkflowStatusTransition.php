<?php

namespace Drupal\eabax_workflows\Plugin\Action;

use Drupal\Core\Action\ConfigurableActionBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * @Action(
 *   id = "entity:wst",
 *   action_label = @Translation("Workflow status transition"),
 *   deriver = "Drupal\eabax_workflows\Plugin\Action\Derivative\EntityStatusTransitionDeriver",
 * )
 */
class WorkflowStatusTransition extends ConfigurableActionBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'workflow' => '',
      'field' => '',
      'transition' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    // TODO: Implement buildConfigurationForm() method.
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitConfigurationForm() method.
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\period\Entity\PeriodInterface $object */
    return $object->access('update', $account, $return_as_object);
  }

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    /** @var \Drupal\workflows\WorkflowInterface $workflow */
    $workflow = $this->entityTypeManager->getStorage('workflow')->load($this->configuration['workflow']);
    $transition = $workflow->getTypePlugin()->getTransition($this->configuration['transition']);
    $from = $transition->from();
    $from = array_map(function ($item) {
      /** @var \Drupal\workflows\StateInterface $item */
      return $item->id();
    }, $from);
    if (in_array($entity->get($this->configuration['field'])->value, $from)) {
      $entity->set($this->configuration['field'], $transition->to()->id());
      $entity->save();
    }
  }

}