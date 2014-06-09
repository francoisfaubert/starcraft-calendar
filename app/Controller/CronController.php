<?php

App::uses('HttpSocket', 'Network/Http');

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
}
