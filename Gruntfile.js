module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-symlink');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-coffee');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Création du répertoire d'image pour l'application s'il n'existe pas.
    grunt.file.mkdir('app/Resources/public/images/');

    // properties are css files
    // values are less files
    var filesLess = {},
        filesCoffee = {};

    // Configuration du projet
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        symlink: {
            // app/Resources/public/ doit être disponible via web/bundles/app/
            app: {
                dest: 'web/bundles/app',
                relativeSrc: '../../app/Resources/public/',
                options: {type: 'dir'}
            }
        },

        less: {
            bundles: {
                files: filesLess
            }
        },

        cssmin: {
            minify: {
                expand: true,
                src: ['web/built/all.css'],
                ext: '.min.css'
            }
        },

        coffee: {
            compileBare: {
                options: {
                    bare: true
                },
                files: filesCoffee
            }
        },

        uglify: {
            dist: {
                files: {
                    'web/built/all.min.js': ['web/built/all.js']
                }
            }
        },

        concat: {
            js: {
                src: [
                    'bower_components/jquery/jquery.js',
                    'web/built/*/js/*.js',
                    'web/built/*/js/*/*.js',
                ],
                dest: 'web/built/all.js'
            },
            css: {
                src: [
                    'web/built/*/css/*.css',
                    'web/built/*/css/*/*.css',
                ],
                dest: 'web/built/all.css'
            }
        },

        watch: {
            css: {
                files: ['web/bundles/*/less/*.less'],
                tasks: ['css']
            },
            javascript: {
                files: ['web/bundles/*/coffee/*.coffee'],
                tasks: ['javascript']
            }
        }
    });

    // Default task(s).
    grunt.registerTask('default', ['css', 'javascript']);
    grunt.registerTask('css', ['less:discovering', 'less', 'concat:css', 'cssmin']);
    grunt.registerTask('javascript', ['coffee:discovering', 'coffee', 'concat:js', 'uglify']);
    grunt.registerTask('assets:install', ['symlink']);
    grunt.registerTask('deploy', ['assets:install', 'default']);
    grunt.registerTask('less:discovering', 'This is a function', function() {
        // LESS Files management
        // Source LESS files are located inside : bundles/[bundle]/less/
        // Destination CSS files are located inside : built/[bundle]/css/
        var mappingFileLess = grunt.file.expandMapping(
            ['*/less/*.less', '*/less/*/*.less'],
            'web/built/', {
                cwd: 'web/bundles/',
                rename: function(dest, matchedSrcPath, options) {
                    return dest + matchedSrcPath.replace(/less/g, 'css');
                }
            });

        grunt.util._.each(mappingFileLess, function(value) {
            // Why value.src is an array ??
            filesLess[value.dest] = value.src[0];
        });
    });
    grunt.registerTask('coffee:discovering', 'This is a function', function() {
        // COFFEE Files management
        // Source COFFEE files are located inside : bundles/[bundle]/coffee/
        // Destination JS files are located inside : built/[bundle]/js/
        var mappingFileCoffee = grunt.file.expandMapping(
            ['*/coffee/*.coffee', '*/coffee/*/*.coffee'],
            'web/built/', {
                cwd: 'web/bundles/',
                rename: function(dest, matchedSrcPath, options) {
                    return dest + matchedSrcPath.replace(/coffee/g, 'js');
                }
            });

        grunt.util._.each(mappingFileCoffee, function(value) {
            // Why value.src is an array ??
            filesCoffee[value.dest] = value.src[0];
        });
    });
};
