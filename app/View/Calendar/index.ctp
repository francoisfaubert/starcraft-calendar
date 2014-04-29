BEGIN:VCALENDAR
PRODID:-//tlcalendar v0.1//NONSGML iCal Writer//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME: <?php echo $title . PHP_EOL; ?>
<?php
$dateIcal = 'Ymd\THis\Z';
foreach($events as $event) : 
	// If a date has a valid end date, all works as one would think.
	// If it doesn't, make 'now' the end date and last modified timestamp
	// Continue updating the value until we get a end date. 
	// @todo : make sure events finish eventually and that this doesn't pollute calendars.
	$hasEnd =  !is_null($event["timestamp_end"]);
	$endDate = $hasEnd ? $event["timestamp_end"] : time();
	$modifiedData = $hasEnd ? $event["modified"] : $endDate;
?>
BEGIN:VEVENT
STATUS:CONFIRMED
SUMMARY:<?php echo $event["name"] . ($hasEnd ? "" : " (ongoing)")  . PHP_EOL ?>
UID:<?php echo $event["id"]; ?>@tlcalendar.francoisfaubert.com
DTSTART:<?php echo date($dateIcal, $event["timestamp_start"])  . PHP_EOL ?>
DTEND:<?php echo date($dateIcal, $endDate) . PHP_EOL ?>
LAST-MODIFIED:<?php echo date($dateIcal, $endDate) . PHP_EOL ?>
CREATED:<?php echo date($dateIcal, $event["created"]) . PHP_EOL ?>
END:VEVENT
<?php endforeach; ?>
END:VCALENDAR