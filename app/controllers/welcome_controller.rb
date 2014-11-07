class WelcomeController < ApplicationController
    def index
    end

    def api
        timestamp = Time.now.to_i.to_s
        @events = Wcs.where('start >= ?', timestamp).limit(6).order('start desc')
        @series = Serie.limit(3).order('start desc')
    end

end
