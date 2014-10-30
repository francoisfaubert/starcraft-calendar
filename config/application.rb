# Thank you to https://github.com/uq-eresearch/miletus/blob/master/config/application.rb for this sample file


require File.expand_path('../boot', __FILE__)

require "active_record/railtie"
require 'rails/all'

if defined?(Bundler)
  # If you precompile assets before deploying to production, use this line
  Bundler.require(*Rails.groups(:assets => %w(development test)))
  # If you want your assets lazily compiled in production, use this line
  # Bundler.require(:default, :assets, Rails.env)
end

# Monkey-patch Rails to handle the lack of database.yml
class Rails::Application::Configuration

  def database_configuration
    # There is no config file, so manufacture one
    config = {
      'test' => 'sqlite3://localhost/:memory:',
      #'development' => ENV['DATABASE_URL'],
      'production' => ENV['DATABASE_URL']
    }
    config.each do |key, value|
      env_config = get_database_environment_from_database_url(value)
      if env_config.nil?
        config.delete(key)
      else
        config[key] = env_config
      end
    end

    config['development'] = {
      'adapter' => 'sqlite3',
      'database' => 'db/development.sqlite3',
      'pool' => 5,
      'timeout' => 5000
    }

    config
  end

  def get_database_environment_from_database_url(db_url)
    # Based on how Heroku do it: https://gist.github.com/1059446
    begin
      uri = URI.parse(db_url)

      return {
        'adapter' => uri.scheme == "postgres" ? "postgresql" : uri.scheme,
        'database' => (uri.path || "").split("/")[1],
        'username' => uri.user,
        'password' => uri.password,
        'host' => uri.host,
        'port' => uri.port
      }
    rescue URI::InvalidURIError
      nil
    end
  end

end

module StarcraftCalendar
  class Application < Rails::Application
    # Settings in config/environments/* take precedence over those specified here.
    # Application configuration should go into files in config/initializers
    # -- all .rb files in that directory are automatically loaded.

    # Set Time.zone default to the specified zone and make Active Record auto-convert to this zone.
    # Run "rake -D time" for a list of tasks for finding time zone names. Default is UTC.
    # config.time_zone = 'Central Time (US & Canada)'
    config.time_zone = 'UTC'

    # The default locale is :en and all translations from config/locales/*.rb,yml are auto loaded.
    # config.i18n.load_path += Dir[Rails.root.join('my', 'locales', '*.{rb,yml}').to_s]
    # config.i18n.default_locale = :de
  end
end
