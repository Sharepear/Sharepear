# General settings
set :domain,           "sharepear.prod"
set :deploy_to,        "/var/www/sharepear"
set :user,             "www-data"
set :repository,       "https://github.com/chlorius/MyAlbums.git"
set :branch,           "master"

server domain, :app, :web, :primary => true

# Composer settings
set :composer_options, "--no-progress --prefer-dist --optimize-autoloader"
