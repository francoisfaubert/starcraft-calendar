<?php
App::uses('RemoteEvent', 'Model');
class TaketvEvent extends RemoteEvent {

	protected $_srcUrl = "http://taketv.net/cups/bracket";

	public function getEventsFromHtml($html)
	{
		$eventData = array();		
		$dom = new DOMDocument();

		if (@$dom->loadHTML($html)) {

			$finder = new DomXPath($dom);
			$eventContainer = $finder->query('//*[@id="cups"]');
		
			foreach($eventContainer->item(0)->getElementsByTagName("tr") as $tr) {
				$tds = $tr->getElementsByTagName("td");

				if($tds->length > 0 && trim($tds->item(0)->nodeValue) != "Finished") {
					
					$strDateRange = $tds->item(3)->nodeValue;
					// The range is expected to be under the form of 21:00 17.05.2014 MESZ
					preg_match('/(\d{2}):(\d{2})\s(\d{1,2})\.(\d{1,2})\.(\d{4})/', $strDateRange, $matches);						
					$start = mktime((int)$matches[1] - 2, (int)$matches[2], 0, (int)$matches[4], (int)$matches[3] , (int)$matches[5]);

					$eventData[] = array(
						"name" 				=> trim($tds->item(6)->nodeValue),
						"timestamp_start"	=> $start,
						"timestamp_end"		=> $start + (3 * DAY) // assume HSC always spans 3 days
					);
				}
			}
		}

		return $eventData;
	}

}