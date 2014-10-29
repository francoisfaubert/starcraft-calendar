StarCraft II Calendar
=====================

This project fetches date information on the premier StarCraft II events and builds a calendar file that can be imported in Google Calendar, Outlook, iCal and other calendar applications which can read the <code>.ics</code> file format.

How it works
------------

Import the following url in your favorite calendar application. Once the feed is added, it will automatically be kept up to date by your software.

     http://starcraftcalendar.francoisfaubert.com/calendar/sc2/cal.ics


What is listed
--------------

This tool crawls the list of every WCS StarCraft 2 events listed on [WCS](http://wcs.battle.net/sc2/en/schedule)

Developper information
----------------------

This website is built on Ruby on Rails.

Set up the database using Cake's console utility

    bundle install
    rake db:migrate


Or once on heroku

    heroku run rake db:migrate


There is one required cron rule :

	0 10 * * * php /path_to_install/html/app/Console/cake.php App daily starcraftcalendar.francoisfaubert.com  > /dev/null 2>&1

Thanks
------

This tool was not created by and is not directly maintained by Blizzard. All my thanks go to Blizzard for their regular updates which I, in turn, pull out to generate the calendars.

I hope you will find this tool useful, your feedback is appreciated.

~ [@francoisfaubert](http://www.twitter.com/francoisfaubert/)
