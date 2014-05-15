<?php
App::uses('RemoteEvent', 'Model');
class DreamhackEvent extends RemoteEvent {

	protected $_srcUrl = "http://open.dreamhack.se/";

	/**
	 * Dreamhack lists events for the current year. Assume that 
	 * every date found in the html chunk is based on it.
	 *
	 * I will have to keep on eye on what happens on January 1st 
	 * and decide then if/what I need to improve date validation.
	 */
	public function getEventsFromHtml($html)
	{
		$eventData = array();		
		$dom = new DOMDocument();

		if (@$dom->loadHTML($html)) {

			$finder = new DomXPath($dom);
			$eventContainers = $finder->query('//*[@class="site-live-event"]');

			foreach ($eventContainers as $eventNode) {

				$h3 = $eventNode->getElementsByTagName("h3")->item(0)->nodeValue;
				$span = $eventNode->getElementsByTagName("span")->item(0)->nodeValue;

				// The span contain the name of the event
				// while the whole h3 contains said span and the date range
				$strDateRange = substr($h3, 0, strpos($h3, $span));

				// The range is expected to be under the form of 'September 13 - 14'
				preg_match('/([A-Za-z]+)\s(\d{1,2})\s\-\s(\d{1,2})/', $strDateRange, $matches);

				if (count($matches) > 3) {
					$eventData[] = array(
						"name" 				=> $span,
						"timestamp_start" 	=> strtotime($matches[1] . " " . $matches[2] . " " . date("Y")),
						"timestamp_end" 	=> strtotime($matches[1] . " " . $matches[3] . " " . date("Y"))
					);
				}
			}
		}

		return $eventData;
	}

}