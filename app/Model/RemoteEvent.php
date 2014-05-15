<?php

App::uses('iRemoteSourceParser', 'Model');
App::uses('HttpSocket', 'Network/Http');

abstract class RemoteEvent extends AppModel implements iRemoteSourceParser {

	/**
	 * srcUrl is the url that will be called when the html parser
	 * tries to update.
	 */
	protected $_srcUrl;

	/**
	 * Updates the data set of the event object. Connects to a remote url.
	 *
	 * @return bool
	 */
	public function updateData()
	{
		$html = $this->getSourcePageHTML();
		$list = $this->getEventsFromHtml(str_replace("\n", "", $html));

		if ($list) {
			$filteredList = $this->filterNew($list);			
			if(count($filteredList) > 0) {
				return $this->saveAll($filteredList);
			}
		}
		
		return false;
	}

	public function getSourcePageHTML()
	{
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->get($this->_srcUrl);

		if ($response->isOk()) {
			return $response->body;
		}
	}

	/**	 
	 * Takes an array of events and filters out the new and valid ones
	 * @param (array) $data Array of event hashes
	 * @return (array) Array of new results
	 */
	public function filterNew($data)
	{
		$filtered 	= array();
		$timestamps = Hash::extract($data, "{n}.timestamp_start");
		$names 		= Hash::extract($data, "{n}.name");
		$existing 	= Hash::extract($this->findAllByTimestampStartAndName($timestamps, $names), "{n}." . $this->alias . ".timestamp_start");

		foreach ($data as $event) {
			if (!in_array($event["timestamp_start"], $existing) && $this->_eventNotPassed($event)) {
				$filtered[] = $event;
			}
		}

		return $filtered;
	}

	/**	 
	 * List all active events for this object.
	 * @param (int) $limit Limit of event to pull
	 * @return (array) Array of events
	 */
	public function findAllActive($limit = 20)
	{
		$cacheName = 'active_' . $this->alias;
		$result = Cache::read($cacheName, 'daily');
        if (!$result) {
            $result = $this->find("all", array(
            	"conditions" => array(
					"timestamp_start >" => strtotime("yesterday"),
				),
				"limit" => $limit,
				"order" => array("timestamp_start" => "ASC")
			));
            Cache::write($cacheName, $result, 'daily');
        }

        return Hash::extract($result, "{n}." . $this->alias);
	}

	/**
	 * Validates if the event is in the past or not
	 * @return (bool) True if event ends in the future, false if the event ended already.
	 */
	private function _eventNotPassed($event)
	{		
		if (array_key_exists("timestamp_end", $event)) {
			return $event["timestamp_end"] > time();
		}
		return true;
	}
}