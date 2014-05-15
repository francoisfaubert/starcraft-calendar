<div class="jumbotron">
	<div class="container">
		<h1>StarCraft II Calendar</h1>
		<p class="lead">This project fetches date information on the premier StarCraft II events and builds a calendar file that can be imported in Google Calendar, Outlook, iCal and other calendar applications which can read the <code>.ics</code> file format.</p>
	</div>
</div>

<div class="container">

	<div class="row">
		<div class="col-md-12">
			<h2>How it works</h2>
			<p>Import the following url in your favorite calendar application. Once the feed is added, it will automatically be kept up to date by your software.</p>			
			<p><code>http://starcraftcalendar.francoisfaubert.com/calendar/sc2/cal.ics</code></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">			

			<h2>What is listed</h2>

			<p>This tool crawls the schedules of every premier StarCraft 2 tournaments that are considered important on <a href="http://wiki.teamliquid.net/starcraft2/Premier_Tournaments">Liquipedia</a>.</p>

			<ul>
				<li><a href="http://wcs.battle.net/sc2/en/schedule">WCS</a></li>
				<li><a href="http://open.dreamhack.se/">Dreamhack</a></li>
				<li><a href="http://www.majorleaguegaming.com/seasons">MLG</a></li>
				<li><a href="http://taketv.net/cups/bracket">Take TV</a></li>
			</ul>

		</div>
		<div class="col-md-8">
			<h2>Overview</h2>
			<table class="table table-striped">
				<thead>
					<th>Name</th>
					<th>Start date</th>
					<th>End date</th>
				</thead>
				<tbody><?php foreach($eventList as $event) : ?>
					<tr>
						<td><?php echo $event["name"]; ?></td>
						<td>
							<time datetime="<?php echo $this->Time->i18nFormat($event["timestamp_start"]); ?>" data-title="true" title="<?php echo $this->Time->format($event["timestamp_start"], '%B %e, %Y %H:%M %p'); ?>">
					            <?php echo $this->Time->format($event["timestamp_start"], '%b %e'); //, %Y %H:%M %p (UTC)'); ?>
					        </time>
				        </td>
				        <td>
				        	<?php if(array_key_exists("timestamp_end", $event)) : ?>
							<time datetime="<?php echo $this->Time->i18nFormat($event["timestamp_end"]); ?>" data-title="true" title="<?php echo $this->Time->format($event["timestamp_end"], '%B %e, %Y %H:%M %p'); ?>">
					            <?php echo $this->Time->format($event["timestamp_end"], '%b %e'); //%Y %H:%M %p (UTC)'); ?>
					        </time>
					    	<?php else : ?>
							<time datetime="<?php echo $this->Time->i18nFormat($event["timestamp_start"]); ?>" data-title="true" title="<?php echo $this->Time->format($event["timestamp_start"], '%B %e, %Y %H:%M %p'); ?>">
					            <?php echo $this->Time->format($event["timestamp_start"], '%b %e'); //, %Y %H:%M %p (UTC)'); ?>
					        </time>
					    	<?php endif; ?>
				        </td>
				    </tr>
				<?php endforeach; ?></tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<h3>Thanks</h3>
			<p>This tool was not created by and is not directly maintained by Team Liquid or Blizzard. All my thanks go to Blizzard and Team Liquid's community for their regular updates which I, in turn, pull out to generate the calendars.</p>
			<p>I hope you will find this tool useful. Your feedback is appreciated.</p>
			<p>~ <a href="http://www.twitter.com/francoisfaubert/">@francoisfaubert</a></p>
		</div>
		<div class="col-md-6">
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