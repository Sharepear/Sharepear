module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-contrib-symlink');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-coffee');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('livereloadx');
    grunt.loadNpmTasks('grunt-php');
    grunt.loadNpmTasks('grunt-autoprefixer');

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
                src: 'app/Resources/public/',
                dest: 'web/bundles/app'
            },
            knacss: {
                files: [
                    {
                        expand: true,
                        overwrite: false,
                        cwd: 'bower_components/knacss/less/',
                        src: ['_0[1-9]*.less'],
                        dest: 'app/Resources/public/knacss'
                    }
                ]
            },
            dropzone_image: {
                src: 'bower_components/dropzone/downloads/images/spritemap.png',
                dest: 'web/images/spritemap.png'
            },
            fontawesome_font: {
                src: 'bower_components/font-awesome/fonts/',
                dest: 'web/fonts'
            }
        },

        clean: {
            built: ["web/built"],
            symlink: ["web/bundles/app", "web/images/spritemap.png", "web/fonts"]
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
            bowerjs: {
                src: [
                    // jquery
                    'bower_components/jquery/dist/jquery.js',

                    // masonery
                    'bower_components/get-style-property/get-style-property.js',
                    'bower_components/get-size/get-size.js',

                    'bower_components/eventEmitter/EventEmitter.js',
                    'bower_components/eventie/eventie.js',
                    'bower_components/doc-ready/doc-ready.js',
                    'bower_components/jquery-bridget/jquery.bridget.js',
                    'bower_components/matches-selector/matches-selector.js',
                    'bower_components/outlayer/item.js',
                    'bower_components/outlayer/outlayer.js',

                    'bower_components/masonry/masonry.js',

                    // imagesloaded
                    'bower_components/imagesloaded/imagesloaded.js',

                    // dropzone
                    'bower_components/dropzone/downloads/dropzone.js'
                ],
                dest: 'web/built/bower.js'
            },
            js: {
                src: [
                    'web/built/bower.js',
                    'web/built/*/js/*.js',
                    'web/built/*/js/*/*.js'
                ],
                dest: 'web/built/all.js'
            },
            bowercss: {
                src: [
                    'bower_components/dropzone/downloads/css/*.css',
                    'bower_components/font-awesome/css/font-awesome.css'
                ],
                dest: 'web/built/bower.css'
            },
            css: {
                src: [
                    'web/built/bower.css',
                    'web/built/*/css/*.css',
                    'web/built/*/css/*/*.css'
                ],
                dest: 'web/built/all.css'
            }
        },

        autoprefixer: {
            no_dest: {
                src: 'web/built/all.css'
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
        },

        livereloadx: {
            port: 8000,
            proxy: "http://localhost:35729/",
            dir: 'web/built'
        },

        php: {
            live: {
                options:{
                    port: 35729,
                    router: '../vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/config/router_dev.php',
                    base: 'web/'
                }
            },
            server: {
                options:{
                    port: 8000,
                    router: '../vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/config/router_dev.php',
                    base: 'web/'
                }
            }
        }
    });

    // Default task(s).
    grunt.registerTask('default', ['clean:built', 'symlink', 'concat:bowercss', 'css', 'concat:bowerjs', 'javascript']);
    grunt.registerTask('live', ['default', 'php:live', 'livereloadx', 'watch']);
    grunt.registerTask('server', ['default', 'php:server', 'watch']);
    grunt.registerTask('css', ['less:discovering', 'less', 'concat:css', 'autoprefixer:no_dest', 'cssmin']);
    grunt.registerTask('javascript', ['coffee:discovering', 'coffee', 'concat:js', 'uglify']);
    grunt.registerTask('less:discovering', 'This is a function', function() {
        // LESS Files management
        // Source LESS files are located inside : bundles/[bundle]/less/
        // Destination CSS files are located inside : built/[bundle]/css/
        var mappingFileLess = grunt.file.expandMapping(
            ['*/less/*.less', '*/less/*/*.less'],
            'web/built/', {
                cwd: 'web/bundles/',
                rename: function(dest, matchedSrcPath, options) {
                    var destPath = dest + matchedSrcPath.replace(/less/g, 'css');
                    grunt.log.write(matchedSrcPath + " : ");
                    grunt.log.write("File " + destPath + " created.\n");
                    return destPath;
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
