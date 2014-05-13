Starcraft II Calendars
======================

This project fetches data on Team Liquid and Battle.net and generates calendars of upcoming Starcraft II events that can be imported in Google Calendar, Outlook, iCal and other calendar applications which can read the .ics file format.

Generated calendars
-------------------

WCS tournaments
http://starcraftcalendar.francoisfaubert.com/calendar/wcs/cal.ics	

Premier Stracraft 2 tournaments :
http://starcraftcalendar.francoisfaubert.com/calendar/premiertournaments/cal.ics

Major Stracraft 2 tournaments :
http://starcraftcalendar.francoisfaubert.com/calendar/majortournaments/cal.ics

Links
-----

http://starcraftcalendar.francoisfaubert.com/


Developper information
----------------------

This website is built on CakePHP. All validated events are then stored in MySql. The database structure is packaged in the project inside the file ./dump.sql. You are expected to create and configure app/Config/database.php yourself.

There are 4 required cron rules needed. One per calendar type, and another that updates the tournament details:

5 8 * * 6 curl -sL starcraftcalendar.francoisfaubert.com/cron/wcsdailyevents > /dev/null 2>&1

5 8 * * 6 curl -sL starcraftcalendar.francoisfaubert.com/cron/premiertournamentlist > /dev/null 2>&1

5 8 * * 6 curl -sL starcraftcalendar.francoisfaubert.com/cron/majortournamentlist > /dev/null 2>&1

5 */2 * * * curl -sL starcraftcalendar.francoisfaubert.com/cron/syncdetails > /dev/null 2>&1


Thanks
------

This tool was not created by and is not directly maintained by Team Liquid or Blizzard. All my thanks go to Blizzard and Team Liquid's community for their regular updates which I, in turn, pull out to generate the calendars.

I hope you will find this tool useful, your feedback is appreciated.

~ @francoisfaubert
