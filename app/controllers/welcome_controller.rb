class WelcomeController < ApplicationController
    def index
        timestamp = Time.now.to_i.to_s
        @events = Wcs.where('start >= ?', timestamp).limit(6).order('start desc')
    end
end
