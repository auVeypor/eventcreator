<?php

/**
 * @file
 * Contains attendee_event.page.inc.
 *
 * Page callback for Attendee event entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Attendee event templates.
 *
 * Default template: attendee_event.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_attendee_event(array &$variables) {
  // Fetch AttendeeEvent Entity Object.
  $attendee_event = $variables['elements']['#attendee_event'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
