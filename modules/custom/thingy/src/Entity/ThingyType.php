<?php

namespace Drupal\thingy\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Thingy type entity.
 *
 * @ConfigEntityType(
 *   id = "thingy_type",
 *   label = @Translation("Thingy type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\thingy\ThingyTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\thingy\Form\ThingyTypeForm",
 *       "edit" = "Drupal\thingy\Form\ThingyTypeForm",
 *       "delete" = "Drupal\thingy\Form\ThingyTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\thingy\ThingyTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "thingy_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "thingy",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/thingy_type/{thingy_type}",
 *     "add-form" = "/admin/structure/thingy_type/add",
 *     "edit-form" = "/admin/structure/thingy_type/{thingy_type}/edit",
 *     "delete-form" = "/admin/structure/thingy_type/{thingy_type}/delete",
 *     "collection" = "/admin/structure/thingy_type"
 *   }
 * )
 */
class ThingyType extends ConfigEntityBundleBase implements ThingyTypeInterface {

  /**
   * The Thingy type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Thingy type label.
   *
   * @var string
   */
  protected $label;

}
