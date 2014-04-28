<?php

App::uses('HttpSocket', 'Network/Http');
class CronController extends AppController {
	
	const TL_BASE_URL = "http://wiki.teamliquid.net";

	public function premiertournamentlist()
	{
		$this->layout ="text";	
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->get(self::TL_BASE_URL . '/starcraft2/Premier_Tournaments');

		$this->loadModel("TlEvent");
		$list = $this->TlEvent->getPremierEventsFromListHtml(str_replace("\n", "", $response->body));
		$filteredList = $this->TlEvent->filterNew($list);
		
		if(count($filteredList) > 0) {
			$this->TlEvent->saveAll($filteredList);
		}

		$this->render("index");
	}

	public function majortournamentlist()
	{
		$this->layout ="text";	
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->get(self::TL_BASE_URL . '/starcraft2/Major_Tournaments');

		$this->loadModel("TlEvent");
		$list = $this->TlEvent->getMajorEventsFromListHtml(str_replace("\n", "", $response->body));
		$filteredList = $this->TlEvent->filterNew($list);

		if(count($filteredList) > 0) {
			$this->TlEvent->saveAll($filteredList);
		}

		$this->render("index");
	}

	public function syncdetails()
	{
		$this->layout ="text";	
		$this->loadModel("TlEvent");
		$HttpSocket = new HttpSocket();
		$checkRequired = $this->TlEvent->findAllNotValidated(2);

		foreach ($checkRequired as $event) {
			$response = $HttpSocket->get(self::TL_BASE_URL . $event['TlEvent']['url']);
			$details = $this->TlEvent->getDetailsFromHtml(str_replace("\n", "", $response->body));

			// Though we can tolerate a missing end date,
			// we need a start date.
			if(!is_null($details["timestamp_start"])) {
				$this->TlEvent->save(array(
					"id" => $event["TlEvent"]["id"],
					"timestamp_start" => $details["timestamp_start"],
					"timestamp_end" => $details["timestamp_end"],
					"is_validated" => true
				));
			}
		}

		$this->render("index");
	}


}
