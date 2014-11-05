class Calendar

    public

        def self.generateEventList(events)
            str = self._addHeader([])
            str << 'X-WR-CALNAME: StarCraft II Calendar'
            events.each do |event|
                str << 'BEGIN:VEVENT'
                str << 'STATUS:CONFIRMED'
                str << 'TZNAME:GMT'
                str << 'SUMMARY:' + event.summary
                str << 'UID:' + event.id.to_s + '@starcraftcalendar.francoisfaubert.com'
                str << 'DTSTART:' + event.start_date_ical.to_s
                if event.has_end_date?
                    str << 'DTEND:' + event.end_date_ical.to_s
                end
                str << 'LAST-MODIFIED:' + event.updated_at_ical.to_s
                str << 'CREATED:' + event.created_at_ical.to_s
                str << 'END:VEVENT'
            end
            str = self._addFooter(str)
            str.join("\r\n")
        end

        def self.generateSeriesList(series)
            str = self._addHeader([])
            str << 'X-WR-CALNAME: StarCraft II Results'
            series.each do |serie|
                str << 'BEGIN:VEVENT'
                str << 'STATUS:CONFIRMED'
                str << 'TZNAME:GMT'
                str << 'SUMMARY:' + serie.summary
                str << 'UID:' + serie.id.to_s + '@starcraftcalendar.francoisfaubert.com'
                str << 'DTSTART:' + serie.start_date_ical.to_s
                str << 'LAST-MODIFIED:' + serie.updated_at_ical.to_s
                str << 'CREATED:' + serie.created_at_ical.to_s
                str << 'END:VEVENT'
            end
            str = self._addFooter(str)
            str.join("\r\n")
        end

    private

        def self._addHeader(str)
            str << 'BEGIN:VCALENDAR'
            str << 'VERSION:2.0'
            str << 'PRODID:-//sccalendar v0.1//NONSGML iCal Writer//EN'
            str << 'CALSCALE:GREGORIAN'
            str << 'METHOD:PUBLISH'
            str
        end

        def self._addFooter(str)
            str << 'END:VCALENDAR'
            str
        end
end
