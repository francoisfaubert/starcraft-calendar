class MobileController < ApplicationController
    def schedule
        @events = Wcs.limit(20).order('start desc')
    end

    def scores
        @series = Serie.limit(20).order('start desc')
    end
end
