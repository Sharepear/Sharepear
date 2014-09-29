role :app, %w{www-data@sharepear.dev}

set :deploy_to, '/var/www/deploy'

server 'sharepear.dev', user: 'www-data', roles: %w{app}
