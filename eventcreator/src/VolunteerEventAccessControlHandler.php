<?php

namespace Drupal\eventcreator;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Volunteer event entity.
 *
 * @see \Drupal\eventcreator\Entity\VolunteerEvent.
 */
class VolunteerEventAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\eventcreator\VolunteerEventInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished volunteer event entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published volunteer event entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit volunteer event entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete volunteer event entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add volunteer event entities');
  }

}
