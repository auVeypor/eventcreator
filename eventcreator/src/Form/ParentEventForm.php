<?php

namespace Drupal\eventcreator\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Parent Event edit forms.
 *
 * @ingroup eventcreator
 */
class ParentEventForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\eventcreator\Entity\ParentEvent */
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
        drupal_set_message($this->t('Created the %label Parent Event.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Parent Event.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.parent_event.canonical', ['parent_event' => $entity->id()]);
  }

}
