<?php

namespace Drupal\eventcreator\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Attendee event entities.
 */
class AttendeeEventViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['attendee_event']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Attendee event'),
      'help' => $this->t('The Attendee event ID.'),
    );

    return $data;
  }

}
