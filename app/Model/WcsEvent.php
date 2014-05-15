<?php
App::uses('RemoteEvent', 'Model');
class WcsEvent extends RemoteEvent {

	protected $_srcUrl = "http://wcs.battle.net/sc2/en/schedule";

	public function getEventsFromHtml($html)
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
					"timestamp_start" => strtotime($timeMatch[1])
				);
			}
		}

		return $eventData;
	}
}