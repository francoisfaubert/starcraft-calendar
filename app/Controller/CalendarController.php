<?php
class CalendarController extends AppController {

	public function beforeFilter()
    {   
        $this->layout   = "text";   
		$this->loadModel("TlEvent");

		if(Configure::read('debug') < 1) {
			header('Content-Type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename="cal.ics"');
		} else {
			header('Content-Type: text/plain; charset=utf-8');
		}
    }

	public function premiertournaments($name)
	{
		$data = $this->TlEvent->findAllActivePremier();

		$this->set("events", Hash::extract($data, "{n}.TlEvent"));
		$this->set("title", "Premier Starcraft 2 Tournaments");
		
		$this->render("index");
	}

	public function majortournaments($name)
	{
		$data = $this->TlEvent->findAllActiveMajor();

		$this->set("events", Hash::extract($data, "{n}.TlEvent"));
		$this->set("title", "Major Starcraft 2 Tournaments");
		
		$this->render("index");
	}

}
