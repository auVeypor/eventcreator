<?php

namespace Drupal\eventcreator;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Attendee event entities.
 *
 * @ingroup eventcreator
 */
interface AttendeeEventInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Attendee event name.
   *
   * @return string
   *   Name of the Attendee event.
   */
  public function getName();

  /**
   * Sets the Attendee event name.
   *
   * @param string $name
   *   The Attendee event name.
   *
   * @return \Drupal\eventcreator\AttendeeEventInterface
   *   The called Attendee event entity.
   */
  public function setName($name);

  /**
   * Gets the Attendee event creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Attendee event.
   */
  public function getCreatedTime();

  /**
   * Sets the Attendee event creation timestamp.
   *
   * @param int $timestamp
   *   The Attendee event creation timestamp.
   *
   * @return \Drupal\eventcreator\AttendeeEventInterface
   *   The called Attendee event entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Attendee event published status indicator.
   *
   * Unpublished Attendee event are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Attendee event is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Attendee event.
   *
   * @param bool $published
   *   TRUE to set this Attendee event to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\eventcreator\AttendeeEventInterface
   *   The called Attendee event entity.
   */
  public function setPublished($published);

}
