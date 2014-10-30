class Calendar

    def self.generate(events)
        str = []
        str << 'BEGIN:VCALENDAR'
        str << 'PRODID:-//tlcalendar v0.1//NONSGML iCal Writer//EN'
        str << 'VERSION:2.0'
        str << 'CALSCALE:GREGORIAN'
        str << 'METHOD:PUBLISH'
        str << 'X-WR-CALNAME: StarCraft II Calendar'
        events.each do |event|
            str << 'BEGIN:VEVENT'
            str << 'STATUS:CONFIRMED'
            str << 'TZNAME:GMT'
            str << 'SUMMARY:' + event.name.gsub(/,/, "\\,")
            str << 'UID:' + event.id.to_s + '@starcraftcalendar.francoisfaubert.com'
            str << 'DTSTART:' + event.start_date_ical.to_s
            if event.has_end_date?
                str << 'DTEND:' + event.end_date_ical.to_s
            end
            str << 'LAST-MODIFIED:' + event.updated_at_ical.to_s
            str << 'CREATED:' + event.created_at_ical.to_s
            str << 'END:VEVENT'
        end
        str << 'END:VCALENDAR'
        str.join("\n")
    end

end
