<?php

class WcsEvent extends AppModel {

	const TYPE = "wcs";

	public function getEventsFromListHtml($html)
	{
		$results = $this->_parseEventHtml($html);

		if (count($results)) {
			return Hash::insert($results, "{n}.type", "major");
		}

		return null;
	}

	public function filterNew($data)
	{
		$filtered 	= array();
		$timestamps = Hash::extract($data, "{n}.timestamp_start");
		$existing 	= Hash::extract($this->findAllByTimestampStart($timestamps), "{n}.TlEvent.timestamp_start");

		foreach($data as $event) {
			if(!in_array($event["timestamp_start"], $existing)) {
				$filtered[] = $event;
			}
		}

		return $filtered;
	}

	public function findAllActive($limit = 20)
	{
		$result = Cache::read('active_notpassed_wcs', 'daily');
        if (!$result) {
            $result = $this->find("all", array(
				"order" => array("timestamp_start" => "DESC"),
				"limit" => $limit
			));
            Cache::write('active_notpassed_wcs', $result, 'daily');
        }
        return $result;
	}

	private function _parseEventHtml($html)
	{
		$thisYear = date("Y");
		$lastmonth = strtotime("last month");
		$eventData = array();
		
		preg_match_all('/<div class=\'rhs\'>(.+?<\/div>)<\/div>/', $html, $eventMatches);
		if (count($eventMatches) > 1) {
			foreach ($eventMatches[1] as $row) {				
				// Get the timestamp of the event from the time tag
				preg_match('/<time.+?datetime=\'(.+?)\'/', $row, $timeMatch);

				// Get the title and competitor names
				preg_match('/<div class=\'title\'>(.+?)<\/div>/', $row, $titleMatch);
				preg_match('/<ul>(.+?)<\/ul>/', $row, $competitorsMatch);

				$title = $titleMatch[1];
				if (count($competitorsMatch) > 1 && trim($competitorsMatch[1]) != "TBD") {
					preg_match_all('/<li>(.+?)<\/li>/', $competitorsMatch[1], $liMatches);

					if (count($liMatches) > 0) {
						$playerNames = array();		
						foreach ($liMatches[1] as $li) {
							$name = trim(strip_tags($li));
							$playerNames[] = $name;
						}
						if (count($playerNames) > 0) {
							$title .=  " (" . implode(", ", $playerNames) . ")";
						}
					}
				}

				$eventData[] = array(
					"name" => $title,
					"type" => self::TYPE,					
					"timestamp_start" => strtotime($timeMatch[1]),
					"is_validated" => true
				);
			}
		}
		return $eventData;
	}
}