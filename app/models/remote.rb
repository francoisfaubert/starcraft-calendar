class Remote

    require 'open-uri'
    require 'hpricot'

    def self.getPageByURL(url)
        doc = open(url) { |f| Hpricot(f) }
        doc
    end

end
