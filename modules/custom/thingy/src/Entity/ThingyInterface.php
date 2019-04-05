<?php

namespace Drupal\thingy\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Thingy entities.
 *
 * @ingroup thingy
 */
interface ThingyInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Thingy name.
   *
   * @return string
   *   Name of the Thingy.
   */
  public function getName();

  /**
   * Sets the Thingy name.
   *
   * @param string $name
   *   The Thingy name.
   *
   * @return \Drupal\thingy\Entity\ThingyInterface
   *   The called Thingy entity.
   */
  public function setName($name);

  /**
   * Gets the Thingy creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Thingy.
   */
  public function getCreatedTime();

  /**
   * Sets the Thingy creation timestamp.
   *
   * @param int $timestamp
   *   The Thingy creation timestamp.
   *
   * @return \Drupal\thingy\Entity\ThingyInterface
   *   The called Thingy entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Thingy published status indicator.
   *
   * Unpublished Thingy are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Thingy is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Thingy.
   *
   * @param bool $published
   *   TRUE to set this Thingy to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\thingy\Entity\ThingyInterface
   *   The called Thingy entity.
   */
  public function setPublished($published);

  /**
   * Gets the Thingy revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Thingy revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\thingy\Entity\ThingyInterface
   *   The called Thingy entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Thingy revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Thingy revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\thingy\Entity\ThingyInterface
   *   The called Thingy entity.
   */
  public function setRevisionUserId($uid);

}
