<?php

namespace Drupal\thingy;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\thingy\Entity\ThingyInterface;

/**
 * Defines the storage handler class for Thingy entities.
 *
 * This extends the base storage class, adding required special handling for
 * Thingy entities.
 *
 * @ingroup thingy
 */
class ThingyStorage extends SqlContentEntityStorage implements ThingyStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ThingyInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {thingy_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {thingy_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ThingyInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {thingy_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('thingy_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
