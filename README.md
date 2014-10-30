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

This website is built on Ruby on Rails 4.

Set up the requirements using the bundler and the database using the migration tool.

    $ bundle install
    $ rake db:migrate

Or, should you throw this repository on Heroku run the following command after it has been deployed for the first time.

    $ heroku run rake db:migrate


There is one required daily cron command to ensure new events are fetched :

	$ rake cron

Thanks
------

This tool was not created by and is not directly maintained by Blizzard. All my thanks go to Blizzard for their regular updates which I, in turn, pull out to generate the calendars.

I hope you will find this tool useful, your feedback is appreciated.

~ [@francoisfaubert](http://www.twitter.com/francoisfaubert/)
