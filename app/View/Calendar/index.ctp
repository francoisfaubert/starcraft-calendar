BEGIN:VCALENDAR
PRODID:-//tlcalendar v0.1//NONSGML iCal Writer//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME: <?php echo $title . PHP_EOL; ?>
<?php
$dateIcal = 'Ymd\THis\Z';
foreach($eventList as $event) : 
	$isUngoing = false;
	$modifiedDate = $event["modified"];
	$endDate = 0;

	if (array_key_exists("timestamp_end", $event)) {
		$isUngoing = is_null($event["timestamp_end"]);
		// If a date has a valid end date, all works as one would think.
		// If it doesn't, make 'now' the end date and last modified timestamp
		// Continue updating the value until we get a end date. 
		// @todo : make sure events finish eventually and that this doesn't pollute calendars.
		if($isUngoing) {
			$modifiedDate 	= $endDate = time();
		} else {
			$endDate 		= $event["timestamp_end"];
		}
	}
?>
BEGIN:VEVENT
STATUS:CONFIRMED
SUMMARY:<?php echo $event["name"] . ($isUngoing ? " (ongoing)" : "")  . PHP_EOL ?>
UID:<?php echo $event["id"]; ?>@starcraftcalendar.francoisfaubert.com
DTSTART:<?php echo date($dateIcal, $event["timestamp_start"])  . PHP_EOL ?>
<?php if ($endDate  > 0) : ?>DTEND:<?php echo date($dateIcal, $endDate) . PHP_EOL ?><?php endif; ?>
LAST-MODIFIED:<?php echo date($dateIcal, $modifiedDate) . PHP_EOL ?>
CREATED:<?php echo date($dateIcal, $event["created"]) . PHP_EOL ?>
END:VEVENT
<?php endforeach; ?>
END:VCALENDAR