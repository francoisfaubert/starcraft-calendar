<?php

class CronController extends AppController {
	
	/**
	 * Daily cron action. Goes though a list of known events and
	 * updates our data set.
	 */
	public function daily()
	{
		$this->layout ="text";	
		
		foreach (array("WcsEvent", "DreamhackEvent", "MlgEvent", "TaketvEvent") as $event) {
			$this->loadModel($event);
			$this->{$event}->updateData();
		}

		$this->render("index");
	}


	/**
	 * Connect to the WCS portal to fetch the upcoming 
 	 * events.
	 */
	public function wcsdailyevents()
	{
		$this->layout ="text";	
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->get(self::WCS_BASE_URL);

		if ($response->isOk()) {
			$this->loadModel("WcsEvent");

			$list = $this->WcsEvent->getEventsFromListHtml(str_replace("\n", "", $response->body));
			if ($list) {
				$filteredList = $this->WcsEvent->filterNew($list);			
				if(count($filteredList) > 0) {
					$this->WcsEvent->saveAll($filteredList);
				}
			}
		}

		$this->render("index");
	}

	public function premiertournamentlist()
	{
		$this->layout ="text";	
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->get(self::TL_BASE_URL . '/starcraft2/Premier_Tournaments');

		if ($response->isOk()) {
			$this->loadModel("TlEvent");
			$list = $this->TlEvent->getPremierEventsFromListHtml(str_replace("\n", "", $response->body));

			if ($list) {
				$filteredList = $this->TlEvent->filterNew($list);			
				if(count($filteredList) > 0) {
					$this->TlEvent->saveAll($filteredList);
				}
			}
		}

		$this->render("index");
	}

	public function majortournamentlist()
	{
		$this->layout ="text";	
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->get(self::TL_BASE_URL . '/starcraft2/Major_Tournaments');

		if ($response->isOk()) {
			$this->loadModel("TlEvent");
			$list = $this->TlEvent->getMajorEventsFromListHtml(str_replace("\n", "", $response->body));
			if ($list) {
				$filteredList = $this->TlEvent->filterNew($list);
				if(count($filteredList) > 0) {
					$this->TlEvent->saveAll($filteredList);
				}
			}
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
			if ($response->isOk()) {
				$details = $this->TlEvent->getDetailsFromHtml(str_replace("\n", "", $response->body));
				// Though we can tolerate a missing end date,
				// we need a start date.
				if (!is_null($details["timestamp_start"]) && $details["timestamp_start"] > 0) {
					$this->TlEvent->save(array(
						"id" => $event["TlEvent"]["id"],
						"timestamp_start" => $details["timestamp_start"],
						"timestamp_end" => $details["timestamp_end"],
						"is_validated" => true
					));
				}
			}
		}

		$this->render("index");
	}


}
