set :application,           "share-pear"

# multiple stages
set :stages,                ["vagrant", "prod"]
set :default_stage,         "vagrant"
set :stage_dir,             "app/config/deploy"
require 'capistrano/ext/multistage'

# git
set :scm,                   :git
default_run_options[:pty] = true
default_run_options[:shell] = '/bin/bash --login'
set :ssh_options, {
    :forward_agent => true
}

# shared files
set :shared_files,          ["app/config/parameters.yml"]
set :shared_children,       [app_path + "/logs", app_path + "/bower_components", app_path + "/node_modules", web_path + "/uploads", web_path + "/media"]

# project config
set :model_manager,         "doctrine"
set :interactive_mode,      false

# composer settings
set :composer_bin,      "/usr/local/bin/composer"
set :use_composer,      true
set :update_vendors,    false
set :copy_vendors,      true
set :vendors_mode,      "install"

# permissions config
set :writable_dirs,         ["app/cache", "app/logs"]
set :webserver_user,        "www-data"
set :use_set_permissions,   false
set :use_sudo,              false

# misc
set :app_path,              "app"
set :keep_releases,         3

# Be less verbose by commenting the following line
logger.level = Logger::MAX_LEVEL

# deployment tasks
after "symfony:composer:install", "symfony:doctrine:migrations:migrate"
after "symfony:doctrine:migrations:migrate", "npm:install"
after "npm:install", "grunt:generate"
after "deploy", "deploy:cleanup"

namespace :npm do
    desc "Install npm packages"
    task :install do
        capifony_pretty_print "--> Install npm packages"
        run "cd #{latest_release} && npm install"
        capifony_puts_ok
    end
end

namespace :grunt do
    desc "Generate all assets with grunt"
    task :generate do
        capifony_pretty_print "--> Generating all assets with grunt"
        run "cd #{latest_release} && ./node_modules/grunt-cli/bin/grunt"
        capifony_puts_ok
    end
end
