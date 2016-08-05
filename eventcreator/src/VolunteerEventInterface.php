<?php

namespace Drupal\eventcreator;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Volunteer event entities.
 *
 * @ingroup eventcreator
 */
interface VolunteerEventInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Volunteer event name.
   *
   * @return string
   *   Name of the Volunteer event.
   */
  public function getName();

  /**
   * Sets the Volunteer event name.
   *
   * @param string $name
   *   The Volunteer event name.
   *
   * @return \Drupal\eventcreator\VolunteerEventInterface
   *   The called Volunteer event entity.
   */
  public function setName($name);

  /**
   * Gets the Volunteer event creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Volunteer event.
   */
  public function getCreatedTime();

  /**
   * Sets the Volunteer event creation timestamp.
   *
   * @param int $timestamp
   *   The Volunteer event creation timestamp.
   *
   * @return \Drupal\eventcreator\VolunteerEventInterface
   *   The called Volunteer event entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Volunteer event published status indicator.
   *
   * Unpublished Volunteer event are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Volunteer event is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Volunteer event.
   *
   * @param bool $published
   *   TRUE to set this Volunteer event to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\eventcreator\VolunteerEventInterface
   *   The called Volunteer event entity.
   */
  public function setPublished($published);

}
