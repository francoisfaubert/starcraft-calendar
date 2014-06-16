<?php
class UpdateEventsTask extends Shell {

    public $uses = array('Config');

    public function execute()
    {
		$this->out("Updating events...");
		
		//foreach (array("WcsEvent", "DreamhackEvent", "MlgEvent", "TaketvEvent") as $event) {
		foreach (array("WcsEvent") as $event) {
			$this->loadModel($event);
			$this->{$event}->updateData();
		}

		$this->out("Completed.");
    }
}
