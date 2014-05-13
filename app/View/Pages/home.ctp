<div class="jumbotron">
	<div class="container">
		<h1>Starcraft II Calendar</h1>
		<p class="lead">This project fetches data on Team Liquid and Battle.net and generates calendars of upcoming Starcraft II events that can be imported in Google Calendar, Outlook, iCal and other calendar applications which can read the <code>.ics</code> file format.</p>
	</div>
</div>

<div class="container">

	<div class="row">
		<div class="col-md-12">
			<h2>Generated calendars</h2>
			<p class="lead">Import the following urls in your favorite calendar application. Once the feeds are added, they will automatically be kept up to date by your software.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			<h3>WCS</h3>
			<p>This calendar schedule lists upcoming matches from any of the WCS leagues as taken from the official Blizzard page.</p>
			<p>The content is found on the official WCS <a href="http://wcs.battle.net/sc2/en/schedule">schedule</a> page.</p>
			<p><code>http://starcraftcalendar.francoisfaubert.com/calendar/wcs/cal.ics</code></p>
		</div>
		<div class="col-md-5">
			<table class="table table-striped">
				<thead>
					<th>Type</th>
					<th>Name</th>
					<th>Start date</th>
				</thead>
				<tbody><?php foreach($wcsevents as $event) : ?>
					<tr>
						<td>
							<span class="label label-default">WCS</span>
						</td> 
						<td><?php echo $event["name"]; ?></td>
						<td> 
							<time datetime="<?php echo $this->Time->i18nFormat($event["timestamp_start"]); ?>" data-title="true" title="<?php echo $this->Time->format($event["timestamp_start"], '%B %e, %Y %H:%M %p'); ?>">
					            <?php echo $this->Time->format($event["timestamp_start"], '%b %e, %Y %H:%M %p (UTC)'); ?>
					        </time>
				        </td>
				    </tr>
				<?php endforeach; ?></tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			<h3>Community curated</h3>
			<p>This schedules list premier and major tournaments in and outside of WCS. More exhaustive than the WCS calendar, information may not be 100% available as the sources of these feeds are community curated.</p>
			<p>The content is found on Liquipedia's <a href="http://wiki.teamliquid.net/starcraft2/Premier_Tournaments">premier</a> and <a href="http://wiki.teamliquid.net/starcraft2/Major_Tournaments">major</a> event listing page.</p>

			<h4>Premier tournaments</h4>
			<p><code>http://starcraftcalendar.francoisfaubert.com/calendar/premiertournaments/cal.ics</code></p>

			<h4>Major tournaments</h4>
			<p><code>http://starcraftcalendar.francoisfaubert.com/calendar/majortournaments/cal.ics</code></p>
		</div>		
	
		<div class="col-md-5">	
			<table class="table table-striped">
				<thead>
					<th>Type</th>
					<th>Name</th>
					<th>Start date</th>
					<th>End date</th>
				</thead>
				<tbody><?php foreach($tlevents as $event) : $hasEnd =  !is_null($event["timestamp_end"]); ?>
					<tr>
						<td>
							<span class="label label-<?php echo $event["type"] == "premier" ? "primary" : "info"; ?>"><?php echo $event["type"]; ?></span>
						</td> 
						<td><?php echo $event["name"]; ?></td>
						<td> 
							<time datetime="<?php echo $this->Time->i18nFormat($event["timestamp_start"]); ?>" data-title="true" title="<?php echo $this->Time->format($event["timestamp_start"], '%B %e, %Y %H:%M %p'); ?>">
					            <?php echo $this->Time->format($event["timestamp_start"], '%b %e'); ?>
					        </time>
				        </td>
				    	<td> 
				        <?php if($hasEnd) : ?>
				        	<time datetime="<?php echo $this->Time->i18nFormat($event["timestamp_end"]); ?>" data-title="true" title="<?php echo $this->Time->format($event["timestamp_end"], '%B %e, %Y %H:%M %p'); ?>">
				            	<?php echo $this->Time->format($event["timestamp_end"], '%b %e'); ?>
				        	</time>
				        <?php else : ?>
				        	[ongoing]
				        <?php endif; ?>
				        </td>
				    </tr>
				<?php endforeach; ?></tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-md-7">
			<h3>Thanks</h3>
			<p>This tool was not created by and is not directly maintained by Team Liquid or Blizzard. All my thanks go to Blizzard and Team Liquid's community for their regular updates which I, in turn, pull out to generate the calendars.</p>
			<p>I hope you will find this tool useful. Your feedback is appreciated.</p>
			<p>~ <a href="http://www.twitter.com/francoisfaubert/">@francoisfaubert</a></p>
		</div>
		<div class="col-md-5">
			<h3>Fork me</h3>
			<p>There have been other people who have coded similar calendars along the way. Some of the previous project have stopped being maintained along the way, which is the way of things on the Internet. I have published the code for this website on GitHub in case I can no longer maintain the website and someone else wants to have a starting point to bring the calendars back.</p>
			<ul>
				<li><a href="https://github.com/francoisfaubert/starcraft-calendar">Visit on GitHub</a></li>
			</ul>
		</div>
	</div>
</div>

<footer class="jumbotron" style="font-size:2.5em; text-align:center; margin-bottom:0; margin-top:2em;">
	<i class="glyphicon glyphicon-calendar"></i>
</footer>