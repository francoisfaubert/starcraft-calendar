<?php
class CalendarController extends AppController {

    public function sc2($filename)
    {
        $this->layout   = "text";  
		if(Configure::read('debug') < 1) {
			header('Content-Type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename="cal.ics"');
		} else {
			header('Content-Type: text/plain; charset=utf-8');
		}

		$eventList = array();
		foreach (array("WcsEvent", "DreamhackEvent", "MlgEvent", "TaketvEvent") as $event) {
			if($this->loadModel($event)) {
				$eventList = array_merge($eventList, $this->{$event}->findAllActive(5));
			}
		}

		$this->set("eventList", Hash::sort($eventList, '{n}.timestamp_start', 'asc', 'numeric'));
		$this->set("title", "StarCraft II Calendar");

		$this->render("index");
    }

}
