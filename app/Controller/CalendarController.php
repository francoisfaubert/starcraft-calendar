<?php
class CalendarController extends AppController {

	public function beforeFilter()
    {   
        $this->layout   = "text";   

		if(Configure::read('debug') < 1) {
			header('Content-Type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename="cal.ics"');
		} else {
			header('Content-Type: text/plain; charset=utf-8');
		}
    }

	public function wcs($name)
	{
		$this->loadModel("WcsEvent");
		$data = $this->WcsEvent->findAllActive();

		$this->set("events", Hash::extract($data, "{n}.WcsEvent"));
		$this->set("title", "WCS Tournaments");
		
		$this->render("index");
	}

	public function premiertournaments($name)
	{
		$this->loadModel("TlEvent");
		$data = $this->TlEvent->findAllActivePremier();

		$this->set("events", Hash::extract($data, "{n}.TlEvent"));
		$this->set("title", "Premier Starcraft 2 Tournaments");
		
		$this->render("index");
	}

	public function majortournaments($name)
	{
		$this->loadModel("TlEvent");
		$data = $this->TlEvent->findAllActiveMajor();

		$this->set("events", Hash::extract($data, "{n}.TlEvent"));
		$this->set("title", "Major Starcraft 2 Tournaments");
		
		$this->render("index");
	}

}
