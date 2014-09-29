lock '3.2.1'

set :application, 'sharepear'
set :repo_url, 'git@github.com:Sharepear/Sharepear.git'

# Default deploy_to directory is /var/www/my_app
set :deploy_to, '/var/www/sharepear'

# Default value for :linked_files is []
set :linked_files, ["app/config/parameters.yml"]

# Default value for linked_dirs is []
set :linked_dirs, ["app/logs", "bower_components", "node_modules", "web/uploads", "web/media"]

set :ssh_options, {
  forward_agent: true,
}

namespace :deploy do
  task :migrate do
    invoke 'symfony:console', 'doctrine:migrations:migrate', '--no-interaction'
  end
end
