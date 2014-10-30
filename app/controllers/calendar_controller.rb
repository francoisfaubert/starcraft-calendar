class CalendarController < ApplicationController

    def sc2
        timestamp = Time.now.to_i.to_s
        events = Wcs.where('start >= ?', timestamp).limit(100).order('start')
        content = Calendar.generate(events)

        if Rails.env.production?
            send_data content,  :filename => "cal.ics"
        else
            render plain: content
        end
    end
end
