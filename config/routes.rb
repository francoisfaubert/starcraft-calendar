Rails.application.routes.draw do

  get 'api/schedule'
  get 'api/scores'

  get '/api/sc2/events.json', to: 'api#events'
  get '/api/sc2/scores.json', to: 'api#scores'

  get '/calendar/sc2/events.ics', to: 'calendar#events'
  get '/calendar/sc2/scores.ics', to: 'calendar#scores'
  get 'welcome/index'

  get 'api', to: 'welcome#api'
  root 'welcome#index'

end
