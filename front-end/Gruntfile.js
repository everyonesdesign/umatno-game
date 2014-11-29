module.exports = function(grunt) {

    grunt.initConfig({
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'css/main_unprefixed.css': 'scss/main.scss'
                }
            }
        },
        watch: {
            css: {
                files: ['scss/*.scss'],
                tasks: ['sass', 'autoprefixer'],
                options: {
                    spawn: false
                }
            }/*,
            scripts: {
                files: ['js/*.js'],
                tasks: ['uglify'],
                options: {
                    spawn: false
                }
            }*/
        },
        autoprefixer: {
            options: {
                browsers: ['last 5 versions', 'ie 8', 'ie 9', '> 1%', 'Opera 12.1']
            },
            task: {
                src: 'css/main_unprefixed.css',
                dest: 'css/main.css'
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            my_target: {
                files: {
                    'js/all_scripts.min.js': ['js/vendors.js', 'js/scripts.js']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['watch']);
    grunt.registerTask('run', ['sass', 'autoprefixer'/*, 'uglify'*/]);

};