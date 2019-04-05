<?php

namespace Drupal\thingy;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Thingy entity.
 *
 * @see \Drupal\thingy\Entity\Thingy.
 */
class ThingyAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\thingy\Entity\ThingyInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished thingy entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published thingy entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit thingy entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete thingy entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add thingy entities');
  }

}
