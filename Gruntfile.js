module.exports = function(grunt) {

    var fileHash = grunt.template.today('yyyymmddHHMMss');

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            css: {
                src: [
                    'www/css/yar/font.css',
                    'www/css/yar/styles.css',
                    'www/css/yar/template_styles.css',
                    'www/fancybox/jquery.fancybox.css',
                    'www/fancybox/helpers/jquery.fancybox-buttons.css',
                    'www/fancybox/helpers/jquery.fancybox-thumbs.css'
                ],
                dest: 'www/yar-min/combined.css'
            },
            js: {
                src: [
                    'www/js/cookie.js',
                    'www/fancybox/jquery.fancybox.pack.js',
                    'www/fancybox/helpers/jquery.fancybox-buttons.js',
                    'www/fancybox/helpers/jquery.fancybox-thumbs.js',
                    'www/fancybox/jquery.fancybox.pack.js',
                    'www/js/jquery.customSelect.min.js',
                    'www/js/jquery.lazyload.js',
                    'www/js/yar/application.js',
                    'www/js/jquery.mosaicflow.min.js',
                    'www/js/yar/template.js'
                ],
                dest: 'www/yar-min/combined.js'
            }
        },
        csso: {
            css: {
                expand: true,
                cwd: 'www/yar-min/',
                src: ['combined.css'],
                dest: 'www/yar-min/',
                ext: '.min.css'
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            js: {
                files: {
                    'www/yar-min/combined.min.js': ['www/yar-min/combined.js']
                }
            }
        },
        asset_version_json: {
            options: {
                algorithm: 'sha1',
                length: 8,
                format: false,
                rename: true
            },
            css: {
                src: 'www/yar-min/combined.min.css',
                dest: 'protected/config/filerevs.json'
            },
            js: {
                src: 'www/yar-min/combined.min.js',
                dest: 'protected/config/filerevs.json'
            }
        },
        clean: {
            css: ['www/yar-min/*.css'],
            js: ['www/yar-min/*.js'],
            after_created: [
                'www/yar-min/combined.css',
                'www/yar-min/combined.min.js',
                'www/yar-min/combined.js'
            ]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-csso');
    grunt.loadNpmTasks('grunt-asset-version-json');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('default', [
        'clean:css',
        'clean:js',
        'concat',
        'csso:css',
        'uglify',
        'asset_version_json',
        'clean:after_created'
    ]);
};