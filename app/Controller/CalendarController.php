<?php
class CalendarController extends AppController {

	public function premiertournaments($name)
	{

		$this->layout ="text";	
		$this->loadModel("TlEvent");
		$data = $this->TlEvent->findAllActivePremier();

		if(Configure::read('debug') < 1) {
			header('Content-Type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename="cal.ics"');
		} else {
			header('Content-Type: text/plain; charset=utf-8');
		}

		$this->set("events", Hash::extract($data, "{n}.TlEvent"));
		$this->set("title", "Premier Starcraft 2 Tournaments");
		
		$this->render("index");
	}


}
