<?php

namespace Drupal\thingy;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ThingyStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Thingy revision IDs for a specific Thingy.
   *
   * @param \Drupal\thingy\Entity\ThingyInterface $entity
   *   The Thingy entity.
   *
   * @return int[]
   *   Thingy revision IDs (in ascending order).
   */
  public function revisionIds(ThingyInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Thingy author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Thingy revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\thingy\Entity\ThingyInterface $entity
   *   The Thingy entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ThingyInterface $entity);

  /**
   * Unsets the language for all Thingy with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
