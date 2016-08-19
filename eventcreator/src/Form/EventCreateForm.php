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

    $form['checkAtt'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Attendee')
    );

    $form['event-desc-att'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Attendee Event Description'),
      '#states' => array(
        'visible' => array(
          ':input[name="checkAtt"]' => array('checked' => TRUE),
        ),
        'optional' => array(
          ':input[name="checkAtt"]' => array('checked' => FALSE),
        )
      )
    );

    $form['event-date-att'] = array(
      '#type' => 'datetime',
      '#title' => $this->t('Attendee Date'),
      '#states' => array(
        'visible' => array(
          ':input[name="checkAtt"]' => array('checked' => TRUE),
        ),
        'optional' => array(
          ':input[name="checkAtt"]' => array('checked' => FALSE),
        )
      )
    );

    $form['checkVol'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Volunteer')
    );

     $form['event-desc-vol'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Volunteer Event Description'),
      '#states' => array(
        'visible' => array(
          ':input[name="checkVol"]' => array('checked' => TRUE),
        ),
        'optional' => array(
          ':input[name="checkVol"]' => array('checked' => FALSE),
        )
      )
    );

    $form['event-date-vol'] = array(
      '#type' => 'datetime',
      '#title' => $this->t('Volunteer Date'),
      '#states' => array(
        'visible' => array(
          ':input[name="checkVol"]' => array('checked' => TRUE),
        ),
        'optional' => array(
          ':input[name="checkVol"]' => array('checked' => FALSE),
        )
      )
    );

  	$form['event-venue'] = array(
  		'#type' => 'textfield',
      '#description' => $this->t('E.g. 1 Hargreaves St, Unanderra NSW 2526'),
  		'#title' => $this->t('Venue'),
      '#required' => TRUE,
  	);

    $form['event-status'] = [
      '#type' => 'select',
      '#title' => $this->t('Select status'),
      '#options' => [
        '1' => $this->t('Going ahead'),
        '2' => $this->t('Pending'),
        '3' => $this->t('Cancelled'),
      ],
    ];

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
    $event_include_att = $form_state->getValue('checkAtt');
    $event_include_vol = $form_state->getValue('checkVol');
    if($event_include_vol == 0 && $event_include_att == 0)
    {
      $form_state->setErrorByName('event-include', $this->t("Must select at least one event to create"));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  	// Grab the data from the form
    $status_strings = array("Going ahead", "Pending", "Cancelled");
  	$event_name = $form_state->getValue('event-name');
  	$event_description = $form_state->getValue('event-description');
  	$event_venue = $form_state->getValue('event-venue');

    if($form_state->hasValue('event-desc-att')) { 
      $event_desc_att = $form_state->getValue('event-desc-att');
    } else {
      $event_desc_att = "";
    }

    if($form_state->hasValue('event-desc-vol')) { 
     $event_desc_vol = $form_state->getValue('event-desc-vol');
    } else {
      $event_desc_vol = "";
    }

    if($form_state->hasValue('event-date-att')) { 
      $event_date_att = $form_state->getValue('event-date-att');
    } else {
      $event_date_att = "";
    }

    if($form_state->hasValue('event-date-vol')) { 
     $event_date_vol = $form_state->getValue('event-date-vol');
    } else {
      $event_date_vol = "";
    }

    $event_status = $form_state->getValue('event-status');
    $event_include_att = $form_state->getValue('checkAtt');
    $event_include_vol = $form_state->getValue('checkVol');


    //split the date to array. Original format: "yyyy-mm-dd hh:mm:ss Country/City"
    $date_list_vol = explode(" ", $event_date_vol);
    $date_list_att = explode(" ", $event_date_att);
    
    //\Drupal::logger('eventcreator')->error($event_include[1]);

  	// Save the parent event
  	$parent_event = Event::create([
  		'label' => $event_name,
  		'name' => $event_name,
  		'field_venue' => $event_venue,
  		//'field_date' => $date,
      'field_status' => $event_status
  	]);
  	$parent_event->save();

    $att = NULL;
    $vol = NULL;
    if($event_include_att > 0)
    {
    	// Now for the two sub events
    	$att = Node::create(array(
        	'type' => 'attendeeevent',
        	'title' => $event_name.' Attendee',
        	'langcode' => 'en',
          'uid' => '1',
          'field_original_date' => $event_date_att,
          'field_text_date' => $date_list_att[0],
          'field_text_time' => $date_list_att[1],
          'field_description' => $event_desc_att,
          'field_venue' => $event_venue,
          'field_status_int' => $event_status,
          'field_status' => $status_strings[intval($event_status)-1],
    	));
    	$att->save();
    }
    if($event_include_vol > 0)
    {
    	$vol = Node::create(array(
        	'type' => 'volunteerevent',
        	'title' => $event_name.' Volunteer',
        	'langcode' => 'en',
        	'uid' => '1',
          'field_original_date' => $event_date_vol,
          'field_text_date' => $date_list_vol[0],
          'field_text_time' => $date_list_vol[1],
        	'field_description' => $event_desc_vol,
        	'field_venue' => $event_venue,
          'field_status_int' => $event_status,
          'field_status' => $status_strings[intval($event_status)-1],
    	));
    	$vol->save();
    }
  	// Once we've saved and verified everything, we can redirect and set a success message!
    drupal_set_message($this->t('Successfully created event: @event', array('@event' => $event_name)));
    $url = '';
    
    if($att && !$vol) {
      $url = 'view/' . $att->id();
    } else if($vol && !$att) {
      $url = 'view/' . $vol->id();
    } else if ($vol && $att) {
      $url = 'view/' . $att->id() . '/' . $vol->id();
    }
  
    $response = new RedirectResponse($url);
    $response->send();
  }
}
