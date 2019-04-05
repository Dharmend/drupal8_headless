<?php

/**
 * @file
 * Contains thingy.page.inc.
 *
 * Page callback for Thingy entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Thingy templates.
 *
 * Default template: thingy.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_thingy(array &$variables) {
  // Fetch Thingy Entity Object.
  $thingy = $variables['elements']['#thingy'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
