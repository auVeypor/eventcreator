<?php

namespace Drupal\eventcreator\Form;
use Drupal\node\Entity\Node;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\eventcreator\Entity\VolunteerEvent;
use Drupal\eventcreator\Entity\AttendeeEvent;

/**
 * Form controller for Event edit forms.
 *
 * @ingroup eventcreator
 */
class EventForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	/* @var $entity \Drupal\eventcreator\Entity\Event */
	$form = parent::buildForm($form, $form_state);
	$entity = $this->entity;

	// $form['date'] = array(
	// 	'#type' => 'datetime',
	// 	'#title' => $this->t('Date'),
	// 	'#description' => $this->t("Date of the event."),
	// 	'#required' => TRUE,
	// );

	// $form['description'] = array(
	// 	'#type' => 'textarea',
	// 	'#title' => $this->t('Description'),
	// 	'#maxlength' => 255,
	// 	'#description' => $this->t("Description of the event."),
	// 	'#required' => TRUE,
	// );

	// $form['venue'] = array(
	// 	'#type' => 'textfield',
	// 	'#title' => $this->t('Venue'),
	// 	'#maxlength' => 255,
	// 	'#description' => $this->t("Venue of the event."),
	// 	'#required' => TRUE,
	// );

	// $form['status'] = array(
	// 	'#type' => 'textfield',
	// 	'#title' => $this->t('Status'),
	// 	'#default_value' => 1,
	// 	'#description' => $this->t("Status of the event."),
	// 	'#required' => TRUE,
	// );

	return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
	$entity = $this->entity;
	$status = parent::save($form, $form_state);

	$description = $form_state->getValue('field_description');
	$venue = $form_state->getValue('field_venue');
	$status = $form_state->getValue('field_status');
		
	// Need to format the date so it goes into DB
	$date = $form_state->getValue('field_date');
	// $formatted_date = new DrupalDateTime($date);
	// echo $date . ' - ' . $formatted_date->format('d/m/Y H:i:s A');

	$att = Node::create(array(
    	'type' => 'event',
    	'title' => 'att ' . $entity->getName(),
    	'langcode' => 'en',
    	'uid' => '1',
    	// 'field_date' => $formatted_date,
    	'field_description' => $description,
    	'field_venue' => $venue,
    	'field_status' => $status,
	));
	$att->save();

	$vol = Node::create(array(
    	'type' => 'event_1',
    	'title' => 'vol ' . $entity->getName(),
    	'langcode' => 'en',
    	'uid' => '1',
    	// 'field_date_vol' => $formatted_date,
    	'field_description_vol' => $description,
    	'field_venue_vol' => $venue,
    	'field_status_vol' => $status,
	));
	$vol->save();

	$form_state->setRedirect('entity.event.canonical', ['event' => $entity->id()]);
  }
}
