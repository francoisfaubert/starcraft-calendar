class Wcs < ActiveRecord::Base

    def self.fetchRemoteList
        list = []
        RemoteEvent.getPageByURL(@remoteUrl).search("*.rhs").each do |row|
            title = row.at('.title').inner_html
            title += self._parsePlayers(row)
            start =  DateTime.iso8601(row.at('time').attributes['datetime'])

            list << Wcs.where(:name => title, :start => start).first_or_create
        end
        list
    end

    def start_time
        Time.parse(self.start)
    end

    def end_time
        Time.parse(self.end)
    end

    def start_date
        if self.start_time.hour == self.start_time.min && self.start_time.min == 0
            self.start_time.strftime("%Y-%m-%d")
        else
            self.start_time.strftime("%Y-%m-%d %H:%M UTC")
        end
    end

    def end_date
        if self.end_time.hour == self.end_time.min && self.end_time.min == 0
            self.end_time.strftime("%Y-%m-%d")
        else
            self.end_time.strftime("%Y-%m-%d %H:%M UTC")
        end
    end

    def start_date_ical
        self.start_time.strftime("%Y%m%dT%H%M%S")
    end

    def end_date_ical
        self.end_time.strftime("%Y%m%dT%H%M%S")
    end

    def created_at_ical
        self.created_at.strftime("%Y%m%dT%H%M%S")
    end

    def updated_at_ical
        self.updated_at.strftime("%Y%m%dT%H%M%S")
    end

    def start_date_utc
        self.start_time.utc.iso8601
    end

    def end_date_utc
        self.end_time.utc.iso8601
    end

    def passed?
        self.start_time < Time.now
    end

    def today?
        self.start_time.strftime("%Y-%m-%d") == Time.now.strftime("%Y-%m-%d")
    end

    def has_end_date?
        !self.end.nil?
    end

    protected

    @remoteUrl = "http://wcs.battle.net/sc2/en/schedule"

    def self._parsePlayers(el)
        players = []
        el.search('.competitors .spoiler').each do |player|
            name =  player.inner_html.gsub(/<\/?[^>]+>/, '')
            players << name.strip! || name
        end
        players.length > 0 ? " (" + players.join(", ") + ")" : ""
    end


end
