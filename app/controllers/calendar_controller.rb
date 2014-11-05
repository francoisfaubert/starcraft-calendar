class CalendarController < ApplicationController

    def events
        content = Calendar.generateEventList(Wcs.limit(30).order('start'))

        if Rails.env.production?
            send_data content,  :filename => "cal.ics"
        else
            render plain: content
        end
    end

    def scores
        content = Calendar.generateSeriesList(Serie.limit(30).order('start'))

        if Rails.env.production?
            send_data content,  :filename => "scores.ics"
        else
            render plain: content
        end
    end
end
