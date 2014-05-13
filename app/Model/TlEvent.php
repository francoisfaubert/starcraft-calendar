<?php

class TlEvent extends AppModel {

	public function getMajorEventsFromListHtml($html)
	{
		$results = $this->_parseEventHtml($html);
		if (count($results)) {
			return Hash::insert($results, "{n}.type", "major");
		}

		return null;
	}

	public function getPremierEventsFromListHtml($html)
	{	
		$results = $this->_parseEventHtml($html);

		if (count($results)) {
			return Hash::insert($results, "{n}.type", "premier");
		}

		return null;
	}

	public function getDetailsFromHtml($html)
	{
		$data = array(
			"timestamp_start" => null,
			"timestamp_end" => null
		);

		// wiki TOC table is the only one with border-collapsing
		if(preg_match_all('/<table style=\"border.+?>(.+?)<\/table>/', $html, $matches)) {
			
			foreach ($matches[1] as $idx => $rows) {
				$text = strip_tags($rows);
				if (preg_match('/Start&#160;Date:(\d{4}\-\d{2}-\d{2})/', $text, $matches)) {
					$data["timestamp_start"] = strtotime($matches[1]);
				}

				if (preg_match('/End&#160;Date:(\d{4}\-\d{2}-\d{2})/', $text, $matches)) {
					$data["timestamp_end"] = strtotime($matches[1]);
				}
			}
		}

		return $data;
	}

	public function filterNew($data)
	{
		$filtered 	= array();
		$urls 		= Hash::extract($data, "{n}.url");
		$existing 	= Hash::extract($this->findAllByUrl($urls), "{n}.TlEvent.url");

		foreach($data as $event) {
			if(!in_array($event["url"], $existing)) {
				$filtered[] = $event;
			}
		}

		return $filtered;
	}

	public function findAllNotValidated($limit = null)
	{
		return $this->find("all", array("conditions" => array("is_validated" => false), "limit" => $limit));
	}

	public function findAllActive()
	{
		$result = Cache::read('active_notpassed', 'daily');
        if (!$result) {
            $result = $this->find("all", array(
				"conditions" => array(
					"or" => array(
						"timestamp_end" => null,
						"timestamp_end >" => time()
						),
					 "is_validated" => true),
				"order" => array("timestamp_start" => "DESC")
			));
            Cache::write('active_notpassed', $result, 'daily');
        }
        return $result;
	}

	public function findAllActivePremier()
	{
 		$result = Cache::read('active_premier', 'daily');
        if (!$result) {
            $result = $this->find("all", array(
				"conditions" => array("type" => "premier", "is_validated" => true),
				"order" => array("timestamp_start" => "DESC")
			));
            Cache::write('active_premier', $result, 'daily');
        }
        return $result;
	}

	public function findAllActiveMajor()
	{
 		$result = Cache::read('active_major', 'daily');
        if (!$result) {
            $result = $this->find("all", array(
				"conditions" => array("type" => "major", "is_validated" => true),
				"order" => array("timestamp_start" => "DESC")
			));
            Cache::write('active_major', $result, 'daily');
        }
        return $result;
	}

	/**
	 * Luckily, the html format for both lists is common. 
	 * All calls can use de same function.
	 */
	private function _parseEventHtml($html)
	{
		$thisYear = date("Y");
		$lastmonth = strtotime("last month");
		$eventData = array();
		
		// Information is split by table blocks with a h3 header
		if(preg_match_all('/<h3>.+?(\d{4}).+?<\/table>/', $html, $matches)) {
			foreach ($matches[0] as $idx => $eventchunk) {
				// If the year of the header is current or future
				// continue
				if((int)$matches[1][$idx] >= $thisYear) {
					// Fetch alll the rows in the table and split it in known columns
					preg_match_all('/<tr><td>(.+?)<\/td><\/tr>/', $eventchunk, $rowmatches);
					
					foreach($rowmatches[1] as $row) {
						$cols = explode("</td><td>", $row);
						$eventDate = "1 " . trim($cols[0]) . " " . (int)$matches[1][$idx];
						$eventTimestamp = strtotime($eventDate);

						if($eventTimestamp >= $lastmonth) {
							if(preg_match('/<a href=\"(.+?)\".+?>(.+?)<\/a>/', trim($cols[1]), $linkname)) {
								if(strpos($linkname[1], "index.php") === false) {
									$eventData[] = array(
										"url" => $linkname[1],
										"name" => $linkname[2],
										"type" => null,
										"is_validated" => false
									);
								}
							}
						}
					}
				}
			}
		}

		return $eventData;
	}
}