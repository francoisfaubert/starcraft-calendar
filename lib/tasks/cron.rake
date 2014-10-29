task :cron => :environment do

    puts "Pulling new events..."
    puts "---------------------"
    puts " "

    puts "WCS..."
    Wcs.fetchRemoteList

    puts " "
    puts "Done."

end
