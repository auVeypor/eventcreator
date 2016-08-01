<?php

namespace Drupal\eventcreator\Form;

use Drupal\node\Entity\Node;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\eventcreator\Entity\Event;
use Drupal\eventcreator\Entity\VolunteerEvent;
use Drupal\eventcreator\Entity\AttendeeEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class EventCreateForm.
 *
 * @package Drupal\eventcreator\Form
 */
class EventCreateForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
	return 'event_create_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	$form['event-name'] = array(
	  '#type' => 'textfield',
	  '#title' => $this->t('Event name'),
      '#required' => TRUE,
	);

	$form['event-description'] = array(
		'#type' => 'textarea',
		'#title' => $this->t('Event description'),
        '#required' => TRUE,
	);

	$form['event-date-vol'] = array(
		'#type' => 'datetime',
		'#title' => $this->t('Volunteer Date'),
        '#required' => TRUE,
	);

	$form['event-date-att'] = array(
	        '#type' => 'datetime',
         	'#title' => $this->t('Attendee Date'),
	'#required' => TRUE,
	  );

	$form['event-venue'] = array(
		'#type' => 'textfield',
		'#title' => $this->t('Venue'),
        '#required' => TRUE,
	);

    $form['event-status'] = array(
        '#type' => 'number',
        '#title' => $this->t('Status'),
        '#required' => TRUE,
    );

	$form['submit-event'] = array(
	  '#type' => 'submit',
	  '#value' => $this->t('Create Event'),
	);


	return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $status = $form_state->getValue('event-status');
    if (!($status >= 0 && $status <= 2)) {
        $form_state->setErrorByName('event-status', $this->t("Must enter a valid event status"));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  	// Grab the data from the form
  	$event_name = $form_state->getValue('event-name');
  	$event_description = $form_state->getValue('event-description');
  	$event_venue = $form_state->getValue('event-venue');
    $event_date_att = $form_state->getValue('event-date-att');
  	$event_date_vol = $form_state->getValue('event-date-vol');
    $event_status = $form_state->getValue('event-status');

    //split the date to array. Original format: "yyyy-mm-dd hh:mm:ss Country/City"
    $date_list_vol = explode(" ", $event_date_vol);
    $date_list_att = explode(" ", $event_date_att);
//    \Drupal::logger('eventcreator')->error($datelist[0].' _ '.$datelist[1]);

  	// Save the parent event
  	$parent_event = Event::create([
  		'label' => $event_name,
  		'name' => $event_name,
  		'field_description' => $event_description,
  		'field_venue' => $event_venue,
  		//'field_date' => $date,
      'field_status' => $event_status
  	]);
  	$parent_event->save();

  	// Now for the two sub events
  	$att = Node::create(array(
      	'type' => 'attendeeevent',
      	'title' => $event_name.' Attendee',
      	'langcode' => 'en',
        'uid' => '1',
        'field_original_date' => $event_date_att,
        'field_text_date' => $date_list_att[0],
        'field_text_time' => $date_list_att[1],
        'field_description' => $event_description,
        'field_venue' => $event_venue,
        'field_status' => $event_status,
  	));
  	$att->save();

  	$vol = Node::create(array(
      	'type' => 'volunteerevent',
      	'title' => $event_name.' Volunteer',
      	'langcode' => 'en',
      	'uid' => '1',
        'field_original_date' => $event_date_vol,
        'field_text_date' => $date_list_vol[0],
        'field_text_time' => $date_list_vol[1],
      	'field_description' => $event_description,
      	'field_venue' => $event_venue,
      	'field_status' => $event_status,
  	));
  	$vol->save();

  	// Once we've saved and verified everything, we can redirect and set a success message!
  	drupal_set_message($this->t('Successfully created event: @event', array('@event' => $event_name)));
  	$response = new RedirectResponse('view/' . $parent_event->id());
  	$response->send();
  }
}
