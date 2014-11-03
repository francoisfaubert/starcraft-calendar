task :cron => :environment do

    puts "Pulling new events..."
    Wcs.fetchRemoteList
    puts " "

    puts "Pulling new series..."
    Serie.fetchRemoteList
    puts " "

    puts "Done."

end
