class ApiController < ApplicationController

    after_filter :cors_set_access_control_headers

    def cors_set_access_control_headers
      headers['Access-Control-Allow-Origin'] = '*'
      headers['Access-Control-Allow-Methods'] = 'GET'
      headers['Access-Control-Max-Age'] = "1728000"
    end

    def events
        render :json => Wcs.limit(30).order('start DESC')
    end

    def scores
        render :json => Serie.limit(30).order('start DESC')
    end
end
