<?php
App::uses('RemoteEvent', 'Model');
class MlgEvent extends RemoteEvent {

	protected $_srcUrl = "http://www.majorleaguegaming.com/seasons";

	/**
	 * MLG blocks direct request from Cake or DomDocument. Curl the request instead.
	 */
	public function getSourcePageHTML()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_srcUrl);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html = curl_exec($ch);
		curl_close($ch);

		return $html;
	}

	/**
	 * MLG lists events for the current year. Assume that 
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
			$eventContainers = $finder->query('//*[@class="season_widget"]');

			foreach ($eventContainers as $eventNode) {

				// Check whether or not they are talking about Starcraft in the event block
				if (strpos($eventNode->nodeValue, "StarCraft 2") !== false) {
					
					// Get the name of the event
					$h1 = trim($eventNode->getElementsByTagName("h1")->item(0)->nodeValue);

					// Dont check if the title looks like a previous date
					if (preg_match('/^\d{4}$/', $h1) < 1) {
						// Loop the games of the event until we find Starcraft's row.
						// Afterwards, we can break as there shouldn't be two entries
						// of the same game during a tournament					
						foreach($eventNode->getElementsByTagName("li") as $liNode) {
							if (strpos($liNode->nodeValue, "StarCraft 2") !== false) {

								$strDateRange = $liNode->getElementsByTagName("h5")->item(0)->nodeValue;
								// The range is expected to be under the form of 'Jan 19â€“26'
								preg_match('/([A-Za-z]{3})\s(\d{1,2}).+?(\d{1,2})/', $strDateRange, $matches);

								$eventData[] = array(
									"name" 				=> $h1,
									"timestamp_start"	=> strtotime($matches[1] . " " . $matches[2] . " " . date("Y")),
									"timestamp_end"		=> strtotime($matches[1] . " " . $matches[2] . " " . date("Y"))
								);
								break;
							}
						}
					}
				}
			}
		}

		return $eventData;
	}

}