<?php

namespace Drupal\thingy\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ThingyTypeForm.
 */
class ThingyTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $thingy_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $thingy_type->label(),
      '#description' => $this->t("Label for the Thingy type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $thingy_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\thingy\Entity\ThingyType::load',
      ],
      '#disabled' => !$thingy_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $thingy_type = $this->entity;
    $status = $thingy_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Thingy type.', [
          '%label' => $thingy_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Thingy type.', [
          '%label' => $thingy_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($thingy_type->toUrl('collection'));
  }

}
