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

=begin
  def sc2
    respond_to do |format|
        format.ics do
            index_csv
        end
    end



    timestamp = Time.now.to_i.to_s
    @events = Wcs.where('start >= ?', timestamp).limit(100).order('start')
    respond_to do |format|
      format.ics do
        setup_download
      end
    end
  end

  private

  def setup_download
    filename = "cal.ics"
    if !Rails.env.production?
        if request.env['HTTP_USER_AGENT'] =~ /msie/i
            headers['Pragma'] = 'public'
            headers["Content-type"] = "text/plain"
            headers['Cache-Control'] = 'no-cache, must-revalidate, post-check=0, pre-check=0'
            headers['Content-Disposition'] = "attachment; filename=\"#{filename}\""
            headers['Expires'] = "0"
        else
            headers["Content-Type"] ||= 'text/calendar'
            headers["Content-Disposition"] = "attachment; filename=\"#{filename}\""
        end
    else
        headers["Content-Type"] ||= 'text/plain'
    end
    render :layout => false
    send_data
  end

end
=end
