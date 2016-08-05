<?php

namespace Drupal\eventcreator\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Attendee event edit forms.
 *
 * @ingroup eventcreator
 */
class AttendeeEventForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\eventcreator\Entity\AttendeeEvent */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Attendee event.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Attendee event.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.attendee_event.canonical', ['attendee_event' => $entity->id()]);
  }

}
