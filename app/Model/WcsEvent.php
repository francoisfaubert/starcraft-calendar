<?php
App::uses('RemoteEvent', 'Model');
class WcsEvent extends RemoteEvent {

	protected $_srcUrl = "http://wcs.battle.net/sc2/en/schedule";

	public function getEventsFromHtml($html)
	{
		$dom = new DOMDocument();
		if (@$dom->loadHTML($html)) {

			$finder = new DomXPath($dom);
			$eventContainers = $finder->query('//*[@class="rhs"]');

			foreach ($eventContainers as $eventNode) {
				$title = $eventNode->getElementsByTagName("div")->item(0)->nodeValue;
				$time = $eventNode->getElementsByTagName("time")->item(0)->getAttribute("datetime");			
				$playersNodes = $eventNode->getElementsByTagName("li");
				
				if(count($playersNodes) > 1) {
					$title .= " (";
					foreach($playersNodes as $node) {
						$title .= $node->item(0)->nodeValue . " ";
					}
					$title .= ")";
				}
			
				$eventData[] = array(
					"name" 				=> $title,
					"timestamp_start" => strtotime($time)
				);
				
			}
		}

		return $eventData;
	}


}