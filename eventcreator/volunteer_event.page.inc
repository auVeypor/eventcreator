<?php

/**
 * @file
 * Contains volunteer_event.page.inc.
 *
 * Page callback for Volunteer event entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Volunteer event templates.
 *
 * Default template: volunteer_event.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_volunteer_event(array &$variables) {
  // Fetch VolunteerEvent Entity Object.
  $volunteer_event = $variables['elements']['#volunteer_event'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
