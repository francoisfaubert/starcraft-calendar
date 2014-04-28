BEGIN:VCALENDAR
PRODID:-//tlcalendar v0.1//NONSGML iCal Writer//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME: <?php echo $title . PHP_EOL; ?>
<?php
$dateIcal = 'Ymd\THis\Z';
foreach($events as $event) : ?>
BEGIN:VEVENT
STATUS:CONFIRMED
SUMMARY:<?php echo $event["name"]  . PHP_EOL ?>
UID:<?php echo $event["id"]; ?>@tlcalendar.francoisfaubert.com
DTSTART:<?php echo date($dateIcal, $event["timestamp_start"])  . PHP_EOL ?>
DTEND:<?php echo date($dateIcal, is_null($event["timestamp_end"]) ? $event["timestamp_start"] : $event["timestamp_end"] )  . PHP_EOL ?>
LAST-MODIFIED:<?php echo date($dateIcal, $event["modified"]) . PHP_EOL ?>
CREATED:<?php echo date($dateIcal, $event["created"]) . PHP_EOL ?>
END:VEVENT
<?php endforeach; ?>
END:VCALENDAR