<?php

namespace Drupal\eventcreator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;


class EventViewController extends ControllerBase {
	public function content($aid, $vid) {
		// This is needed so we can construct the URL
		global $base_url;
			
		// Load the nodes (events) from the IDs passed from the URL
		$att = Node::load($aid);
		$vol = Node::load($vid);

		// Construct the HTML to display (two links corresponding to each event)
		$links .= "<a href=" . $base_url . "/node/" . $aid . ">" . $att->label() . "</a><br>";
		$links .= "<a href=" . $base_url . "/node/" . $vid . ">" . $vol->label() . "</a>";
		$build = array(
			'#type' => 'markup',
			'#markup' => $this->t($links)
		);

		return $build;
	}
}