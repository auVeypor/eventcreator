<?php

namespace Drupal\eventcreator\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Volunteer event entities.
 */
class VolunteerEventViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['volunteer_event']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Volunteer event'),
      'help' => $this->t('The Volunteer event ID.'),
    );

    return $data;
  }

}
