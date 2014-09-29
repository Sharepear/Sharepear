role :app, %w{www-data@sharepear.io}

server 'sharepear.io', user: 'www-data', roles: %w{app}
