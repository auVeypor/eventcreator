<?php

namespace Drupal\eventcreator;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Volunteer event entities.
 *
 * @ingroup eventcreator
 */
class VolunteerEventListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Volunteer event ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\eventcreator\Entity\VolunteerEvent */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.volunteer_event.edit_form', array(
          'volunteer_event' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
