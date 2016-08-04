<?php

namespace Drupal\eventcreator\Controller;

use Drupal\Core\Controller\ControllerBase;

class EventViewController extends ControllerBase {
	public function content($aid, $vid) {
		global $base_url;

		$links = "<a href=" . $base_url . "/node/" . $aid . ">Attendee Event</a><br>";
		$links .= "<a href=" . $base_url . "/node/" . $vid . ">Volunteer Event</a>";
		$build = array(
			'#type' => 'markup',
			'#markup' => $this->t($links)
		);

		return $build;
	}
}