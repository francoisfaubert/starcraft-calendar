<?php
interface iRemoteSourceParser
{	
	/**
	 * Updates the data set of the event object. Connects to a remote url.
	 *
	 * @return void
	 */
	public function updateData();

    public function getEventsFromHtml($html);

    public function filterNew($data);

    public function findAllActive($limit);

    public function getSourcePageHTML();

}