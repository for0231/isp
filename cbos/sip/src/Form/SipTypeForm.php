<?php

namespace Drupal\sip\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SipTypeForm.
 */
class SipTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $sip_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $sip_type->label(),
      '#description' => $this->t("Label for the Sip type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $sip_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\sip\Entity\SipType::load',
      ],
      '#disabled' => !$sip_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $sip_type = $this->entity;
    $status = $sip_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Sip type.', [
          '%label' => $sip_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Sip type.', [
          '%label' => $sip_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($sip_type->toUrl('collection'));
  }

}
