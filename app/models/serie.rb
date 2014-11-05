class Serie < ActiveRecord::Base

    ICAL_FORMAT = "%Y%m%dT%H%M%SZ"

    protected

        @remoteUrl = "http://wcs.battle.net/sc2/en/brackets"

    public

        def self.fetchRemoteList
            list = []
            Remote.getPageByURL(@remoteUrl).search("*.match-result").each do |row|

                serie = Serie.where(:matchid => row.attributes['matchid']).first_or_create
                serie.name = row.at('.match-title .match-bracket').inner_html
                serie.start = DateTime.iso8601(row.at('time').attributes['datetime'])

                row.search('.player-name').each_with_index do |player, idx|
                    if idx == 0
                        serie.player1 = player.inner_html
                    else
                        serie.player2 = player.inner_html
                    end
                end

                row.search('.player-score').each_with_index do |score, idx|
                    if idx == 0
                        serie.player1_score = score.inner_html
                    else
                        serie.player2_score = score.inner_html
                    end
                end

                serie.save
                list << serie
            end
            list
        end

        def summary
            self.player1 + " (" + self.player1_score.to_s + ") vs " + self.player2 + " (" + self.player2_score.to_s + ")"
        end

        def start_time
            Time.parse(self.start)
        end

        def start_date
            if self.start_time.hour == self.start_time.min && self.start_time.min == 0
                self.start_time.strftime("%Y-%m-%d")
            else
                self.start_time.strftime("%Y-%m-%d %H:%M UTC")
            end
        end

        def start_date_utc
            self.start_time.utc.iso8601
        end

        def start_date_ical
            self.start_time.strftime(ICAL_FORMAT)
        end

        def end_date_ical
            self.end_time.strftime(ICAL_FORMAT)
        end

        def created_at_ical
            self.created_at.strftime(ICAL_FORMAT)
        end

        def updated_at_ical
            self.updated_at.strftime(ICAL_FORMAT)
        end

        def passed?
            self.start_time < Time.now
        end

        def today?
            self.start_time.strftime("%Y-%m-%d") == Time.now.strftime("%Y-%m-%d")
        end
end
