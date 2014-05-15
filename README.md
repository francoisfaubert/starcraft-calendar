StarCraft II Calendar
=====================

This project fetches date information on the premier StarCraft II events and builds a calendar file that can be imported in Google Calendar, Outlook, iCal and other calendar applications which can read the <code>.ics</code> file format.

How it works
------------
			
Import the following url in your favorite calendar application. Once the feed is added, it will automatically be kept up to date by your software.</p>			

     http://starcraftcalendar.francoisfaubert.com/calendar/sc2/cal.ics


What is listed
--------------

This tool crawls the schedules of every premier StarCraft 2 tournaments that are considered important on [Liquipedia](http://wiki.teamliquid.net/starcraft2/Premier_Tournaments)


* [WCS](http://wcs.battle.net/sc2/en/schedule)
* [Dreamhack](http://open.dreamhack.se/)
* [MLG](http://www.majorleaguegaming.com/seasons)
* [Take TV](http://taketv.net/cups/bracket)


Developper information
----------------------

This website is built on CakePHP. All validated events are then stored in MySql. The database structure is packaged in the project inside the file ./app/Config/Schema/events.sql. You are expected to create and configure app/Config/database.php yourself.

There 1 required cron rule needed :

	20 4 * * * curl -sL starcraftcalendar.francoisfaubert.com/cron/daily > /dev/null 2>&1

Thanks
------

This tool was not created by and is not directly maintained by Team Liquid or Blizzard. All my thanks go to Blizzard and Team Liquid's community for their regular updates which I, in turn, pull out to generate the calendars.

I hope you will find this tool useful, your feedback is appreciated.

~ [@francoisfaubert](http://www.twitter.com/francoisfaubert/)