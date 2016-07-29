<?php

namespace Drupal\eventcreator;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Attendee event entity.
 *
 * @see \Drupal\eventcreator\Entity\AttendeeEvent.
 */
class AttendeeEventAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\eventcreator\AttendeeEventInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished attendee event entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published attendee event entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit attendee event entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete attendee event entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add attendee event entities');
  }

}
