<?php

namespace Drupal\isp_ip\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class InetTypeForm.
 */
class InetTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $isp_inet_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $isp_inet_type->label(),
      '#description' => $this->t("Label for the Inet IP type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $isp_inet_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\isp_ip\Entity\InetType::load',
      ],
      '#disabled' => !$isp_inet_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $isp_inet_type = $this->entity;
    $status = $isp_inet_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Inet IP type.', [
          '%label' => $isp_inet_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Inet IP type.', [
          '%label' => $isp_inet_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($isp_inet_type->toUrl('collection'));
  }

}
