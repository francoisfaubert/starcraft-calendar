class ApiController < ApplicationController
    def schedule
        render :json => Wcs.limit(30).order('start')
    end

    def scores
        render :json => Serie.limit(30).order('start')
    end
end
