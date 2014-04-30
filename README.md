Team Liquid Calendar
====================

This project fetches curated data of the latest Starcraft 2 tournaments on Team Liquid and generates event calenders that can be imported in Google Calendar, iCal and other calendar software that can read the .ics file format. 

Generated calendars
-------------------

Premier Stracraft 2 tournaments :
http://tlcalendar.francoisfaubert.com/calendar/premiertournaments/cal.ics

Major Stracraft 2 tournaments :
http://tlcalendar.francoisfaubert.com/calendar/majortournaments/cal.ics

Some Handy Links
----------------

[Fork me](https://github.com/francoisfaubert/team-liquid-calendar/) - Create your own version of this website

[Website home](http://tlcalendar.francoisfaubert.com/) - Website


Developper information
----------------------

This website is built on CakePHP. All validated events are then stored in MySql. The database structure is packaged in the project inside the file ./dump.sql. You are expected to create and configure app/Config/database.php yourself.

There are 4 required cron rules needed. One per calendar type, and another that updates the tournament details:

5 8 * * 6 curl -sL tlcalendar.francoisfaubert.com/cron/premiertournamentlist > /dev/null 2>&1

5 8 * * 6 curl -sL tlcalendar.francoisfaubert.com/cron/majortournamentlist > /dev/null 2>&1

5 */2 * * * curl -sL tlcalendar.francoisfaubert.com/cron/syncdetails > /dev/null 2>&1


Thanks
------

This tool was not created by and is not directly maintained by Team Liquid. All my thanks go Team Liquid's community for their regular updates which I, in turn, pull out to generate the calendars.

I hope you will find this tool useful, your feedback is appreciated.

~ @francoisfaubert